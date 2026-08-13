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
        title: 'درخواست های پشتیبانی',
        href: '/dashboard/ticket',
    },
];
interface Props {
    models: object;
}
const props = defineProps<Props>()
const formatDate = (d) =>
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' })

</script>

<template>
    <Head title="درخواست های پشتیبانی" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">درخواست های پشتیبانی</h3>

                    </div>
                    <div class="ml-3">
                        <div class="w-full max-w-sm min-w-[200px] relative">
                            <div class="relative">
                                <Link href="/dashboard/ticket/create">
                                    <button class="p-2 bg-black rounded-md text-gray-100 cursor-pointer">درخواست جدید</button>

                                </Link>

                            </div>
                        </div>
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
                                    جزئیات
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    وضعیت
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    دپارتمان
                                </p>
                            </th>

                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    تاریخ
                                </p>
                            </th>
                        </tr>
                        </thead>
                        <tbody v-if="models && models.data">
                        <tr v-for="(item, index) in models.data" :key="index" :class="item.deleted_at ? 'bg-red-100' : ''">
                            <td class="p-4 border-b border-slate-200 py-1">
                                <Link :href="`/dashboard/ticket/show/${item.id}`">
                                    <p class="block font-semibold text-sm text-blue-800">{{ item.id }}</p>
                                </Link>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <Link :href="`/dashboard/ticket/show/${item.id}`">
                                    <span class="p-2 cursor-pointer text-blue-500">{{ item.title }}</span>

                                </Link>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <div class="w-max">
                                    <div
                                        :class="`relative grid items-center px-2 py-1 font-sans text-xs font-bold uppercase rounded-md select-none whitespace-nowrap ${item.status.css_class}`">
                                        <span class="">{{ item?.status?.name }}</span>
                                    </div>

                                </div>
                            </td>

                            <td class="p-4 border-b border-slate-200 py-1">
                                <p class="text-sm text-slate-500">{{ item?.department?.name}}</p>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1" style="direction: ltr">
                                <p class="text-sm text-slate-500">{{ formatDate(item.created_at) }}</p>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="my-3" v-if="models">
                        <Pagination :links="models.links" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
