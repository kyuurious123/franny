<template>
  <div class="writing-detail">
    <div class="writing-detail__title">
      <p class="title">{{ writingTitle }}</p>
      <p class="summary">{{ writingSummary }}</p>
    </div>
    <div v-if="markdownContent" v-html="renderedMarkdown" class="markdown-body"></div>
    <p v-else>Loading...</p>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute } from 'vue-router';
import { marked } from 'marked';
import bestarWritingsData from '../data/bestarwritings.json'; // ✅ JSON 데이터 가져오기

const route = useRoute();
const markdownContent = ref('');
const writingTitle = ref('');
const writingSummary = ref('');


// ✅ JSON 데이터에서 해당하는 글 찾기
const bestarwriting = bestarWritingsData.bestarwritings.find(w => w.id === route.params.id);

if (bestarwriting) {
  writingTitle.value = bestarwriting.title; // ✅ 해당 글의 제목 가져오기
  writingSummary.value = bestarwriting.summary; // ✅ 해당 글의 상세 가져오기

}

// Markdown 파일 가져오기
const fetchMarkdown = async () => {
  try {
    const filePath = `/writing/bestar/${route.params.id}.md`; // ✅ Markdown 파일 경로 설정
    const response = await fetch(filePath);

    if (!response.ok) {
      throw new Error("파일을 찾을 수 없습니다.");
    }

    markdownContent.value = await response.text();
  } catch (error) {
    markdownContent.value = "Markdown 파일을 불러오는 중 오류가 발생했습니다.";
    console.error(error);
  }
};

// ✅ Markdown을 HTML로 변환 (개행 및 스타일 적용)
const renderedMarkdown = computed(() => marked(markdownContent.value));

onMounted(fetchMarkdown);
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
