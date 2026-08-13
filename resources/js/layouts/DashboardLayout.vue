<script setup lang="ts">
import AppLayout from '@/layouts/app/DashboardSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import Toast from '@/components/Toast.vue'

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Toast />
        <slot />
    </AppLayout>
</template>
<style>
body{
    direction: rtl;
    text-align: right;
}
button[type='submit']{
    cursor: pointer !important;
}
</style>
