<template>
  <div class="app">
    <MobileHeader v-if="isMobile" />
    <DesktopHeader v-else />
    
    <main class="content">
      <router-view />
    </main>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import MobileHeader from './components/MobileHeader.vue'
import DesktopHeader from './components/DesktopHeader.vue'

export default defineComponent({
  name: 'App',
  components: {
    MobileHeader,
    DesktopHeader,
  },
  data() {
    return {
      isMobile: false,
    };
  },
  mounted() {
    this.checkScreenSize();  // 화면 크기 체크
    window.addEventListener('resize', this.checkScreenSize);  // 리사이즈 이벤트 리스너 추가
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.checkScreenSize);  // 리사이즈 이벤트 리스너 제거
  },
  methods: {
    checkScreenSize() {
      this.isMobile = window.innerWidth <= 768;  // 화면 크기가 768px 이하인 경우 모바일로 판단
    }
  }
})
</script>

<style scoped>
/* App 컴포넌트의 스타일은 여기에 추가 */
</style>
