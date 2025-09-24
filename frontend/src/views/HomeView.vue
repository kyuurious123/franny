<template>
  <div class="home-random-text h-full bg-[#DE2F36] overflow-hidden">
    <!-- 5개의 span이 있는 div -->
    <div class="md:space-y-4 md:p-6 p-4 h-full">
      <span 
        v-for="(text, index) in displayTexts" 
        :key="`text-${index}-${textKey}`"
        :class="[
          'p-2 md:text-4xl text-2xl font-[BookkMyungjo-Bd] font-bold transition-all duration-500 ease-in-out leading-[1.5] md:leading-[1.4] break-keep md:m-3 m-0',
          index % 2 === 0 
            ? 'bg-white text-[#DE2F36]' 
            : 'text-white italic'
        ]"
      >
        {{ text }}
      </span>
    </div>
  </div>
  <div class="bg-black absolute w-full md:h-14 h-10 text-center flex items-center justify-center bottom-0">
    <a @click="$router.push('/dfesta')" class="text-white text-lg font-bold no-underline">인포 페이지로 →</a>
  </div>

</template>

<script lang="ts">
import { defineComponent, ref, onMounted, onUnmounted } from 'vue';


export default defineComponent({
  name: 'HomeView',
  
  setup() {
    // 30가지 텍스트 종류
    const textOptions = ref([
      '들라크루아야말로 그가 굳이 도쿄까지 먼 걸음을 한 이유였다.',
      '대표님, 이거 전부 가짜예요. 바꿔치기 당했다고요!',
      '폭력과 광기, 죽음, 그로데스크...',
      '그건 그가 꽤 오랫동안 지켜온 삶의 신조였는데.',
      '갈색 나뭇잎이 나무 근처로 천천히 떨어져 내리고 그 밑을 두 사람이 걸어간다.',
      '기억하지 않기 위해 순간을 보냈다. 하지만 노력에도 불구하고 기억이 쏟아져 들어오는 순간이 있다, 지금처럼.',
      '히로미츠와는 연락이 닿지 않은지 벌써 4년도 넘었다.',
      '“야, 공명. 저거 네 사건 얘기 아냐?”',
      '열을 맞춰 짜인 살 사이로 냉기가 흘러나온다.',
      '하지만 뒷목을 감싸는, 어떤 불길함의 징조 같은 기운이 그를 불쾌하게 만들었다.',
      '사실 어떤 형태로 무너졌느냐는 중요한게 아니다.',
      '순진한 신이 온갖 것을 담아둔 자루를 잘 잠그지 않아서 새어나온 악의가 머리 위로 쏟아진다.',
      '그런데 이제는 그런 보살핌이나 사랑 같은 건 없다.',
      '지옥에 갇혀본 자는 안다. 한번 지옥은 영원한 지옥.',
      '언제나 같은 자리에서 자신을 기다리고 있고',
      '그곳을 빠져나온 것처럼 언제든 다시 돌아갈 수도 있단 사실을.',
      '다른 빛 다른 그림으로 빛나는 조각들로 몸이 이루어져있다고 생각한 적이 있다.',
      '여러 이름을 쓰며 여러 얼굴로 살아가다보면 생의 출처를 잊어버릴 때가 있기 때문이다.',
      '형은 진짜 내가 누구인지를 증명해줄 단 한 명의 사람이다.',
      '형이 있었으면 좋겠다. 지금 당장. 눈 앞에.',
      '남자는 자신의 동생, 히로미츠였다.',
      '얇은 눈송이처럼 어깨에 내려앉는 그 빛에 섞여 지독한 농담, 악의가…',
      '몸을 던지듯 달려들어 두 팔 가득 끌어안고 싶다.',
      '그러자 어디선가 빛이 새어들어왔다.',
      '문과 벽의 틈 사이로 바깥의 빛이 폭포수처럼 반짝이고 있었다.',
      '늘 반듯하고 말끔한 얼굴이, 지금의 감정에 물들며 흐트러지는 게… 좋았다.',
      '느슨했던 감각의 비늘이 쭈뼛 일어섰다.',
      '4년만이다. 히로미츠의 목소리를 듣는 건. 여전히 앳되고 불안한…',
      '"히로미츠."',
      '"오랜만이야, 형."'
    ]);
    
    const displayTexts = ref<string[]>([]);
    const textKey = ref(0); // 리렌더링을 위한 키
    let intervalId: number | null = null;
    
    // 30개 중에서 5개 랜덤 선택 (중복 없이)
    const generateRandomTexts = () => {
      const shuffled = [...textOptions.value].sort(() => Math.random() - 0.5);
      displayTexts.value = shuffled.slice(0, 5);
      textKey.value++; // 키 업데이트로 리렌더링 강제
    };
    
    // 5초마다 자동 변경 타이머 시작
    const startTimer = () => {
      intervalId = setInterval(() => {
        generateRandomTexts();
      }, 5000);
    };
    
    onMounted(() => {
      // 초기 텍스트 설정
      generateRandomTexts();
      // 5초마다 텍스트 변경
      startTimer();
    });
    
    onUnmounted(() => {
      // 컴포넌트가 제거될 때 타이머 정리
      if (intervalId) {
        clearInterval(intervalId);
      }
    });
    
    return {
      displayTexts,
      textKey
    };
  }
});
</script>
