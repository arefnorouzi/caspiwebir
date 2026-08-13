<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import Pagination from '@/components/Pagination.vue';
import { ref, watch } from 'vue';
import _ from "lodash";
import FlashMessage from '@/components/FlashMessage.vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'شبکه های اجتماعی',
        href: '/admin/social',
    },
];

interface Props {
    models: object;
    search_text: string;
}
const props = defineProps<Props>()
const search = ref(props.search_text)


watch(search, _.debounce(
    (q) => router.get("/admin/social", {search: q}, {preserveState: true}
    ), 1000));

async function destroy(id: number) {
    if (confirm('از حذف رکورد مطمئنی؟')) {
        router.delete('/admin/social/' + id)
    }
}

async function restore(id: number) {
    if (confirm('از بازیابی رکورد مطمئنی؟')) {
        router.delete('/admin/restore-brand/' + id)
    }
}

const toggleStatus = (id: number) => {
    router.put('/admin/social-status/' + id,
        {
            preserveScroll: true,
            preserveState: true,
        }
    )
}

</script>

<template>
    <Head title="شبکه های اجتماعی" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">لیست شبکه ها</h3>

                    </div>
                    <div class="ml-3">
                        <div class="w-full max-w-sm min-w-[200px] relative">
                            <div class="relative">
                                <input v-model="search"
                                       class="bg-white w-full pr-11 h-10 pl-3 py-2 bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md"
                                       placeholder="جستجو براساس نام"
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
                <Link href="/admin/social/create">
                    <button
                        class="me-1 cursor-pointer text-oklch(44.8% 0.119 151.328) bg-green-200 hover:bg-green-300 focus:ring-4 focus:ring-green-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                        <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6 12H18M12 6V18" stroke="#008080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                        <span class="ms-1"> افزودن آیتم</span>
                    </button>
                </Link>
                <div class="my-2 p-2 rounded-md">
                    <FlashMessage />
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
                                    لوگو
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    وضعیت
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    آدرس
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    عملیات
                                </p>
                            </th>
                        </tr>
                        </thead>
                        <tbody v-if="models?.data">
                        <tr v-for="(item, index) in models.data" :key="index" :class="item.deleted_at ? 'bg-red-100' : ''">
                            <td class="p-4 border-b border-slate-200 py-1">
                                <p class="block font-semibold text-sm text-slate-800">{{ item.id }}</p>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <p class="text-sm text-slate-500">{{ item.name }}</p>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <div v-if="item.image" class="mt-2">
                                    <img :src="item.image" class="border rounded object-fill table-img" />
                                </div>

                            </td>


                            <td class="p-4 border-b border-slate-200 py-1" style="direction: ltr">
                                <button
                                    @click="toggleStatus(item.id)"
                                    class="relative inline-flex h-4 w-8 items-center rounded-full transition-colors duration-300 cursor-pointer"
                                    :class="item.status ? 'bg-green-700' : 'bg-gray-300'"
                                >
                                  <span
                                      class="inline-block h-3 w-3 transform rounded-full bg-gray-200 transition-transform duration-300"
                                      :class="item.status ? 'translate-x-1' : 'translate-x-5'"
                                  />
                                </button>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1" style="direction: ltr">
                                <p class="text-sm text-slate-500">{{ item.link }}</p>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <Link :href="`/admin/social/${item.id}/edit`">
                                    <button
                                        class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                        type="button">
                                     <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="w-4 h-4">
                                      <path
                                          d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z">
                                      </path>
                                    </svg>
                                  </span>
                                    </button>
                                </Link>


                                <button v-if="item.deleted_at" @click="restore(item.id)"
                                        class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                        type="button">
                                  <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                    <svg width="25px" height="25px" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg"><path d="M25 38c-5.1 0-9.7-3-11.8-7.6l1.8-.8c1.8 3.9 5.7 6.4 10 6.4 6.1 0 11-4.9 11-11s-4.9-11-11-11c-4.6 0-8.5 2.8-10.1 7.3l-1.9-.7c1.9-5.2 6.6-8.6 12-8.6 7.2 0 13 5.8 13 13s-5.8 13-13 13z"/><path d="M20 22h-8v-8h2v6h6z"/></svg>
                                  </span>
                                </button>
                                <button v-else  @click="destroy(item.id)"
                                        class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                        type="button">
                                      <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                          <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14px" height="14px" viewBox="0 0 488.936 488.936" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M381.16,111.948H107.376c-6.468,0-12.667,2.819-17.171,7.457c-4.504,4.649-6.934,11.014-6.738,17.477l9.323,307.69 c0.39,12.92,10.972,23.312,23.903,23.312h20.136v-21.012c0-24.121,19.368-44.049,43.488-44.049h127.896 c24.131,0,43.893,19.928,43.893,44.049v21.012h19.73c12.933,0,23.52-10.346,23.913-23.268l9.314-307.7 c0.195-6.462-2.234-12.863-6.738-17.513C393.821,114.767,387.634,111.948,381.16,111.948z"></path> <path d="M309.166,435.355H181.271c-6.163,0-11.915,4.383-11.915,11.516v30.969c0,6.672,5.342,11.096,11.915,11.096h127.895 c6.323,0,11.366-4.773,11.366-11.096v-30.969C320.532,440.561,315.489,435.355,309.166,435.355z"></path> <path d="M427.696,27.106C427.696,12.138,415.563,0,400.591,0H88.344C73.372,0,61.239,12.138,61.239,27.106v30.946 c0,14.973,12.133,27.106,27.105,27.106H400.59c14.973,0,27.105-12.133,27.105-27.106L427.696,27.106L427.696,27.106z"></path> </g> </g> </g></svg>
                                      </span>
                                </button>
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
