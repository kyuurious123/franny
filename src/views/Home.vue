<template>
  <div class="home">
    <div class="img-wrapper">
      <img class="main-img" src="/src/assets/main.svg" alt="">
    </div>
    <section class="container">
      <div class="home__title">
        <h2>2025-3-18</h2>
      </div>
      <div>
        <p class="home__body">안녕하세요? 아직 공사중이에요.<br />그래도 뭐.... 둘러보고 가세요</p>
      </div>
    </section>
    <section class="container">
      <div class="home__title">
        <h2>공지</h2>
      </div>
      <div>
        <p class="home__body">공지 테스트</p>
      </div>
    </section>
  </div>
</template>

<style scoped>
.home {
  padding: 2rem;
}

.home > section {
  margin-bottom: 3rem;
}

.home__title {
  font-size: 32px;
  margin-bottom: 12px;
  border-bottom: 1px solid #000;
}

.img-wrapper {
  text-align: center;
  margin: 1rem 0 3rem 0;
}

.container {
  margin-bottom: 20px;
}

.home__body {
  font-size: 15px;
  line-height: 24px;
}

.writing-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1.5rem;
}

.writing-card {
  display: flex;
  flex-direction: column;
  height: 100%;
}

.writing-summary {
  flex-grow: 1;
  margin-bottom: 1rem;
  color: #555;
}

.writing-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: auto;
}

.read-more {
  font-weight: 500;
}

.view-all-link {
  margin-top: 1.5rem;
  text-align: right;
}

.view-all-link a {
  font-weight: 500;
}

.announcement-section .card {
  background-color: #f8f9fa;
  border-left: 4px solid var(--accent-color);
}

@media (max-width: 768px) {
  .writing-grid {
    grid-template-columns: 1fr;
  }
}
</style>