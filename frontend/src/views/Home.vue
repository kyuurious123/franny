<template>
  <div class="home md:p-4">
    <div class="mobile-only">
      <div class="border-t mt-10 border-black mb-8">
        <div class="py-3 bg-black text-white text-center">
          <a @click="$emit('open-info-modal')" class="no-underline cursor-pointer text-white">
            🏡 이게아냐2025 켜3a 부스 인포 →
          </a>
        </div>
        
        <div class="py-3 border-b border-black text-center">
          <a class="no-underline cursor-pointer" @click="$router.push('/igeanya2025')"><그리고 각자가 그 진실을> 샘플 →</a>
        </div>

        <div class="py-3 border-b border-black text-center">
          <a class="no-underline cursor-pointer" @click="$router.push('/Wave')"><다만 파도를 기다렸네> 샘플 →</a>
        </div>
      </div>
    </div>
    <section class="p-4 md:p-0">
      <h2 class="big-title">SHOW MUST GO ON</h2>
      <div class="flex">
        <div>
          <h3>프래니 @franny1220 / 파프리카 @ange2205ccb</h3>
          <div>
            <p>베리드 스타즈 주력 <br> 가끔 앙스타 얘기 합니다. </p>
          </div>
          <div class="banner">
            <p>banner 뿌립니다</p>
            <img class="banner-img" :src="bannerImg" alt="">
          </div>
        </div>
        <img class="turtle" src="https://blog.kakaocdn.net/dn/n9a8S/btsMUy2wn0Y/V4Iib3gYLCkRbXZpdWOLkk/img.png" alt="">
      </div>
    </section>
    <section class="home__desc p-4 md:p-0">
      <span class="line-green">베스타 최신글</span>
      <span v-for="writing in latestBestarWritings" :key="writing.id" class="lts-writing">
          <router-link :to="`/bestar/${writing.id}`">
          <span class="lts-writing__title">{{ writing.title }}</span><span class="lts-writing__sum">{{ writing.summary }}</span>{{ formatDate(writing.date) }}
          </router-link>
      </span>
      <span class="line-green">앙스타 최신글</span>
      <span v-for="writing in latestEnstarWritings" :key="writing.id" class="lts-writing">
          <router-link :to="`/enstar/${writing.id}`">
          <span class="lts-writing__title">{{ writing.title }}</span><span class="lts-writing__sum">{{ writing.summary }}</span>{{ formatDate(writing.date) }}
          </router-link>
      </span>
    </section>
  </div>
</template>

<script setup>
import bannerImg from '/src/assets/franny-banner.png'
import { ref, onMounted, onUnmounted, computed } from 'vue'
import bestarWritingsData from '../data/bestarwritings.json';
import enstarWritingsData from '../data/enstarwritings.json';
import Memo from '../views/Memo.vue'

// JSON 데이터를 객체에서 배열로 변환
const bestarwritings = ref(Object.values(bestarWritingsData.bestarwritings || {}));
const enstarwritings = ref(Object.values(enstarWritingsData.enstarwritings || {}));

// 최신 5개만 가져오기
const latestBestarWritings = computed(() => {
  return bestarwritings.value
    .slice()
    .sort((a, b) => new Date(b.date) - new Date(a.date)) // 날짜 내림차순 정렬
    .slice(0, 5);
});

// 최신 5개만 가져오기
const latestEnstarWritings = computed(() => {
  return enstarwritings.value
    .slice()
    .sort((a, b) => new Date(b.date) - new Date(a.date)) // 날짜 내림차순 정렬
    .slice(0, 5);
});

const formatDate = (dateString) => {
  const date = new Date(dateString);
  
  // 연도의 마지막 두 자리만 가져오기
  const year = date.getFullYear() % 100;
  
  // 월과 일을 가져와서 한 자리인 경우에도 그대로 사용
  const month = date.getMonth() + 1; // getMonth()는 0부터 시작하므로 1을 더함
  const day = date.getDate();
  
  // 연도, 월, 일을 연결하여 반환
  return `${year}${month}${day}`;
};

// //모달
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

</script>

<style scoped>
.banner {
  margin-top: 1rem;
}

.banner-img {
  width: 200px;
}

.flex {
  display: flex;
  justify-content: space-between;
  margin-top: 5rem;
  padding-bottom: 2rem;
  border-bottom: 1px solid #000;
}

.big-title {
  font-size: 3.5rem;
  font-weight: 600;
}

@media (max-width: 767px) {
  .big-title {
    font-size: 2rem;
  }

  .flex {
    margin-top: 2rem;
    padding-bottom: 1rem;
  }
}

.turtle {
  width: 45%;
  height: 100%;
}

.main-img {
  width: 100%;
}

/* PC 레이아웃에서는 모바일 전용 요소 숨기기 */
@media (min-width: 768px) {  
  .mobile-only {
    display: none !important;
  }

  .home {
    padding: 0;
  }
}

.progress {
    height: 16px;
}

.lts-writing__title {
    font-weight: 700;
}

.lts-writing__sum {
    font-style: italic;
}

.lts-writing a {
    text-decoration: none;
}

.bg-dark {
  color: #fff;
  background-color: #000;
  font-weight: 700;
}

.bg-yellow {
    background-color:#FFFD79;
}

.bg-green {
    background-color: #3DFF7E;
}

.line-green {
    text-decoration: underline;
    text-decoration-color: #3DFF7E;
}

.home > section {
  margin-bottom: 3rem;
}

.home__desc {
    line-height: 1.8;
    font-weight: 400;
    margin-top: 1rem;
}

.home__desc span {
    margin-right: 0.25rem;
}

.img-wrapper {
  text-align: center;
  margin: 1rem 0 3rem 0;
}

.hover-div {
  padding: 1rem;
  cursor: pointer;
  background-color: #FF16B7;
  min-height: 32px;
  color: white;
  transform: rotate(13deg);
  width: 260px;
  display: inline-block;
  text-decoration: none;
  margin: 2rem 2rem 0 3rem;
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
  margin: 0;
  margin-left: 1rem;
}

.id-15 {
  background-color: #0F1013;
  transform: rotate(2deg);
  width: 300px;
  margin: 0 2rem 2rem 4rem;
}

</style>