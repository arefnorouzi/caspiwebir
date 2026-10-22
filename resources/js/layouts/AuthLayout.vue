<script setup lang="ts">
import AuthLayout from '@/layouts/auth/AuthCardLayout.vue';
import FlashMessage from '@/components/FlashMessage.vue';
import Toast from '@/components/Toast.vue';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <AuthLayout :title="title" :description="description">
        <FlashMessage />
        <Toast />
        <slot />
    </AuthLayout>
</template>
