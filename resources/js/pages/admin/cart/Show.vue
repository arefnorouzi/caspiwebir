<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import {Head, Link} from '@inertiajs/vue3';
import ValidationErrors from "@/components/validation/ValidationErrors.vue";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'جزئیات سبد کاربر',
        href: '/admin/show',
    },
];

interface Props {
    cart: object;
}
const props = defineProps<Props>()


const formatDate = (d) =>
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' })

</script>

<template>
    <Head title="جزئیات سبد" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">جزئیات سبد خرید</h3>
                    </div>
                    <div class="ml-3">
                        <Link href="/admin/cart">
                            <button
                                class="me-1 cursor-pointer text-black bg-white border border-gray-200 hover:border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-md inline-flex items-center px-3 py-2.5 text-center mr-2">
                                <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20 10L20.7071 10.7071L21.4142 10L20.7071 9.29289L20 10ZM3 18C3 18.5523 3.44772 19 4 19C4.55229 19 5 18.5523 5 18L3 18ZM15.7071 15.7071L20.7071 10.7071L19.2929 9.29289L14.2929 14.2929L15.7071 15.7071ZM20.7071 9.29289L15.7071 4.29289L14.2929 5.70711L19.2929 10.7071L20.7071 9.29289ZM20 9L10 9L10 11L20 11L20 9ZM3 16L3 18L5 18L5 16L3 16ZM10 9C6.13401 9 3 12.134 3 16L5 16C5 13.2386 7.23858 11 10 11L10 9Z" fill="#33363F"></path> </g></svg>

                                <span class="ms-1">بازگشت</span>
                            </button>
                        </Link>
                    </div>
                </div>

                <div class="relative flex flex-col w-full h-full overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
                    <div class="p-2 mb-3 w-full">
                        <p class="bg-orange-200 text-black p-2 rounded-md mb-2">قیمت ها براساس تومان میباشد</p>
                        <table class="w-full text-right table-auto min-w-max mb-5 overflow-x-scroll">
                            <thead>
                            <tr>
                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-xs font-normal leading-none text-slate-500">
                                        ردیف
                                    </p>
                                </th>


                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-xs font-normal leading-none text-slate-500">
                                        محصول
                                    </p>
                                </th>

                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-xs font-normal leading-none text-slate-500">
                                        تعداد
                                    </p>
                                </th>
                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-xs font-normal leading-none text-slate-500">
                                        قیمت واحد
                                    </p>
                                </th>
                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-xs font-normal leading-none text-slate-500">
                                        جمع واحد
                                    </p>
                                </th>
                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-xs font-normal leading-none text-slate-500">
                                        تخفیف
                                    </p>
                                </th>
                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-xs font-normal leading-none text-slate-500">
                                        مجموع تخفیف
                                    </p>
                                </th>
                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-xs font-normal leading-none text-slate-500">
                                        جمع
                                    </p>
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, i) in cart?.items" :key="item.id">
                                <td class="p-2 border-b border-slate-200">
                                    <p class="block font-semibold text-xs text-blue-800">{{ i + 1 }}</p>

                                </td>

                                <td class="p-2 border-b border-slate-200">
                                    <p v-if="item.product_id" class="text-xs">
                                        <a :href="`/shop/product/${item?.product?.slug}`" target="_blank">
                                            {{ item?.name }}
                                        </a>
                                    </p>
                                </td>

                                <td class="p-2 border-b border-slate-200">
                                    <p class="text-xs text-slate-500">{{ Number(item.qty).toLocaleString()}}</p>
                                </td>
                                <td class="p-2 border-b border-slate-200">
                                    <p class="text-xs text-slate-500">{{ Number(item.item_price).toLocaleString()}}</p>
                                </td>
                                <td class="p-2 border-b border-slate-200">
                                    <p class="text-xs text-slate-500">{{ Number(item.item_price * item.qty).toLocaleString()}}</p>
                                </td>
                                <td class="p-2 border-b border-slate-200">
                                    <p class="text-xs text-slate-500">{{ Number(Math.max(0, item.item_price - item.unit_price)).toLocaleString()}}</p>
                                </td>
                                <td class="p-2 border-b border-slate-200">
                                    <p class="text-xs text-slate-500">{{ Number(Math.max(0, item.item_price - item.unit_price) * item.qty).toLocaleString()}}</p>
                                </td>
                                <td class="p-2 border-b border-slate-200">
                                    <p class="text-xs text-slate-500">{{ Number(item.unit_price * item.qty).toLocaleString()}}</p>
                                </td>
                            </tr>

                            </tbody>
                        </table>

                        <hr class="my-2">

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-1 mt-3">
                            <div class="mb-1 border border-gray-200 p-2">
                                <h3 class="text-xs text-gray-800">مشتری: <a v-if="cart?.user" :href="`/admin/user/${cart?.user_id}`">{{cart?.user?.name}}</a> </h3>
                            </div>
                            <div class="mb-1 border border-gray-200 p-2">
                                <h3 class="text-xs text-gray-800">شماره تماس: <span v-if="cart?.user">{{cart?.user?.mobile}}</span> </h3>
                            </div>

                            <div class="mb-1 border border-gray-200 p-2">
                                <h3 class="text-xs text-gray-800">جمع آیتم ها: {{Number(cart.sub_total).toLocaleString()}} تومان</h3>
                            </div>

                            <div class="mb-1 border border-gray-200 p-2">
                                <h3 class="text-xs text-rose-800">تخفیف: {{Number(cart.discount).toLocaleString()}} تومان</h3>
                            </div>

                            <div class="mb-1 border border-gray-200 p-2">
                                <h3 class="text-xs text-green-800">مبلغ قابل پرداخت: {{Number(cart.total_amount).toLocaleString()}} تومان</h3>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>


    </AppLayout>
</template>

<style scoped>

</style>
