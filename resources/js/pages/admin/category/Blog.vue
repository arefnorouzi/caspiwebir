<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import Pagination from '@/components/Pagination.vue';
import { ref, watch } from 'vue';
import _ from "lodash";
import axios from 'axios';
import { showToast } from '@/composables/useToast.js'
import ValidationErrors from '@/components/validation/ValidationErrors.vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'مدیریت دسته بندیها',
        href: '/admin/blog/category',
    },
];
interface Props {
    models: object;
    categories: object;
    search_text: string;
}
const props = defineProps<Props>()
const search = ref(props.search_text)
const preview = ref(null)
const uploading = ref(false)
const validation_errors = ref(null)
watch(search, _.debounce(
    (q) => router.get("/admin/blog/category", {search: q}, {preserveState: true}
    ), 1000));


const form = useForm({
    name: '',
    meta: null,
    description: null,
    parent_id: null,
    image: null,
    status: false,
    home_page: false,
});

async function destroy(id: number) {
    if (confirm('از حذف رکورد مطمئنی؟')) {
        router.delete('/admin/blog/category/' + id)
    }
}

async function restore(id: number) {
    if (confirm('از بازیابی رکورد مطمئنی؟')) {
        router.delete('/admin/restore-blog-category/' + id)
    }
}


</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">لیست دسته بندیها</h3>

                    </div>
                    <div class="ml-3">
                        <div class="w-full max-w-sm min-w-[200px] relative">
                            <div class="relative">
                                <input v-model="search"
                                       class="bg-white w-full pr-11 h-10 pl-3 py-2 bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md"
                                       placeholder="جستجو براساس نام دسته بندی"
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
                <button @click=""
                        class="me-1 cursor-pointer text-oklch(44.8% 0.119 151.328) bg-green-200 hover:bg-green-300 focus:ring-4 focus:ring-green-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                    <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6 12H18M12 6V18" stroke="#008080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    <span class="ms-1"> افزودن آیتم</span>
                </button>
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
                                    نام دسته بندی
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    تصویر
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    وضعیت
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    دسته والد
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
                                <p class="block font-semibold text-sm text-slate-800">{{ item.id }}</p>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <p class="text-sm text-slate-500">{{ item.name }}</p>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <div v-if="item.image" class="mt-2">
                                    <img :src="item.image" class="w-15 h-15 object-cover border rounded object-fill" />
                                </div>
                            </td>


                            <td class="p-4 border-b border-slate-200 py-1">
                                <div class="w-max">
                                    <div v-if="item.status"
                                         class="relative grid items-center px-2 py-1 font-sans text-xs font-bold text-green-900 uppercase rounded-md select-none whitespace-nowrap bg-green-500/20">
                                        <span class="">فعال</span>
                                    </div>
                                    <div v-else
                                         class="relative grid items-center px-2 py-1 font-sans text-xs font-bold uppercase rounded-md select-none whitespace-nowrap bg-amber-500/20 text-amber-900">
                                        <span class="">غیرفعال</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <p class="text-sm text-slate-500">{{ item?.parent?.name }}</p>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <button  @click="openModal('detail-modal', index)"
                                         class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                         type="button">
                                  <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
     class="w-4 h-4">
                                      <path
                                          d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z">
                                      </path>
                                    </svg>
                                  </span>
                                </button>


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
                    <div id="create-modal" class="fixed hidden z-50 inset-0 bg-gray-200 bg-opacity-10 overflow-y-auto h-full w-full px-4 ">
                        <div class="relative top-40 mx-auto shadow-xl rounded-md bg-white max-w-md">

                            <div class="flex justify-end p-2">
                                <button @click="closeModal('create-modal')" type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>

                            <div class="p-6 pt-1">
                                <h3 class="text-center text-xl pb-2">افزودن دسته بندی جدید</h3>
                                <hr />
                                <div class="flex flex-row mt-3">
                                    <div class="px-2">

                                        <div class="grid grid-cols-3 gap-4 mt-3">
                                            <div class="col-span-3">
                                                <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">نام دسته بندی</label>
                                                <input type="text" v-model="form.name" name="product-name" id="product-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                                       placeholder="عنوان را وارد نمایید" required="">
                                            </div>
                                            <div>
                                                <label for="status-radio" class="text-sm font-medium text-gray-900 block mb-2">وضعیت</label>
                                                <select v-model="form.status"
                                                        class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                                >
                                                    <option :value="false">غیرفعال</option>
                                                    <option :value="true">فعال</option>
                                                </select>
                                            </div>
                                            <div class="col-span-2">
                                                <label for="home-page-radio" class="text-sm font-medium text-gray-900 block mb-2">اسلایدر محصولات در صفحه اصلی</label>
                                                <select v-model="form.home_page"
                                                        class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                                >
                                                    <option :value="false">عدم نمایش</option>
                                                    <option :value="true">نمایش</option>
                                                </select>
                                            </div>
                                            <div class="col-span-3">
                                                <label for="stock" class="text-sm font-medium text-gray-900 block mb-2">انتخاب دسته والد</label>

                                                <select v-model="form.parent_id"
                                                        class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                                >
                                                    <option value="">بدون والد (دسته اصلی)</option>
                                                    <option v-for="(cat, index) in categories"
                                                            :key="index" :value="cat.id"
                                                    >{{cat.name}}</option>
                                                </select>
                                            </div>


                                            <div class="col-span-3">
                                                <label for="price" class="text-sm font-medium text-gray-900 block mb-2">توضیحات متا</label>
                                                <textarea type="text" maxlength="250" v-model="form.meta" name="price" id="price" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                                          placeholder="معرفی دسته بندی"></textarea>
                                            </div>


                                            <div class="col-span-2">
                                                <label for="offer_end_date" class="text-sm font-medium text-gray-900 block mb-2">عکس دسته بندی</label>
                                                <input type="file" @change="handleFileChange" name="image" id="product_image" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">

                                                <div v-if="uploading">در حال آپلود...</div>

                                            </div>
                                            <div>
                                                <div v-if="preview" class="mt-2">
                                                    <img :src="preview" class="w-20 h-20 object-cover border rounded" />
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <div class="my-5 text-center">
                                    <button  @click="storeRecord()"
                                             class="me-2 cursor-pointer bg-green-200 hover:bg-green-300 focus:ring-4 focus:ring-green-300 rounded-md inline-flex items-center px-3 py-2.5 text-center mr-2">
                                        <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M18.1716 1C18.702 1 19.2107 1.21071 19.5858 1.58579L22.4142 4.41421C22.7893 4.78929 23 5.29799 23 5.82843V20C23 21.6569 21.6569 23 20 23H4C2.34315 23 1 21.6569 1 20V4C1 2.34315 2.34315 1 4 1H18.1716ZM4 3C3.44772 3 3 3.44772 3 4V20C3 20.5523 3.44772 21 4 21L5 21L5 15C5 13.3431 6.34315 12 8 12L16 12C17.6569 12 19 13.3431 19 15V21H20C20.5523 21 21 20.5523 21 20V6.82843C21 6.29799 20.7893 5.78929 20.4142 5.41421L18.5858 3.58579C18.2107 3.21071 17.702 3 17.1716 3H17V5C17 6.65685 15.6569 8 14 8H10C8.34315 8 7 6.65685 7 5V3H4ZM17 21V15C17 14.4477 16.5523 14 16 14L8 14C7.44772 14 7 14.4477 7 15L7 21L17 21ZM9 3H15V5C15 5.55228 14.5523 6 14 6H10C9.44772 6 9 5.55228 9 5V3Z" fill="#008040"></path> </g></svg>
                                        <span class="ms-2"> ثبت اطلاعات</span>

                                    </button>
                                    <button @click="closeModal('create-modal')"
                                            class="cursor-pointer text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-cyan-200 border border-gray-200 inline-flex items-center rounded-md px-3 py-2.5 text-center"
                                            data-modal-toggle="delete-user-modal">
                                        انصراف
                                    </button>
                                </div>


                            </div>

                        </div>
                    </div>

                    <div id="detail-modal" class="fixed hidden z-50 inset-0 bg-gray-200 bg-opacity-10 overflow-y-auto h-full w-full px-4 ">
                        <div class="relative top-40 mx-auto shadow-xl rounded-md bg-white max-w-md">

                            <div class="flex justify-end p-2">
                                <button @click="closeModal('detail-modal')" type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>

                            <div class="p-6 pt-1">
                                <h3 class="text-center">ویرایش دسته: {{form.name}}</h3>
                                <hr />
                                <div class="w-full">
                                    <ValidationErrors :errors="validation_errors" />
                                </div>
                                <div class="flex flex-row mt-3">
                                    <div class="px-2">

                                        <div class="grid grid-cols-3 gap-4 mt-3">
                                            <div class="col-span-3">
                                                <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">نام دسته بندی</label>
                                                <input type="text" v-model="form.name" name="product-name" id="product-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                                       placeholder="عنوان را وارد نمایید" required="">
                                            </div>
                                            <div>
                                                <label for="status-radio" class="text-sm font-medium text-gray-900 block mb-2">وضعیت</label>
                                                <select v-model="form.status"
                                                        class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                                >
                                                    <option :value="false">غیرفعال</option>
                                                    <option :value="true">فعال</option>
                                                </select>
                                            </div>
                                            <div class="col-span-2">
                                                <label for="home-page-radio" class="text-sm font-medium text-gray-900 block mb-2">اسلایدر محصولات در صفحه اصلی</label>
                                                <select v-model="form.home_page"
                                                        class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                                >
                                                    <option :value="false">عدم نمایش</option>
                                                    <option :value="true">نمایش</option>
                                                </select>
                                            </div>
                                            <div class="col-span-3">
                                                <label for="stock" class="text-sm font-medium text-gray-900 block mb-2">انتخاب دسته والد</label>

                                                <select v-model="form.parent_id"
                                                        class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                                >
                                                    <option value="">بدون والد (دسته اصلی)</option>
                                                    <option v-for="(cat, index) in categories"
                                                            :key="index" :value="cat.id"
                                                    >{{cat.name}}</option>
                                                </select>
                                            </div>


                                            <div class="col-span-3">
                                                <label for="price" class="text-sm font-medium text-gray-900 block mb-2">توضیحات متا</label>
                                                <textarea type="text" maxlength="250" v-model="form.meta" name="price" id="price" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                                          placeholder="معرفی دسته بندی"></textarea>
                                            </div>


                                            <div class="col-span-2">
                                                <label for="offer_end_date" class="text-sm font-medium text-gray-900 block mb-2">تصویر دسته بندی</label>
                                                <input type="file" @change="handleFileChange" name="image" id="product_image" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">

                                                <div v-if="uploading">در حال آپلود...</div>

                                            </div>
                                            <div>
                                                <div v-if="preview" class="mt-2">
                                                    <img :src="preview" class="w-20 h-20 object-cover border rounded" />
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <div class="my-5 text-center">
                                    <button  @click="updateRecord()"
                                             class="me-2 cursor-pointer bg-green-200 hover:bg-green-300 focus:ring-4 focus:ring-green-300 font-medium rounded-md inline-flex items-center px-3 py-2.5 text-center mr-2">
                                        بروزرسانی
                                    </button>
                                    <button @click="closeModal('detail-modal')"
                                            class="cursor-pointer text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-cyan-200 border border-gray-200 font-medium inline-flex items-center rounded-md px-3 py-2.5 text-center"
                                            data-modal-toggle="delete-user-modal">
                                        انصراف
                                    </button>
                                </div>


                            </div>

                        </div>
                    </div>

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
