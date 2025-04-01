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
    <!-- <div v-else-if="currentRoute === '/'">
      <div>
        <img class="main-img" :src="mainSvg" alt="">
      </div>
    </div> -->
    <div v-else-if="currentRoute === '/'" class="home">
      <a
        class="hover-div"
        href="/bestar/13"
        @mouseenter="isHovered = true"
        @mouseleave="isHovered = false"
      >
        <span :class="getSpanClass(0)">그러니 SCOOP의 기획 회의에 이름이 거론되는 건 당연한 수순이었다. 물론 강민호, 이름 세 글자에서 </span>
        <span class="span-fixed focused-span">시작</span>
        <span :class="getSpanClass(1)">해 그의 아내 서연희가 운영하는 장학 재단과 재단의 각종 횡령, 사기 행각까지 뽑아낸 건 승연의 작품이었다.</span>
      </a>
      <a
        class="hover-div id-14"
        href="/bestar/14"
        @mouseenter="isHovered = true"
        @mouseleave="isHovered = false"
      >
        <span :class="getSpanClass(2)">되새길 이유가 없어 그 마음을 잊히게 두었지만 이따금 </span>
        <span class="span-fixed focused-span">잊지 않았다면</span>
        <span :class="getSpanClass(3)"> 어디로 흘러갔을까 세일은 궁금하기도 했다.</span>
      </a>
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

<script lang="ts">import { defineComponent, computed, onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import BestarWritingList from '../views/BestarWritingList.vue';
import EnstarWritingList from '../views/EnstarWritingList.vue';
import mainSvg from '/src/assets/main.svg';

export default defineComponent({
  components: {
    BestarWritingList,
    EnstarWritingList
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

.home {
  padding: 3rem 5rem;
}

.hover-div {
  padding: 1rem;
  cursor: pointer;
  background-color: #FF16B7;
  min-height: 32px;
  color: white;
  transform: rotate(15deg);
  width: 260px;
  display: inline-block;
  text-decoration: none;
}

.id-14 {
  padding: 1rem;
  cursor: pointer;
  background-color: #00B985;
  min-height: 32px;
  color: white;
  transform: rotate(-5deg);
  width: 280px;
  display: inline-block;
  text-decoration: none;
  margin-left: 2.5rem;
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