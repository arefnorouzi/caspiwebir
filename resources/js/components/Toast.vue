<script setup>
import { toastMessage, toastType, toastVisible } from '@/composables/useToast.js'
</script>

<template>
    <transition name="fade">
        <div
            v-if="toastVisible"
            class="fixed top-5 left-5 px-4 py-3 rounded shadow-lg z-50"
            :class="toastType === 'success'
        ? 'bg-green-500 text-white'
        : 'bg-red-500 text-white'"
        >
            {{ toastMessage }}
        </div>
    </transition>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
