<template>
  <header class="header">
    <nav class="nav-menu">
      <ul class="nav-links">
        <li>
          <router-link to="/">
            <span class="text">HOME</span>
          </router-link>
        </li>
        <li>
          <router-link to="/profile">
            <span class="text">PROFILE</span>
          </router-link>
        </li>
        <li>
          <router-link to="/bestar">
            <span class="text">BESTAR</span>
          </router-link>
        </li>
        <li>
          <router-link to="/enstar">
            <span class="text">ENSTAR</span>
          </router-link>
        </li>
        <li>
          <router-link to="/guest">
            <span class="text">GUEST</span>
          </router-link>
        </li>
      </ul>
    </nav>
  </header>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'Header'
})
</script>

<style scoped>
.header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  background-color: white;
  z-index: 100;
  display: flex;
  flex-direction: column;
  border-bottom: 1px solid #000;
}

.header-content {
  padding: 0.75rem 1rem;
  text-align: center;
  border-bottom: 1px solid var(--border-color);
}

.logo a {
  font-size: 1.2rem;
  font-weight: 700;
  color: var(--primary-color);
  text-decoration: none;
}

.nav-menu {
  width: 100%;
  background-color: white;
}

.nav-links {
  list-style: none;
  display: flex;
  justify-content: space-between;
  padding: 0;
  margin: 0;
}

.nav-links li {
  flex: 1;
  text-align: center;
}

.nav-links a {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 0.5rem 0;
  color: var(--primary-color);
  text-decoration: none;
  font-weight: 500;
  font-size: 0.9rem;
}

.nav-links a.router-link-active {
    text-decoration: underline;
}

/* PC에서 모바일 뷰 시뮬레이션 시에도 동일한 스타일 유지 */
@media (min-width: 768px) {
  .header {
    width: var(--mobile-width);
    left: 50%;
    transform: translateX(-50%);
    border-radius: 24px 24px 0 0;
    top: 16px;
  }
}
</style>