<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import Pagination from '@/components/Pagination.vue';
import { ref, watch } from 'vue';
import _ from "lodash";
import FlashMessage from "@/components/FlashMessage.vue";
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'مدیریت کاربران',
        href: '/admin/user',
    },
];
interface Props {
    models: object;
    search_text: string;
}
const props = defineProps<Props>()
const search = ref(props.search_text)
watch(search, _.debounce(
    (q) => router.get("/admin/user", {search: q}, {preserveState: true}
    ), 1000));


async function destroy(id: number) {
    if (confirm('از حذف رکورد مطمئنی؟')) {
        router.delete('/admin/user/' + id)
    }
}

async function restore(id: number) {
    if (confirm('از بازیابی رکورد مطمئنی؟')) {
        router.delete('/admin/restore-user/' + id)
    }
}
const toggleStatus = (id: number) => {
    router.put('/admin/user-status/' + id,
        {
            preserveScroll: true,
            preserveState: true,
        }
    )
}

const formatDate = (d) =>
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' })

</script>

<template>
    <Head title="کاربران" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="w-full flex flex-wrap justify-between items-center mb-3 mt-1 pl-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">لیست کاربران</h3>

                    </div>
                    <div class="my-2 p-2 rounded-md">
                        <FlashMessage />
                    </div>
                    <div class="ml-3">
                        <div class="w-full max-w-[150px] min-w-[100px] relative">
                            <div class="relative">
                                <input v-model="search"
                                       class="bg-white w-full pr-9 h-10 pl-3 py-2 bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md"
                                       placeholder="جستجو کاربران"
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
                    <div class="w-full flex flex-wrap">
                        <Link href="/admin/user/create" class="m-1">
                            <button
                                class="me-1 cursor-pointer text-oklch(44.8% 0.119 151.328) bg-green-200 hover:bg-green-300 focus:ring-4 focus:ring-green-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                                <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6 12H18M12 6V18" stroke="#008080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                <span class="ms-1"> افزودن کاربر</span>
                            </button>
                        </Link>
                        <Link href="/admin/user" class="m-1">
                            <button
                                class="me-1 cursor-pointer text-indigo-500 border border-indigo-500 hover:border-indigo-600 focus:ring-4 focus:ring-indigo-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                                <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd" d="M15.6987 3.7536C16.6297 3.29889 17.6656 3.04415 18.5288 3.46151C18.9889 3.68399 19.3072 4.05664 19.4998 4.50023C19.6748 4.90322 19.7461 5.36164 19.7502 5.83576C19.7537 6.23436 19.7098 6.66491 19.6257 7.11782C19.4986 7.80246 19.2783 8.5467 18.982 9.32271C18.951 9.40394 18.9074 9.47667 18.8543 9.53952C19.0395 9.60206 19.2203 9.66638 19.3964 9.73238L19.398 9.73299C19.4447 9.75052 19.4959 9.77 19.5418 9.7877C19.6752 9.83919 19.8057 9.89165 19.9333 9.94504C20.2592 10.0815 20.5657 10.224 20.8503 10.3719C21.1429 10.5239 21.416 10.6833 21.666 10.8499C22.5282 11.4244 23.2707 12.1904 23.3457 13.1462C23.3857 13.6557 23.2245 14.1185 22.9386 14.5086C22.6789 14.8629 22.3191 15.1558 21.9118 15.3985C21.5693 15.6025 21.1754 15.7818 20.742 15.9377C20.0867 16.1733 19.3329 16.3585 18.5134 16.4941C18.1048 16.5617 17.7187 16.2853 17.6511 15.8766C17.5834 15.4679 17.8599 15.0818 18.2685 15.0142C18.8304 14.9212 19.3343 14.8067 19.7754 14.676L19.7805 14.6744C20.3465 14.5064 20.8022 14.3136 21.1439 14.1099C21.4382 13.9346 21.6232 13.766 21.7288 13.6219C21.834 13.4782 21.8583 13.3649 21.8503 13.2636C21.8318 13.0276 21.6033 12.6106 20.8342 12.0982C20.6356 11.9658 20.4102 11.8336 20.1588 11.703L18.8625 11.1341C17.1096 10.478 14.7616 9.97604 12.177 9.79571C11.8562 9.77333 11.54 9.75647 11.2289 9.74492C10.8125 10.2712 10.4013 10.8295 10.002 11.4152C9.25831 12.5061 8.63349 13.5782 8.13654 14.5844C8.45124 14.7636 8.598 15.1499 8.46644 15.4997C8.32367 15.8793 7.90606 16.0752 7.52476 15.9464C7.29856 16.5091 7.12027 17.0399 6.99187 17.5285C6.97835 17.5799 6.96544 17.6307 6.95312 17.6808L6.95091 17.6901C6.75535 18.489 6.71235 19.115 6.78099 19.5518C6.80764 19.7214 6.84758 19.8469 6.89363 19.9404C6.96396 20.0829 7.04854 20.1512 7.12109 20.1871L7.125 20.189C7.16826 20.2099 7.22162 20.2276 7.28863 20.2385C7.41121 20.2586 7.5793 20.2562 7.80056 20.2085C8.20032 20.1224 8.7073 19.9032 9.3015 19.5308C9.43875 19.4448 9.57941 19.3514 9.72315 19.2508C9.96278 19.0829 10.2101 18.8955 10.4636 18.6891L11.639 17.734C11.9604 17.4728 12.4328 17.5217 12.694 17.8431C12.9552 18.1646 12.9064 18.637 12.5849 18.8982L11.4106 19.8524C11.1319 20.0793 10.8556 20.2889 10.5836 20.4794C10.4204 20.5937 10.2584 20.7014 10.098 20.8019C9.42044 21.2265 8.74759 21.5389 8.11647 21.6749C7.7601 21.7516 7.39734 21.7764 7.04586 21.7188C6.84886 21.6865 6.65581 21.6283 6.47203 21.5394L6.45569 21.5314C5.72621 21.1703 5.3902 20.4583 5.28829 19.7107C5.18729 18.9698 5.29402 18.0875 5.54113 17.1472C5.68165 16.6126 5.87203 16.0425 6.10911 15.4467L5.60235 15.2678C5.26583 15.1416 4.94545 15.0088 4.64378 14.8701C4.46272 14.7868 4.28805 14.7012 4.12035 14.6134C3.41201 14.2425 2.80283 13.8191 2.36708 13.3428C2.12103 13.0738 1.91665 12.7731 1.78913 12.4405C1.71765 12.2541 1.67054 12.058 1.65457 11.8545L1.65322 11.8364C1.59703 11.0244 2.04235 10.3751 2.6365 9.90997C3.2253 9.44904 4.04092 9.09617 4.97746 8.83525C6.46501 8.42082 8.38735 8.20311 10.5292 8.22755C11.5426 7.01274 12.588 5.96465 13.5889 5.1496L13.5903 5.1485C13.629 5.11705 13.6717 5.0826 13.7101 5.05194C13.8218 4.96273 13.9329 4.87649 14.0434 4.7933C14.3256 4.58067 14.6033 4.38799 14.8745 4.21681C15.1534 4.04083 15.4288 3.88542 15.6987 3.7536ZM12.4463 8.31129C14.2722 8.44839 16.0104 8.74028 17.5366 9.14469C17.5224 9.02764 17.5357 8.90552 17.5807 8.78771C17.7838 8.25569 17.9391 7.76283 18.0487 7.31596L18.05 7.3108C18.1903 6.73733 18.2537 6.24661 18.2503 5.84877C18.2473 5.5062 18.195 5.26149 18.1239 5.09761C18.053 4.93426 17.9673 4.85617 17.8758 4.81193C17.6627 4.70886 17.1874 4.69585 16.357 5.10143C16.1425 5.20618 15.9146 5.33413 15.6751 5.48531L14.5299 6.31768C13.8603 6.86356 13.1551 7.53546 12.4463 8.31129ZM9.34882 9.73983C7.8005 9.79171 6.44319 9.98403 5.38003 10.2802C5.32879 10.2945 5.27844 10.309 5.22895 10.3236L5.21984 10.3264C4.43134 10.5605 3.86918 10.8391 3.52662 11.1187C3.39365 11.2273 3.30539 11.3251 3.24787 11.412C3.16033 11.5446 3.14406 11.6521 3.14964 11.7328L3.14997 11.7372C3.15373 11.7851 3.16539 11.8401 3.1897 11.9035C3.23417 12.0194 3.3211 12.1633 3.47386 12.3303C3.74987 12.6321 4.1949 12.9593 4.81612 13.2845C4.9596 13.3596 5.1112 13.434 5.27062 13.5073C5.5364 13.6296 5.82308 13.7486 6.12905 13.8633L6.71774 14.0711C7.2636 12.9456 7.9513 11.7604 8.76262 10.5703C8.95504 10.288 9.15065 10.011 9.34882 9.73983Z" fill="#1C274C"></path> <path d="M11.7647 14.2813C11.7509 13.3709 11.7441 12.9157 12.0311 12.75C12.3181 12.5843 12.7089 12.8178 13.4905 13.2849L13.6927 13.4058C13.9148 13.5385 14.0258 13.6048 14.1481 13.6203C14.2705 13.6358 14.3902 13.5986 14.6298 13.5242L14.8479 13.4565C15.6908 13.1947 16.1123 13.0638 16.3656 13.2978C16.619 13.5318 16.5364 13.9757 16.3713 14.8635L16.3286 15.0932C16.2817 15.3455 16.2582 15.4716 16.286 15.5949C16.3139 15.7181 16.3898 15.8245 16.5418 16.0372L16.6801 16.2309C17.2148 16.9795 17.4821 17.3538 17.3517 17.6641C17.2213 17.9745 16.7794 18.0153 15.8958 18.0969L15.6672 18.118C15.4161 18.1412 15.2906 18.1528 15.1854 18.2135C15.0803 18.2742 15.0075 18.3771 14.8619 18.583L14.7293 18.7704C14.2168 19.4948 13.9605 19.8571 13.6266 19.8148C13.2926 19.7726 13.1021 19.354 12.7211 18.5166L12.6226 18.3C12.5143 18.062 12.4602 17.943 12.3674 17.8573C12.2745 17.7716 12.1536 17.7288 11.9116 17.6433L11.6914 17.5655C10.8399 17.2646 10.4142 17.1141 10.3383 16.7777C10.2623 16.4413 10.5864 16.1418 11.2345 15.5426L11.4022 15.3876C11.5864 15.2174 11.6785 15.1322 11.7263 15.0186C11.774 14.9049 11.7721 14.7755 11.7682 14.5168L11.7647 14.2813Z" fill="#1C274C"></path> </g></svg>
                                <span class="ms-1"> همه رکوردها</span>
                            </button>
                        </Link>
                        <Link href="/admin/user?trash=true" class="m-1">
                            <button
                                class="me-1 cursor-pointer text-red-500 border border-red-500 hover:border-red-600 focus:ring-4 focus:ring-red-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                                <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14px" height="14px" viewBox="0 0 488.936 488.936" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M381.16,111.948H107.376c-6.468,0-12.667,2.819-17.171,7.457c-4.504,4.649-6.934,11.014-6.738,17.477l9.323,307.69 c0.39,12.92,10.972,23.312,23.903,23.312h20.136v-21.012c0-24.121,19.368-44.049,43.488-44.049h127.896 c24.131,0,43.893,19.928,43.893,44.049v21.012h19.73c12.933,0,23.52-10.346,23.913-23.268l9.314-307.7 c0.195-6.462-2.234-12.863-6.738-17.513C393.821,114.767,387.634,111.948,381.16,111.948z"></path> <path d="M309.166,435.355H181.271c-6.163,0-11.915,4.383-11.915,11.516v30.969c0,6.672,5.342,11.096,11.915,11.096h127.895 c6.323,0,11.366-4.773,11.366-11.096v-30.969C320.532,440.561,315.489,435.355,309.166,435.355z"></path> <path d="M427.696,27.106C427.696,12.138,415.563,0,400.591,0H88.344C73.372,0,61.239,12.138,61.239,27.106v30.946 c0,14.973,12.133,27.106,27.105,27.106H400.59c14.973,0,27.105-12.133,27.105-27.106L427.696,27.106L427.696,27.106z"></path> </g> </g> </g></svg>
                                <span class="ms-1"> سطل زباله</span>
                            </button>
                        </Link>
                        <a class="m-1" href="/excel/users" target="_blank">
                            <button
                                class="me-1 cursor-pointer text-oklch(44.8% 0.119 151.328) border-2 border-blue-500 hover:border-blue-600 focus:ring-4 focus:ring-blue-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                                <svg width="15px" height="15px" viewBox="0 0 192 192" xmlns="http://www.w3.org/2000/svg" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M56 30c0-1.662 1.338-3 3-3h108c1.662 0 3 1.338 3 3v132c0 1.662-1.338 3-3 3H59c-1.662 0-3-1.338-3-3v-32m0-68V30" style="fill-opacity:.402658;stroke:#000000;stroke-width:12;stroke-linecap:round;paint-order:stroke fill markers"></path><rect width="68" height="68" x="-58.1" y="40.3" rx="3" style="fill:none;fill-opacity:.402658;stroke:#000000;stroke-width:12;stroke-linecap:round;stroke-linejoin:miter;stroke-dasharray:none;stroke-opacity:1;paint-order:stroke fill markers" transform="translate(80.1 21.7)"></rect><path d="M138.79 164.725V27.175M56.175 58.792H170M170 96H90.328M169 133.21H56.175M44.5 82l23 28m0-28-23 28" style="fill:none;stroke:#000000;stroke-width:12;stroke-linecap:round;stroke-linejoin:round;stroke-dasharray:none;stroke-opacity:1"></path></g></svg>
                                <span class="ms-1"> خروجی اکسل</span>
                            </button>
                        </a>
                    </div>
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
                                    نام کاربر
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    موبایل
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    وضعیت
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    سطح کاربر
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    عضویت
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    عملیات
                                </p>
                            </th>
                        </tr>
                        </thead>
                        <tbody v-if="models && models.data">
                        <tr v-for="(item, index) in models.data" :key="index" :class="item.deleted_at ? 'bg-red-100' : ''">
                            <td class="p-4 border-b border-slate-200 py-1">
                                <a :href="`/admin/user/${item.id}`" target="_blank"
                                   class="text-sm text-blue-500">{{ item.id}}</a>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <p class="text-sm text-slate-500">{{ item.name}}</p>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <div class="w-max">
                                    <div v-if="item.mobile_verified"
                                         class="relative grid items-center px-2 py-1 font-sans text-xs font-bold text-green-900 uppercase rounded-md select-none whitespace-nowrap bg-green-500/20">
                                        <span class="">{{ item.mobile }}</span>
                                    </div>
                                    <div v-else
                                         class="relative grid items-center px-2 py-1 font-sans text-xs font-bold uppercase rounded-md select-none whitespace-nowrap bg-amber-500/20 text-amber-900">
                                        <span class="">{{ item.mobile }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1" style="direction: ltr">
                                <button
                                    @click="toggleStatus(item.id)"
                                    class="relative inline-flex h-4 w-8 items-center rounded-full transition-colors duration-300 cursor-pointer"
                                    :class="item.is_active ? 'bg-green-700' : 'bg-gray-300'"
                                >
                                  <span
                                      class="inline-block h-3 w-3 transform rounded-full bg-gray-200 transition-transform duration-300"
                                      :class="item.is_active ? 'translate-x-1' : 'translate-x-5'"
                                  />
                                </button>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <p v-if="item.role_id" class="text-sm text-slate-500">{{ item?.role?.name}}</p>

                            </td>
                            <td class="p-4 border-b border-slate-200 py-1" style="direction: ltr">
                                <p class="text-sm text-slate-500">{{ formatDate(item.created_at) }}</p>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <Link :href="`/admin/user/${item.id}`" target="_blank">
                                    <button
                                        class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                        type="button">
                                     <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                            <svg fill="#000000" width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M21.92,11.6C19.9,6.91,16.1,4,12,4S4.1,6.91,2.08,11.6a1,1,0,0,0,0,.8C4.1,17.09,7.9,20,12,20s7.9-2.91,9.92-7.6A1,1,0,0,0,21.92,11.6ZM12,18c-3.17,0-6.17-2.29-7.9-6C5.83,8.29,8.83,6,12,6s6.17,2.29,7.9,6C18.17,15.71,15.17,18,12,18ZM12,8a4,4,0,1,0,4,4A4,4,0,0,0,12,8Zm0,6a2,2,0,1,1,2-2A2,2,0,0,1,12,14Z"/></svg>
                                     </span>
                                    </button>
                                </Link>


                                <button v-if="item.deleted_at" @click="openModal('delete-modal', index)"
                                        class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                        type="button">
                                  <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
<svg width="25px" height="25px" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg"><path d="M25 38c-5.1 0-9.7-3-11.8-7.6l1.8-.8c1.8 3.9 5.7 6.4 10 6.4 6.1 0 11-4.9 11-11s-4.9-11-11-11c-4.6 0-8.5 2.8-10.1 7.3l-1.9-.7c1.9-5.2 6.6-8.6 12-8.6 7.2 0 13 5.8 13 13s-5.8 13-13 13z"/><path d="M20 22h-8v-8h2v6h6z"/></svg>
                                  </span>
                                </button>
                                <button v-else  @click="openModal('delete-modal', index)"
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


                    <div id="delete-modal" class="fixed hidden z-50 inset-0 bg-gray-200 bg-opacity-10 overflow-y-auto h-full w-full px-4 ">
                        <div class="relative top-40 mx-auto shadow-xl rounded-md bg-white max-w-md">

                            <div class="flex justify-end p-2">
                                <button @click="closeModal('delete-modal')" type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>

                            <div v-if="delete_modal_action" class="p-6 pt-1">
                                <h3 class="text-center text-md text-blue-800">عنوان: {{form?.name}}</h3>

                                <hr />
                                <div  class="mt-5">
                                    <p class="mb-5">آیا از بازیابی رکورد اطمینان دارید؟</p>
                                    <button  @click="restore(update_item_id, update_item_index)"
                                             class="me-2 text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2">
                                        تایید
                                    </button>
                                    <button @click="closeModal('delete-modal')"
                                            class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-cyan-200 border border-gray-200 font-medium inline-flex items-center rounded-lg text-base px-3 py-2.5 text-center"
                                            data-modal-toggle="delete-user-modal">
                                        انصراف
                                    </button>
                                </div>
                            </div>
                            <div v-else class="p-6 pt-1">
                                <h3 class="text-center text-md text-red-800">عنوان: {{form?.name}}</h3>

                                <hr />
                                <div  class="mt-5">

                                    <p class="mb-5">آیا از حذف رکورد اطمینان دارید؟</p>
                                    <button  @click="destroy(update_item_id, update_item_index)"
                                             class="me-2 text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2">
                                        تایید
                                    </button>
                                    <button @click="closeModal('delete-modal')"
                                            class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-cyan-200 border border-gray-200 font-medium inline-flex items-center rounded-lg text-base px-3 py-2.5 text-center"
                                            data-modal-toggle="delete-user-modal">
                                        انصراف
                                    </button>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="my-3" v-if="models">
                        <Pagination :links="models.links" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
