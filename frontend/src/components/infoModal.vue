<template>
    <div
      class="fixed inset-0 bg-black/30 z-50 flex items-center justify-center"
      @click.self="$emit('close')"
    >
      <div class="bg-white max-w-4xl p-5 md:border border-t border-black
             h-[90%] md:h-auto
             overflow-y-auto
             absolute md:relative
             bottom-0 md:bottom-auto
             animate-slide-up md:animate-none">
        <button @click="$emit('close')" class="md:absolute -top-12 right-0 text-gray-500 bg-white rounded-none !border border-black">✕</button>

        <div class="flex justify-between w-full md:px-6 md:text-2xl text-lg font-bold mb-8">
            <div>켜3a</div>
            <p>미친여자와비정상남자들</p>
            <p>이게아냐 2025</p>
        </div>
        <div class="flex flex-col gap-15 md:flex-row">
            <div class="md:border-r md:border-black md:px-8 items-center mb-4 w-full">
                <div class="mb-6">
                    <img class="w-[180px] m-auto" src="https://blog.kakaocdn.net/dn/cjprU5/btsNi3IVkz9/K6TwmJd2YcIBbypbP3IzS0/img.png" alt="">
                    <a href=""></a>
                </div>
                <div class="flex mb-5 justify-between items-center">
                    <div>
                        <p class="text-lg font-bold">그리고 각자가 그 진실을</p>
                        <p class="text-gray-500 text-sm md:text-xs mt-1">신승연, 장세일, 이규혁</p>
                    </div>
                    <p class="text-lg font-bold">18,000원</p>
                </div>
                <div class="flex py-2 md:py-1 border-t border-b border-black justify-between mb-5 md:text-[13px]">
                    <p>무선제본</p>
                    <p>115 * 190(비규격)</p>
                    <P>180p 이상</P>
                </div>
                <div class="md:text-[13px]">
                    <p>그러니까 세일은 사실 이렇게 말하고 싶었다.<br>나는 어쩌면… 당신이 되고 싶었던 것 같아.</p>
                </div>
            </div>

            <div class="items-center md:px-8 mb-4 w-full">
                <div class="mb-6">
                    <img class="w-[180px] m-auto" src="https://blog.kakaocdn.net/dn/yuvGQ/btsNwa2nWoa/3d1n63SxMNjiRHhfZ9j4o1/img.png" alt="">

                    <a href=""></a>
                </div>
                <div class="flex mb-5 justify-between items-center">
                    <div>
                        <p class="text-lg font-bold">다만 파도를 기다렸네</p>
                        <p class="text-gray-500 text-xs mt-1">이규혁, 한도윤</p>
                    </div>
                    <p class="text-lg font-bold">6,000원</p>
                </div>
                <div class="flex py-2 md:py-1 border-t border-b border-black justify-between mb-5 md:text-[13px]">
                    <p>무선제본</p>
                    <p>B6</p>
                    <P>40p 이상</P>
                </div>
                <div class="md:text-[13px]">
                    <p>나, 내가 받은 것처럼 그대로 흉내내서 –거절하고 방치해서 키운, 그 아이가 어 떤 삶 을 살지. <br><br> 궁금해졌어.</p>
                </div>
            </div>
        </div>
        <div class="text-center italic text-xs text-gray-400 mt-4 mb-4 md:mt-2 md:mb-0">
            <p>그리고....</p>
            <p>행사장에 도착하기 전까지 있을지 없을지 모르는 슈뢰딩거의 무료배포본...!!</p>
        </div>
      </div>
    </div>
  </template>
  

<style>

@keyframes slide-up {
  from {
    transform: translateY(100%);
  }
  to {
    transform: translateY(0);
  }
}

.animate-slide-up {
  animation: slide-up 0.3s ease-out;
}
</style>