
<template>
<div class="bg-[#DE2F36] text-black">
  <!-- 이벤트 포스터 -->
  <div class="border-b border-black">
    <header class="p-4">
      <a @click="$router.push('/')" class="no-underline font-normal text-base">← 홈으로</a>
    </header>
    <div class="relative mb-20">
        <img src="https://blog.kakaocdn.net/dna/l4YJg/btsQzlM6y6y/AAAAAAAAAAAAAAAAAAAAAPiyvcbHqe97Pd5g2IQuaSgpx4eEiB24aXXBz6HGQB47/img.png?credential=yqXZFxpELC7KVnFOS48ylbz2pIh7yKj8&expires=1759244399&allow_ip=&allow_referer=&signature=CFg8I7xmlhiDgAjvhBTa4cJ1gC8%3D" class="mb-10">
        <img :src="dfTitle" alt="" class="absolute bottom-[-7%] w-[90%]">
    </div>
    
    <div class="text-center border-t border-black text-black py-2">
      <a 
        @click="navigateToList"
        class="no-underline text-black"
        >
        <span>샘플 →</span>
      </a>
    </div>
  </div>

  <!-- 신청 링크 -->
  <div class="border-b border-black py-2 text-center">
    <!-- <a href="#" target="_blank" class="no-underline text-lg">DFESTA 2025 참가 신청 폼 →</a> -->
    <span>선입금/통판 폼 (9/24 오픈)</span>
  </div>
  
  <div class="p-4 pb-10">
    <p class="mb-4 text-sm">무선제본, 비규격(115*190), 120p(예상)</p>
    <p class="leading-8 mb-8">카루이자와의 쇼룸에서 일어난 작품 도난 사건을 담당하게 된 타카아키. 현장 조사를 포함해, 운영 기록과 회계 내역을 확인하는 과정에서 쇼룸이 범죄 조직의 자금 세탁에 이용되고 있음을 알게된다. 한편, 조직에 잠입해 있던 스카치는 상부로부터 쇼룸 오너와 자신의 형, 모로후시 타카아키를 제거하라는 지시를 받고 나가노로 향하는데…</p>
  </div>
</div>
</template>
  
<script setup lang="ts">
import { useRouter } from 'vue-router';
import dfTitle from '/src/assets/dftitle.svg'


const router = useRouter();

function navigateToList() {
  router.push('/dfesta/list');
}
</script>
