<!-- Memo.vue -->
<template>
    <div class="memo-container" @click.stop>
      <div 
      v-for="(memo, index) in memos" 
        :key="memo.id"
        class="memo text-sm"
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
        @click.stop="bringToFront(memo)"
      >
        <div class="memo-title">{{ memo.title }}</div>
        <div class="memo-content">{{ memo.content }}</div>
      </div>
    </div>
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
        content: '이게아냐 2025에 발매 예정인 신간 샘플은 따로 페이지를 만들어 관리 중입니다. 아래 버튼을 클릭해 이동하실 수 있어요.',
        color: '#f8c2c2', // 연한 핑크
        position: { x: 50, y: 400, zIndex: 99 },
        rotation: 0,
        width: 300
    },
    {
        id: 2,
        title: '01. 시작',
        content: '화면 왼쪽, 범인 윤 씨의 얼굴이 멀거니 떠올라 대사를 내뱉는다. 돈만 돌려준다면 그냥 돌아가겠다. 여자는 매우 화가 난 듯 빨간 얼굴에 잔뜩 인상을 썼고, 큰 돈을 잃어버린 여파인지 보풀이 일어나 후줄근한 가디건을 입고 있다. 윤 씨의 말이 끝나자 오른편에는 서 씨가 페이드인 된다. 내가 강요한 것도 아니고 스스로 좋아서 한 일 아니냐. 돌려줄 수 없다. 한쪽 어깨 앞으로 길게 내린 머리카락. 당혹스러운 표정. 둘 다 저런 여자였나? 저건 사실이 아니다. 실제로는 둘 다 고생이라고는 모르고 산 샌님같이 생겼다. 저런 사소한 다툼마저도 해본 적 없는, 상처 받은 적도, 그래서 누군가를 상처 입히는 방법도 모르는 고상한 아가씨처럼 보였다. ',
        color: '#fcb356', // 주황색
        position: { x: -10, y: 250, zIndex: 2 },
        rotation: -5,
        width: 380
    },
    {
        id: 3,
        title: '02. 침투',
        content: '다들 힘드니까. 왜냐면 한 사람을 이해한다는 건 무척이나 고된 일이라서. 나는 그걸 잘 알아. 하루 10시간 직장을 다니면서 누군가의 상황과 맥락과 역사와 무게를 온전히 씹어서 소화할 기력이 있겠냐고? 영화관에는 관객이 없고 리뷰 영상은 나날이 조회수가 느는데. 그러니까 나도 그런 거라고. 내가 한 사람의 삶을, 깔끔하게, 3장 뜨기 해서 내놓는 거라고. 나는 사람들이 멍청하고, 게을러서 너무 좋다. 회식에서 맞은편에 있는 사람에게 얘기하는 걸 엿들었는데, 맞은편에 있던 사람이 누구였는지는 기억나지 않았다.',
        color: '#fcf356', // 노란색
        position: { x: 60, y: 320, zIndex: 3 },
        rotation: 5,
        width: 400
    },
    {
        id: 4,
        title: 'Paul on...',
        content: 'My process is different for each thing I do, and it\'s really just about having fun.',
        color: '#102e21', // 어두운 초록색
        color_text: '#ffffff', // 텍스트 색상
        position: { x: 70, y: 400, zIndex: 4 },
        rotation: -3,
        width: 320
    }
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
  
  // 드래그 시작 핸들러
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
  
  // 드래그 중 핸들러
  function onDrag(event) {
    if (!dragInfo.isDragging || !dragInfo.currentMemo) return;
    
    // 새 위치 계산 (오프셋 고려)
    dragInfo.currentMemo.position.x = event.clientX - dragInfo.offsetX;
    dragInfo.currentMemo.position.y = event.clientY - dragInfo.offsetY;
  }
  
  // 드래그 종료 핸들러
  function stopDrag() {
    dragInfo.isDragging = false;
    dragInfo.currentMemo = null;
  }
  
  // 컴포넌트가 마운트될 때 이벤트 리스너 등록
  onMounted(() => {
    document.addEventListener('mousemove', onDrag);
    document.addEventListener('mouseup', stopDrag);
  });
  
  // 컴포넌트가 언마운트될 때 이벤트 리스너 제거 (메모리 누수 방지)
  onUnmounted(() => {
    document.removeEventListener('mousemove', onDrag);
    document.removeEventListener('mouseup', stopDrag);
  });
  </script>
  
  <style scoped>
  .memo-container {
    position: relative;
    width: 100%;
    height: 100%;
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