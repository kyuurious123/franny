<template>
    <div class="flex h-screen bg-book">
      <!-- 좌측 영역 -->
      <div class="w-1/2 border-r border-black">
        <header class="px-6 py-3">
          <button @click="$router.push('/')" class="bg-transparent text-black font-normal text-base">← 홈으로</button>
        </header>
        <div class="mt-4">
          <!-- 책 표지 -->
          <div class="border-b border-black pb-8">
            <img :src="book1" alt="" class="w-[280px] m-auto">

          </div>
          <!-- 책 정보 -->
          <div class="px-10 py-8">
            <img :src="book1Title" alt="">
            <p>사양 준비중</p>
          </div>
          <div class="space-y-2">
            <p>줄거리 준비중</p>
          </div>
        </div>
      </div>
  
      <!-- 우측 영역 -->
      <div class="w-1/2 overflow-y-auto">
        <h2 class="text-xl font-semibold mb-2">글 목록</h2>
        <ul class="space-y-1 mb-4">
          <li
            v-for="(post, index) in posts"
            :key="index"
            @click="updateContent(post)"
            class="cursor-pointer hover:underline"
          >
            {{ post.number }}
            {{ post.title }}
          </li>
        </ul>
  
        <hr class="mb-4" />
  
        <div v-html="htmlContent" class="prose max-w-none" />
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref } from 'vue';
  import { marked } from 'marked';
  import book1 from '/src/assets/sample1.png'
  import book1Title from '/src/assets/book1title.svg'


  
  // public/bestar 폴더에 있는 마크다운 파일들
  const posts = ref([
    { title: '시작', number: '01', path: '/public/writing/bestar/12.md' },
    { title: '견착', number: '02', path: '/public/writing/bestar/13.md' },
    { title: '침투', number: '03', path: '/public/writing/bestar/14.md' }
  ]);
  
  const selected = ref(posts.value[0]);
  const htmlContent = ref('');
  
  // fetch + marked 방식으로 마크다운 내용 보여주기
  async function updateContent(post: { title: string; path: string }) {
    selected.value = post;
    const res = await fetch(post.path);
    const rawText = await res.text();
    htmlContent.value = marked.parse(rawText);
  }
  
  
  // 초기 글 설정
  updateContent(selected.value);
  </script>
  
  <style scoped>
  .prose {
    line-height: 1.7;
  }

  .bg-book {
    background: linear-gradient(to bottom, #FEF6F7, #FFFFFF);
  }
  </style>
  