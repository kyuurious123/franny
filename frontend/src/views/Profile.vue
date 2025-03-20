<template>
  <div class="profile">
    <h3 class="name">프래니 / 파프리카</h3>
    <div class="desc">
      <p>신승연 주간</p>
      <p>글은 천천히 옮기고 있어요</p>
    </div>
    <div class="sns">twitter
      <a class="link-text" href="https://x.com/franny1220">@franny1220</a>
      <a class="link-text" href="https://x.com/ange2205ccb">@ange2205ccb</a>
    </div>
    <div class="banner"></div>
    <div class="twitter">
      <a
        class="twitter-timeline"
        data-width="400"
        data-height="600"
        href="https://twitter.com/franny1220?ref_src=twsrc%5Etfw"
      >
      </a>
    </div>
  </div>
</template>



<script setup>
import { onMounted } from 'vue';

onMounted(() => {
  // 트위터 위젯 스크립트를 동적으로 추가
  const script = document.createElement("script");
  script.setAttribute("src", "https://platform.twitter.com/widgets.js");
  script.setAttribute("async", "true");
  document.body.appendChild(script);
});
</script>


<style scoped>
.profile {
  background: linear-gradient(#FAFF95, #fff);
  padding: 3rem 1rem;
  background-attachment: fixed;
  text-align: center;
  height: 100%;
}

.link-text{
  margin-left: 0.5rem;
}

.name{
  margin-top: 0.75rem;
  font-size: 1rem;
  font-weight: 600;
}

.sns {
  margin-top: 1rem;
}

.desc {
  font-weight: 400;
}

.twitter {
  display: flex;
  justify-content: center;
  margin-top: 2rem;
}

</style>