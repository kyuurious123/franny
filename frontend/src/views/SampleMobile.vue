<template>
    <div class="p-4">
      <header class="mb-6">
        <h1 class="text-2xl font-bold mb-2">이게아냐 2025</h1>
        <p class="text-gray-600">새로운 시리즈를 소개합니다</p>
      </header>
      
      <!-- 소개 섹션 -->
      <section class="mb-8">
        <div class="bg-blue-50 p-4 rounded-lg mb-6">
          <h2 class="text-lg font-semibold mb-2">소개</h2>
          <p>이게아냐 2025는 일상에서 마주하는 다양한 사건과 생각들을 담은 새로운 시리즈입니다. 현대 사회의 모순과 아이러니를 담백하게 풀어냅니다.</p>
        </div>
        
        <div class="bg-amber-50 p-4 rounded-lg">
          <h2 class="text-lg font-semibold mb-2">작가의 말</h2>
          <p>이 시리즈는 2025년을 살아가는 우리의 모습을 관찰하고 기록한 작품들입니다. 여러분의 일상에 작은 위로와 공감이 되었으면 합니다.</p>
        </div>
      </section>
      
      <!-- 최신 글 목록으로 이동 버튼 -->
      <section class="mb-8">
        <button 
          @click="navigateToList" 
          class="w-full bg-blue-500 text-white py-3 px-4 rounded-lg shadow-md hover:bg-blue-600 transition duration-300 flex items-center justify-center"
        >
          <span>글 목록 보기</span>
          <span class="ml-2">→</span>
        </button>
      </section>
      
      <!-- 샘플 글 미리보기 -->
      <section>
        <h2 class="text-xl font-semibold mb-4">미리보기</h2>
        
        <div class="bg-white p-4 rounded-lg shadow-sm mb-4">
          <h3 class="font-medium mb-2">이게아냐 - 첫 번째 이야기</h3>
          <p class="text-sm text-gray-600 mb-2">2025년 3월 15일</p>
          <p class="line-clamp-3">오늘도 버스를 기다리며 스마트폰을 들여다보는 사람들. 모두가 연결되어 있지만, 어쩌면 그 어느 때보다 단절되어 있는 것 같다. 이게 우리가 꿈꾸던 미래였을까...</p>
          <button @click="navigateToDetail('01')" class="text-blue-500 mt-2 hover:underline">더 읽기</button>
        </div>
        
        <div class="bg-white p-4 rounded-lg shadow-sm">
          <h3 class="font-medium mb-2">이게아냐 - 두 번째 이야기</h3>
          <p class="text-sm text-gray-600 mb-2">2025년 3월 30일</p>
          <p class="line-clamp-3">인공지능이 그려준 그림으로 SNS에서 유명해진 화가의 이야기. 기술이 예술을 대체하는 시대, 우리는 어떤 가치를 지켜야 할까...</p>
          <button @click="navigateToDetail('02')" class="text-blue-500 mt-2 hover:underline">더 읽기</button>
        </div>
      </section>
      
      <!-- 홈으로 돌아가기 -->
      <div class="mt-8 text-center">
        <button @click="goHome" class="text-gray-600 hover:text-blue-500">
          홈으로 돌아가기
        </button>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import { useRouter } from 'vue-router';
  
  const router = useRouter();
  
  function navigateToList() {
    router.push('/igeanya2025/list');
  }
  
  function navigateToDetail(id: string) {
    router.push(`/igeanya2025/${id}`);
  }
  
  function goHome() {
    router.push('/');
  }
  </script>
  
  <style scoped>
  .line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  </style>