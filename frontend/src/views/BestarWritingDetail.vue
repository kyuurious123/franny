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
import bestarWritingsData from '../data/bestarwritings.json';
import CommentSection from '../components/CommentSection.vue';

const route = useRoute();
const postId = route.params.id;

const markdownContent = ref('');
const writingTitle = ref('');
const writingSummary = ref('');

const writing = bestarWritingsData.bestarwritings.find(w => w.id === postId);

if (writing) {
writingTitle.value = writing.title;
writingSummary.value = writing.summary;
}

if (writing && writing.filePath) {
  const mdFilePath = `${writing.filePath}?t=${new Date().getTime()}`; // 캐시 무효화
  console.log("Markdown 요청 경로:", mdFilePath);

  fetch(mdFilePath, { cache: "no-store" })
    .then(response => {
      if (!response.ok) {
        throw new Error(`Markdown 파일을 찾을 수 없습니다: ${mdFilePath} (HTTP ${response.status})`);
      }
      return response.text();
    })
    .then(data => {
      console.log("Markdown 파일 로드 성공");
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
