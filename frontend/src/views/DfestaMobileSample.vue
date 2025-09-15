
<template>
  <div class="relative z-1 text-neutral-900">
    <!-- 헤더 영역 -->
    <div class="p-4">
      <a @click="goToSample" class="no-underline font-normal text-base hover:bg-transparent">
        <span class="mr-1">←</span>뒤로
      </a>
    </div>
    
    <!-- 이벤트 목록 -->
    <div class="p-4 mt-2 mb-10">
      <ul class="text-xl font-[BookkMyungjo-Bd]">
        <li
          v-for="(post, index) in posts"
          :key="index"
          @click="viewDetail(post)"
          class="cursor-pointer dfesta-title mb-4 bg-black text-black"
          :class="{ 
              '!bg-white': selected?.title === post.title,
              'ml-20': index >= 4
            }"
        >
        {{ post.title }}
        </li>
      </ul>
    </div>

    <!-- 상세 내용 (목록 아래에 표시) -->
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
        이벤트를 선택하면 내용이 여기에 표시됩니다.
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
  path: string;
}

const posts = ref<Post[]>([
  { title: '"그 날, 타카아키의 손바닥에 마지막으로 새겨진 감각은 히로미츠의 부드러운 피부, 따뜻한 체온이었다."', path: './writing/dc/sample1.md' },
  { title: '"지옥에 갇혀본 자는 안다. 한번 지옥은 영원한 지옥. 언제나 같은 자리에서 자신을 기다리고 있고 그곳을 빠져나온 것처럼 언제든 다시 돌아갈 수도 있단 사실을."', path: './writing/dc/sample2.md' }
]);

const selected = ref<Post | null>(null);
const markdownContent = ref('');
const loading = ref(false);
const error = ref('');

// 마크다운을 렌더링하는 computed 속성
const renderedMarkdown = computed((): string => {
  return markdownContent.value ? (marked.parse(markdownContent.value) as string) : '';
});

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
    const post = posts.value.find(p => p.number === postId);
    if (post) {
      viewDetail(post);
    } else {
      viewDetail(posts.value[0]);
    }
  } else {
    viewDetail(posts.value[0]);
  }
});

// 마크다운 로드 및 표시 함수
async function viewDetail(post: Post): Promise<void> {
  if (selected.value?.title === post.title && markdownContent.value) {
    return;
  }
  
  selected.value = post;
  loading.value = true;
  error.value = '';
  markdownContent.value = '';
  
  try {
    console.log('파일 경로:', post.path);
    const res = await fetch(`${post.path}?t=${new Date().getTime()}`, { cache: "no-store" });
    
    if (!res.ok) {
      throw new Error(`파일을 불러올 수 없습니다. (상태 코드: ${res.status})`);
    }
    
    const rawText = await res.text();
    
    if (rawText.trim() === '') {
      throw new Error('콘텐츠가 비어있습니다.');
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
  router.push('/dfesta/sample');
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
</style>