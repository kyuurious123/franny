<!-- Memo.vue -->
<template>
  <div class="memo-container" @click.stop>
    <div 
    v-for="(memo, index) in memos" 
      :key="memo.id"
      class="memo text-[13px] whitespace-pre-wrap"
      :style="{
          left: `${getMemoPosition(memo).x}px`, 
          top: `${getMemoPosition(memo).y}px`,
          zIndex: getMemoPosition(memo).zIndex,
          backgroundColor: memo.color,
          color: memo.color_text || '#000000',
          transform: `rotate(${memo.rotation}deg)`,
          width: isMobile ? `${memo.width * 0.8}px` : `${memo.width}px`
      }"
      @mousedown="startDrag($event, memo, index)"
      @touchstart="startTouchDrag($event, memo, index)"
      @click.stop="bringToFront(memo)"
    >
      <div class="memo-title">{{ memo.title }}</div>
      <div class="memo-content">{{ memo.content }}</div>
    </div>
  </div>
  <a class="text-sm block md:mt-10 mt-0 mb-6 text-center cursor-pointer" @click="$router.push('/igeanya2025')">이게아냐 2025 인포</a>
</template>

<script setup>
import { ref, reactive, onMounted, onUnmounted, computed } from 'vue';
const isMobile = ref(false);

const checkMobile = () => {
isMobile.value = window.innerWidth <= 768;
};

onMounted(() => {
checkMobile();
window.addEventListener('resize', checkMobile);
});

onUnmounted(() => {
window.removeEventListener('resize', checkMobile);
});

// 메모 위치 계산
const getMemoPosition = (memo) => {
if (isMobile.value) {
  return {
    x: memo.position.x,
    y: Math.min(memo.position.y * 0.2, 150), // 최대 높이 제한
    zIndex: memo.position.zIndex
  };
} else {
  // PC용 위치 (원래 위치)
  return memo.position;
}
};

