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
    <div class="px-8 py-4 mt-4 mb-10">
      <ul class="text-2xl">
        <li
          v-for="(post, index) in posts"
          :key="index"
          @click="viewDetail(post)"
          class="cursor-pointer sample-title mb-4"
          :class="{ 'line-through': selected?.title === post.title }"
        >
          {{ post.number }}
          {{ post.title }}
        </li>
      </ul>
    </div>

    <!-- 글 상세 (목록 아래에 표시) -->
    <div v-if="selected" class="mt-8 p-4 text-neutral-900">
      <div v-if="loading" class="text-center py-4">
        불러오는 중...
      </div>
      <div v-else-if="error" class="text-red-500 py-4">
        {{ error }}
      </div>
      <div v-else-if="htmlContent" v-html="htmlContent" class="prose max-w-none text-[15px] leading-[1.8] indent-3 sample-content" />
      <div v-else class="text-neutral-500 py-4">
        글을 선택하면 내용이 여기에 표시됩니다.
      </div>
      
      <!-- 이전/다음 글 네비게이션 -->
      <div class="flex justify-between mt-8">
        <a 
          @click="navigateToPrevious" 
          class="px-3 py-2 rounded flex items-center no-underline"
          :disabled="!hasPrevious"
          :class="{ 'opacity-50 cursor-not-allowed': !hasPrevious }"
        >
          <span class="mr-1">←</span> 이전 글
      </a>
        
        <a 
          @click="navigateToNext" 
          class="px-3 py-2 rounded flex items-center no-underline"
          :disabled="!hasNext"
          :class="{ 'opacity-50 cursor-not-allowed': !hasNext }"
        >
          다음 글 <span class="ml-1">→</span>
    </a>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import { marked } from 'marked';
import { useRouter } from 'vue-router';
import { useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();


const posts = ref([
    { title: '시작', number: '01', path: '/public/writing/bestar/13.md' },
    { title: '견착', number: '02', path: '/public/writing/bestar/14.md' },
    { title: '침투', number: '03', path: '/public/writing/bestar/15.md' }
  ]);

const selected = ref(posts.value[0]);
const htmlContent = ref('');
const loading = ref(false);
const error = ref('');

// 현재 선택된 글의 인덱스
const currentIndex = computed(() => {
  if (!selected.value) return -1;
  return posts.value.findIndex(post => post.title === selected.value.title);
});

// 이전/다음 글 존재 여부
const hasPrevious = computed(() => currentIndex.value > 0);
const hasNext = computed(() => currentIndex.value < posts.value.length - 1);

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

// fetch로 md 파일 내용 불러오고 marked로 변환
async function viewDetail(post: { title: string; path: string; number: string }) {
  // 같은 글을 다시 클릭하면 아무것도 하지 않음
  if (selected.value?.title === post.title && htmlContent.value) {
    return;
  }
  
  selected.value = post;
  loading.value = true;
  error.value = '';
  
  try {
    const res = await fetch(post.path);
    
    if (!res.ok) {
      throw new Error(`파일을 불러올 수 없습니다. (상태 코드: ${res.status})`);
    }
    
    const rawText = await res.text();
    htmlContent.value = marked.parse(rawText);
  } catch (err) {
    console.error('파일 로딩 오류:', err);
    error.value = `콘텐츠를 불러오는 데 실패했습니다: ${err instanceof Error ? err.message : '알 수 없는 오류'}`;
  } finally {
    loading.value = false;
  }
}

// 이전 글로 이동
function navigateToPrevious() {
  if (hasPrevious.value) {
    viewDetail(posts.value[currentIndex.value - 1]);
  }
}

// 다음 글로 이동
function navigateToNext() {
  if (hasNext.value) {
    viewDetail(posts.value[currentIndex.value + 1]);
  }
}

// 소개 페이지로 이동
function goToSample() {
  router.push('/igeanya2025/sample');
}
</script>

<style scoped>
.prose {
  line-height: 1.8;
  font-size: 15px;
  text-indent: 0.5rem;
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
  background: linear-gradient(to bottom, #D9E3E2, #FFFFFF);
  z-index: -1; /* 내용보다 뒤에 배치 */
  pointer-events: none; /* 클릭 이벤트가 배경을 통과하게 함 */
}


</style>