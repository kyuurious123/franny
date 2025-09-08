<template>
  <div class="writing-detail mt-10 md:mt-0">
    <div class="writing-detail__title">
      <p class="title">{{ writingTitle }}</p>
      <p class="summary">{{ writingSummary }}</p>
    </div>
    <div v-if="markdownContent" v-html="renderedMarkdown" class="markdown-body"></div>
    <p v-else>Loading...</p>
    <CommentSection :postId="String(currentPostId)" />
  </div>
</template>
  
<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import { useRoute } from 'vue-router';
import { marked } from 'marked';
import dcWritingsData from '../data/dcwritings.json';
import CommentSection from '../components/CommentSection.vue';

// Props 정의
const props = defineProps({
  id: {
    type: String,
    required: false
  }
});

const route = useRoute();
const markdownContent = ref('');
const writingTitle = ref('');
const writingSummary = ref('');

// props.id 또는 route.params.id에서 가져옴
const currentPostId = computed(() => {
  console.log("Props ID:", props.id);
  console.log("Route params ID:", route.params.id);
  return props.id || route.params.id || ''; // 빈 문자열 기본값 추가
});

// 글 데이터 로드 함수
const loadWritingData = () => {
  const postId = currentPostId.value;
  console.log("로드할 postId:", postId);
  
  if (!postId) {
    console.error("postId가 없습니다");
    return;
  }
  
  const writing = dcWritingsData.dcwritings.find(w => w.id === postId);
  console.log("찾은 writing 데이터:", writing);

  if (writing) {
    writingTitle.value = writing.title;
    writingSummary.value = writing.summary;
    
    if (writing.filePath) {
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
          markdownContent.value = data;
        })
        .catch(error => console.error("Markdown 로드 실패:", error));
    }
  } else {
    console.error("글을 찾을 수 없음:", postId);
  }
};

// 컴포넌트 마운트 시 데이터 로드
onMounted(() => {
  loadWritingData();
});

// currentPostId가 변경될 때마다 데이터 다시 로드
watch(currentPostId, (newId) => {
  if (newId) {
    loadWritingData();
  }
});

const renderedMarkdown = computed(() => {
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
    padding: 0;
    padding-top: 2rem;
  }
}

.markdown-body {
  line-height: 1.8;
  word-wrap: break-word;
}

.markdown-body h1, .markdown-body h2, .markdown-body h3 {
  font-weight: bold;
  margin-top: 1rem;
}

::v-deep(.markdown-body p) {
  margin-bottom: 0.75rem;
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