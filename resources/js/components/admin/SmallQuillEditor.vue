<script setup lang="ts">
import { ref, defineProps, onMounted, defineEmits, watch, onBeforeUnmount } from 'vue';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';
const props = defineProps({
    modelValue: String
})
const emit = defineEmits(['update:modelValue'])

const editorContainer = ref(null);
let quill = null;
const content = ref(props.modelValue)

watch(content, (value) => emit('update:modelValue', value))


onMounted(() => {
    // اکنون editorContainer.value حاوی المنت DOM است
    if (editorContainer.value) {
        quill = new Quill(editorContainer.value, {
            theme: 'snow',
            placeholder: 'مطلب خود را بنویسید...',
            modules: {
                toolbar: {
                    container: [
                        [{ header: [1, 2, 3, 4, 5, 6, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ color: [] }, { background: [] }],
                        [{ list: 'ordered' }, { list: 'bullet' }, { list: 'check' }],
                        [{ indent: '-1' }, { indent: '+1' }],
                        [{ align: [] }],
                        ['blockquote', 'code-block'],
                        ['link'],
                        ['clean'],
                        [{ 'direction': 'rtl' }],  // اضافه کردن دکمه راست‌چین
                    ]
                }
            }
        });
        quill.root.innerHTML = content.value
        quill.on('text-change', (delta, oldDelta, source) => {
            // دریافت HTML داخلی ادیتور
            content.value = quill.root.innerHTML;
        });

        // هنگام unmount برای جلوگیری از memory leak
        onBeforeUnmount(() => {
            if (quill) {
                quill.off('text-change');
                quill = null;
            }
        });
    }
});

</script>

<template>
    <div ref="editorContainer"></div>
    <textarea v-model="content" style="display: none" readonly></textarea>
</template>

<style>
.ql-editor {
    direction: rtl !important;
    text-align: right !important;
    min-height: 100px !important;
    font-size: 14px;
    font-family: 'iransans', sans-serif;
    line-height: 30px;
}
.ql-snow .ql-picker-label{padding-left: 0;
    padding-right: 20px;}

.ql-toolbar{direction: rtl; text-align: right;}

</style>
