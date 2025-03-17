<template>
  <div class="writing-list">
    <h1 class="section-title">WRITING</h1>
    
    <div class="writings">
      <div class="writing-item card" v-for="writing in writings" :key="writing.id">
        <h2 class="writing-title">{{ writing.title }}</h2>
        <p class="writing-summary">{{ writing.summary }}</p>
        <div class="writing-footer">
          <span class="writing-date">{{ formatDate(writing.date) }}</span>
          <router-link :to="`/writing/${writing.id}`" class="read-more">
            자세히 보기
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import writingsData from '../data/writings.json';

const writings = ref([]);

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString('ko-KR', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });
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
  max-width: 800px;
  margin: 0 auto;
}

.writings {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.writing-item {
  transition: transform 0.3s, box-shadow 0.3s;
}

.writing-item:hover {
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.writing-title {
  font-size: 1.5rem;
  margin-bottom: 0.5rem;
}

.writing-summary {
  color: #555;
  margin-bottom: 1rem;
}

.writing-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 0.9rem;
}

.writing-date {
  color: #777;
}

.read-more {
  font-weight: 500;
}
</style>