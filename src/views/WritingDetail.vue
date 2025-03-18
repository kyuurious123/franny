<template>
  <div class="writing-detail" v-if="writing">
    <h1>{{ writing.title }}</h1>
    <p class="date">{{ formatDate(writing.date) }}</p>
    
    <!-- HTML 파일인 경우 -->
    <div class="content" v-if="writing.fileType === 'html'" v-html="content"></div>
    
    <!-- 마크다운 파일인 경우 -->
    <div class="content" v-else-if="writing.fileType === 'md'" v-html="renderedMarkdown"></div>
  </div>
  <div v-else>
    <p>글을 찾을 수 없습니다.</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import writingsData from '../data/writings.json';
import { marked } from 'marked'; // 마크다운 파싱 라이브러리

const route = useRoute();
const writing = ref(null);
const content = ref('');
const renderedMarkdown = ref('');

const formatDate = (dateString) => {
  if (!dateString) return '';
  
  const date = new Date(dateString);
  const year = date.getFullYear() % 100;
  const month = date.getMonth() + 1;
  const day = date.getDate();
  return `${year}${month}${day}`;
};

onMounted(async () => {
  // 현재 라우트의 id와 일치하는 글 찾기
  const id = route.params.id;
  
  // 콘솔에 정보 출력하여 디버깅
  console.log('Route ID:', id);
  console.log('Available writings:', writingsData.writings);
  
  // ID가 일치하는 글 찾기
  writing.value = writingsData.writings.find(w => w.id === id);
  
  console.log('Found writing:', writing.value);
  
  if (writing.value) {
    try {
      // fetch API를 사용하여 파일 가져오기
      const response = await fetch(writing.value.filePath);
      
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      
      const data = await response.text();
      
      // 파일 타입에 따라 처리
      if (writing.value.fileType === 'html') {
        content.value = data;
      } else if (writing.value.fileType === 'md') {
        // 마크다운을 HTML로 변환
        renderedMarkdown.value = marked(data);
      }
    } catch (error) {
      console.error('파일을 불러오는 데 실패했습니다:', error);
    }
  } else {
    console.error('해당 ID의 글을 찾을 수 없습니다:', id);
  }
});
</script>

<style scoped>
.writing-detail {
  padding: 1rem;
}

.content :deep(p) {
  text-indent: 0.75rem;
  line-height: 1.8;
  font-weight: 500;
  word-break: break-word;
}
</style>