<template>
  <div class="home">
    <div class="img-wrapper">
        <img class="main-img" :src="mainSvg" alt="">
        <p class="main-img__title">이게아냐 2025 신간 준비중 🚧</p>
    </div>
    <section class="home__desc">
        <span>안녕하세요. 방문을 환영합니다. 저는</span><span class="bg-dark">프래니 / 파프리카</span><span>어느쪽이든 편하신대로 불러주시면 댑니다. 여기 아직 공사중이긴 한데</span>
        <span class="bg-yellow">2025-3-19 기준</span><img src="/src/assets/progress.svg" class="progress" alt=""><span>80%정도 완성된 거 같아요. 4 디페 어나스테 / 베스타 배포전 <span class="bg-yellow"> 신간 인포는 아직 준비중입니다.</span></span>
        <span>개저미소녀피디를 사랑합니다.</span>
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
import mainSvg from '/src/assets/main.svg'
import { ref, computed } from "vue";
import bestarWritingsData from '../data/bestarwritings.json';
import enstarWritingsData from '../data/enstarwritings.json';

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
</script>

<style scoped>
.home {
  padding: 1rem;
}

.main-img {
  width: 100%;
}

@media (min-width: 768px) {
  .home {
    padding: 2rem;
  }
}

.main-img__title {
    font-family: 'DOSGothic';
    margin-top: 1rem;
    font-weight: 500;
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
</style>