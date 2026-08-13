<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'جزئیات محصول',
        href: '/admin/product',
    },
];
const props = defineProps({
    model: Object
})
</script>

<template>
    <Head title="جزئیات محصول" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <h1 class="text-2xl font-bold mb-4">{{ model?.name }}</h1>
            <p class="text-gray-600 mb-6">{{ model?.description }}</p>

            <h2 class="text-xl font-semibold mb-2">واریانت‌ها:</h2>

            <div class="space-y-4">
                <div v-for="variant in model?.variants" :key="variant.id" class="border p-3 rounded">
                    <div class="font-semibold">قیمت: {{ model?.price + variant.price }} تومان</div>
                    <div class="text-sm text-gray-600">موجودی: {{ variant.stock }}</div>


                    <div class="mt-2 flex gap-2">


                    </div>
                </div>
            </div>
        </div>
    </AppLayout>


</template>

<style scoped>

</style>
