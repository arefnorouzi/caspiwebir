<template>
    <transition name="fade">
        <div
            v-if="message"
            :class="{
        'bg-green-100 text-green-800 border-green-400 ms-auto': type === 'success',
        'bg-red-100 text-red-800 border-red-400 ms-auto': type === 'error',
      }"
            class="fixed top-5 left-5 border rounded-lg px-4 py-3 shadow-lg z-50"
        >
            {{ message }}
        </div>
    </transition>
</template>

<script setup>
import { ref, watch } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const message = ref(null)
const type = ref(null)

// Watch for flash message changes from backend
watch(
    () => page.props.flash,
    (flash) => {
        if (flash.success) {
            message.value = flash.success
            type.value = 'success'
        } else if (flash.error) {
            message.value = flash.error
            type.value = 'error'
        }else if (flash.message) {
            message.value = flash.message
            type.value = 'success'
        } else {
            message.value = null
        }

        // Auto-hide after 3 seconds
        if (message.value) {
            setTimeout(() => (message.value = null), 3000)
        }
    },
    { immediate: true, deep: true }
)
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.4s;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
