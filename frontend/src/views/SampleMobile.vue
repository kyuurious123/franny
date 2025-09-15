<template>
<div class="bg-book text-neutral-900">
  <!-- 책 표지 -->
  <div class="border-b border-black">

  <header class="p-4">
    <a @click="$router.push('/')" class="no-underline font-normal text-base">← 홈으로</a>
  </header>
    <img src="https://blog.kakaocdn.net/dn/cjprU5/btsNi3IVkz9/K6TwmJd2YcIBbypbP3IzS0/img.png" alt="" class="w-[70%] m-auto">
    <p class="text-center mt-2 text-neutral-500 italic text-sm mb-8">표지 계란님(@egg_bst)</p>

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
    <a href="https://tmm.im/p/52765" target="_blank" class="no-underline text-lg">10 디페 선입금/통판 폼 (TMM) 9.10 ~ 9.17 정오 →</a>
  </div>
  <!-- 책 정보 -->
  <div class="px-4 py-8">
      <img :src="book1Title" alt="" class="w-[80%] m-auto">
  </div>
  
  <div class="space-y-2 px-4 pb-10">
    <p class="mb-4 text-sm text-gray-500">무선제본, 비규격(115*190), 200p</p>
    <p class="leading-8 mb-8">SCOOP의 새로운 기획으로 여배우 배이현과 얽힌 사이비 종교 ‘영명교’의 취재를 이어가던 승연과 세일. 그러던 어느 날, 승연은 싸늘한 주검으로 돌아온다. 경찰은 자살이라 단정하지만, 세일은 수사에 석연치 않은 점을 느낀다. 이에 세일은 규혁과 함께 승연의 죽음에 얽힌 비밀을 파헤치기 시작한다. <br>그러나 파고들수록, 자신이 알지 못했던 승연의 또 다른 얼굴과 마주하게 되고, 세일은 진실에서 점점 더 멀어지는 느낌에 사로잡히는데…</p>
  </div>
</div>

</template>
  
<script setup lang="ts">
import book1Title from '/src/assets/book1title.svg'
import { useRouter } from 'vue-router';

const router = useRouter();

function navigateToList() {
  router.push('/igeanya2025/list');
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
  background: linear-gradient(to bottom, #D9E3E2, #FFFFFF);
}
</style>