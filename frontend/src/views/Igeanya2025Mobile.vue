<template>
  <div class="p-4">
    <!-- 헤더 영역 -->
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-xl font-bold">글 목록</h2>
      <button @click="goToSample" class="text-blue-500 flex items-center">
        <span class="mr-1">←</span> 소개 페이지
      </button>
    </div>
    
    <!-- 글 목록 -->
    <div>
      <ul class="space-y-2 mb-6">
        <li
          v-for="(post, index) in posts"
          :key="index"
          @click="viewDetail(post)"
          class="cursor-pointer border-b pb-2 hover:bg-gray-100 p-2"
          :class="{ 'line-through': selected?.title === post.title }"
        >
          {{ post.number }}
          {{ post.title }}
        </li>
      </ul>
    </div>

    <!-- 글 상세 (목록 아래에 표시) -->
    <div v-if="selected" class="mt-8 border-t pt-4">
      <h3 class="text-xl font-bold mb-4">{{ selected.title }}</h3>
      <div v-if="loading" class="text-center py-4">
        불러오는 중...
      </div>
      <div v-else-if="error" class="text-red-500 py-4">
        {{ error }}
      </div>
      <div v-else-if="htmlContent" v-html="htmlContent" class="prose max-w-none text-[15px] leading-[1.8] indent-3" />
      <div v-else class="text-gray-500 py-4">
        글을 선택하면 내용이 여기에 표시됩니다.
      </div>
      
      <!-- 이전/다음 글 네비게이션 -->
      <div class="flex justify-between mt-8 pt-4 border-t">
        <button 
          @click="navigateToPrevious" 
          class="px-3 py-2 bg-gray-100 rounded hover:bg-gray-200 flex items-center"
          :disabled="!hasPrevious"
          :class="{ 'opacity-50 cursor-not-allowed': !hasPrevious }"
        >
          <span class="mr-1">←</span> 이전 글
        </button>
        
        <button 
          @click="navigateToNext" 
          class="px-3 py-2 bg-gray-100 rounded hover:bg-gray-200 flex items-center"
          :disabled="!hasNext"
          :class="{ 'opacity-50 cursor-not-allowed': !hasNext }"
        >
          다음 글 <span class="ml-1">→</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import { marked } from 'marked';
import { useRouter } from 'vue-router';

const router = useRouter();

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

// 페이지 로드 시 첫 번째 글 미리 로드
onMounted(() => {
  // 첫 번째 글 자동 로드
  viewDetail(posts.value[0]);
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
</style>