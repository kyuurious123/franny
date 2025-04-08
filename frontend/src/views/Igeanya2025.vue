<template>
  <div>
    <DesktopLayout v-if="!isMobile" />
    <MobileLayout v-else />
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import DesktopLayout from '../views/Igeanya2025Desktop.vue';
import MobileLayout from '../views/Igeanya2025Mobile.vue';

const isMobile = ref(false);

onMounted(() => {
  isMobile.value = window.innerWidth <= 768;
});
</script>
