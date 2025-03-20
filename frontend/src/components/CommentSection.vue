<template>
  <div class="comment-section">
    <div class="comment-write">
      <div class="wrapper">
        <input class="textfield" v-model="newComment.nickname" placeholder="닉네임" />
        <input class="textfield " v-model="newComment.password" type="password" placeholder="비밀번호" />
      </div>
      <textarea class="textarea" v-model="newComment.content" placeholder="댓글 내용"></textarea>
      <button class="button-primary" @click="addComment">댓글 작성</button>
    </div>
    

    <div class="comments">
      <h3>댓글</h3>
      <div v-for="comment in comments" :key="comment.id" class="comment">
        <span class="comment-nickname">{{ comment.nickname }}</span>
        <span class="comment-time">{{ formatDateTime(comment.createdAt) }}</span>
        <button class="delete-btn" @click="promptDelete(comment)">삭제</button>
        <p class="comment-content">{{ comment.content }}</p>
      </div>
    </div>
  </div>
  <AlertModal ref="alertModal" />
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { db } from '../firebaseConfig';
import { ref as dbRef, push, remove, onValue, set, get } from "firebase/database";
import AlertModal from "./AlertModal.vue";

const alertModal = ref<InstanceType<typeof AlertModal> | null>(null);

const props = defineProps<{ postId: string, context: string }>();

type Comment = {
  id: string;
  postId: string; // ✅ postId 추가
  nickname: string;
  content: string;
  password?: string;
  createdAt: number;
};

// ✅ 환경 변수에서 최고관리자 비밀번호 불러오기
const ADMIN_PASSWORD = import.meta.env.VITE_ADMIN_PASSWORD;

// ✅ 댓글 목록
const comments = ref<Comment[]>([]);

// ✅ 날짜 및 시간 포맷 변환 함수
const formatDateTime = (timestamp: number) => {
  const date = new Date(timestamp);
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, "0");
  const day = String(date.getDate()).padStart(2, "0");
  const hours = String(date.getHours()).padStart(2, "0");
  const minutes = String(date.getMinutes()).padStart(2, "0");

  return `${year}-${month}-${day} ${hours}:${minutes}`;
};

// ✅ Realtime Database에서 댓글 불러오기 (postId 기반 필터링)
const loadComments = () => {
  const commentsRef = dbRef(db, "comments");

  onValue(commentsRef, (snapshot) => {
    if (snapshot.exists()) {
      const data = snapshot.val();
      comments.value = Object.keys(data)
        .map((key) => ({ id: key, ...data[key] }))
        .filter((comment) => comment.postId === props.postId); // ✅ 해당 postId의 댓글만 가져오기
    } else {
      comments.value = [];
    }
  });
};

// ✅ 새로운 댓글을 위한 객체
const newComment = ref({
  nickname: "",
  password: "",
  content: ""
});

// ✅ Realtime Database에 댓글 추가 (postId 포함)
const addComment = async () => {
  if (!newComment.value.nickname || !newComment.value.content || !newComment.value.password) {
    alertModal.value?.showModal("닉네임, 비밀번호, 내용을 입력해주세요!");
    return;
  }

  try {
    const newCommentRef = push(dbRef(db, "comments"));
    await set(newCommentRef, {
      postId: props.postId, // ✅ 현재 글의 postId 저장
      nickname: newComment.value.nickname,
      password: newComment.value.password,
      content: newComment.value.content,
      createdAt: Date.now()
    });

    newComment.value.nickname = "";
    newComment.value.password = "";
    newComment.value.content = "";

  } catch (error) {
    console.error("댓글 작성 실패:", error);
  }
};

const promptDelete = async (comment) => {
  const inputPassword = prompt("비밀번호를 입력하세요.");

  if (!inputPassword) return;

  // 🔹 최고관리자 비밀번호 확인
  if (inputPassword === ADMIN_PASSWORD) {
    await deleteComment(comment.id);
    return;
  }

  // 🔹 일반 사용자 비밀번호 확인 (Firebase에서 가져옴)
  const commentRef = dbRef(db, `comments/${comment.id}`);
  const snapshot = await get(commentRef);

  if (!snapshot.exists()) {
    alertModal.value?.showModal("댓글을 찾을 수 없습니다.");
    return;
  }

  const commentData = snapshot.val();

  if (commentData.password === inputPassword) {
    await deleteComment(comment.id);
  } else {
    alertModal.value?.showModal("비밀번호가 일치하지 않습니다.");
  }
};

// 🔹 실제 삭제 함수 (Firebase에서 댓글 삭제)
const deleteComment = async (commentId) => {
  try {
    await remove(dbRef(db, `comments/${commentId}`));
    alertModal.value?.showModal("댓글이 삭제되었습니다.");
  } catch (error) {
    console.error("댓글 삭제 실패:", error);
  }
};


onMounted(loadComments);
</script>

<style scoped>

.comment-section {
  margin-top: 4rem;
}

.comment-write {
  text-align: right;
}

.wrapper {
  display: flex;
  gap: 0.75rem;
  margin-bottom: 1rem;
}

.textfield {
  border: none;
  border-bottom: 1px solid var(--border-color);
  height: 36px;
  font-size: 0.9rem;
  padding: 0.75rem;
  width: 100%;
}

.textfield:focus {
  outline: none;
  border-bottom: 1px solid var(--primary-color);
}

.textfield::placeholder {
  color: var(--text-gray);
}

.textarea {
  width: 100%;
  font-size: 0.9rem;
  padding: 0.75rem;
  height: 4rem;
  border: 1px solid var(--border-color);
  border-radius: 0.25rem;
  font-family: 'Pretendard';
  resize: none;
}

.textarea:focus{
  outline: none;
  border: 1px solid var(--primary-color);
  resize: none;
}

.textarea::placeholder {
  color: var(--text-gray);
}

.comment {
  margin-bottom: 1rem;
}

.comment-nickname {
  font-size: 0.8rem;
  font-weight: 600;
  margin-right: 0.5rem;
}

.comment-time {
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