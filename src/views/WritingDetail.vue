<template>
  <div class="writing-detail">
    <div v-if="loading" class="loading">로딩 중...</div>
    <div v-else-if="error" class="error">
      <h2>오류가 발생했습니다</h2>
      <p>{{ error }}</p>
    </div>
    <div v-else>
      <div class="top">
        <h1 class="title">{{ writing.title }}</h1>
        <p>{{ writing.summary }}</p>
      </div>
      <div v-html="writing.content" class="novel"></div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import writingsData from '../data/bestarwritings.json';

const route = useRoute();
const writing = ref({ title: '', content: '' });
const loading = ref(true);
const error = ref(null);

// 마크다운 파일을 HTML로 변환하는 함수
const convertMarkdownToHtml = (mdText) => {
  if (!mdText) return '';
  
  // 줄바꿈을 <p>로 감싸서 변환
  const lines = mdText.split('\n');
  let paragraphs = '';
  let inParagraph = false;

  lines.forEach(line => {
    if (line.trim() === '') {
      if (inParagraph) {
        paragraphs += '</p>';
        inParagraph = false;
      }
      paragraphs += '<br>';
    } else {
      if (!inParagraph) {
        paragraphs += '<p>';
        inParagraph = true;
      }
      paragraphs += line + ' ';
    }
  });

  if (inParagraph) {
    paragraphs += '</p>';
  }

  return paragraphs;
};

const loadWriting = async () => {
  loading.value = true;
  error.value = null;
  
  try {
    const id = route.params.id;
    console.log(`[loadWriting] Loading writing with ID: ${id}`);
    
    // writings.json에서 해당 ID의 글 찾기
    const writingData = writingsData.writings.find(w => w.id === id);
    
    if (!writingData) {
      throw new Error(`ID가 ${id}인 글을 찾을 수 없습니다`);
    }
    
    writing.value.title = writingData.title;
    writing.value.summary = writingData.summary;

    // 파일 경로 준비
    let filePath = writingData.filePath;
    if (!filePath.startsWith('/')) {
      filePath = '/' + filePath;
    }
    
    console.log(`[loadWriting] 파일 경로: ${filePath}`);
    
    // 파일 로드 시도 1: 상대 경로
    try {
      const response = await fetch(filePath);
      
      if (!response.ok) {
        throw new Error(`서버 응답 오류: ${response.status}`);
      }
      
      const text = await response.text();
      writing.value.content = convertMarkdownToHtml(text);
      console.log(`[loadWriting] 파일 로드 성공 (상대 경로)`);
    } catch (fetchError) {
      console.error(`[loadWriting] 상대 경로 로드 실패: ${fetchError.message}`);
      
      // 파일 로드 시도 2: 절대 경로
      try {
        const absolutePath = window.location.origin + filePath;
        console.log(`[loadWriting] 절대 경로 시도: ${absolutePath}`);
        
        const response = await fetch(absolutePath);
        
        if (!response.ok) {
          throw new Error(`서버 응답 오류 (절대 경로): ${response.status}`);
        }
        
        const text = await response.text();
        writing.value.content = convertMarkdownToHtml(text);
        console.log(`[loadWriting] 파일 로드 성공 (절대 경로)`);
      } catch (absoluteFetchError) {
        console.error(`[loadWriting] 절대 경로 로드 실패: ${absoluteFetchError.message}`);
        throw new Error(`마크다운 파일을 로드할 수 없습니다: ${fetchError.message}`);
      }
    }
  } catch (err) {
    console.error(`[loadWriting] 오류 발생: ${err.message}`);
    error.value = err.message;
  } finally {
    loading.value = false;
  }
};

// ID가 변경될 때마다 글 다시 로드
watch(() => route.params.id, (newId, oldId) => {
  if (newId !== oldId) {
    loadWriting();
  }
});

onMounted(() => {
  loadWriting();
});
</script>

<style scoped>
.top {
  padding-bottom: 1rem;
  margin-bottom: 1rem;
}

.writing-detail {
  padding: 1rem;
  max-width: 800px;
  margin: 0 auto;
}

.title {
  font-size: 1.5rem;
  margin-bottom: 0.75rem;
}

.loading {
  text-align: center;
  padding: 2rem;
}

.error {
  color: red;
  text-align: center;
  padding: 2rem;
}

@media (min-width: 768px) {
  .writing-detail {
    padding: 2rem;
  }
}
</style>