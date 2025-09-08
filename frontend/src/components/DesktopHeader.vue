<!-- DesktopHeader.vue -->
<template>
  <div class="desktop-header">
    <!-- 메인 내비게이션 -->
    <nav class="main-nav mb-8 p-4">
      <ul class="space-y-4">
        <li>
          <router-link 
            to="/" 
            class="nav-link"
            :class="{ 'active': currentRoute === '/' }"
          >
            MAIN
          </router-link>
        </li>
        <li>
          <router-link 
            to="/bestar" 
            class="nav-link"
            :class="{ 'active': currentRoute.includes('/bestar') }"
          >
            BURRIED STARS
          </router-link>
        </li>
        <li>
          <router-link 
            to="/enstar" 
            class="nav-link"
            :class="{ 'active': currentRoute.includes('/enstar') }"
          >
            ENSEMBLE STARS
          </router-link>
        </li>

        <li>
          <router-link 
            to="/dc" 
            class="nav-link"
            :class="{ 'active': currentRoute.includes('/dc') }"
          >
            DC
          </router-link>
        </li>
        <li>
          <router-link 
            to="/guest" 
            class="nav-link"
            :class="{ 'active': currentRoute.includes('/guest') }"
          >
            GUEST
          </router-link>
        </li>
      </ul>
    </nav>
    <div class="sub-nav p-4">
      <p class="event-text">다음 참가 행사</p>
      <p class="event-date">25</p><p class="event-date">9</p><p class="event-date">21</p>
      <p class="event-name mb-4">戦国八陣虎之巻 2</p>
      <p class="event-text">그 다음 참가 행사!!!!!</p>
      <p class="event-date">25</p><p class="event-date">10</p><p class="event-date">11</p>
      <p class="event-name mb-4">디페스타</p>
      <p class="copyright">last updated 25-9-8</p>
      <p class="copyright">copyright (c) 프래니</p>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, computed } from 'vue';
import { useRoute } from 'vue-router';

export default defineComponent({
  setup() {
    const route = useRoute();
    // 현재 경로 계산
    const currentRoute = computed(() => route.path);
    
    return {
      currentRoute
    };
  }
});
</script>

<style scoped>
.desktop-header {
  display: flex;
  flex-direction: column;
  height: 100%;
  min-height: calc(100vh - 2rem);
  overflow-y: auto;
  justify-content: space-between;
}

.nav-link {
  display: block;
  border-radius: 0.25rem;
  text-align: right;
  transition: all 0.2s ease;
  text-decoration: none;
  font-size: 1rem;
}

.nav-link.active {
  font-weight: bold;
  text-decoration: underline;
}

.sub-nav {
  text-align: right;
}

.event-text {
  margin-bottom: 0.5rem;
}

.event-date {
  width: 32px;
  height: 32px;
  background: #3DFF7E;
  text-align: center;
  line-height: 32px;
  border-radius: 100px;
  font-size: 15px;
  color: #000;
  display: inline-block;
  margin-left: 0.5rem;
}

.event-name {
  margin-top: 0.5rem;
  font-weight: 500;
}

.copyright {
  font-size: 0.75rem;
  color: var(--text-gray)
}
</style>