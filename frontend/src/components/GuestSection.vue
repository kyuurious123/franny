<template>
  <div class="guest-section">
    <div class="guest-write">
      <div class="wrapper">
        <input class="textfield" v-model="newGuest.nickname" placeholder="닉네임" />
        <input class="textfield " v-model="newGuest.password" type="password" placeholder="비밀번호" />
      </div>
      <textarea class="textarea" v-model="newGuest.content" placeholder="저에 대한 객관적인 비평 또는 피드백? 그런 거 원하지 않습니다. 무조건 박수갈채. 일방적이고 편향적인 칭찬 부탁드립니다."></textarea>
      <button class="button-primary" @click="addGuest">방명록 작성</button>
    </div>
    

    <div class="guests">
      <h3>방명록</h3>
      <div v-for="guest in guests" :key="guest.id" class="guest">
        <span class="guest-nickname">{{ guest.nickname }}</span>
        <span class="guest-time">{{ formatDateTime(guest.createdAt) }}</span>
        <button class="delete-btn" @click="promptDelete(guest)">삭제</button>
        <p class="guest-content">{{ guest.content }}</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import { db } from "../firebaseConfig";
import { ref as dbRef, push, remove, onValue, set, get } from "firebase/database";
import AlertModal from "./AlertModal.vue";

// ✅ 환경 변수에서 최고 관리자 비밀번호 불러오기
const ADMIN_PASSWORD = import.meta.env.VITE_ADMIN_PASSWORD;

// ✅ 방명록 목록
const guests = ref<{ id: string; nickname: string; message: string; password?: string; createdAt: number }[]>([]);

// ✅ Realtime Database에서 방명록 불러오기
const loadGuests = () => {
  const guestsRef = dbRef(db, "guests");

  onValue(guestsRef, (snapshot) => {
    if (snapshot.exists()) {
      const data = snapshot.val();
      guests.value = Object.keys(data).map((key) => ({
        id: key,
        ...data[key],
      }));
    } else {
      guests.value = [];
    }
  });
};

// ✅ 새로운 방명록을 위한 객체
const newGuest = ref({
  nickname: "",
  password: "",
  message: "",
});

// ✅ 방명록 작성
const addGuest = async () => {
  if (!newGuest.value.nickname || !newGuest.value.message || !newGuest.value.password) {
    alertModal.value?.showModal("닉네임, 비밀번호, 내용을 입력해주세요!");
    return;
  }

  try {
    const newGuestRef = push(dbRef(db, "guests"));
    await set(newGuestRef, {
      postId: "guest",
      nickname: newGuest.value.nickname,
      password: newGuest.value.password, // 🔹 비밀번호 저장
      message: newGuest.value.message,
      createdAt: Date.now(),
    });

    newGuest.value.nickname = "";
    newGuest.value.password = "";
    newGuest.value.message = "";

  } catch (error) {
    console.error("방명록 작성 실패:", error);
  }
};

// ✅ 방명록 삭제 로직 (최고 관리자 또는 작성자만 삭제 가능)
const promptDelete = async (guest) => {
  const inputPassword = prompt("비밀번호를 입력하세요.:");

  if (!inputPassword) return;

  // 🔹 최고 관리자 비밀번호 확인
  if (inputPassword === ADMIN_PASSWORD) {
    await deleteGuest(guest.id);
    return;
  }

  // 🔹 일반 사용자 비밀번호 확인
  const guestRef = dbRef(db, `guests/${guest.id}`);
  const snapshot = await get(guestRef);

  if (!snapshot.exists()) {
    alertModal.value?.showModal("방명록을 찾을 수 없습니다.");
    return;
  }

  const guestData = snapshot.val();

  if (guestData.password === inputPassword) {
    await deleteGuest(guest.id);
  } else {
    alertModal.value?.showModal("비밀번호가 일치하지 않습니다.");
  }
};

// ✅ 실제 삭제 함수 (Firebase에서 방명록 삭제)
const deleteGuest = async (guestId) => {
  try {
    await remove(dbRef(db, `guests/${guestId}`));
    alertModal.value?.showModal("방명록이 삭제되었습니다.");
  } catch (error) {
    console.error("방명록 삭제 실패:", error);
  }
};

onMounted(loadGuests);
</script>

<style scoped>
.guest-write {
  text-align: right;
}

.wrapper {
  display: flex;
  gap: 0.75rem;
  margin-bottom: 0.75rem;
}

.textfield {
  border: 1px solid var(--border-color);
  height: 36px;
  font-size: 0.9rem;
  padding: 0.75rem;
  width: 100%;
  border-radius: 0.25rem;
}

.textfield:focus {
  outline: none;
  border: 1px solid var(--primary-color);
}

.textfield::placeholder {
  color: var(--text-gray);
}

.textarea {
  width: 100%;
  font-size: 0.9rem;
  padding: 0.75rem;
  height: 7rem;
  border: 1px solid var(--border-color);
  border-radius: 0.25rem;
  font-family: 'Pretendard';
  line-height: 1.7;
  resize: none;
}

.textarea:focus{
  outline: none;
  border: 1px solid var(--primary-color)
}

.textarea::placeholder {
  color: var(--text-gray);
}

.guest {
  margin-bottom: 1rem;
}

.guest-nickname {
  font-size: 0.8rem;
  font-weight: 600;
  margin-right: 0.5rem;
}

.guest-time {
  font-size: 0.75rem;
  color: var(--text-gray);
}

.delete-btn {
  background-color: white;
  font-size: 0.75rem;
  color: var(--text-gray);
  height: 1rem;
  padding: 0;
  margin-left: 0.75rem;
}
</style>