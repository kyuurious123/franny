<template>
  <div class="guest mt-10 md:mt-0">
    <iframe width="100%" height="220" src="https://www.youtube.com/embed/ITrFZkVGpzA?si=nDPCbnTh8nIHqWF8" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    <section class="simple-profile">
      <h2>제 아들 노래 듣고가세요 ^^</h2>
    </section>
    <GuestSection :postId="'guest'" :context="'guest'" />
  </div>
</template>

<script setup>
import { useRoute } from 'vue-router';
import GuestSection from '../components/GuestSection.vue'

</script>

<style scoped>
.guest {
    padding: 1rem;
}
</style>