<template>
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto p-4">
      <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">리뷰 작성</h1>
        
        <div class="mb-4">
          <label for="title" class="block text-gray-700 mb-2">제목</label>
          <input
            type="text"
            id="title"
            v-model="title"
            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-300"
            required
          />
        </div>
        
        <div class="mb-6">
          <label class="block text-gray-700 mb-2">내용</label>
          <div class="border rounded">
            <TipTapEditor v-model="content" />
          </div>
        </div>
        
        <div class="flex justify-end space-x-3">
          <button
            @click="router.push('/review-board')"
            class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition"
          >
            취소
          </button>
          <button
            @click="savePost"
            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition"
          >
            저장
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import TipTapEditor from '../components/TipTapEditor.vue';

export default defineComponent({
  name: 'WritePost',
  components: {
    TipTapEditor
  },
  setup() {
    const router = useRouter();
    const title = ref('');
    const content = ref('');
    
    onMounted(() => {
      // 관리자 인증 검사
      const adminToken = sessionStorage.getItem('adminToken');
      if (!adminToken) {
        alert('관리자 권한이 필요합니다.');
        router.push('/review');
      }
    });
    
    const savePost = () => {
      if (!title.value.trim()) {
        alert('제목을 입력해주세요.');
        return;
      }
      
      if (!content.value.trim()) {
        alert('내용을 입력해주세요.');
        return;
      }
      
      // 임시 테스트용 저장 로직
      try {
        // localStorage에 게시글 저장
        const posts = JSON.parse(localStorage.getItem('reviewPosts') || '[]');
        const newId = posts.length > 0 ? Math.max(...posts.map(p => p.id)) + 1 : 1;
        
        const newPost = {
          id: newId,
          title: title.value,
          content: content.value,
          date: new Date().toISOString(),
          views: 0
        };
        
        posts.push(newPost);
        localStorage.setItem('reviewPosts', JSON.stringify(posts));
        
        alert('게시글이 저장되었습니다.');
        router.push('/review');
      } catch (error) {
        console.error('게시글 저장 중 오류가 발생했습니다:', error);
        alert('게시글 저장 중 오류가 발생했습니다.');
      }
      
      /* 실제 API 코드는 주석 처리
      try {
        const response = await fetch('/api/savePost.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${sessionStorage.getItem('adminToken')}`
          },
          body: JSON.stringify({
            title: title.value,
            content: content.value,
            date: new Date().toISOString()
          })
        });
        
        const result = await response.json();
        
        if (result.success) {
          alert('게시글이 저장되었습니다.');
          router.push('/review');
        } else {
          alert('게시글 저장에 실패했습니다.');
        }
      } catch (error) {
        console.error('게시글 저장 중 오류가 발생했습니다:', error);
        alert('게시글 저장 중 오류가 발생했습니다.');
      }
      */
    };
    
    return {
      router,
      title,
      content,
      savePost
    };
  }
});
</script>
