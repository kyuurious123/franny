<template>
  <div class="sidebar-list h-full !overflow-hidden">
    <!-- 현재 페이지가 BestarWritingDetail 또는 BestarWritingList인 경우 -->
    <div v-if="currentRoute.includes('bestar')" class="p-6 overflow-x-scroll h-full">
      <BestarWritingList @click.native.prevent="captureLinks" />
    </div>
    
    <!-- 현재 페이지가 EnstarWritingDetail 또는 EnstarWritingList인 경우 -->
    <div v-else-if="currentRoute.includes('enstar')" class="overflow-x-scroll h-full">
      <EnstarWritingList @click.native.prevent="captureLinks" />
    </div>

    
    <!-- 현재 페이지가 DcWritingDetail 또는 DcWritingList인 경우 -->
    <div v-else-if="currentRoute.includes('dc')" class="p-6 overflow-x-scroll h-full">
      <DcWritingList @click.native.prevent="captureLinks" />
    </div>

    <!-- Home 페이지인 경우 -->
    <div v-else-if="currentRoute === '/'" class="home relative h-full bg-[url(../assets/img2.png)] bg-cover bg-[#DE2F36] bg-right flex flex-col justify-end
">
      <img :src="titleText" alt="" class="absolute top-[40%] right-[-10%] w-[70%]">
      <p class="text-lg text-white pb-8 text-center">9/17 샘플 공개 예정</p>
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
import { defineComponent, computed, onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import BestarWritingList from '../views/BestarWritingList.vue';
import EnstarWritingList from '../views/EnstarWritingList.vue';
import DcWritingList from '../views/DcWritingList.vue';

import mainSvg from '/src/assets/main.svg';
import titleText from '/src/assets/text.svg';

// const showModal = ref(false)

// const closeModal = () => {
//   showModal.value = false
// }

// const handleEsc = (e: KeyboardEvent) => {
//   if (e.key === 'Escape') {
//     closeModal()
//   }
// }

// onMounted(() => {
//   window.addEventListener('keydown', handleEsc)
// })

// onUnmounted(() => {
//   window.removeEventListener('keydown', handleEsc)
// })

export default defineComponent({
  components: {
    BestarWritingList,
    EnstarWritingList,
    DcWritingList,
  },
  
  setup() {
  const route = useRoute();
  const router = useRouter();
  const currentRoute = computed(() => route.path);

  const isHovered = ref(false);

  const getSpanClass = (index: number) => {
    return {
      'span-fixed': true,
      'invisible': isHovered.value && index !== 999
    };
  };

  // 새로운 함수 추가 - 여기에 추가하세요
  const openExternalLink = (e: Event) => {
    e.preventDefault();
    window.open('https://spin-spin.com/SmZAKQznJ8Z2GYQ', '_blank');
  };

  // 기존 captureLinks 함수 수정 - 이 함수를 아래와 같이 교체하세요
  const captureLinks = (event: Event) => {
    const mouseEvent = event as MouseEvent;
    const target = mouseEvent.target as HTMLElement;

    if (target.tagName === 'A' || target.closest('a')) {
      const anchorElement = target.tagName === 'A' 
        ? (target as HTMLAnchorElement) 
        : (target.closest('a') as HTMLAnchorElement);
      
      // 외부 링크인지 확인
      if (anchorElement.href && anchorElement.href.startsWith('https://spin-spin.com')) {
        // 외부 링크는 기본 동작 유지 또는 window.open으로 처리
        if (anchorElement.target === '_blank') {
          return; // 기본 동작 유지 (새 창에서 열기)
        } else {
          event.preventDefault();
          window.open(anchorElement.href, '_blank');
        }
        return;
      }
      
      // 내부 링크 처리 (기존 코드)
      event.preventDefault();
      const link = anchorElement.href;
      if (link) {
        const parts = link.split('/');
        const id = parts[parts.length - 1];
        let type = 'bestar';
        if (link.includes('enstar')) type = 'enstar';
        if (link.includes('dc')) type = 'dc';
        router.push(`/${type}/${id}`);
      }
    }
  };

  onMounted(() => {
    // 기존 코드 유지
    const sidebarElement = document.querySelector('.sidebar-list');
    if (sidebarElement) {
      sidebarElement.addEventListener('click', captureLinks);
    }

    return () => {
      if (sidebarElement) {
        sidebarElement.removeEventListener('click', captureLinks);
      }
    };
  });

  // return 문에 openExternalLink 추가 - 여기에 추가하세요
  return {
    currentRoute,
    mainSvg,
    isHovered,
    titleText,
    captureLinks,
    getSpanClass,
    openExternalLink // 이 줄 추가
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

.span-fixed {
  min-width: 3ch; /* span마다 글자 수에 따라 조절 */
  text-align: center;
}

.focused-span {
  font-weight: bold;
}

.invisible {
  visibility: hidden;
}


</style>