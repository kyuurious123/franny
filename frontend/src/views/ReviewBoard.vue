<template>
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto p-4">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">리뷰 게시판</h1>
        <button 
          @click="handleWriteClick"
          class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition"
        >
          글쓰기
        </button>
      </div>

      <div v-if="loading" class="text-center py-10">
        <p>게시글을 불러오는 중...</p>
      </div>
      <PostList v-else :posts="posts" />
    </div>

    <!-- 비밀번호 모달 -->
    <PasswordModal 
      v-if="showPasswordModal"
      @close="showPasswordModal = false"
      @submit="handlePasswordSubmit"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import PostList from '../components/PostList.vue';
import PasswordModal from '../components/PasswordModal.vue';
import { Post } from '../types';

export default defineComponent({
  name: 'ReviewBoard',
  components: {
    PostList,
    PasswordModal
  },
  setup() {
    const router = useRouter();
    const posts = ref<Post[]>([]);
    const loading = ref(true);
    const showPasswordModal = ref(false);
    
    onMounted(() => {
      // 임시 테스트용 모의 데이터
      const mockPosts = [
        {
          id: 1,
          title: '첫 번째 테스트 게시글',
          date: '2025-04-25T12:00:00.000Z',
          views: 5
        },
        {
          id: 2,
          title: '두 번째 테스트 게시글',
          date: '2025-04-24T14:30:00.000Z',
          views: 10
        }
      ];
      
      posts.value = mockPosts;
      loading.value = false;
      
      /* 실제 API 코드는 주석 처리
      try {
        const response = await fetch('/api/getPosts.php');
        const data = await response.json();
        posts.value = data;
      } catch (error) {
        console.error('게시글을 불러오는 중 오류가 발생했습니다:', error);
      } finally {
        loading.value = false;
      }
      */
    });
    
    const handleWriteClick = () => {
      showPasswordModal.value = true;
    };
    
    const handlePasswordSubmit = (inputPassword: string) => {
      // 임시 테스트용 비밀번호 확인
      if (inputPassword === 'admin1234') {
        sessionStorage.setItem('adminToken', 'test-token-123');
        router.push('/review/write');
      } else {
        alert('비밀번호가 올바르지 않습니다.');
      }
      
      /* 실제 API 코드는 주석 처리
      try {
        const response = await fetch('/api/checkPassword.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ password: inputPassword }),
        });
        
        const result = await response.json();
        
        if (result.success) {
          sessionStorage.setItem('adminToken', result.token);
          router.push('/review/write');
        } else {
          alert('비밀번호가 올바르지 않습니다.');
        }
      } catch (error) {
        console.error('비밀번호 확인 중 오류가 발생했습니다:', error);
      }
      */
    };
    
    return {
      posts,
      loading,
      showPasswordModal,
      handleWriteClick,
      handlePasswordSubmit
    };
  }
});
</script>