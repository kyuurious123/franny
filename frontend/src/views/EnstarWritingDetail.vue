<template>
  <div class="writing-detail">
    <div class="writing-detail__title">
      <p class="title">{{ writingTitle }}</p>
      <p class="summary">{{ writingSummary }}</p>
    </div>
    <div v-if="markdownContent" v-html="renderedMarkdown" class="markdown-body"></div>
    <p v-else>Loading...</p>
    <CommentSection :postId="postId" />
  </div>
</template>
  
<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute } from 'vue-router';
import { marked } from 'marked';
import enstarWritingsData from '../data/enstarwritings.json';
import CommentSection from '../components/CommentSection.vue';

const route = useRoute();
const postId = route.params.id || ''; // ✅ 기본값 추가

console.log("현재 페이지 postId:", postId); // ✅ postId 값 확인

const markdownContent = ref('');
const writingTitle = ref('');
const writingSummary = ref('');

const writing = enstarWritingsData.enstarwritings[postId] || null; // ✅ 데이터 없을 경우 대비

if (writing) {
  writingTitle.value = writing.title;
  writingSummary.value = writing.summary;
} else {
  console.error("데이터를 찾을 수 없음:", postId);
}

console.log("현재 postId:", postId);
console.log("현재 writing 객체:", writing);
console.log("현재 writing.filePath:", writing?.filePath);


if (writing && writing.filePath) {
  const mdFilePath = `/writing/enstar/${postId}.md`; // ✅ 파일 경로를 보장
  console.log("MD 파일 경로:", mdFilePath); // ✅ 확인용 로그

  fetch(mdFilePath)
    .then(response => {
      if (!response.ok) {
        throw new Error("Markdown 파일을 찾을 수 없습니다.");
      }
      return response.text();
    })
    .then(data => {
      markdownContent.value = marked(data);
    })
    .catch(error => console.error("Markdown 로드 실패:", error));
}

const renderedMarkdown = computed(() => {
  console.log("Markdown 변환 결과:", marked(markdownContent.value)); // ✅ 변환된 HTML 확인
  return marked(markdownContent.value);
});


</script>

  

<style scoped>
.writing-detail {
  padding: 1rem;
}

.writing-detail__title {
  margin-bottom: 4rem;
  text-align: center;
}

.title {
  font-weight: 700;
  font-size: 2.5rem;
  margin-bottom: 0.75rem;
  font-family: 'BookkMyungjo-Bd';
}

.summary {
  color: #666;
}

@media (min-width: 768px) {
  .writing-detail {
    padding: 1.5rem;
  }
}

.markdown-body {
  line-height: 1.8;
  white-space: pre-wrap; /* ✅ 개행 유지 */
  word-wrap: break-word;
}

.markdown-body h1, .markdown-body h2, .markdown-body h3 {
  font-weight: bold;
  margin-top: 1rem;
}

::v-deep(.markdown-body p) {
  margin-bottom: 0.25rem;
  text-indent: 0.5rem;
}
.markdown-body pre {
  background: #f4f4f4;
  padding: 10px;
  border-radius: 5px;
  overflow-x: auto;
}
.markdown-body blockquote {
  border-left: 4px solid #ddd;
  padding-left: 10px;
  color: #666;
}
</style>
