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
                            <th class="p-2 border-b border-slate-300 bg-slate-50">
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
                                <a :href="`/dashboard/invoice/${item.id}`" target="_blank">
                                    <p class="block font-semibold text-sm text-blue-800">{{ item.id }}</p>
                                </a>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <a :href="`/dashboard/invoice/${item.id}`" target="_blank" title="مشاهده جزئیات">
                                    <button
                                        class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                    >
                                  <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                      <svg fill="#000000" height="20px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 495.558 495.558" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M492.538,242.716c-3.702-6.173-92.288-151.327-244.76-151.327c-152.476,0-241.063,145.154-244.76,151.327L0,247.774 l3.019,5.058c3.697,6.173,92.284,151.337,244.76,151.337c152.471,0,241.058-145.164,244.76-151.337l3.019-5.058L492.538,242.716z M247.779,384.476c-125.769,0-207.625-111.394-224.587-136.702c16.962-25.298,98.817-136.692,224.587-136.692 s207.625,111.394,224.587,136.692C455.404,273.082,373.548,384.476,247.779,384.476z"></path> </g> </g> <g> <g> <path d="M247.779,140.505c-59.149,0-107.274,48.125-107.274,107.269c0,59.154,48.125,107.279,107.274,107.279 c59.154,0,107.279-48.125,107.279-107.279C355.058,188.63,306.933,140.505,247.779,140.505z M247.779,335.361 c-48.293,0-87.582-39.288-87.582-87.587c0-48.288,39.288-87.577,87.582-87.577c48.298,0,87.587,39.288,87.587,87.577 C335.365,296.072,296.077,335.361,247.779,335.361z"></path> </g> </g> <g> <g> <path d="M247.779,207.438c-22.24,0-40.337,18.096-40.337,40.336c0,22.24,18.096,40.337,40.337,40.337 c22.24,0,40.337-18.096,40.337-40.337C288.115,225.534,270.019,207.438,247.779,207.438z M247.779,268.418 c-11.385,0-20.644-9.26-20.644-20.644c0-11.385,9.26-20.644,20.644-20.644c11.385,0,20.644,9.26,20.644,20.644 C268.423,259.159,259.163,268.418,247.779,268.418z"></path> </g> </g> </g></svg>
                                  </span>
                                    </button>
                                </a>
                            </td>
                            <td class="p-2 border-b border-slate-200 py-1">
                                <span :class="`${item?.invoice_type?.css_class} text-xs`">{{ item?.invoice_type?.name }}</span>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <span :class="`${item?.status?.css_class} text-xs`">{{ item?.status?.name }}</span>
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
