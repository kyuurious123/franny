<template>
  <div class="profile">
    <img src="https://blog.kakaocdn.net/dn/bALfgk/btsMOdLUnBU/XWIkJKdKc2KpTK03MPMQLk/img.png" alt="">
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
  </div>
</template>


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

</style>