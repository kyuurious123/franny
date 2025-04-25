
<!-- ViewPost.vue - 게시글 보기 페이지 -->
<template>
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto p-4">
      <div v-if="loading" class="text-center py-10">
        <p>게시글을 불러오는 중...</p>
      </div>
      <div v-else-if="post" class="bg-white rounded-lg shadow p-6">
        <div class="mb-4 pb-4 border-b">
          <h1 class="text-2xl font-bold text-gray-800">{{ post.title }}</h1>
          <div class="mt-2 text-sm text-gray-500 flex justify-between">
            <span>작성일: {{ formatDate(post.date) }}</span>
            <span>조회수: {{ post.views }}</span>
          </div>
        </div>
        
        <div class="prose max-w-none mt-6" v-html="post.content"></div>
        
        <div class="flex justify-between mt-8">
          <button
            @click="router.push('/review-board')"
            class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition"
          >
            목록으로
          </button>
          
          <button
            v-if="isAdmin"
            @click="deletePost"
            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition"
          >
            삭제
          </button>
        </div>
      </div>
      <div v-else class="bg-white rounded-lg shadow p-6 text-center">
        <p>게시글을 찾을 수 없습니다.</p>
        <button
          @click="router.push('/review-board')"
          class="mt-4 px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition"
        >
          목록으로
        </button>
      </div>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { Post } from '../types';

export default defineComponent({
  name: 'ViewPost',
  setup() {
    const router = useRouter();
    const route = useRoute();
    const post = ref<Post | null>(null);
    const loading = ref(true);
    const isAdmin = ref(false);
    
    onMounted(() => {
      // 관리자 확인
      const adminToken = sessionStorage.getItem('adminToken');
      isAdmin.value = !!adminToken;
      
      const postId = Number(route.params.id);
      
      // 임시 테스트용 게시글 조회 로직
      try {
        // localStorage에서 게시글 가져오기
        const posts = JSON.parse(localStorage.getItem('reviewPosts') || '[]');
        const foundPost = posts.find(p => p.id === postId);
        
        if (foundPost) {
          // 조회수 증가
          foundPost.views = (foundPost.views || 0) + 1;
          localStorage.setItem('reviewPosts', JSON.stringify(posts));
          
          post.value = foundPost;
        } else {
          post.value = null;
        }
      } catch (error) {
        console.error('게시글을 불러오는 중 오류가 발생했습니다:', error);
        post.value = null;
      } finally {
        loading.value = false;
      }
      
      /* 실제 API 코드는 주석 처리
      try {
        const response = await fetch(`/api/getPost.php?id=${postId}`);
        const data = await response.json();
        
        if (data.success) {
          post.value = data.post;
        } else {
          post.value = null;
        }
      } catch (error) {
        console.error('게시글을 불러오는 중 오류가 발생했습니다:', error);
        post.value = null;
      } finally {
        loading.value = false;
      }
      */
    });
    
    const formatDate = (dateString: string) => {
      const date = new Date(dateString);
      return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
    };
    
    const deletePost = () => {
      if (!confirm('정말로 이 게시글을 삭제하시겠습니까?')) {
        return;
      }
      
      // 임시 테스트용 삭제 로직
      try {
        // localStorage에서 게시글 삭제
        const posts = JSON.parse(localStorage.getItem('reviewPosts') || '[]');
        const filteredPosts = posts.filter(p => p.id !== post.value?.id);
        localStorage.setItem('reviewPosts', JSON.stringify(filteredPosts));
        
        alert('게시글이 삭제되었습니다.');
        router.push('/review');
      } catch (error) {
        console.error('게시글 삭제 중 오류가 발생했습니다:', error);
        alert('게시글 삭제 중 오류가 발생했습니다.');
      }
      
      /* 실제 API 코드는 주석 처리
      try {
        const response = await fetch('/api/deletePost.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${sessionStorage.getItem('adminToken')}`
          },
          body: JSON.stringify({
            id: post.value?.id
          })
        });
        
        const result = await response.json();
        
        if (result.success) {
          alert('게시글이 삭제되었습니다.');
          router.push('/review');
        } else {
          alert('게시글 삭제에 실패했습니다.');
        }
      } catch (error) {
        console.error('게시글 삭제 중 오류가 발생했습니다:', error);
        alert('게시글 삭제 중 오류가 발생했습니다.');
      }
      */
    };
    
    return {
      router,
      post,
      loading,
      isAdmin,
      formatDate,
      deletePost
    };
  }
});
</script>