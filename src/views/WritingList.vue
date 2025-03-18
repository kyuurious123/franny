<template>
  <div class="writing-list">
    <div class="writings">
      <router-link 
        v-for="writing in writings" 
        :key="writing.id"
        :to="`/writing/${writing.id}`" 
        class="writing-item"
      ><p class="writing-item-text">{{ writing.title }} <div class="writing-list__sum">{{ writing.summary }}</div>{{ formatDate(writing.date) }}</p>
      </router-link>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import writingsData from '../data/writings.json';

const writings = ref([]);

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
  writings.value = [...writingsData.writings].sort((a, b) => 
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
}

.writing-list__sum {
  font-style: italic;
  display: inline;
  margin-right: 0.5rem;
}
</style>