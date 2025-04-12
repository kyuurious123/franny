<template>
    <div class="flex h-screen bg-book text-neutral-900">
      <!-- 좌측 영역 -->
      <div class="w-1/2 border-r border-black overflow-scroll">
        <header class="px-6 py-2">
          <button @click="$router.push('/')" class="bg-transparent text-black font-normal text-base hover:bg-transparent">← 홈으로</button>
        </header>
        <div class="mt-4">
          <!-- 책 표지 -->
          <div class="border-b border-black pb-8">
            <img src="https://blog.kakaocdn.net/dn/cjprU5/btsNi3IVkz9/K6TwmJd2YcIBbypbP3IzS0/img.png" alt="" class="w-[60%] m-auto">
            <p class="text-center mt-2 text-neutral-500 italic text-xs">표지 계란님(@egg_bst)</p>

          </div>
          <!-- 책 정보 -->
          <div class="px-10 py-8">
            <img :src="book1Title" alt="" class="w-[80%] m-auto">
          </div>
          <div class="space-y-2 px-10">
            <p class="mb-4 text-sm text-gray-500">무선제본, B6, 150p↑ (변동O)</p>
            <p class="text-[15px] leading-7">SCOOP의 새로운 기획으로 여배우 배이현과 얽힌 사이비 종교 ‘영명교’의 취재를 이어가던 승연과 세일. 그러던 어느 날, 두 사람에게 예기치 못한 일이 일어나는데...</p>

            <!-- <p class="text-lg leading-8">SCOOP의 새로운 기획으로 여배우 배이현과 얽힌 사이비 종교 ‘영명교’의 취재를 이어가던 승연과 세일. 그러던 어느 날, 승연은 싸늘한 주검으로 돌아온다. 경찰은 자살이라 단정하지만, 세일은 수사에 석연치 않은 점을 느낀다. 이에 세일은 규혁과 함께 승연의 죽음에 얽힌 비밀을 파헤치기 시작한다. <br>그러나 파고들수록, 자신이 알지 못했던 승연의 또 다른 얼굴과 마주하게 되고, 세일은 진실에서 점점 더 멀어지는 느낌에 사로잡히는데…</p> -->
          </div>
        </div>
      </div>
  
      <!-- 우측 영역 -->
      <div class="w-1/2 overflow-y-auto p-10">
        <ul class="text-3xl mb-20">
          <li
            v-for="(post, index) in posts"
            :key="index"
            @click="updateContent(post)"
            class="cursor-pointer sample-title mb-4"
            :class="{ 'line-through': selected?.title === post.title }"
          >
            {{ post.number }}.
            {{ post.title }}
          </li>
        </ul>
  
        <div v-html="htmlContent" class="prose max-w-none indent-2 leading-6 text-[15px] sample-content text-neutral-800" />
        
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref, onMounted } from 'vue';
  import { marked } from 'marked';
  import book1Title from '/src/assets/book1title.svg'
  import { useRoute } from 'vue-router';

  const route = useRoute();
  
  // public/bestar 폴더에 있는 마크다운 파일들
  const posts = ref([
    { title: '시작', number: '01', path: '/public/writing/bestar/13.md' },
    { title: '견착', number: '02', path: '/public/writing/bestar/14.md' },
    { title: '침투', number: '03', path: '/public/writing/bestar/15.md' }
  ]);
  
  const selected = ref(posts.value[0]);
  const htmlContent = ref('');

  async function updateContent(post: { title: string; number: string; path: string }) {
  selected.value = post;
  const res = await fetch(post.path);
  const rawText = await res.text();
  // 타입 단언 추가
  htmlContent.value = marked.parse(rawText) as string;
}
  onMounted(() => {
  const postId = route.params.id;
  // post 타입 문제 수정
  if (postId) {
    const post = posts.value.find(p => p.number === postId);
    if (post) {
      selected.value = post;  // 이제 타입이 일치함
    }
  }

  
  // 선택된 글 로드
  updateContent(selected.value);
});
  
  </script>
  
  <style scoped>
  .prose {
    line-height: 1.7;
  }

  .bg-book {
    background: linear-gradient(to bottom, #D9E3E2, #FFFFFF);
  }

  .sample-title {
    font-family: 'BookkMyungjo-Bd';
  }

  .sample-content :deep(p) {
    margin-bottom: 0.5rem;
  }
  </style>
  