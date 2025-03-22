<template>
  <div class="sidebar-list p-4">
    <!-- 현재 페이지가 BestarWritingDetail 또는 BestarWritingList인 경우 -->
    <div v-if="currentRoute.includes('bestar')">
      <BestarWritingList @click.native.prevent="captureLinks" />
    </div>
    
    <!-- 현재 페이지가 EnstarWritingDetail 또는 EnstarWritingList인 경우 -->
    <div v-else-if="currentRoute.includes('enstar')">
      <EnstarWritingList @click.native.prevent="captureLinks" />
    </div>

    <!-- Home 페이지인 경우 -->
    <div v-else-if="currentRoute === '/'">
      <div>
        <img class="main-img" :src="mainSvg" alt="">
      </div>
    </div>

    <!-- Guest 페이지인 경우 -->
    <div v-else-if="currentRoute.includes('guest')" class="side-guest">
      <h3 class="text-lg font-medium mb-4">잘생긴 승연이도 보고가시길</h3>
      <div class="space-y-4">
        <!-- 이미지 컨텐츠 예시 -->
        
        <div class="p-4 bg-gray-100 rounded-md mt-4">
          <img class="guest-img" src="https://blog.kakaocdn.net/dn/b2NNrq/btsMT3IxGQu/jFUAuKRQNrGlB1xPbix3S0/img.png" alt="">
          <p>밀(@garumill2)님께서 그려주심</p>
        </div>
      </div>
    </div>

    <!-- 기타 페이지(목록 페이지 등)에서의 사이드바 컨텐츠 -->
    <div v-else>
      <h3 class="text-lg font-medium mb-4">추천 글</h3>
      <div class="space-y-4">
        <!-- 샘플 추천 컨텐츠 -->
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, computed, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import BestarWritingList from '../views/BestarWritingList.vue';
import EnstarWritingList from '../views/EnstarWritingList.vue';
import mainSvg from '/src/assets/main.svg'

export default defineComponent({
  components: {
    BestarWritingList,
    EnstarWritingList
  },
  setup() {
    const route = useRoute();
    const router = useRouter();
    const currentRoute = computed(() => route.path);
    
    // 상세 페이지 여부 확인
    const isDetailPage = computed(() => {
      return route.params.id !== undefined;
    });
    
    const captureLinks = (event: Event) => {
      // Event를 MouseEvent로 캐스팅
      const mouseEvent = event as MouseEvent;
      // target을 HTMLElement로 캐스팅
      const target = mouseEvent.target as HTMLElement;
      
      // 이벤트 발생 요소가 router-link인지 확인
      if (target.tagName === 'A' || target.closest('a')) {
        event.preventDefault();
        
        // 클릭된 링크의 href 속성에서 ID 추출
        const link = (target as HTMLAnchorElement).href || (target.closest('a') as HTMLAnchorElement).href;
        
        if (link) {
          // URL에서 ID 추출 (마지막 슬래시 이후의 모든 것)
          const parts = link.split('/');
          const id = parts[parts.length - 1];
          
          // 링크 타입 결정 (bestar 또는 enstar)
          let type = 'bestar';
          if (link.includes('enstar')) {
            type = 'enstar';
          }
          
          // URL 업데이트 - 페이지 새로고침 없이 라우터만 사용
          router.push(`/${type}/${id}`);
        }
      }
    };
    
    // 컴포넌트 마운트 후 이벤트 리스너 추가
    onMounted(() => {
      const sidebarElement = document.querySelector('.sidebar-list');
      if (sidebarElement) {
        sidebarElement.addEventListener('click', captureLinks);
      }
      
      // 컴포넌트 언마운트 시 이벤트 리스너 제거
      return () => {
        if (sidebarElement) {
          sidebarElement.removeEventListener('click', captureLinks);
        }
      };
    });
    
    return {
      currentRoute,
      isDetailPage,
      mainSvg,
      captureLinks
    };
  }
});
</script>

<style>
.side-guest {
  padding: 1rem;
}

.guest-img {
  width: 100%;
}

@media (min-width: 768px) {
  .main-img {
  padding: 2rem;
  width: 100%;
}
}

</style>