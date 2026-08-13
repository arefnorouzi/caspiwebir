<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { ref } from 'vue'
import axios from 'axios';
import FlashMessage from "@/components/FlashMessage.vue";
import InputComponent from "@/components/form/InputComponent.vue";
import MediaPicker from "@/components/admin/MediaPicker.vue";
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'افزودن بنر',
        href: '/admin/banner',
    },
];
interface Props {
    page_sections: object;
}
const props = defineProps<Props>()
const form = useForm({
    name: null,
    url: null,
    position: 1,
    image: null,
    status: 0,
    new_tab: 1,
    size: 3,
    rank: 10,
    page_section_id: null

});
async function submit() {
    form.post("/admin/banner")
}
</script>
<template>
    <Head title="ویرایش بنر" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">افزودن بنر</h3>
                    </div>
                    <div class="ml-3">
                        <Link href="/admin/banner">
                            <button
                                class="me-1 cursor-pointer text-black bg-white border border-gray-200 hover:border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-md inline-flex items-center px-3 py-2.5 text-center mr-2">
                                <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20 10L20.7071 10.7071L21.4142 10L20.7071 9.29289L20 10ZM3 18C3 18.5523 3.44772 19 4 19C4.55229 19 5 18.5523 5 18L3 18ZM15.7071 15.7071L20.7071 10.7071L19.2929 9.29289L14.2929 14.2929L15.7071 15.7071ZM20.7071 9.29289L15.7071 4.29289L14.2929 5.70711L19.2929 10.7071L20.7071 9.29289ZM20 9L10 9L10 11L20 11L20 9ZM3 16L3 18L5 18L5 16L3 16ZM10 9C6.13401 9 3 12.134 3 16L5 16C5 13.2386 7.23858 11 10 11L10 9Z" fill="#33363F"></path> </g></svg>

                                <span class="ms-1">بازگشت</span>
                            </button>
                        </Link>
                    </div>
                </div>
                <div class="my-2 p-2 rounded-md">
                    <FlashMessage />
                </div>
                <div class="relative flex flex-col w-full h-full overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
                    <form @submit.prevent="submit" class="space-y-4 p-2">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-3">
                            <div>
                                <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">عنوان</label>
                                <input type="text" v-model="form.name" name="product-name" id="product-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                       placeholder="عنوان را وارد نمایید" required="">
                                <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">
                                    {{ form.errors.name }}
                                </div>
                            </div>
                            <div>
                                <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">لینک</label>
                                <input type="text" v-model="form.link" name="product-name" id="product-name" style="direction: ltr" class="shadow-sm bg-gray-50 text-left border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                       placeholder="/shop">
                                <div v-if="form.errors.link" class="text-red-500 text-sm mt-1">
                                    {{ form.errors.link }}
                                </div>
                            </div>

                            <div>
                                <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">جایگاه در صفحه</label>
                                <select v-model="form.page_section_id"
                                        class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                >
                                    <option value="">بدون جایگاه</option>
                                    <option v-for="(page_section, p) in page_sections"
                                            :key="p" :value="page_section.id"
                                    >{{page_section.name}}</option>
                                </select>
                                <div v-if="form.errors.page_section_id" class="text-red-500 text-sm mt-1">
                                    {{ form.errors.page_section_id }}
                                </div>
                            </div>
                            <div>
                                <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">جایگاه در بخش</label>
                                <select v-model="form.position"
                                        class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                >
                                    <option :value="1">ابتدا</option>
                                    <option :value="2">میانه</option>
                                    <option :value="3">انتها</option>
                                </select>
                                <div v-if="form.errors.position" class="text-red-500 text-sm mt-1">
                                    {{ form.errors.position }}
                                </div>
                            </div>
                            <div>
                                <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">نحوه نمایش در صفحه</label>
                                <select v-model="form.size"
                                        class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                >
                                    <option :value="1">تمام عرض</option>
                                    <option :value="2">1/2</option>
                                    <option :value="3">1/3</option>
                                    <option :value="4">1/4</option>
                                    <option :value="4">1/6</option>
                                </select>
                                <div v-if="form.errors.position" class="text-red-500 text-sm mt-1">
                                    {{ form.errors.position }}
                                </div>
                            </div>
                            <div>
                                <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">ترتیب</label>
                                <select v-model="form.rank"
                                        class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                >
                                    <option :value="1">1</option>
                                    <option :value="2">2</option>
                                    <option :value="3">3</option>
                                    <option :value="4">4</option>
                                    <option :value="5">5</option>
                                    <option :value="6">6</option>
                                    <option :value="7">7</option>
                                    <option :value="8">8</option>
                                    <option :value="9">9</option>
                                    <option :value="10">10</option>
                                </select>
                                <div v-if="form.errors.rank" class="text-red-500 text-sm mt-1">
                                    {{ form.errors.rank }}
                                </div>
                            </div>

                            <div>
                                <label for="status-radio" class="text-sm font-medium text-gray-900 block mb-2">وضعیت</label>
                                <select v-model="form.status"
                                        class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                >
                                    <option :value="0">غیرفعال</option>
                                    <option :value="1">فعال</option>
                                </select>
                                <div v-if="form.errors.status" class="text-red-500 text-sm mt-1">
                                    {{ form.errors.status }}
                                </div>
                            </div>


                            <div>
                                <label for="product_image" class="text-sm font-medium text-gray-900 block mb-2">تصویر محصول</label>
                                <MediaPicker @select="(url) => form.image = url" />
                                <div v-if="form.errors.image" class="text-red-500 text-sm mt-1">
                                    {{ form.errors.image }}
                                </div>
                            </div>
                            <div>
                                <InputComponent v-model="form.image"
                                                label="آدرس تصویر"
                                                :value="form.image"
                                                id="image-url"
                                                placeholder="image-url"
                                                :input_error="form?.errors?.image"
                                                css_class="ltr"
                                />
                            </div>

                            <div>
                                <div v-if="form.image" class="mt-2">
                                    <img :src="form.image" class="w-20 h-20 object-fill border rounded" />
                                </div>
                            </div>

                        </div>

                        <button type="submit"
                                class="me-1 cursor-pointer text-oklch(44.8% 0.119 151.328) bg-green-200 hover:bg-green-300 focus:ring-4 focus:ring-green-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                            <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M18.1716 1C18.702 1 19.2107 1.21071 19.5858 1.58579L22.4142 4.41421C22.7893 4.78929 23 5.29799 23 5.82843V20C23 21.6569 21.6569 23 20 23H4C2.34315 23 1 21.6569 1 20V4C1 2.34315 2.34315 1 4 1H18.1716ZM4 3C3.44772 3 3 3.44772 3 4V20C3 20.5523 3.44772 21 4 21L5 21L5 15C5 13.3431 6.34315 12 8 12L16 12C17.6569 12 19 13.3431 19 15V21H20C20.5523 21 21 20.5523 21 20V6.82843C21 6.29799 20.7893 5.78929 20.4142 5.41421L18.5858 3.58579C18.2107 3.21071 17.702 3 17.1716 3H17V5C17 6.65685 15.6569 8 14 8H10C8.34315 8 7 6.65685 7 5V3H4ZM17 21V15C17 14.4477 16.5523 14 16 14L8 14C7.44772 14 7 14.4477 7 15L7 21L17 21ZM9 3H15V5C15 5.55228 14.5523 6 14 6H10C9.44772 6 9 5.55228 9 5V3Z" fill="#008040"></path> </g></svg>
                            <span class="ms-1">ذخیره اطلاعات</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>

</template>


