<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import FlashMessage from '@/components/FlashMessage.vue';
import MediaPicker from "@/components/admin/MediaPicker.vue";
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'تنظیمات عمومی سایت',
        href: '/admin/setting/website',
    },
];
interface Props {
    model: object;
}
const props = defineProps<Props>()
const preview = ref(null)
const uploading = ref(false)

onMounted(() => {
    // همه‌ی attributesها رو به object واقعی تبدیل کن
    preview.value = props.model.logo
})

const form = useForm({
    name: props.model.name,
    meta: props.model.meta,
    mobile: props.model.mobile,
    logo: props.model.logo,
    email: props.model.email,
    phone: props.model.phone,
    x: props.model.x,
    youtube: props.model.youtube,
    telegram: props.model.telegram,
    instagram: props.model.instagram,
    whatsapp: props.model.whatsapp,
    ita: props.model.ita,
    rubika: props.model.rubika,
    igap: props.model.igap,
    soroush: props.model.soroush,
    aparat: props.model.aparat,
    address: props.model.address,
    enamad: props.model.enamad,
});

function removeImage(){
    form.logo = props.model.logo
    preview.value = props.model.logo
}
async function updateRecord() {
    form.post('/admin/setting/website')
}


async function handleFileChange(e) {
    const file = e.target.files[0]
    if (!file) return

    uploading.value = true
    const formData = new FormData()
    formData.append('file', file)
    formData.append('folder_name', 'logo')

    try {
        const res = await axios.post('/upload', formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        })

        preview.value = res.data.url // نمایش پیش‌نمایش
        form.logo = res.data.path

    } catch (err) {
        alert('خطا در آپلود تصویر')
    } finally {
        uploading.value = false
    }
}
</script>

<template>
    <Head title="تنظیمات عمومی سایت" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">تنظیمات عمومی سایت</h3>
                    </div>
                    <div class="ml-3">
                        <Link :href="`/admin/setting`">
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
                <div class="relative flex mt-2 flex-col w-full h-full overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">

                    <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 gap-4 mt-3 p-1">
                        <div>
                            <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">نام سایت</label>
                            <input type="text" v-model="form.name" name="product-name" id="product-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="عنوان را وارد نمایید" required="">
                        </div>
                        <div>
                            <label for="stock" class="text-sm font-medium text-gray-900 block mb-2">تلفن</label>
                            <input type="text" v-model="form.phone" name="stock" id="stock" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="" required="">
                        </div>


                        <div>
                            <label for="price" class="text-sm font-medium text-gray-900 block mb-2">ایمیل</label>
                            <input type="email" v-model="form.email" name="price" id="price" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="info@domain.ir" required="">
                        </div>
                        <div>
                            <label for="offer_price" class="text-sm font-medium text-gray-900 block mb-2">آدرس</label>
                            <input type="text" v-model="form.address" name="offer_price" id="offer_price" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="تهران، خیابان انقلاب" required="">
                        </div>
                        <div>
                            <label for="telegram" class="text-sm font-medium text-gray-900 block mb-2">تلگرام</label>
                            <input type="text" v-model="form.telegram" name="telegram" id="telegram" class="shadow-sm bg-gray-50 ltr border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="" required="">
                        </div>
                        <div>
                            <label for="instagram" class="text-sm font-medium text-gray-900 block mb-2">اینستاگرام</label>
                            <input type="text" v-model="form.instagram" name="instagram" id="instagram" class="shadow-sm bg-gray-50 ltr border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="" required="">
                        </div>

                        <div>
                            <label for="whatsapp" class="text-sm font-medium text-gray-900 block mb-2">واتس اپ</label>
                            <input type="text" v-model="form.whatsapp" name="whatsapp" id="stock" class="shadow-sm bg-gray-50 ltr border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="" required="">
                        </div>

                        <div class="col-span-4">
                            <label for="product-meta" class="text-sm font-medium text-gray-900 block mb-2">معرفی کوتاه</label>
                            <input type="text" v-model="form.meta" id="product-meta" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-4" placeholder="توضیحات متا">
                        </div>
                        <div class="col-span-4">
                            <label for="enamad" class="text-sm font-medium text-gray-900 block mb-2">کد اینماد</label>
                            <input type="text" v-model="form.enamad" id="enamad" class="bg-gray-50 border ltr border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-4" placeholder="کد اینماد">
                        </div>

                        <div>
                            <label for="x" class="text-sm font-medium text-gray-900 block mb-2">ایکس (توییتر)</label>
                            <input type="text" v-model="form.x" name="stock" id="x" class="shadow-sm bg-gray-50 border ltr border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="" required="">
                        </div>

                        <div>
                            <label for="youtube" class="text-sm font-medium text-gray-900 block mb-2">بوتیوب</label>
                            <input type="text" v-model="form.youtube" name="youtube" id="youtube" class="shadow-sm bg-gray-50 ltr border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="" required="">
                        </div>

                        <div>
                            <label for="aparat" class="text-sm font-medium text-gray-900 block mb-2">آپارات</label>
                            <input type="text" v-model="form.aparat" name="aparat" id="aparat" class="shadow-sm bg-gray-50 border ltr border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="" required="">
                        </div>

                        <div>
                            <label for="rubika" class="text-sm font-medium text-gray-900 block mb-2">روبیکا</label>
                            <input type="text" v-model="form.rubika" name="rubika" id="rubika" class="shadow-sm bg-gray-50 ltr border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="" required="">
                        </div>

                        <div>
                            <label for="igap" class="text-sm font-medium text-gray-900 block mb-2">آیگپ</label>
                            <input type="text" v-model="form.igap" name="igap" id="igap" class="ltr shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="" required="">
                        </div>

                        <div>
                            <label for="soroush" class="text-sm font-medium text-gray-900 block mb-2">سروش</label>
                            <input type="text" v-model="form.soroush" name="soroush" id="soroush" class="shadow-sm ltr bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="" required="">
                        </div>

                        <div>
                            <label for="ita" class="text-sm font-medium text-gray-900 block mb-2">ایتا</label>
                            <input type="text" v-model="form.ita" name="soroush" id="ita" class="shadow-sm bg-gray-50 ltr border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="" required="">
                        </div>
                        <div>
                            <label for="product_image" class="text-sm font-medium text-gray-900 block mb-2">تصویر لوگو</label>
                            <MediaPicker @select="(url) => form.logo = url" />
                            <div v-if="form.errors.logo" class="text-red-500 text-sm mt-1">
                                {{ form.errors.logo }}
                            </div>
                        </div>
                        <div v-if="form.logo">
                            <img :src="form.logo" class="object-cover border rounded" />

                            <button @click="removeImage" class="py-1 px-2 rounded-md bg-red-500 text-white">حذف</button>

                        </div>
                    </div>

                    <div class="my-5 text-center">
                        <button type="submit" @click="updateRecord"
                                class="bg-gray-500 w-50 text-white rounded-md shadow-md px-4 py-2 cursor-pointer">ذخیره تنظیمات</button>

                    </div>


                </div>
            </div>
        </div>
    </AppLayout>
</template>
