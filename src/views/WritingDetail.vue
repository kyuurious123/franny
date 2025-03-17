<template>
  <div class="writing-detail">
    <div class="writing-header">
      <h1 class="writing-title">{{ writing.title }}</h1>
      <div class="writing-meta">
        <span class="writing-date">{{ formatDate(writing.date) }}</span>
      </div>
    </div>

    <div class="writing-content" v-if="htmlContent" v-html="htmlContent"></div>
    <div class="loading" v-else>
      <p>글을 불러오는 중입니다...</p>
    </div>

    <div class="writing-footer">
      <router-link to="/writing" class="back-button">
        ← 목록으로 돌아가기
      </router-link>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import writingsData from '../data/writings.json';

const route = useRoute();
const writing = ref({});
const htmlContent = ref('');

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString('ko-KR', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });
};

onMounted(async () => {
  // 현재 라우트 ID로 글 데이터 찾기
  const writingId = route.params.id;
  const foundWriting = writingsData.writings.find(w => w.id === writingId);
  
  if (foundWriting) {
    writing.value = foundWriting;
    
    // HTML 파일 불러오기
    if (foundWriting.htmlFile) {
      try {
        const response = await fetch(foundWriting.htmlFile);
        if (response.ok) {
          htmlContent.value = await response.text();
        } else {
          console.error('HTML 파일을 불러올 수 없습니다');
        }
      } catch (error) {
        console.error('HTML 파일 로딩 중 오류:', error);
      }
    }
  }
});
</script>

<style scoped>
.writing-detail {
  max-width: 800px;
  margin: 0 auto;
}

.writing-header {
  margin-bottom: 2rem;
}

.writing-title {
  font-size: 1.8rem;
  margin-bottom: 0.5rem;
}

.writing-meta {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 0.9rem;
  color: #666;
  border-bottom: 1px solid var(--border-color);
  padding-bottom: 1rem;
  margin-bottom: 1rem;
}

.writing-content {
  line-height: 1.8;
  margin-bottom: 2rem;
}

/* HTML 컨텐츠 스타일링을 위한 글로벌 스타일 */
:deep(h1), :deep(h2), :deep(h3) {
  margin-top: 1.5rem;
  margin-bottom: 1rem;
}

:deep(p) {
  margin-bottom: 1rem;
}

:deep(img) {
  max-width: 100%;
  height: auto;
  margin: 1rem 0;
}

.writing-footer {
  margin-top: 3rem;
  padding-top: 1rem;
  border-top: 1px solid var(--border-color);
}

.back-button {
  display: inline-block;
  margin-top: 1rem;
  font-weight: 500;
}

.loading {
  text-align: center;
  padding: 2rem 0;
  color: #666;
}
</style>