<script setup lang="ts">
import AppLayout from '@/layouts/DashboardLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import Pagination from '@/components/Pagination.vue';
import { ref, watch } from 'vue';
import _ from "lodash";
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'فاکتورهای من',
        href: '/dashboard/invoice',
    },
];
interface Props {
    models: object;
    search_text: string;
}
const props = defineProps<Props>()
const search = ref(props.search_text)

watch(search, _.debounce(
    (q) => router.get("/dashboard/invoice", {search: q}, {preserveState: true}
    ), 1000));

const formatDate = (d) =>
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'numeric', day: 'numeric'})

</script>

<template>
    <Head title="فاکتورهای من" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">لیست فاکتورها</h3>

                    </div>
                    <div class="ml-3">
                        <div class="w-full max-w-sm min-w-[200px] relative">
                            <div class="relative">
                                <input v-model="search"
                                       class="bg-white w-full pr-11 h-10 pl-3 py-2 bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md"
                                       placeholder="جستجو فاکتورها"
                                />
                                <button
                                    class="absolute h-8 w-8 right-1 top-1 my-auto px-2 flex items-center bg-white rounded "
                                    type="button"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-8 h-8 text-slate-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>
                                </button>
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
                                    نوع
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    وضعیت
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    مبلغ
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
                                <a :href="`/checkout/${item.uuid}`" target="_blank">
                                    <p class="block font-semibold text-sm text-blue-800">{{ item.id }}</p>
                                </a>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <a :href="`/checkout/${item.uuid}`" target="_blank">
                                    <button class="p-2 cursor-pointer bg-indigo-500 text-gray-100 rounded-md border border-green-800">جزئیات</button>

                                </a>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <div class="w-max">
                                    <div
                                        :class="`relative grid items-center px-2 py-1 font-sans text-xs font-bold uppercase rounded-md select-none whitespace-nowrap ${item.invoice_type.css_class}`">
                                        <span class="">{{ item?.invoice_type?.name }}</span>
                                    </div>

                                </div>
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
                                <p class="text-sm text-slate-500">{{ Number(item.amount).toLocaleString()}}</p>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
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
