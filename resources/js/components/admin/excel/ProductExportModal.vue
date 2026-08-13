<script setup>
import { useForm } from '@inertiajs/vue3'
import {computed} from "vue";

const props = defineProps({
    brands: Object,
    categories: Object
})


const export_form = useForm({
    category: null,
    brand_id: null,
    status: null,
    pinned: null
})
const emit = defineEmits(['close'])
const exportUrl = computed(() => {
    const params = new URLSearchParams()

    if (export_form.brand_id) params.append('brand_id', export_form.brand_id)
    if (export_form.status !== null) params.append('status', export_form.status)
    if (export_form.category) params.append('category', export_form.category)

    return '/excel/products' + '?' + params.toString()
})
</script>

<template>
    <div class="fixed inset-0 z-50 flex items-center justify-center">
        <!-- Backdrop -->
        <div
            class="absolute inset-0 bg-black/40"
            @click="emit('close')"
        ></div>

        <!-- Modal -->
        <div
            class="relative w-full max-w-lg bg-white rounded-lg shadow-lg p-6"
        >
            <h2 class="text-lg font-semibold mb-4">
                خروجی اکسل
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-2 mb-4">
                <div>
                    <select v-model="export_form.category"
                            class="bg-white m-1 p-2 text-slate-700 text-sm w-full border border-slate-200 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md">
                        <option :value="null">انتخاب دسته بندی</option>
                        <option
                            v-for="category in categories" :key="category.id"
                            :value="category.id">{{ category.name }}</option>
                    </select>
                </div>
                <div>
                    <select v-model="export_form.brand_id"
                            class="bg-white m-1 p-2 text-slate-700 w-full text-sm border border-slate-200 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md">
                        <option :value="null">انتخاب برند</option>
                        <option
                            v-for="brand in brands" :key="brand.id"
                            :value="brand.id">{{ brand.name }}</option>
                    </select>
                </div>
                <div>
                    <select v-model="export_form.status"
                            class="bg-white m-1 p-2 text-slate-700 w-full text-sm border border-slate-200 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md">
                        <option :value="null">وضعیت محصول</option>
                        <option :value="1">منتشر شده ها</option>
                        <option :value="0">پیشنویس ها</option>
                    </select>
                </div>
                <div>
                    <select v-model="export_form.pinned"
                            class="bg-white m-1 p-2 text-slate-700 w-full text-sm border border-slate-200 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md">
                        <option :value="null">نوع محصول</option>
                        <option :value="1">محصولات فروش ویژه</option>
                        <option :value="0">محضولات عادی</option>
                    </select>
                </div>

            </div>

            <div class="flex justify-end gap-2">
                <button
                    @click="emit('close')"
                    class="px-4 py-2 rounded bg-gray-100 text-sm cursor-pointer"
                >
                    انصراف
                </button>

                <a :href="exportUrl" target="_blank" class="m-1">
                    <button
                        class="me-1 cursor-pointer text-oklch(44.8% 0.119 151.328) border-2 border-blue-500 hover:border-green-300 focus:ring-4 focus:ring-green-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                        <svg width="15px" height="15px" viewBox="0 0 192 192" xmlns="http://www.w3.org/2000/svg" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M56 30c0-1.662 1.338-3 3-3h108c1.662 0 3 1.338 3 3v132c0 1.662-1.338 3-3 3H59c-1.662 0-3-1.338-3-3v-32m0-68V30" style="fill-opacity:.402658;stroke:#000000;stroke-width:12;stroke-linecap:round;paint-order:stroke fill markers"></path><rect width="68" height="68" x="-58.1" y="40.3" rx="3" style="fill:none;fill-opacity:.402658;stroke:#000000;stroke-width:12;stroke-linecap:round;stroke-linejoin:miter;stroke-dasharray:none;stroke-opacity:1;paint-order:stroke fill markers" transform="translate(80.1 21.7)"></rect><path d="M138.79 164.725V27.175M56.175 58.792H170M170 96H90.328M169 133.21H56.175M44.5 82l23 28m0-28-23 28" style="fill:none;stroke:#000000;stroke-width:12;stroke-linecap:round;stroke-linejoin:round;stroke-dasharray:none;stroke-opacity:1"></path></g></svg>
                        <span class="ms-1"> خروجی اکسل</span>
                    </button>
                </a>
            </div>
        </div>
    </div>
</template>
