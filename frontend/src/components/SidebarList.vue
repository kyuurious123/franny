<template>
  <div class="sidebar-list h-full">
    <!-- 현재 페이지가 BestarWritingDetail 또는 BestarWritingList인 경우 -->
    <div v-if="currentRoute.includes('bestar')" class="p-6">
      <BestarWritingList @click.native.prevent="captureLinks" />
    </div>
    
    <!-- 현재 페이지가 EnstarWritingDetail 또는 EnstarWritingList인 경우 -->
    <div v-else-if="currentRoute.includes('enstar')">
      <EnstarWritingList @click.native.prevent="captureLinks" />
    </div>

    <!-- Home 페이지인 경우 -->
    <div v-else-if="currentRoute === '/'" class="home h-full">

      <!-- 모달 열기 버튼 -->
      <div class="border-t mt-8 border-black">
        <div class="py-3 bg-black text-white text-center">
          <a @click="$emit('open-info-modal')" class="no-underline cursor-pointer text-white">
            🏡 이게아냐2025 켜3a 부스 인포 →
          </a>
        </div>
        
        <div class="py-3 border-b border-black text-center">
          <a class="no-underline cursor-pointer" @click="$router.push('/igeanya2025')"><그리고 각자가 그 진실을> 샘플 →</a>
        </div>

        <div class="py-3 border-b border-black text-center">
          <a class="no-underline cursor-pointer" @click="$router.push('/igeanya2025')"><다만 파도를 기다렸네> 샘플 →</a>
        </div>
      </div>
     
      <Memo />
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
import mainSvg from '/src/assets/main.svg';
import Memo from '../views/Memo.vue'

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
    Memo
  },
  setup() {
    const route = useRoute();
    const router = useRouter();
    const currentRoute = computed(() => route.path);

    const isHovered = ref(false);

    const getSpanClass = (index: number) => {
      return {
        'span-fixed': true,
        'invisible': isHovered.value && index !== 999 // 999는 focused 인덱스 예외 처리용 (더 안전하게 하려면 별도로 관리 가능)
      };
    };

    const captureLinks = (event: Event) => {
      const mouseEvent = event as MouseEvent;
      const target = mouseEvent.target as HTMLElement;

      if (target.tagName === 'A' || target.closest('a')) {
        event.preventDefault();
        const link = (target as HTMLAnchorElement).href || (target.closest('a') as HTMLAnchorElement).href;
        if (link) {
          const parts = link.split('/');
          const id = parts[parts.length - 1];
          let type = 'bestar';
          if (link.includes('enstar')) type = 'enstar';
          router.push(`/${type}/${id}`);
        }
      }
    };

    onMounted(() => {
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

    return {
      currentRoute,
      mainSvg,
      isHovered,
      captureLinks,
      getSpanClass
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