// 샘플 메모 데이터
const memos = reactive([
  {
      id: 1,
      title: '이게아냐 2025 신간 안내',
      content: '신간 샘플은 따로 페이지를 만들어 관리 중입니다.\n아래 버튼을 클릭해 이동하실 수 있어요.',
      color: '#00F051',
      position: { x: 50, y: 400, zIndex: 99 },
      rotation: 0,
      width: 330
  },
  {
      id: 2,
      title: '01. 시작',
      content: '화면 왼쪽, 범인 윤 씨의 얼굴이 멀거니 떠올라 대사를 내뱉는다. 돈만 돌려준다면 그냥 돌아가겠다. 여자는 매우 화가 난 듯 빨간 얼굴에 잔뜩 인상을 썼고, 큰 돈을 잃어버린 여파인지 보풀이 일어나 후줄근한 가디건을 입고 있다. 윤 씨의 말이 끝나자 오른편에는 서 씨가 페이드인 된다. 내가 강요한 것도 아니고 스스로 좋아서 한 일 아니냐. 돌려줄 수 없다. 한쪽 어깨 앞으로 길게 내린 머리카락. 당혹스러운 표정. 둘 다 저런 여자였나? 저건 사실이 아니다. 실제로는 둘 다 고생이라고는 모르고 산 샌님같이 생겼다. 저런 사소한 다툼마저도 해본 적 없는, 상처 받은 적도, 그래서 누군가를 상처 입히는 방법도 모르는 고상한 아가씨처럼 보였다. ',
      color: '#FB6DFD',
      position: { x: 30, y: 250, zIndex: 2 },
      rotation: -5,
      width: 330
  },
  {
      id: 3,
      title: '02. 견착',
      content: '다들 힘드니까. 왜냐면 한 사람을 이해한다는 건 무척이나 고된 일이라서. 나는 그걸 잘 알아. 하루 10시간 직장을 다니면서 누군가의 상황과 맥락과 역사와 무게를 온전히 씹어서 소화할 기력이 있겠냐고? 영화관에는 관객이 없고 리뷰 영상은 나날이 조회수가 느는데. 그러니까 나도 그런 거라고. 내가 한 사람의 삶을, 깔끔하게, 3장 뜨기 해서 내놓는 거라고. 나는 사람들이 멍청하고, 게을러서 너무 좋다. 회식에서 맞은편에 있는 사람에게 얘기하는 걸 엿들었는데, 맞은편에 있던 사람이 누구였는지는 기억나지 않았다.',
      color: '#002CFF',
      color_text: '#fff',
      position: { x: 60, y: 360, zIndex: 6 },
      rotation: 5,
      width: 360
  },
  {
      id: 4,
      title: '배이현_자료_메모',
      content: '인터뷰/예능/시상식 등 공개 노출 없음.\n SNS 계정 비공개 또는 폐쇄 상태. \n 방송국 행사·VIP 시사회 등 업계 네트워크 자리 불참.\n 비공식 루트 통해 인터뷰 제안 전달 (무응답)',
      color: '#DFE1E0',
      position: { x: 30, y: 400, zIndex: 4 },
      rotation: -3,
      width: 360
  },
  {
      id: 5,
      title: '03. 침투',
      content: '나 참… 승연이 허리를 숙여 카메라를 주우려는데 여자가 승연을 불렀다. 어떤 대명사가 아닌,\n"신승연 피디님."\n하고.\n본명이 튀어나오자 승연의 눈이 번득였다. 단번에 상황을 파악했다. 분장이 통하지 않았던 게 아니다. 이 여자는 자신을 기다리고 있었다.\n이제 무얼 숨기는 건 의미가 없었다. 마침 갑갑했던 차였다. 승연은 진흙이 튄 마스크를 벗었다.\n"씨발... 너 뭐야."\n"꼭 하셔야겠어요? 방송?"\n걱정스러운 목소리와는 달리 여자의 표정은 평온했다. 예상 못 했던 건 아니었다. 카메라를 몇 만 년 전의 원시적인, 투박한 무기처럼 두려워하는 사람이 있다면 당연히 그 반대도 존재했다. 여자는 후자였고. 하지만 친히 렌즈에 얼굴을 갖다 대고 손까지 올리는 사람은 없었다.',
      color: '#E5FB51',
      position: { x: 70, y: 200, zIndex: 5 },
      rotation: 2,
      width: 300
  },
  {
      id: 6,
      title: '04. 징조',
      content: '인대가 늘어났대. 2주는 반깁스 하고있어야 된다는데? 오른팔을 붕대로 칭칭 감고 나타난 승연이 태연하게 말했다. 젓가락질도 잘 못해서 그녀는 모든 반찬을 숟가락으로 떠먹었다. 그러다 오래걸려 답답했는지 화장실에서 깁스 자국이 남은 맨 팔로 돌아왔다. 아니이, 자꾸 그렇게 풀고 그러시면 안 낫는다니까요?? 가영이 걱정 반 답답함 반 섞인 목소리로 외쳤다. 낫기 전에 답답해서 내가 먼저 죽어. 너무나 그녀가 할 법한 말이라 모두가 예상했던 답변을 승연이 그대로 말했다. 젓가락으로 시금치를 집으면서도 손목이 시린지 인상을 썼다. 그리고 팍팍 밥을 퍼먹는 가영을 향해 승연이 말했다. 그런데 홍 작가는, 내가 안 죽었으면 좋겠잖아? 승연의 눈이 짓궃게 휘었다. 불만 가득한 가영이 들으라는 듯 중얼거렸다. 당연한 거 아닌가. 신 피디님 없으면 SCOOP은 망하는데요.',
      color: '#000',
      color_text: '#fff',
      position: { x: 60, y: 240, zIndex: 3 },
      rotation: -2,
      width: 340
  },
]);

// 드래그 상태 관리
const dragInfo = reactive({
  isDragging: false,
  currentMemo: null,
  startX: 0,
  startY: 0,
  offsetX: 0,
  offsetY: 0
});

// 메모를 맨 앞으로 가져오기
function bringToFront(memo) {
  // 현재 가장 높은 z-index 찾기
  const highestZ = Math.max(...memos.map(m => m.position.zIndex));
  // 선택한 메모를 맨 앞으로
  memo.position.zIndex = highestZ + 1;
}

// 드래그 시작 핸들러 (마우스)
function startDrag(event, memo, index) {
  // 기본 동작 방지
  event.preventDefault();
  
  // 드래그 정보 설정
  dragInfo.isDragging = true;
  dragInfo.currentMemo = memo;
  
  // 마우스 시작 위치 기록
  dragInfo.startX = event.clientX;
  dragInfo.startY = event.clientY;
  
  // 메모의 현재 위치에서 마우스 위치 차이 계산 (오프셋)
  dragInfo.offsetX = event.clientX - memo.position.x;
  dragInfo.offsetY = event.clientY - memo.position.y;
  
  // 메모를 최상단으로 가져오기
  bringToFront(memo);
  
  // 이벤트 버블링 방지
  event.stopPropagation();
}

