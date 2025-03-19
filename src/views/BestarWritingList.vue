<template>
  <div class="writing-list">
    <div class="writings">
      <router-link 
        v-for="bestarwriting in bestarwritings" 
        :key="bestarwriting.id"
        :to="`/bestar/${String(bestarwriting.id)}`" 
        class="writing-item"
      >
        <span class="writing-item-text">
          <span class="writing-item-number">{{ bestarwriting.number }}</span>
          <span class="writing-item-title">{{ bestarwriting.title }}</span>
          <span class="writing-list-sum">{{ bestarwriting.summary }}</span>
          <span class="writing-list-date">{{ formatDate(bestarwriting.date) }}</span>
        </span>
      </router-link>
    </div>
  </div>

  
</template>

<script setup>
import { ref, onMounted } from 'vue';
import bestarWritingsData from '../data/bestarwritings.json';

const bestarwritings = ref([]);

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

onMounted(() => {
  // 데이터 로드 및 날짜 기준 내림차순 정렬
  bestarwritings.value = [...bestarWritingsData.bestarwritings].sort((a, b) => 
    new Date(b.date) - new Date(a.date)
  );
});
</script>

<style scoped>
.writing-list {
  padding: 1rem;
}

.writing-item {
  text-decoration: none;
}

.writing-item-text {
  margin-left:0.5rem;
  margin-bottom: 0px;
  color: #000;
}

.writing-item-number {
  background-color: yellow;
  border-radius: 50px;
  border: 1px solid #000;
  padding: 0 4px;
  margin-right: 0.25rem;
}

.writing-item-title {
  font-size: 1.5rem;
  margin-right: 0.25rem;
  font-weight: 500;
}

.writing-item-date {
  margin-right: 0.75rem;
}

.writing-list-sum {
  font-style: italic;
  margin-right: 0.25rem;
}

@media (min-width: 768px) {
  .writing-list {
    padding: 2rem;
  }
}
</style>