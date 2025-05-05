<template>
  <div class="fixed-gradient"></div>
  <div class="relative z-1 text-neutral-900">
    <!-- 헤더 영역 -->
    <div class="p-4">
      <a @click="goToSample" class="no-underlin font-normal text-base hover:bg-transparent">
        <span class="mr-1">←</span>뒤로
      </a>
    </div>
    
    <!-- 글 목록 -->
    <div class="px-8 py-4 mt-2 mb-10">
      <ul class="text-2xl">
        <li
          v-for="(post, index) in posts"
          :key="index"
          @click="viewDetail(post)"
        >
        </li>
      </ul>
    </div>

    <!-- 글 상세 (목록 아래에 표시) -->
    <div v-if="selected" class="mt-8 pb-10 p-4 text-neutral-900">
      <div v-if="loading" class="text-center py-4">
        불러오는 중...
      </div>
      <div v-else-if="error" class="text-red-500 py-4">
        {{ error }}
      </div>
      <div 
        v-else-if="renderedMarkdown" 
        v-html="renderedMarkdown" 
        class="prose max-w-none text-base leading-[1.8] indent-3 markdown-body"
      ></div>
      <div v-else class="text-neutral-500 py-4">
        글을 선택하면 내용이 여기에 표시됩니다.
      </div>
      
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed, watch } from 'vue';
import { marked } from 'marked';
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();

// 타입 정의
interface Post {
  title: string;
  number: string;
  path: string;
}

// 개발 모드 체크를 위한 변수
const isDev = ref(false);

// NODE_ENV 확인을 위한 방법 변경
try {
  // @ts-ignore - Vite 환경에서는 import.meta.env를 사용
  isDev.value = import.meta.env?.MODE === 'development';
} catch (e) {
  // 예외 발생 시 기본값은 false
  console.error('환경 변수 확인 오류:', e);
}

const posts = ref<Post[]>([
  { path: './writing/bestar/19.md' }

]);

const selected = ref<Post | null>(null);
const markdownContent = ref('');
const loading = ref(false);
const error = ref('');

// 마크다운을 렌더링하는 computed 속성
const renderedMarkdown = computed((): string => {
  return markdownContent.value ? (marked.parse(markdownContent.value) as string) : '';
});

// // 현재 선택된 글의 인덱스
// const currentIndex = computed(() => {
//   if (!selected.value) return -1;
//   const selectedPost = selected.value as Post;
//   return posts.value.findIndex(post => post.title === selectedPost.title);
// });

// URL 변경 감지
watch(() => route.params.id, (newId) => {
  if (newId) {
    const post = posts.value.find(p => p.number === newId);
    if (post) {
      viewDetail(post);
    }
  }
});

onMounted(() => {
  // URL 파라미터에서 id를 가져옴
  const postId = route.params.id;
  
  if (postId) {
    // id가 숫자인 경우(01, 02, 03 등) 해당 포스트 찾기
    const post = posts.value.find(p => p.number === postId);
    
    if (post) {
      // 찾은 포스트 불러오기
      viewDetail(post);
    } else {
      // id를 찾지 못한 경우 첫 번째 글 로드
      viewDetail(posts.value[0]);
    }
  } else {
    // id가 없는 경우 첫 번째 글 로드
    viewDetail(posts.value[0]);
  }
});

// 마크다운 로드 및 표시 함수
async function viewDetail(post: Post): Promise<void> {
  // 같은 글을 다시 클릭하면 아무것도 하지 않음
  if (selected.value?.title === post.title && markdownContent.value) {
    return;
  }
  
  selected.value = post;
  loading.value = true;
  error.value = '';
  markdownContent.value = ''; // 기존 내용 초기화
  
  try {
    console.log('파일 경로:', post.path);
    // 캐시 방지를 위한 타임스탬프 추가
    const res = await fetch(`${post.path}?t=${new Date().getTime()}`, { cache: "no-store" });
    
    if (!res.ok) {
      throw new Error(`파일을 불러올 수 없습니다. (상태 코드: ${res.status})`);
    }
    
    const rawText = await res.text();
    console.log('마크다운 내용 길이:', rawText.length);
    
    if (rawText.trim() === '') {
      throw new Error('마크다운 내용이 비어있습니다.');
    }
    
    markdownContent.value = rawText;
  } catch (err) {
    console.error('파일 로딩 오류:', err);
    error.value = `콘텐츠를 불러오는 데 실패했습니다: ${err instanceof Error ? err.message : '알 수 없는 오류'}`;
  } finally {
    loading.value = false;
  }
}

// 소개 페이지로 이동
function goToSample(): void {
  router.push('/Wave/sample');
}
</script>

<style scoped>
.prose {
  line-height: 1.8;
  text-indent: 0.5rem;
}

.markdown-body {
  line-height: 1.8;
  word-wrap: break-word;
}

.markdown-body :deep(h1), 
.markdown-body :deep(h2), 
.markdown-body :deep(h3) {
  font-weight: bold;
  margin-top: 1rem;
  margin-bottom: 0.5rem;
}

.markdown-body :deep(p) {
  margin-bottom: 0.75rem;
  text-indent: 0.5rem;
}

.markdown-body :deep(pre) {
  background: #f4f4f4;
  padding: 10px;
  border-radius: 5px;
  overflow-x: auto;
}

.markdown-body :deep(blockquote) {
  border-left: 4px solid #ddd;
  padding-left: 10px;
  color: #666;
}

/* Vue 3에서는 :deep() 문법 사용 */
.prose :deep(h1), 
.prose :deep(h2), 
.prose :deep(h3) {
  margin-top: 1.5em;
  margin-bottom: 0.75em;
  font-weight: 600;
}

.prose :deep(p) {
  margin-bottom: 1em;
}

.prose :deep(ul), 
.prose :deep(ol) {
  padding-left: 1.5em;
  margin-bottom: 1em;
}

/* 링크 스타일 */
.prose :deep(a) {
  color: #3182ce;
  text-decoration: underline;
}


.sample-title {
  font-family: 'BookkMyungjo-Bd';
}

.sample-content :deep(p) {
  margin-bottom: 0.5rem;
}

.fixed-gradient {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  background: linear-gradient(to bottom, #E8F6FD, #FFFFFF);
  z-index: -1; /* 내용보다 뒤에 배치 */
  pointer-events: none; /* 클릭 이벤트가 배경을 통과하게 함 */
}
</style>