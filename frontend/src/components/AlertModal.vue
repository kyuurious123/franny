<template>
  <div v-if="isOpen" class="modal-overlay">
    <div class="modal">
      <h3 v-if="title">{{ title }}</h3> <!-- 제목이 있을 때만 표시 -->
      <p>{{ message }}</p>

      <div class="modal-buttons">
        <button @click="onPrimaryClick">{{ primaryText }}</button>
        <button v-if="secondaryText" @click="onSecondaryClick">{{ secondaryText }}</button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";

const isOpen = ref(false);
const title = ref<string | null>(null);
const message = ref("");
const primaryText = ref("확인");
const secondaryText = ref<string | null>(null);
const primaryAction = ref<() => void>(() => closeModal());
const secondaryAction = ref<() => void>(() => closeModal());

const showModal = (
  msg: string,
  options?: {
    title?: string;
    primaryText?: string;
    secondaryText?: string;
    onPrimaryClick?: () => void;
    onSecondaryClick?: () => void;
  }
) => {
  message.value = msg;
  title.value = options?.title || null;
  primaryText.value = options?.primaryText || "확인";
  secondaryText.value = options?.secondaryText || null;
  primaryAction.value = options?.onPrimaryClick || closeModal;
  secondaryAction.value = options?.onSecondaryClick || closeModal;
  isOpen.value = true;
};

const closeModal = () => {
  isOpen.value = false;
};

const onPrimaryClick = () => {
  primaryAction.value();
  closeModal();
};

const onSecondaryClick = () => {
  secondaryAction.value();
  closeModal();
};

// ✅ `showModal()`을 외부에서 호출할 수 있도록 `defineExpose()` 사용
defineExpose({ showModal });
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.25);
  display: flex;
  align-items: center;
  justify-content: center;
}
.modal {
  background: white;
  padding: 1rem;
  border-radius: 10px;
  text-align: center;
  min-width: 300px;
  font-size: 0.9rem;
  line-height: 1.7;
}
.modal h3 {
  margin-top: 0;
}
.modal-buttons {
  margin-top: 20px;
  display: flex;
  justify-content: right;
  gap: 10px;
}
</style>
