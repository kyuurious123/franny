<template>
  <div class="app-container">
    <!-- PC용 레이아웃 -->
    <div v-if="!isMobile" class="pc-layout-container">
      <!-- PC 헤더 영역 (좌측 15%) -->
      <aside class="header-area">
        <DesktopHeader />
      </aside>

      <!-- 주요 콘텐츠 영역 (중앙 55%) -->
      <main class="content-area">
        <Transition 
          name="fade-up" 
          mode="out-in"
        >
          <!-- 목록 페이지에서는 기본 글을 보여주고, 다른 페이지에서는 router-view -->
          <BestarWritingDetail v-if="currentPath === '/bestar'" key="bestar-default" id="01" />
          <EnstarWritingDetail v-else-if="currentPath === '/enstar'" key="enstar-default" id="zombie-01" />
          <router-view v-else :key="$route.fullPath" />
        </Transition>
      </main>
      
      <!-- 사이드바 (우측 30%) -->
      <aside class="sidebar-area">
        <SidebarList />
      </aside>
    </div>
    
    <!-- 모바일용 레이아웃 (기존과 동일하게 유지) -->
    <div v-else class="app">
      <MobileHeader />
      <main class="content">
        <Transition name="fade-up" mode="out-in">
          <router-view :key="$route.fullPath" />
        </Transition>
      </main>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, computed } from 'vue'
import { useRoute } from 'vue-router'
import DesktopHeader from './components/DesktopHeader.vue'
import MobileHeader from './components/MobileHeader.vue'
import SidebarList from './components/SidebarList.vue'
import BestarWritingDetail from './views/BestarWritingDetail.vue'
import EnstarWritingDetail from './views/EnstarWritingDetail.vue'

export default defineComponent({
  name: 'App',
  components: {
    DesktopHeader,
    MobileHeader,
    SidebarList,
    BestarWritingDetail,
    EnstarWritingDetail
  },
  setup() {
    const route = useRoute();
    
    // 현재 경로 가져오기
    const currentPath = computed(() => route.path);
    
    return {
      currentPath
    };
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
  beforeUnmount() {
    window.removeEventListener('resize', this.checkScreenSize);
  },
  methods: {
    checkScreenSize() {
      this.isMobile = window.innerWidth <= 768;
    }
  }
})
</script>

<style>
/* 페이드업 트랜지션 애니메이션 (개선됨) */
.fade-up-enter-active,
.fade-up-leave-active {
  transition: opacity 0.5s ease, transform 0.5s ease;
  position: absolute;
  width: 100%;
}

.fade-up-enter-from {
  opacity: 0;
  transform: translateY(30px);
}

.fade-up-leave-to {
  opacity: 0;
  transform: translateY(-30px);
}

/* 기존 스타일 유지 */
.app-container {
  min-height: 100vh;
  height: 100vh;
  overflow: hidden;
}

.pc-layout-container {
  display: flex;
  height: 100vh;
  width: 100%;
}

.header-area {
  width: 15%;
  padding: 1rem;
  overflow-y: auto;
  height: 100vh;
  border-right: 1px solid #000;
}

.content-area {
  width: 55%;
  padding: 1rem 2rem;
  overflow-y: auto;
  height: 100vh;
  flex: 1 1 auto;
  position: relative; /* 트랜지션을 위해 필수 */
}

.content-area > * {
  width: 100%;
}

.sidebar-area {
  width: 30%;
  border-left: 1px solid #000;
  overflow-y: auto;
  height: 100vh;
}

.sidebar-image-container {
  overflow: hidden;
  border-radius: 0.375rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.sidebar-image-container img {
  transition: transform 0.3s ease;
}

.sidebar-image-container:hover img {
  transform: scale(1.05);
}

.app {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  height: 100vh;
  overflow: hidden;
}

.app .content {
  flex: 1;
  overflow-y: auto;
  position: relative; /* 트랜지션을 위해 필수 */
}

.app-flex {
  display: flex;
  gap: 3rem;
}

::-webkit-scrollbar-track {
    display: none;
}
</style>