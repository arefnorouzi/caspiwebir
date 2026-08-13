<script setup lang="ts">
import AppLayout from '@/layouts/DashboardLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import Pagination from '@/components/Pagination.vue';
import { ref, watch } from 'vue';
import { debounce } from "lodash";
import axios from 'axios';
import { showToast } from '@/composables/useToast.js'
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'اطلاعیه ها',
        href: '/dashboard/notification',
    },
];
interface Props {
    model: object;
}
const props = defineProps<Props>()
const formatDate = (d) =>
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' })

</script>

<template>
    <Head title="اطلاعیه ها" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="w-full px-2 py-4">
                    <div>
                        <h3 class="text-lg font-semibold mb-3">{{ model.name }}</h3>
                        <div v-html="model.description"></div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
