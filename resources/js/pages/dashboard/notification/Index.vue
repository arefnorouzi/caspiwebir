<script setup lang="ts">
import AppLayout from '@/layouts/DashboardLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import Pagination from '@/components/Pagination.vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'اطلاعیه ها',
        href: '/dashboard/notification',
    },
];
interface Props {
    models: object;
    user_notifications: object;
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
                <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">اطلاعیه ها</h3>

                    </div>
                </div>
                <div class="relative flex mt-2 flex-col w-full h-full overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">

                    <table class="w-full text-right table-auto min-w-max">
                        <thead>
                        <tr>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    #
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    عنوان
                                </p>
                            </th>

                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    تاریخ
                                </p>
                            </th>
                        </tr>
                        </thead>
                        <tbody v-if="props.models && props.models.data">
                        <tr v-for="(item, index) in props.models.data" :key="index">
                            <td class="p-4 border-b border-slate-200 py-2">
                                <Link :href="`/dashboard/notification/${item.id}`">
                                    <p class="block font-semibold text-sm text-blue-800">{{ item.id }}</p>
                                </Link>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-2">
                                <Link :href="`/dashboard/notification/${item.id}`">
                                    <span class="p-2 cursor-pointer text-blue-500">{{ item.name }}</span>
                                </Link>
                            </td>

                            <td class="p-4 border-b border-slate-200 py-2" style="direction: ltr">
                                <p class="text-sm text-slate-500">{{ formatDate(item.created_at) }}</p>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="my-3" v-if="props.models">
                        <Pagination :links="props.models.links" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
