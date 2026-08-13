<script setup>
import { computed } from 'vue'

const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({
            image: null,
            link: '',
        }),
    },
})

const emit = defineEmits(['update:modelValue'])

const link = computed({
    get() {
        return props.modelValue.link ?? ''
    },
    set(value) {
        emit('update:modelValue', {
            ...props.modelValue,
            link: value,
        })
    },
})
</script>

<template>
    <div class="space-y-4">

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                انتخاب تصویر
            </label>

            <input
                type="file"
                @change="e =>
    emit('update:modelValue', {
      ...modelValue,
      image: e.target.files[0],
    })
  "
                class="w-full rounded-md border p-2 border-gray-300"
                placeholder="مثلاً /category/shoes"
            />
        </div>

    </div>
</template>
