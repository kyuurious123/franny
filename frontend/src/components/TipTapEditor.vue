<template>
  <div class="tiptap-editor">
    <menu-bar class="editor-menu" v-if="editor" :editor="editor" />
    <editor-content class="editor-content p-4" :editor="editor" />
  </div>
</template>

<script lang="ts">
import { defineComponent, onBeforeUnmount, watch } from 'vue';
import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Image from '@tiptap/extension-image';
import Link from '@tiptap/extension-link';
import TextAlign from '@tiptap/extension-text-align';
import MenuBar from './MenuBar.vue';

export default defineComponent({
  name: 'TipTapEditor',
  components: {
    EditorContent,
    MenuBar
  },
  props: {
    modelValue: {
      type: String,
      default: ''
    }
  },
  emits: ['update:modelValue'],
  setup(props, { emit }) {
    const editor = useEditor({
      content: props.modelValue,
      extensions: [
        StarterKit,
        Image,
        Link.configure({
          openOnClick: false,
        }),
        TextAlign.configure({
          types: ['heading', 'paragraph'],
        }),
      ],
      onUpdate: ({ editor }) => {
        emit('update:modelValue', editor.getHTML());
      }
    });

    // 외부에서 modelValue가 변경되면 에디터 내용도 업데이트
    watch(() => props.modelValue, (newValue) => {
      // 에디터 내용과 다를 때만 업데이트
      const editorContent = editor.value?.getHTML();
      if (newValue !== editorContent) {
        editor.value?.commands.setContent(newValue, false);
      }
    });

    // 컴포넌트가 소멸될 때 에디터 인스턴스 해제
    onBeforeUnmount(() => {
      editor.value?.destroy();
    });

    return {
      editor
    };
  }
});
</script>

<style scoped>
.tiptap-editor {
  border-radius: 0.25rem;
  display: flex;
  flex-direction: column;
}

.editor-menu {
  border-bottom: 1px solid #e2e8f0;
  padding: 0.5rem;
  display: flex;
  flex-wrap: wrap;
  gap: 0.25rem;
}

.editor-content {
  min-height: 300px;
  overflow-y: auto;
}

.editor-content :deep(.ProseMirror) {
  outline: none;
}

.editor-content :deep(.ProseMirror p) {
  margin-bottom: 0.75rem;
}

.editor-content :deep(.ProseMirror h1, .ProseMirror h2, .ProseMirror h3) {
  margin-top: 1rem;
  margin-bottom: 0.5rem;
  font-weight: bold;
}

.editor-content :deep(.ProseMirror h1) {
  font-size: 1.5rem;
}

.editor-content :deep(.ProseMirror h2) {
  font-size: 1.25rem;
}

.editor-content :deep(.ProseMirror h3) {
  font-size: 1.125rem;
}
</style>
