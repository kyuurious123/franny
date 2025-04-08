<template>
    <div class="p-4">
      <!-- 글 목록 -->
      <div v-if="currentView === 'list'">
        <h2 class="text-xl font-bold mb-4">글 목록</h2>
        <ul class="space-y-2">
          <li
            v-for="(post, index) in posts"
            :key="index"
            @click="viewDetail(post)"
            class="cursor-pointer border-b pb-2 hover:underline"
          >
            {{ post.title }}
          </li>
        </ul>
      </div>
  
      <!-- 글 상세 -->
      <div v-else>
        <button class="mb-4 text-blue-500" @click="currentView = 'list'">← 목록으로</button>
        <div v-html="htmlContent" class="prose max-w-none" />
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref } from 'vue';
  import { marked } from 'marked';
  
  // 파일 이름 기반 글 목록
  const posts = ref([
    { title: '글 1', path: '/bestar/12.md' },
    { title: '글 2', path: '/bestar/13.md' },
  ]);
  
  const currentView = ref<'list' | 'detail'>('list');
  const selected = ref(posts.value[0]);
  const htmlContent = ref('');
  
  // fetch로 md 파일 내용 불러오고 marked로 변환
  async function viewDetail(post: { title: string; path: string }) {
    selected.value = post;
    const res = await fetch(post.path);
    const rawText = await res.text();
    htmlContent.value = marked.parse(rawText);
    currentView.value = 'detail';
  }
  </script>
  
  <style scoped>
  .prose {
    line-height: 1.7;
  }
  </style>
  