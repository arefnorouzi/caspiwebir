<script setup>
const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits(['update:modelValue'])

const toggle = () => {
    if (props.disabled) return
    emit('update:modelValue', !props.modelValue)
}
</script>

<template>
    <div style="direction: ltr" >
        <button
            type="button"
            @click="toggle"
            :disabled="disabled"
            class="switch-btn relative inline-flex h-4 w-8 items-center rounded-full
           transition-colors duration-300 focus:outline-none cursor-pointer
           disabled:opacity-50"
            :class="modelValue ? 'bg-green-500' : 'bg-gray-300'"
        >
    <span
        class="inline-block h-3 w-3 transform rounded-full bg-white
             transition-transform duration-300"
        :class="modelValue ? 'translate-x-5' : 'translate-x-1'"
    />
        </button>
    </div>
</template>
<style scoped>
@media only screen and (max-width: 650px) {
    .switch-btn{width: 1.7rem !important}
    .switch-btn span{width: .7rem !important}
}
</style>
