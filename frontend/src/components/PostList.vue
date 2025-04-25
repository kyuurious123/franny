
<template>
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">번호</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">제목</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">작성일</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">조회수</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="post in posts" :key="post.id" @click="goToPost(post.id)" class="hover:bg-gray-100 cursor-pointer">
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ post.id }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ post.title }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatDate(post.date) }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ post.views }}</td>
        </tr>
        <tr v-if="posts.length === 0">
          <td colspan="4" class="px-6 py-4 text-center text-gray-500">등록된 게시글이 없습니다.</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { useRouter } from 'vue-router';
import { Post } from '../types';

export default defineComponent({
  name: 'PostList',
  props: {
    posts: {
      type: Array as PropType<Post[]>,
      required: true
    }
  },
  setup() {
    const router = useRouter();
    
    const goToPost = (id: number) => {
      router.push(`/post/${id}`);
    };
    
    const formatDate = (dateString: string) => {
      const date = new Date(dateString);
      return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
    };
    
    return {
      goToPost,
      formatDate
    };
  }
});
</script>