<template>
    <div class="min-h-screen py-[80px] mb:py-8 px-4">
      <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-semibold text-gray-900">티끌모아태산글쓰기법</h1>
            <p class="text-sm text-gray-700">100자씩 10번쓰면 1천자 ㅎㅇㅌㅎㅇㅌㅎㅇ</p>
        </div>
  
        
  
        <!-- Text Boxes -->
        <div class="space-y-4">
          <div 
            v-for="(box) in textBoxes" 
            :key="box.id"
            class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200 animate-slide-in"
          >
            <div class="p-5">
              <textarea
                :ref="el => setTextareaRef(box.id, el)"
                v-model="box.content"
                @input="handleTextChange(box.id)"
                maxlength="100"
                placeholder="내용을 입력하세요..."
                :class="['w-full min-h-[120px] p-3 border rounded-lg text-base resize-y focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all', getTextareaStyle(box.content.length)]"
              />

              <span :class="['text-sm font-medium', getCounterColor(box.content.length)]">
                {{ box.content.length }} / 100
              </span>
            </div>
            
          </div>
        </div>
  
        <!-- Button Group -->
        <div class="flex justify-between mt-6">
            <!-- Add Button -->
            <button
                @click="addNewBox"
                class="inline-flex items-center gap-1 px-2 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm"
            >
            <span class="inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                새 박스 추가
            </span>
            </button>

            <!-- Action Buttons - Top -->
            <div class="flex gap-3 justify-end">
                <button
                    @click="copyAllText"
                    class="inline-flex items-center gap-1 px-2 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    복사하기
                </button>
                <button
                    @click="downloadAsText"
                    class="inline-flex items-center gap-1 px-2 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    다운로드
                </button>
            </div>
        </div>
        
  
        <!-- Total Stats Card -->
        <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-100 p-4 mb:p-6">
          <div class="flex items-center justify-between">
            <div class="flex">
              <div class="font-medium text-gray-600 mr-1">작성 통계</div>
              <div class="font-bold text-gray-900">{{ totalChars }}자</div>
            </div>
            <div class="flex flex-col items-end gap-1">
              <div class="flex items-center gap-2">
                <div class="text-sm text-gray-600">
                  목표: <span class="font-semibold text-gray-900">{{ goalChars.toLocaleString() }}자</span>
                </div>
                <button
                  @click="openGoalModal"
                  class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded hover:bg-blue-100 transition-all duration-200"
                >
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                  수정
                </button>
              </div>
              <div class="w-48 h-2 bg-gray-200 rounded-full overflow-hidden">
                <div 
                  class="h-full bg-gradient-to-r from-blue-500 to-indigo-500 transition-all duration-300"
                  :style="{ width: `${Math.min((totalChars / goalChars) * 100, 100)}%` }"
                />
              </div>
              <div class="text-xs text-gray-500">
                {{ ((totalChars / goalChars) * 100).toFixed(1) }}% 달성
              </div>
            </div>
          </div>
        </div>
  
        <!-- Goal Setting Modal -->
        <div 
          v-if="showGoalModal"
          class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" 
          @click="showGoalModal = false"
        >
          <div 
            class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md" 
            @click.stop
          >
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-xl font-semibold text-gray-900">목표 설정</h3>
              <button
                @click="showGoalModal = false"
                class="text-gray-400 hover:text-gray-600 transition-colors"
              >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
            <p class="text-gray-600 text-sm mb-4">하루에 작성할 목표 글자 수를 설정하세요</p>
            <div class="mb-6">
              <label class="block text-sm font-medium text-gray-700 mb-2">
                목표 글자 수
              </label>
              <div class="relative">
                <input
                  type="number"
                  v-model="tempGoal"
                  @keypress.enter="saveGoal"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg"
                  placeholder="예: 5000"
                  min="100"
                  max="100000"
                />
                <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500">자</span>
              </div>
              <p class="text-xs text-gray-500 mt-2">* 100자 ~ 100,000자 사이로 설정 가능합니다</p>
            </div>
            <div class="flex gap-3">
              <button
                @click="showGoalModal = false"
                class="flex-1 px-4 py-2.5 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors font-medium"
              >
                취소
              </button>
              <button
                @click="saveGoal"
                class="flex-1 px-4 py-2.5 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors font-medium"
              >
                저장
              </button>
            </div>
          </div>
        </div>
  
        <!-- Toast Notification -->
        <div
          :class="['fixed top-6 right-6 text-white px-5 py-3 rounded-lg shadow-lg transform transition-all duration-300 flex items-center gap-2', toastColor, showToast ? 'translate-x-0 opacity-100' : 'translate-x-96 opacity-0']"
        >
          {{ toastMessage }}
        </div>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref, computed, nextTick } from 'vue';
  
  interface TextBox {
    id: number;
    content: string;
  }
  
  // State
  const textBoxes = ref<TextBox[]>([{ id: 1, content: '' }]);
  const goalChars = ref<number>(5000);
  const showGoalModal = ref<boolean>(false);
  const tempGoal = ref<string>('5000');
  const showToast = ref<boolean>(false);
  const toastMessage = ref<string>('');
  const toastColor = ref<string>('bg-green-500');
  const textareaRefs = ref<{ [key: number]: HTMLTextAreaElement }>({});
  
  // Computed
  const totalChars = computed(() => {
    return textBoxes.value.reduce((sum, box) => sum + box.content.length, 0);
  });
  
  // Methods
  const setTextareaRef = (id: number, el: any): void => {
    if (el) {
      textareaRefs.value[id] = el;
    }
  };
  
  const addNewBox = (): void => {
    const newId = textBoxes.value.length > 0 
      ? Math.max(...textBoxes.value.map(box => box.id)) + 1 
      : 1;
    textBoxes.value.push({ id: newId, content: '' });
    
    nextTick(() => {
      const newTextarea = textareaRefs.value[newId];
      if (newTextarea) {
        newTextarea.scrollIntoView({ behavior: 'smooth', block: 'center' });
        newTextarea.focus();
      }
    });
  };
  
  const handleTextChange = (id: number): void => {
    const box = textBoxes.value.find(b => b.id === id);
    if (!box) return;
  
    // 100자를 채웠을 때 자동으로 다음 박스 추가
    if (box.content.length === 100) {
      const currentIndex = textBoxes.value.findIndex(b => b.id === id);
      const isLastBox = currentIndex === textBoxes.value.length - 1;
      
      if (isLastBox) {
        setTimeout(() => {
          addNewBox();
        }, 300);
      } else {
        const nextBox = textBoxes.value[currentIndex + 1];
        setTimeout(() => {
          const nextTextarea = textareaRefs.value[nextBox.id];
          if (nextTextarea) {
            nextTextarea.focus();
          }
        }, 100);
      }
    }
  };
  
  const getAllText = (): string => {
    return textBoxes.value
      .filter(box => box.content.trim())
      .map(box => box.content)
      .join('\n\n');
  };
  
  const copyAllText = async (): Promise<void> => {
    const allText = getAllText();
    
    if (!allText) {
      displayToast('⚠️ 복사할 내용이 없습니다', 'bg-yellow-500');
      return;
    }
    
    try {
      await navigator.clipboard.writeText(allText);
      displayToast('✓ 복사되었습니다!', 'bg-green-500');
    } catch (err) {
      console.error('복사 실패:', err);
      displayToast('✗ 복사 실패', 'bg-red-500');
    }
  };
  
  const downloadAsText = (): void => {
    const allText = getAllText();
    
    if (!allText) {
      displayToast('⚠️ 다운로드할 내용이 없습니다', 'bg-yellow-500');
      return;
    }
    
    const blob = new Blob([allText], { type: 'text/plain;charset=utf-8' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    
    const now = new Date();
    const dateString = now.toISOString().slice(0, 10);
    const timeString = now.toTimeString().slice(0, 5).replace(':', '');
    a.download = `글쓰기_${dateString}_${timeString}.txt`;
    
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    
    displayToast('✓ 다운로드되었습니다!', 'bg-green-500');
  };
  
  const displayToast = (message: string, color: string): void => {
    toastMessage.value = message;
    toastColor.value = color;
    showToast.value = true;
    
    setTimeout(() => {
      showToast.value = false;
    }, 2000);
  };
  
  const openGoalModal = (): void => {
    tempGoal.value = goalChars.value.toString();
    showGoalModal.value = true;
  };
  
  const saveGoal = (): void => {
    const newGoal = parseInt(tempGoal.value);
    if (isNaN(newGoal) || newGoal < 100) {
      displayToast('⚠️ 100자 이상 입력해주세요', 'bg-yellow-500');
      return;
    }
    if (newGoal > 100000) {
      displayToast('⚠️ 100,000자 이하로 입력해주세요', 'bg-yellow-500');
      return;
    }
    goalChars.value = newGoal;
    showGoalModal.value = false;
    displayToast('✓ 목표가 설정되었습니다', 'bg-green-500');
  };
  
  const getCounterColor = (length: number): string => {
    if (length === 100) return 'text-green-600';
    if (length > 100) return 'text-red-500';
    return 'text-gray-500';
  };
  
  const getTextareaStyle = (length: number): string => {
    if (length === 100) return 'border-green-300 bg-green-50';
    return 'border-gray-200';
  };
  </script>
  
  <style scoped>
  @keyframes slideIn {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .animate-slide-in {
    animation: slideIn 0.3s ease-out;
  }
  </style>