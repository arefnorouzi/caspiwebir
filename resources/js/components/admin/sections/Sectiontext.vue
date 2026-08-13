<script setup>
import { computed } from 'vue'
import QuillEditor from "@/components/admin/QuillEditor.vue";

const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({ content: '' }),
    },
})

const emit = defineEmits(['update:modelValue'])

const content = computed({
    get() {
        return props.modelValue.content ?? ''
    },
    set(value) {
        emit('update:modelValue', {
            ...props.modelValue,
            content: value,
        })
    },
})
</script>

<template>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            متن محتوا
        </label>

        <QuillEditor
            v-model="content" />
    </div>
</template>
