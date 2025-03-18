<template>
  <header class="header">
    <nav class="nav-menu">
      <ul class="nav-links">
        <li>
          <router-link to="/">
            <img src="/src/assets/home.png" alt="">
            <span class="text">HOME</span>
          </router-link>
        </li>
        <li>
          <router-link to="/profile">
            <img src="/src/assets/profile.png" alt="">
            <span class="text">PROFILE</span>
          </router-link>
        </li>
        <li>
          <router-link to="/writing">
            <img src="/src/assets/writing.png" alt="">
            <span class="text">WRITING</span>
          </router-link>
        </li>
        <li>
          <router-link to="/guest">
            <img src="/src/assets/guest.png" alt="">
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
}

.nav-links {
  list-style: none;
  padding: 0;
  margin: 0;
}

.nav-links li {
  text-align: center;
  margin-bottom: 1rem;
}

.nav-links a {
  padding: 0.5rem 0;
  color: var(--primary-color);
  text-decoration: none;
  font-weight: 500;
  font-size: 0.75rem;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.nav-links a.router-link-active {
    text-decoration: underline;
}

img {
  width: 48px;
}

</style>