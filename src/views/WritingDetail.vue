<template>
  <div class="writing-detail">
    <h1>{{ writing.title }}</h1>
    <div v-html="writing.content" class="content"></div> <!-- 마크다운을 HTML로 변환하여 표시 -->
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router'; // URL 파라미터를 가져오기 위해 useRoute 사용
import writingsData from '../data/writings.json'; // JSON 데이터 가져오기

const writing = ref({
  title: '',
  content: ''
});

const route = useRoute();
const writingId = route.params.id;

// 마크다운 파일을 HTML로 변환하는 함수
const convertMarkdownToHtml = (mdText) => {
  // 줄바꿈을 <p>로 감싸서 변환
  const paragraphs = mdText.split('\n').map(paragraph => {
    return `<p>${paragraph}</p>`; // 각 줄을 <p>로 감싸기
  }).join(''); // 줄들을 <p>로 감싸서 합침

  return paragraphs;
};

const loadWriting = async () => {
  const writingData = writingsData.writings.find(writing => writing.id === writingId); // ID에 맞는 글 찾기
  if (writingData) {
    writing.value.title = writingData.title;
    const response = await fetch(writingData.filePath); // JSON에서 가져온 filePath를 사용하여 마크다운 파일 로드
    const text = await response.text();
    writing.value.content = convertMarkdownToHtml(text); // 마크다운을 HTML로 변환
  }
};

onMounted(() => {
  loadWriting();
});
</script>

<style scoped>
.writing-detail {
  padding: 1rem;
}

h1 {
  font-size: 2rem;
  margin-bottom: 1rem;
}

.content p {
  font-size: 1rem;
  line-height: 1.6;
  margin-bottom: 1rem; 
  white-space: pre-wrap;
  text-indent: 0.5rem;
}
</style>
