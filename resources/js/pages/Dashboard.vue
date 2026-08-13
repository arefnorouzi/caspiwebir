<script setup lang="ts">
import AppLayout from '@/layouts/DashboardLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'حساب کاربری',
        href: '/dashboard',
    },
];

interface Props {
    invoices: object;
    user: object;
    tickets: object;
    notifications: object;

}
const props = defineProps<Props>()
const formatDate = (d) =>
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' })

const validation_errors = ref(null)
const validation_message = ref(null)


</script>

<template>
    <Head title="حساب کاربری" />

    <AppLayout :breadcrumbs="breadcrumbs">


        <div class="flex flex-wrap mt-2 p-2">

            <div class="w-1/1 p-1 mb-5">
                <div
                    class="grid auto-rows-min gap-3 md:grid-cols-2 sm:grid-cols-1 lg:grid-cols-2 mb-3"
                >
                    <div v-if="!user.authenticated"
                        class="card border border-gray-300 rounded-md mb-2 shadow-md" style="align-content: center">
                        <div class="card-body text-center py-5 px-3">
                            <Link href="/dashboard/profile">
                                <p class="mb-2">احراز هویت حساب کاربری شما تکمیل نشده است.</p>
                                <button class="p-2 rounded-md bg-orange-300 text-black cursor-pointer">تکمیل پروفایل</button>
                            </Link>
                        </div>
                    </div>
                    <div v-else
                         class="card border border-gray-300 rounded-md mb-2 shadow-md" style="align-content: center">
                        <div class="card-body text-center py-5 px-3">
                            <Link href="/dashboard/profile">
                                <p class="mb-2">احراز هویت حساب کاربری شما توسط کارشناسان ما تایید شده است.</p>
                                <button class="p-2 rounded-md bg-indigo-600 text-gray-100 cursor-pointer">مشاهده پروفایل</button>
                            </Link>
                        </div>
                    </div>
                    <div
                        class="card border border-gray-300 rounded-md mb-2 shadow-md" style="align-content: center">
                        <div class="card-body text-center py-5 px-3">
                            <a href="/" target="_blank" class="m-1">
                                <button class="p-2 rounded-md bg-teal-700 text-gray-100 cursor-pointer">مشاهده سایت</button>
                            </a>
                            <a href="/shop" target="_blank" class="m-1">
                                <button class="p-2 rounded-md bg-rose-700 text-gray-100 cursor-pointer">مشاهده فروشگاه</button>
                            </a>
                            <a href="/cart" target="_blank" class="m-1">
                                <button class="p-2 rounded-md bg-indigo-700 text-gray-100 cursor-pointer">سبد خرید</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:w-2/3 md:w-2/3 sm:w-1/1 w-1/1 p-1">


                <div
                    class="relative mb-5 min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-2"
                >
                    <h4>فاکتورهای اخیر</h4>
                    <table class="w-full text-right table-auto min-w-max">
                        <thead class="text-right">
                        <tr>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    #
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
                                    مبلغ(تومان)
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    تاریخ
                                </p>
                            </th>

                        </tr>
                        </thead>
                        <tbody v-if="invoices">
                        <tr v-for="(item, index) in invoices.data" :key="index">

                            <td class="p-4 border-b border-slate-200 py-1">
                                <a :href="`/checkout/${item.uuid}`" target="_blank">
                                    <p class="block font-semibold text-sm text-blue-800">{{ item.id }}</p>
                                </a>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-2">
                                <div class="w-max">
                                    <div
                                        :class="`relative grid items-center px-2 py-1 font-sans text-xs font-bold uppercase rounded-md select-none whitespace-nowrap ${item.invoice_type.css_class}`">
                                        <span class="">{{ item?.invoice_type?.name }}</span>
                                    </div>

                                </div>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-2">
                                <div class="w-max">
                                    <div
                                        :class="`relative grid items-center px-2 py-1 font-sans text-xs font-bold uppercase rounded-md select-none whitespace-nowrap ${item.status.css_class}`">
                                        <span class="">{{ item?.status?.name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-2">
                                <p class="text-sm text-slate-500">{{ Number(item.amount).toLocaleString()}}</p>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-2">
                                <p class="text-sm text-slate-500">{{ formatDate(item.created_at) }}</p>
                            </td>

                        </tr>
                        </tbody>
                    </table>


                </div>

            </div>
            <div class="md:w-1/3 sm:w-1/1 w-1/1 p-1">
                <div class="card border-1 border-indigo-500 rounded-md mb-5 shadow">
                    <div class="card-body px-2 py-5">
                        <div class="my-5 text-center">
                            <img src="/icons/support.svg" class="mx-auto" style="width: 50px;">
                        </div>
                        <div class="mb-4 text-center">
                            <h3 class="text-xl font-bold">مشاوره رایگان</h3>
                        </div>
                        <div class="mb-2 rounded-md px-2 py-3">
                            <p class="text-sm font-bold mb-3">سوالات متداول</p>
                            <ul class="max-w-2xl mx-auto mt-2 divide-y shadow  rounded-md">
                                <li>
                                    <details class="group">
                                        <summary class="flex items-center gap-3 px-4 py-3 font-medium marker:content-none hover:cursor-pointer">
                                            <svg class="w-5 h-5 text-gray-500 transition group-open:rotate-90" xmlns="http://www.w3.org/2000/svg"
                                                 width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                      d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z">
                                                </path>
                                            </svg>
                                            <span>چطور سفارشمو تکمیل کنم؟</span>
                                        </summary>

                                        <article class="px-4 pb-4">
                                            <p class="mb-2">مراحل تکمیل سفارش</p>
                                            <ul class="list-disc">
                                                <li class="mb-1">از بین محصولات سایت، محصول مورد نظرتو انتخاب کن</li>
                                                <li class="mb-1">روی دکمه افزودن به سبد خرید کلیک کن</li>
                                                <li class="mb-1">به صفحه سبد خرید برو و روی دکمه تکمیل سفارش کلیک کن</li>
                                                <li class="mb-1">اطلاعات دریافت کننده رو در صفحه تسویه حساب وارد کن و از بین روش های پرداخت یک مورد رو انتخاب کن و بر روی دکمه پرداخت کلیک کن</li>
                                                <li class="mb-1">وارد صفحه درگاه پرداخت که شدی، اطلاعات حساب بانکیت رو وارد کن و پرداختتو تکمیل کن</li>
                                                <li class="mb-1">مبارکه! سفارشت تکمیل شد.</li>
                                            </ul>
                                        </article>
                                    </details>
                                </li>

                            </ul>
                            <p class="text-sm mb-2 mt-3">اگه جواب سوالت اینجا نبود، میتونی سوالتو بصورت یک درخواست پشتیبانی برامون ارسال کنی</p>

                        </div>
                        <div class="mb-2 text-center p-2">
                            <Link href="/dashboard/ticket">
                                <button class="bg-indigo-500 cursor-pointer text-gray-100 rounded-md px-5 py-3">ارسال درخواست پشتیبانی</button>
                            </Link>

                        </div>
                    </div>

                </div>

                <div class="col-span-1 card border border-gray-100 rounded-md mb-5 shadow">
                    <div class="card-header bg-gray-100 p-2 flex">
                        <h4>درخواست های پشتیبانی</h4>
                        <Link class="ms-auto" href="/dashboard/ticket">
                            <button class="py-1 px-2 cursor-pointer bg-black text-white rounded-md">درخواست جدید</button>
                        </Link>
                    </div>
                    <div class="card-body p-2">

                        <p v-for="(ticket, t) in tickets" class="mb-4 border border-gray-200 p-2" :key="t">
                            <Link :href="`/dashboard/ticket/show/${ticket.id}`">{{ ticket.title }}</Link>
                            <small :class="`ms-2 p-1 rounded-md ${ticket.status.css_class}`">{{ticket.status.name}}</small>
                        </p>
                    </div>
                </div>




            </div>


        </div>



    </AppLayout>
</template>
