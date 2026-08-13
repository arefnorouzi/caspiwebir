<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import FlashMessage from '@/components/FlashMessage.vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'تنظیمات فروشگاه',
        href: '/admin/setting/shop',
    },
];
interface Props {
    model: object;
}
const props = defineProps<Props>()

const form = useForm({
    name: props.model.name,
    meta: props.model.meta,
    mobile: props.model.mobile,
    email: props.model.email,
    phone: props.model.phone,
    address: props.model.address,
    zip_code: props.model.zip_code,
    order_expire: props.model.order_expire,
    tax: props.model.tax,
    sell_status: props.model.sell_status,
    stock_alert: props.model.stock_alert
});

async function updateRecord() {
    form.post('/admin/setting/shop')
}

</script>

<template>
    <Head title="تنظیمات فروشگاه" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">تنظیمات فروشگاه</h3>
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
                <div class="flex mt-2 flex-col w-full text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">

                    <div class="grid grid-cols-1 lg:grid-cols-3 sm:grid-cols-2 gap-4 mt-3 p-2">
                        <div>
                            <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">نام فروشگاه</label>
                            <input type="text" v-model="form.name" name="product-name" id="product-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="عنوان را وارد نمایید" required="">
                        </div>
                        <div>
                            <label for="stock" class="text-sm font-medium text-gray-900 block mb-2">تلفن</label>
                            <input type="text" v-model="form.phone" name="stock" id="stock" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="" required="">
                        </div>
                        <div>
                            <label for="stock" class="text-sm font-medium text-gray-900 block mb-2">موبایل (دریافت کننده پیامک مدیر)</label>
                            <input type="text" v-model="form.mobile" name="stock" id="stock" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="" required="">
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
                            <label for="order_expire" class="text-sm font-medium text-gray-900 block mb-2">انقضای فاکتور (ساعت)</label>
                            <input type="text" v-model="form.order_expire" name="telegram" id="order_expire" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="" required="">
                        </div>
                        <div>
                            <label for="instagram" class="text-sm font-medium text-gray-900 block mb-2">کد پستی</label>
                            <input type="text" v-model="form.zip_code" name="zip_code" id="zip_code" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="" required="">
                        </div>

                        <div>
                            <label for="whatsapp" class="text-sm font-medium text-gray-900 block mb-2">نرخ مالیات (0-100)</label>
                            <input type="number" min="0" max="100" v-model="form.tax" name="whatsapp" id="stock" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="" required="">
                        </div>

                        <div>
                            <label for="brand" class="text-sm font-medium text-gray-900 block mb-2">فروش آنلاین</label>
                            <select v-model="form.sell_status"
                                    class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            >
                                <option value="0">غیرفعال (نمایش محصولات بدون امکان خرید)</option>
                                <option value="1">فعال (امکان خرید آنلاین)</option>
                            </select>
                        </div>
                        <div>
                            <label for="brand" class="text-sm font-medium text-gray-900 block mb-2">کمبود موجودی انبار</label>
                            <input type="number" min="1" max="10" v-model="form.stock_alert" name="whatsapp" id="stock" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="" required="">

                        </div>

                        <div class="my-5 text-center">
                            <button type="submit" @click="updateRecord"
                                    class="bg-gray-500 w-50 text-white px-4 py-2 rounded-md shadow-md cursor-pointer">ذخیره تنظیمات</button>

                        </div>


                    </div>



                </div>
            </div>
        </div>
    </AppLayout>
</template>
