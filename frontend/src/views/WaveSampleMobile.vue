<template>
<div class="bg-book text-neutral-900">
  <!-- 책 표지 -->
  <div class="border-b border-black">

  <header class="p-4">
    <a @click="$router.push('/')" class="no-underline font-normal text-base">← 홈으로</a>
  </header>
    <img src="https://blog.kakaocdn.net/dn/yuvGQ/btsNwa2nWoa/3d1n63SxMNjiRHhfZ9j4o1/img.png" alt="" class="w-[70%] m-auto">
    <p class="text-center mt-2 text-neutral-500 italic text-sm mb-8">표지 작업중</p>

    <div class="text-center border-t border-black py-2">
      <a 
        @click="navigateToList"
        class="no-underline"
        >
        <span>샘플 보기 →</span>
      </a>
    </div>
    
  </div>

  <div class="border-b border-black py-2 text-center">
    <a href="https://tmm.im/p/44730" target="_blank" class="no-underline">선입금 / 통판 폼 (TMM) 5.5 14:00 ~ 5.12 12:00 →</a>
  </div>
  <!-- 책 정보 -->
  <div class="space-y-2 px-4 py-10">
    <p class="mb-4 text-sm text-gray-500">무선제본, B6, 40p↑ (변동O)</p>
    <p class="leading-8 mb-8">무대 붕괴 사고 후 3년이 지난 어느 날, 도윤은 규혁으로부터 뜻밖의 연락을 받는다. 규혁은 곧 결혼할 예정이라며, 여행을 함께 가지 않겠냐고 도윤에게 묻는다.</p>
  </div>
</div>

</template>
  
<script setup lang="ts">
import { useRouter } from 'vue-router';

const router = useRouter();

function navigateToList() {
  router.push('/Wave/list');
}
</script>

<style scoped>
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.bg-book {
  background: linear-gradient(to bottom, #E8F6FD, #FFFFFF);
}
</style>