<template>
  <div class="app-flex">
    <!-- PC에서만 표시되는 Header -->
    <DesktopHeader v-if="!isMobile" />

    <!-- App 내 콘텐츠 -->
    <div class="app">
      <MobileHeader v-if="isMobile" />
      <main class="content">
        <router-view />
      </main>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import DesktopHeader from './components/DesktopHeader.vue'
import MobileHeader from './components/MobileHeader.vue'

export default defineComponent({
  name: 'App',
  components: {
    DesktopHeader,
    MobileHeader
  },
  data() {
    return {
      isMobile: false
    };
  },
  mounted() {
    this.checkScreenSize();
    window.addEventListener('resize', this.checkScreenSize);
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.checkScreenSize);
  },
  methods: {
    checkScreenSize() {
      this.isMobile = window.innerWidth <= 768;
    }
  }
})
</script>

<style scoped>
.app-flex {
  display: flex;
  gap: 3rem;
}

::-webkit-scrollbar-track {
    display: none;
}
</style>
