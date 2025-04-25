<!-- MenuBar.vue - Tiptap 에디터 메뉴바 -->
<template>
  <div class="flex flex-wrap gap-1 p-1 border-b">
    <button
      @click="editor.chain().focus().toggleBold().run()"
      :class="{ 'is-active': editor.isActive('bold') }"
      class="p-1 rounded hover:bg-gray-100"
    >
      <span class="font-bold">B</span>
    </button>
    <button
      @click="editor.chain().focus().toggleItalic().run()"
      :class="{ 'is-active': editor.isActive('italic') }"
      class="p-1 rounded hover:bg-gray-100"
    >
      <span class="italic">I</span>
    </button>
    <button
      @click="editor.chain().focus().toggleStrike().run()"
      :class="{ 'is-active': editor.isActive('strike') }"
      class="p-1 rounded hover:bg-gray-100"
    >
      <span class="line-through">S</span>
    </button>
    <span class="border-r mx-1 h-6"></span>
    <button
      @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
      :class="{ 'is-active': editor.isActive('heading', { level: 1 }) }"
      class="p-1 rounded hover:bg-gray-100"
    >
      H1
    </button>
    <button
      @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
      :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }"
      class="p-1 rounded hover:bg-gray-100"
    >
      H2
    </button>
    <button
      @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
      :class="{ 'is-active': editor.isActive('heading', { level: 3 }) }"
      class="p-1 rounded hover:bg-gray-100"
    >
      H3
    </button>
    <span class="border-r mx-1 h-6"></span>
    <button
      @click="editor.chain().focus().toggleBulletList().run()"
      :class="{ 'is-active': editor.isActive('bulletList') }"
      class="p-1 rounded hover:bg-gray-100"
    >
      ● 목록
    </button>
    <button
      @click="editor.chain().focus().toggleOrderedList().run()"
      :class="{ 'is-active': editor.isActive('orderedList') }"
      class="p-1 rounded hover:bg-gray-100"
    >
      1. 번호
    </button>
    <span class="border-r mx-1 h-6"></span>
    <button
      @click="setLink"
      :class="{ 'is-active': editor.isActive('link') }"
      class="p-1 rounded hover:bg-gray-100"
    >
      🔗 링크
    </button>
    <button
      @click="addImage"
      class="p-1 rounded hover:bg-gray-100"
    >
      🖼 이미지
    </button>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Editor } from '@tiptap/vue-3';

export default defineComponent({
  name: 'MenuBar',
  props: {
    editor: {
      type: Object as () => Editor,
      required: true,
    },
  },
  setup(props) {
    const setLink = () => {
      const previousUrl = props.editor.getAttributes('link').href;
      const url = window.prompt('URL을 입력하세요:', previousUrl);

      // 취소했거나 비어있으면
      if (url === null || url === '') {
        // 링크가 선택된 상태면 제거
        if (previousUrl) {
          props.editor.chain().focus().extendMarkRange('link').unsetLink().run();
        }
        return;
      }

      // 유효한 URL인지 확인
      if (!/^https?:\/\//.test(url)) {
        alert('http:// 또는 https://로 시작하는 유효한 URL을 입력해주세요.');
        return;
      }

      props.editor
        .chain()
        .focus()
        .extendMarkRange('link')
        .setLink({ href: url })
        .run();
    };

    const addImage = () => {
      const url = window.prompt('이미지 URL을 입력하세요:');
      
      if (url) {
        props.editor.chain().focus().setImage({ src: url }).run();
      }
    };

    return {
      setLink,
      addImage
    };
  }
});
</script>

<style scoped>
.is-active {
  background-color: #e2e8f0;
}
</style>