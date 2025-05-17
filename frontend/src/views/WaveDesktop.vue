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
            <img src="https://blog.kakaocdn.net/dn/yuvGQ/btsNwa2nWoa/3d1n63SxMNjiRHhfZ9j4o1/img.png" alt="" class="w-[50%] m-auto">
            <p class="text-center mt-2 text-neutral-500 italic text-xs">표지 작업중</p>

          </div>
          <!-- 선입금 -->
          <div class="border-b border-black py-2 text-center">
            <a href="https://tmm.im/p/45544" target="_blank" class="no-underline text-lg">선입금 / 통판 폼 (TMM) 5.5 14:00 ~ 5.12 12:00 →</a>
          </div>
          <!-- 책 정보 -->
          <div class="space-y-2 px-10 py-8">
            <p class="mb-4 text-sm text-gray-500">무선제본, B6, 40p↑ (변동O)</p>
            <p class="text-base leading-7">무대 붕괴 사고 후 3년이 지난 어느 날, 도윤은 규혁으로부터 뜻밖의 연락을 받는다. 규혁은 곧 결혼할 예정이라며, 여행을 함께 가지 않겠냐고 도윤에게 묻는다.
            </p>
          </div>
        </div>
      </div>
  
      <!-- 우측 영역 -->
      <div class="w-1/2 overflow-y-auto p-10">
        <div v-html="htmlContent" class="prose max-w-none indent-2 leading-6 text-base sample-content text-neutral-800" />
        
      </div>
    </div>
  </template>
  
<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { marked } from 'marked';
import { useRoute } from 'vue-router';

const route = useRoute();

const posts = ref([
  { path: './writing/bestar/19.md' }
]);

const selected = ref(posts.value[0]);
const htmlContent = ref('');

async function updateContent(post: { path: string }) {
  selected.value = post;
  const res = await fetch(post.path);
  const rawText = await res.text();
  htmlContent.value = marked.parse(rawText) as string;
}

onMounted(() => {
  const postId = route.params.id;

  if (postId) {
    const post = posts.value.find(p => p.path.includes(`${postId}.md`));
    if (post) {
      updateContent(post);
      return;
    }
  }

  // fallback: 첫 번째 글 표시
  updateContent(selected.value);
});

  
</script>
  
  <style scoped>
  .prose {
    line-height: 1.7;
  }

  .bg-book {
    background: linear-gradient(to bottom, #E8F6FD, #FFFFFF);
  }

  .sample-title {
    font-family: 'BookkMyungjo-Bd';
  }

  .sample-content :deep(p) {
    margin-bottom: 0.5rem;
  }
  </style>
  