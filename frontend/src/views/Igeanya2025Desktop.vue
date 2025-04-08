<template>
    <div class="flex h-screen">
      <!-- 좌측 영역 -->
      <div class="w-1/2 p-4 border-r">
        <header>
          <button @click="$router.push('/')">← 홈으로</button>
        </header>
        <div class="mt-4">
          <p class="font-bold mb-2">📌 하드코딩된 정보</p>
          <div class="space-y-2">
            <button class="bg-gray-200 px-3 py-1 rounded" @click="selectCategory('category1')">카테고리 1</button>
            <button class="bg-gray-200 px-3 py-1 rounded" @click="selectCategory('category2')">카테고리 2</button>
          </div>
        </div>
      </div>
  
      <!-- 우측 영역 -->
      <div class="w-1/2 p-4 overflow-y-auto">
        <h2 class="text-xl font-semibold mb-2">글 목록</h2>
        <ul class="space-y-1 mb-4">
          <li
            v-for="(post, index) in posts"
            :key="index"
            @click="updateContent(post)"
            class="cursor-pointer hover:underline"
          >
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
  
  // public/bestar 폴더에 있는 마크다운 파일들
  const posts = ref([
    { title: '글 1', path: '/bestar/12.md' },
    { title: '글 2', path: '/bestar/13.md' },
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
  
  // 카테고리 선택은 지금은 기능 없음 (필요시 추가 가능)
  function selectCategory(category: string) {
    console.log(`선택된 카테고리: ${category}`);
  }
  
  // 초기 글 설정
  updateContent(selected.value);
  </script>
  
  <style scoped>
  .prose {
    line-height: 1.7;
  }
  </style>
  