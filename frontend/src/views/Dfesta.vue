<template>
  <div>
    <DesktopLayout v-if="!isMobile" />
    <router-view v-else />
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import DesktopLayout from '../views/DfestaDesktop.vue';

const route = useRoute();
const router = useRouter();
const isMobile = ref(false);

onMounted(() => {
  checkDevice();
  window.addEventListener('resize', checkDevice);
  
  // 모바일이고 하위 경로가 없는 경우 샘플 페이지로 리다이렉트
  if (isMobile.value && route.path === '/dfesta') {
    router.replace('/dfesta/sample');
  }
});

// 화면 크기 변경 감지
function checkDevice() {
  isMobile.value = window.innerWidth <= 768;
}

// 라우트 변경 감지
watch(() => route.path, (newPath) => {
  if (isMobile.value && newPath === '/dfesta') {
    router.replace('/dfesta/sample');
  }
});
</script>