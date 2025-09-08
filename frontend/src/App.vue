<template>
  <div class="app-container">
    <!-- 일반 페이지 (PC/모바일 분기) -->
    <div class="h-full">
      <!-- PC용 레이아웃 -->
      <div v-if="!isMobile" class="pc-layout-container h-full">
        <!-- PC 헤더 영역 (좌측 15%) -->
        <aside class="header-area">
          <DesktopHeader />
        </aside>

        <!-- 주요 콘텐츠 영역 (중앙 55%) -->
        <main class="content-area h-full overflow-scroll">
          <Transition name="fade-up" mode="out-in">
            <BestarWritingDetail v-if="currentPath === '/bestar'" key="bestar-default" id="20" />
            <EnstarWritingDetail v-else-if="currentPath === '/enstar'" key="enstar-default" id="zombie-01" />
            <DcWritingDetail v-else-if="currentPath === '/dc'" key="dc-default" id="dc03" />
            <router-view v-else :key="$route.fullPath" />
          </Transition>
        </main>

        <!-- 사이드바 (우측 30%) -->
        <aside class="sidebar-area h-full">
          <SidebarList @open-info-modal="showModal = true" />
        </aside>
      </div>

      <!-- 모바일 레이아웃 (기존과 동일) -->
      <div v-else class="mobile-layout-container">
        <MobileHeader />
        <router-view v-slot="{ Component }">
          <component
            :is="Component"
            @open-info-modal="showModal = true"
          />
        </router-view>

      </div>
    </div>

    <InfoModal v-if="showModal" @close="showModal = false" />

  </div>
</template>

<script setup lang="ts">
import { useRoute } from 'vue-router'
import { computed, onMounted, onUnmounted, ref } from 'vue'
import DesktopHeader from './components/DesktopHeader.vue'
import MobileHeader from './components/MobileHeader.vue'
import SidebarList from './components/SidebarList.vue'
import BestarWritingDetail from './views/BestarWritingDetail.vue'
import EnstarWritingDetail from './views/EnstarWritingDetail.vue'
import DcWritingDetail from './views/DcWritingDetail.vue'

import InfoModal from './components/InfoModal.vue'


const showModal = ref(false)

const route = useRoute()

const isMobile = ref(false)
const currentPath = computed(() => route.path)


const handleResize = () => {
  isMobile.value = window.innerWidth <= 768
}

onMounted(() => {
  // 초기 설정
  handleResize()
  
  // resize 이벤트 리스너 추가
  window.addEventListener('resize', handleResize)
})

onUnmounted(() => {
  window.removeEventListener('resize', handleResize)
})

</script>

<style scoped>
.app-container {
  height: 100vh;
  width: 100vw;
}

.pc-layout-container {
  display: flex;
  height: 100%;
}

.header-area {
  width: 15%;
  border-right: 1px solid #000;
}

.content-area {
  width: 55%;
  padding: 1rem;
}

.sidebar-area {
  width: 30%;
  border-left: 1px solid #000;
}

.mobile-layout-container {
  display: flex;
  flex-direction: column;
}
</style>
