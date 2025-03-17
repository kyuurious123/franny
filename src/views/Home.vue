<template>
  <div class="home">
    <section class="simple-profile">
        <img src="" alt="">
        <p>안녕하떼염<br>프래니라고합니다.<br>아직 이사중이에요</p>
    </section>
  </div>
</template>

<style scoped>
.home > section {
  margin-bottom: 3rem;
}

.simple-profile {
    font-family: 'DOSGothic';
    font-size: 1rem;
    color: var(--text-color);
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