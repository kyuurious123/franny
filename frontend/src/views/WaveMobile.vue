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

// Post 타입: path만 사용
interface Post {
  path: string;
}

// 개발 모드 체크 (선택적)
const isDev = ref(false);
try {
  isDev.value = import.meta.env?.MODE === 'development';
} catch (e) {
  console.error('환경 변수 확인 오류:', e);
}

// 포스트 목록 (path만 포함)
const posts = ref<Post[]>([
  { path: './writing/bestar/19.md' }
]);

const selected = ref<Post | null>(null);
const markdownContent = ref('');
const loading = ref(false);
const error = ref('');

// 렌더링된 마크다운
const renderedMarkdown = computed((): string => {
  return markdownContent.value ? (marked.parse(markdownContent.value) as string) : '';
});

// URL 파라미터 변경 감지
watch(() => route.params.id, (newId) => {
  if (newId) {
    const post = posts.value.find(p => p.path.includes(`${newId}.md`));
    if (post) {
      viewDetail(post);
    }
  }
});

// 최초 마운트 시 처리
onMounted(() => {
  const postId = route.params.id;

  if (postId) {
    const post = posts.value.find(p => p.path.includes(`${postId}.md`));
    if (post) {
      viewDetail(post);
      return;
    }
  }

  // 기본 글 로드
  viewDetail(posts.value[0]);
});

// 마크다운 파일 불러오기
async function viewDetail(post: Post): Promise<void> {
  if (selected.value?.path === post.path && markdownContent.value) {
    return;
  }

  selected.value = post;
  loading.value = true;
  error.value = '';
  markdownContent.value = '';

  try {
    const res = await fetch(`${post.path}?t=${Date.now()}`, { cache: 'no-store' });
    if (!res.ok) {
      throw new Error(`파일을 불러올 수 없습니다. (상태 코드: ${res.status})`);
    }

    const rawText = await res.text();

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

// 뒤로가기
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