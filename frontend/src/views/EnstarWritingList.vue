<template>
  <div>
    <section class="zombie">
      <div>
        <div>
          <span class="zombie-number">1</span>
        </div>
        <router-link :to="`/enstar/zombie-01`" class="zombie-title">
          {{ enstarwritings?.["zombie-01"]?.title }}
        </router-link>
        <p class="zombie-date">{{ formatDate(enstarwritings?.["zombie-01"]?.date) }}</p>
      </div>
      <div class="flex">
        <div class="flex-div">
          <div>
            <span class="zombie-number">2</span>
          </div>
          <router-link :to="`/enstar/zombie-02`" class="zombie-title">
            {{ enstarwritings?.["zombie-02"]?.title }}
          </router-link>
          <p class="zombie-date">{{ formatDate(enstarwritings?.["zombie-02"]?.date) }}</p>
        </div>
        <div class="flex-div">
          <div>
            <span class="zombie-number">3</span>
          </div>
          <router-link :to="`/enstar/zombie-03`" class="zombie-title">
            {{ enstarwritings?.["zombie-03"]?.title }}
          </router-link>
          <p class="zombie-date">{{ formatDate(enstarwritings?.["zombie-03"]?.date) }}</p>
        </div>
      </div>
      <div>
        <div>
          <span class="zombie-number">4</span>
        </div>
        <router-link :to="`/enstar/zombie-04`" class="zombie-title">
          {{ enstarwritings?.["zombie-04"]?.title }}
        </router-link>
        <p class="zombie-date">{{ formatDate(enstarwritings?.["zombie-04"]?.date) }}</p>
      </div>
    </section>
    <section class="short-dream">
      <div class="flex flex--center">
        <p>1</p>
        <div class="dream__wrapper flex--center">
          <router-link :to="`/enstar/short-dream-01`" class="dream-title">
            {{ enstarwritings?.["short-dream-01"]?.title }}
          </router-link>
          <p class="dream-name">이츠키 슈</p>
        </div>
      </div>
      <div class="flex flex--center">
        <p>2</p>
        <div class="dream__wrapper flex--center">
          <router-link :to="`/enstar/short-dream-02`" class="dream-title">
            {{ enstarwritings?.["short-dream-02"]?.title }}
          </router-link>
          <p class="dream-name">사쿠마 레이</p>
        </div>
      </div>
      <div class="flex flex--center">
        <p>3</p>
        <div class="dream__wrapper flex--center">
          <router-link :to="`/enstar/short-dream-03`" class="dream-title">
            {{ enstarwritings?.["short-dream-03"]?.title }}
          </router-link>
          <p class="dream-name">하카제 카오루</p>
        </div>
      </div>
      <div class="flex flex--center">
        <p>4</p>
        <div class="dream__wrapper flex--center">
          <router-link :to="`/enstar/short-dream-04`" class="dream-title">
            {{ enstarwritings?.["short-dream-04"]?.title }}
          </router-link>
          <p class="dream-name">텐쇼인 에이치</p>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import enstarWritingsData from '../data/enstarwritings.json';

const enstarwritings = ref(null);

onMounted(() => {
  try {
    console.log("불러온 JSON 데이터:", enstarWritingsData); // ✅ 데이터 로드 확인
    enstarwritings.value = enstarWritingsData.enstarwritings || {}; // ✅ JSON 로드 확인
  } catch (error) {
    console.error("JSON 로딩 실패:", error);
    enstarwritings.value = {}; // ✅ 오류 방지
  }
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
.zombie {
  padding: 2rem 1.5rem;
  background: linear-gradient(#FF3333,#FF6149,#1DDB99, #FFFFFF);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2rem;
}

@media (min-width: 768px) {
  .zombie {
    padding: 2rem 1.5rem;
  }

  .short-dream {
    padding: 2rem 3rem;
    margin: 3rem 0;
  }
}

.zombie-number {
  background-color: #000;
  color: white;
  border-radius: 50px;
  font-size: 13px;
  font-family: 'BookkMyungjo-Bd';
  font-weight: 600;
  padding: 0.25rem 0.35rem;
}

.zombie-title {
  font-size: 1.2rem;
  font-family: 'BookkMyungjo-Bd';
  font-weight: 700;
  text-decoration: none;
}

.zombie-date {
  font-size: 0.75rem;
}

.flex {
  display: flex;
  gap: 1.5rem;
}

.flex-div {
  width: 100%;
}

.flex--top {
  align-items: center;
}

.short-dream {
  padding: 1rem;
  margin: 4rem 0;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.dream__wrapper {
  display: flex;
  width: 100%;
  gap: 1rem;
}

.dream-title {
  font-family: 'BookkMyungjo-Bd';
  font-size: 0.9rem;
  width: 100%;
  text-align: right;
  text-decoration: none;
}

.dream-name{
  font-size: 1rem;
  width: 11rem;
}

</style>
