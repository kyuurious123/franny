<template>
  <div class="relative z-1 text-neutral-900">
    <!-- 메인 콘텐츠 영역 -->
    <div class="content-area">
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

    <!-- 모자이크 덮개 -->
    <div 
      v-show="isHidden" 
      class="mosaic-cover"
      :style="{ 
        display: isHidden ? 'grid' : 'none',
        gridTemplateColumns: `repeat(${cols}, 15px)`,
        gridTemplateRows: `repeat(${rows}, 15px)`
      }"
    >
      <div
        v-for="(piece, index) in pieces"
        :key="index"
        class="mosaic-piece"
        :style="{ 
          opacity: piece.visible ? 1 : 0,
          transform: piece.visible ? 'scale(1)' : 'scale(0)'
        }"
      ></div>
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

// 모자이크 관련 상태
const isHidden = ref(true);
const isRevealing = ref(false);
const cols = ref(0);
const rows = ref(0);
const pieces = ref<Array<{ visible: boolean }>>([]);

// 마크다운을 렌더링하는 computed 속성
const renderedMarkdown = computed((): string => {
  return markdownContent.value ? (marked.parse(markdownContent.value) as string) : '';
});

// 모자이크 조각 초기화
function initMosaic() {
  const containerWidth = window.innerWidth;
  const containerHeight = window.innerHeight;
  
  cols.value = Math.floor(containerWidth / 15);
  rows.value = Math.floor(containerHeight / 15);
  
  const totalPieces = cols.value * rows.value;
  pieces.value = Array.from({ length: totalPieces }, () => ({ visible: true }));
  
  console.log(`모바일 모자이크 초기화: ${cols.value}x${rows.value} = ${totalPieces}개 조각`);
}

// 콘텐츠 공개 애니메이션
function revealContent() {
  if (isRevealing.value) return;
  
  console.log('모바일 콘텐츠 공개 시작');
  isRevealing.value = true;
  
  // 랜덤 순서로 조각 인덱스 생성
  const indices = Array.from({ length: pieces.value.length }, (_, i) => i);
  const shuffled = indices.sort(() => Math.random() - 0.5);
  
  const batchSize = 100; // 한번에 100개씩
  const batchDelay = 50; // 50ms마다

  for (let batch = 0; batch < shuffled.length; batch += batchSize) {
    setTimeout(() => {
      for (let i = batch; i < Math.min(batch + batchSize, shuffled.length); i++) {
        pieces.value[shuffled[i]].visible = false;
      }
      
      if (batch + batchSize >= shuffled.length) {
        setTimeout(() => {
          isHidden.value = false;
          isRevealing.value = false;
          console.log('모바일 공개 완료');
        }, 200);
      }
    }, Math.floor(batch / batchSize) * batchDelay);
  }
}

// 콘텐츠 숨기기
function hideContent() {
  console.log('모바일 콘텐츠 숨기기');
  isHidden.value = true;
  isRevealing.value = false;
  
  // 모든 조각 다시 표시
  pieces.value.forEach(piece => {
    piece.visible = true;
  });
}

// URL 변경 감지
watch(() => route.params.id, (newId) => {
  if (newId) {
    const post = posts.value.find(p => p.number === newId);
    if (post) {
      viewDetail(post);
    }
  }
});

onMounted(async () => {
  console.log('DfestaMobileSample 마운트');
  
  // 모자이크 초기화
  initMosaic();

  // 화면 크기 변경 대응
  window.addEventListener('resize', () => {
    initMosaic();
  });

  // URL 파라미터에서 id를 가져옴
  const postId = route.params.id;
  
  if (postId) {
    const post = posts.value.find(p => p.number === postId);
    if (post) {
      await viewDetail(post);
    } else {
      await viewDetail(posts.value[0]);
    }
  } else {
    await viewDetail(posts.value[0]);
  }

  // 페이지 로드 후 자동으로 모자이크 제거
  setTimeout(() => {
    revealContent();
  }, 500); // 0.5초 후 자동 공개
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

/* 콘텐츠 영역 */
.content-area {
  position: relative;
  width: 100%;
  height: 100%;
  background: white;
  z-index: 1;
}

/* 모자이크 덮개 */
.mosaic-cover {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 10;
  gap: 0;
}

.mosaic-piece {
  background: #dc2626;
  width: 15px;
  height: 15px;
  transition: opacity 0.05s ease-out, transform 0.05s ease-out;
}
</style>