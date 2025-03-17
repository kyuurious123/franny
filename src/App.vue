<template>
  <div class="app">
    <Header />
    <main class="content">
      <router-view />
    </main>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Header from './components/Header.vue'

export default defineComponent({
  name: 'App',
  components: {
    Header,
  }
})
</script>

<style>
/* 스타일은 main.css에서 관리합니다 */
</style>