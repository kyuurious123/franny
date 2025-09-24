<template>
    <div class="flex h-screen text-neutral-900 bg-[#dc2626]">
      <!-- 좌측 영역 - 컨트롤 패널 -->
      <div class="w-1/2 border-r border-black overflow-scroll scrollbar-none">
        <header class="px-6 py-2">
          <button @click="$router.push('/')" class="bg-transparent text-black font-normal text-base hover:bg-transparent">← 홈으로</button>
        </header>
        
        <div class="mt-4">
          <!-- 이벤트 포스터 -->
          <div class="mb-8 text-center">
            <div class="relative mb-16">
                <img src="https://blog.kakaocdn.net/dna/l4YJg/btsQzlM6y6y/AAAAAAAAAAAAAAAAAAAAAPiyvcbHqe97Pd5g2IQuaSgpx4eEiB24aXXBz6HGQB47/img.png?credential=yqXZFxpELC7KVnFOS48ylbz2pIh7yKj8&expires=1759244399&allow_ip=&allow_referer=&signature=CFg8I7xmlhiDgAjvhBTa4cJ1gC8%3D" class="m-auto w-[65%]">
                <img :src="dfTitle" alt="" class="absolute bottom-[-7%] w-[60%] left-[15%]">
            </div>
          </div>

          <!-- 링크 영역 -->
          <div class="flex border-t border-black h-12 justify-between no-underline">
            <button 
                @click="revealContent"
                :disabled="isRevealing"
                class="w-full border-black border-r font-bold"
              >
                {{ isRevealing ? '샘플 읽기 →' : '샘플 읽기 →' }}
            </button>
            <a class="w-full flex justify-center items-center !no-underline" href="https://tmm.im/p/53808" target="_blank">
                선입금/통판 폼 (~9/29) →
            </a>

          </div>
            
          <!-- 모자이크 컨트롤 -->
          <div class="p-8 border-t border-black">
            <div>
              <div class="mb-4">
                <span class="text-sm opacity-80 italic mr-2">
                표지 계란(<a href="https://x.com/egg_conan" target="_blank">@egg_conan</a>)님
                </span>
                <span class="text-sm">무선제본, 비규격(115*190), 110p(예상), 12,000원</span>
              </div>
                
                <p class="leading-8 mb-8">카루이자와의 쇼룸에서 일어난 작품 도난 사건을 담당하게 된 타카아키. 현장 조사를 포함해, 운영 기록과 회계 내역을 확인하는 과정에서 쇼룸이 범죄 조직의 자금 세탁에 이용되고 있음을 알게된다.<br />한편, 조직에 잠입해 있던 스카치는 상부로부터 쇼룸 오너와 자신의 형, 모로후시 타카아키를 제거하라는 지시를 받고 나가노로 향하는데…</p>
            </div>
          </div>
        </div>
      </div>
  
      <!-- 우측 영역 - 컨텐츠 -->
      <div class="w-1/2 relative overflow-hidden">
        <!-- 숨겨진 컨텐츠 -->
        <div class="content-area">
          <div class="h-full overflow-y-auto">
            <!-- 이벤트 목록 -->
            <ul class="text-3xl mb-20 font-[BookkMyungjo-Bd] mt-10 break-keep leading-[1.4]">
              <li
                v-for="(post, index) in posts"
                :key="index"
                @click="updateContent(post)"
                class="cursor-pointer mb-4 text-black line-through italic"
                :class="{ 
                  '!no-underline': selected?.title === post.title,
                  'ml-40': index >= 4
                }"
              >
                {{ post.title }}
              </li>
            </ul>

            <!-- 선택된 컨텐츠 -->
            <div v-if="selected" class="content-detail px-10 mb-20">
              <div v-html="htmlContent" class="prose max-w-none indent-2 leading-7 text-base dfesta-content text-neutral-800" />
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
    </div>
</template>
  
<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { marked } from 'marked';
import dfTitle from '/src/assets/dftitle.svg';


const posts = ref([
  { title: '그 날, 손바닥에 마지막으로 새겨진 감각은 히로미츠의 부드러운 피부, 따뜻한 체온이었다.', path: './writing/dc/sample1.md' },
  { title: '지옥에 갇혀본 자는 안다. 한번 지옥은 영원한 지옥. 그곳을 빠져나온 것처럼 언제든 다시 돌아갈 수도 있단 사실을.', path: './writing/dc/sample2.md' }
]);

const selected = ref(posts.value[0]);
const htmlContent = ref('');
const isRevealing = ref(false);
const isHidden = ref(true);

// 모자이크 관련
const cols = ref(0);
const rows = ref(0);
const pieces = ref<Array<{ visible: boolean }>>([]);

// 모자이크 조각 초기화
function initMosaic() {
  const containerWidth = window.innerWidth * 0.5;
  const containerHeight = window.innerHeight;
  
  cols.value = Math.floor(containerWidth / 15);
  rows.value = Math.floor(containerHeight / 15);
  
  const totalPieces = cols.value * rows.value;
  pieces.value = Array.from({ length: totalPieces }, () => ({ visible: true }));
  
  console.log(`모자이크 초기화: ${cols.value}x${rows.value} = ${totalPieces}개 조각`);
}

async function updateContent(post: { title: string; path: string }) {
  selected.value = post;
  try {
    const res = await fetch(post.path);
    const rawText = await res.text();
    htmlContent.value = marked.parse(rawText) as string;
  } catch (error) {
    htmlContent.value = '<p>컨텐츠를 불러올 수 없습니다.</p>';
  }
}

// 컨텐츠 공개
function revealContent() {
  if (isRevealing.value) return;
  
  console.log('컨텐츠 공개 시작');
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
            console.log('공개 완료');
        }, 200);
        }
    }, Math.floor(batch / batchSize) * batchDelay);
    }
}

onMounted(async () => {
  console.log('DfestaDesktop 마운트');
  await updateContent(selected.value);
  initMosaic();
  
  // 초기 컨텐츠 로드
  await updateContent(selected.value);
  
  // 모자이크 초기화
  initMosaic();

  window.addEventListener('resize', () => {
    initMosaic();
  });
  
});
</script>
  
<style scoped>
.dfesta-content :deep(p) {
  margin-bottom: 1rem;
}

.dfesta-content :deep(h1),
.dfesta-content :deep(h2),
.dfesta-content :deep(h3) {
  color: #dc2626;
  margin-top: 2rem;
  margin-bottom: 1rem;
}

/* 컨텐츠 영역 */
.content-area {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: white;
  z-index: 1;
}

/* 모자이크 덮개 */
.mosaic-cover {
  position: absolute;
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
  transition: opacity 0.05s ease-out, transform 0.05s ease-out; /* 0.2s → 0.05s로 빠르게 */
}

.prose {
  line-height: 1.8;
}

.scrollbar-none {
  -ms-overflow-style: none;
}


.scrollbar-none::-webkit-scrollbar{
  display:none;
}
</style>