// 드래그 시작 핸들러 (터치)
function startTouchDrag(event, memo, index) {
  // 기본 동작 방지 (스크롤 방지)
  event.preventDefault();
  
  // 첫 번째 터치 지점 가져오기
  const touch = event.touches[0];
  
  // 드래그 정보 설정
  dragInfo.isDragging = true;
  dragInfo.currentMemo = memo;
  
  // 터치 시작 위치 기록
  dragInfo.startX = touch.clientX;
  dragInfo.startY = touch.clientY;
  
  // 메모의 현재 위치에서 터치 위치 차이 계산 (오프셋)
  dragInfo.offsetX = touch.clientX - memo.position.x;
  dragInfo.offsetY = touch.clientY - memo.position.y;
  
  // 메모를 최상단으로 가져오기
  bringToFront(memo);
  
  // 이벤트 버블링 방지
  event.stopPropagation();
}

// 드래그 중 핸들러 (마우스)
function onDrag(event) {
  if (!dragInfo.isDragging || !dragInfo.currentMemo) return;
  
  // 새 위치 계산 (오프셋 고려)
  dragInfo.currentMemo.position.x = event.clientX - dragInfo.offsetX;
  dragInfo.currentMemo.position.y = event.clientY - dragInfo.offsetY;
}

// 드래그 중 핸들러 (터치)
function onTouchDrag(event) {
  if (!dragInfo.isDragging || !dragInfo.currentMemo) return;
  
  // 첫 번째 터치 지점 가져오기
  const touch = event.touches[0];
  
  // 새 위치 계산 (오프셋 고려)
  dragInfo.currentMemo.position.x = touch.clientX - dragInfo.offsetX;
  dragInfo.currentMemo.position.y = touch.clientY - dragInfo.offsetY;
  
  // 이벤트 버블링 방지
  event.preventDefault();
  event.stopPropagation();
}

// 드래그 종료 핸들러 (마우스)
function stopDrag() {
  dragInfo.isDragging = false;
  dragInfo.currentMemo = null;
}

// 드래그 종료 핸들러 (터치)
function stopTouchDrag() {
  dragInfo.isDragging = false;
  dragInfo.currentMemo = null;
}

// 컴포넌트가 마운트될 때 이벤트 리스너 등록
onMounted(() => {
  // 마우스 이벤트
  document.addEventListener('mousemove', onDrag);
  document.addEventListener('mouseup', stopDrag);
  
  // 터치 이벤트
  document.addEventListener('touchmove', onTouchDrag, { passive: false });
  document.addEventListener('touchend', stopTouchDrag);
  document.addEventListener('touchcancel', stopTouchDrag);
});

// 컴포넌트가 언마운트될 때 이벤트 리스너 제거 (메모리 누수 방지)
onUnmounted(() => {
  // 마우스 이벤트
  document.removeEventListener('mousemove', onDrag);
  document.removeEventListener('mouseup', stopDrag);
  
  // 터치 이벤트
  document.removeEventListener('touchmove', onTouchDrag);
  document.removeEventListener('touchend', stopTouchDrag);
  document.removeEventListener('touchcancel', stopTouchDrag);
});
</script>

<style scoped>
.memo-container {
  position: relative;
  width: 100%;
  height: 90%;
  min-height: 600px;
}

.memo {
  position: absolute;
  width: 300px;
  padding: 1.5rem;
  box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
  cursor: move;
  font-family:  'BookkMyungjo-Bd';
  user-select: none; /* 텍스트 선택 방지 */
  transition: box-shadow 0.3s ease;
  touch-action: none; /* 모바일에서 터치 이벤트 기본 동작 방지 */
}

.memo:hover {
  box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);
}

.memo-title {
  font-size: 0.75rem;
  margin-bottom: 8px;
  opacity: 0.8;
  color: var(--gray-500);
  font-family: 'Pretendard';
}

.memo-content {
  white-space: pre-wrap;
  line-height: 1.5;
}
</style>