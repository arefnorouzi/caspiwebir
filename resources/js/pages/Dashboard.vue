<script setup lang="ts">
import AppLayout from '@/layouts/DashboardLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

import { ref } from 'vue';
import { Button } from '@/components/ui/button';

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
    admin_mobile: string;

}
const props = defineProps<Props>()
const formatDate = (d) =>
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'numeric', day: 'numeric' })



</script>

<template>
    <Head title="حساب کاربری" />

    <AppLayout :breadcrumbs="breadcrumbs">


        <div class="flex flex-wrap mt-2 p-2">
            <div class="w-full mb-3">
                <a href="/"
                   class="p-2 m-1 rounded-md bg-blue-600 shadow-md text-white cursor-pointer">مشاهده سایت</a>
                <a href="/shop"
                   class="p-2 m-1 rounded-md bg-blue-600 shadow-md text-white cursor-pointer"
                >بازدید فروشگاه</a>
                <a href="/cart"
                   class="p-2 m-1 rounded-md bg-blue-600 shadow-md text-white cursor-pointer"
                >سبد خرید</a>
                <a href="/checkout"
                   class="p-2 m-1 rounded-md bg-blue-600 shadow-md text-white cursor-pointer"
                >تسویه حساب</a>
            </div>
            <div class="w-full p-1 mb-5">
                <div
                    class="grid auto-rows-min gap-3 md:grid-cols-2 sm:grid-cols-1 lg:grid-cols-2 mb-3"
                >

<!--                    <div v-if="!user.name || !user.authenticated"-->
<!--                        class="card border border-gray-300 rounded-md mb-2 shadow-md content-center">-->
<!--                        <div class="card-body text-center py-5 px-3">-->
<!--                            <Link href="/dashboard/profile">-->
<!--                                <p class="mb-2">برای تکمیل اطلاعات حساب کاربری خود میتوانید از لینک زیر اقدام نمایید</p>-->
<!--                                <button class="p-2 rounded-md bg-blue-500 text-white cursor-pointer">تکمیل پروفایل</button>-->
<!--                            </Link>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div v-else-->
<!--                         class="card border border-gray-300 rounded-md mb-2 shadow-md" style="align-content: center">-->
<!--                        <div class="card-body text-center py-5 px-3">-->
<!--                            <Link href="/dashboard/profile">-->
<!--                                <p class="mb-2">احراز هویت حساب کاربری شما توسط کارشناسان ما تایید شده است.</p>-->
<!--                                <button class="p-2 rounded-md bg-indigo-600 text-gray-100 cursor-pointer">مشاهده پروفایل</button>-->
<!--                            </Link>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div
                        class="card border border-gray-300 rounded-md mb-2 shadow-md content-center">
                        <div class="card-body text-center py-5 px-3">
                            <p class="border rounded border-slate-300 p-2 text-slate-700 text-right mb-1">
                                <span>نام و نام خانوادگی: </span><span>{{user?.name ?? '-'}}</span>
                            </p>
                            <p class="border rounded border-slate-300 p-2 text-slate-700 text-right mb-1">
                                <span>شماره تماس: </span><span>{{user?.mobile ?? '-'}}</span>
                            </p>
                            <p class="border rounded border-slate-300 p-2 text-slate-700 text-right mb-1">
                                <span>عضویت: </span><span>{{formatDate(user.created_at)}}</span>
                            </p>
                            <Link href="/dashboard/profile">
                                <p class="mb-2">برای تکمیل اطلاعات حساب کاربری خود میتوانید از لینک زیر اقدام نمایید</p>
                                <button class="p-2 rounded-md bg-blue-500 text-white cursor-pointer">تکمیل پروفایل</button>
                            </Link>
                        </div>
                    </div>
                    <div
                        class="card border border-gray-300 rounded-md mb-2 shadow-md content-center">
                        <div class="card-body text-center py-5 px-3">
                            <p class="mb-2 text-slate-800">اگر نیاز به دوره آموزشی خاص دارید، میتوانید درخواست خود را از طریق تیکت یا ارسال پیام به پشتیبانی ارسال نمایید</p>
                            <div class="flex flex-wrap justify-between mt-5">
                                <div class="mb-2">
                                    <a href="https://ble.ir/join/8JmCqzpfTe" rel="nofollow" target="_blank">
                                        <img src="/images/social/bale.png" class="w-10 rounded">
                                    </a>
                                </div>
                                <div class="mb-2">
                                    <a href="https://rubika.ir/caspiweb_ir" rel="nofollow" target="_blank">
                                        <img src="/images/social/rubika.webp" class="w-10 rounded">
                                    </a>
                                </div>
                                <div class="mb-2">
                                    <a href="https://wa.me/989192138510" rel="nofollow" target="_blank">
                                        <img src="/images/social/whatsapp.png" class="w-10 rounded">
                                    </a>
                                </div>
                                <div class="mb-2">
                                    <a href="https://t.me/caspiweb_ir" rel="nofollow" target="_blank">
                                        <img src="/images/social/telegram.webp" class="w-10 rounded">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:w-3/4 w-full p-1">


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
                                    جزئیات
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
                            <td class="p-4 border-b border-slate-200 py-2">
                                <span :class="`${item?.status?.css_class} text-xs`">{{ item?.status?.name }}</span>

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
            <div class="lg:w-1/4 w-full p-1">
                <div class="card border-1 border-indigo-500 rounded-md mb-1 shadow">
                    <div class="card-body px-2 py-5">

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
                                            <span class="text-blue-700">چطور سفارش ثبت کنم؟</span>
                                        </summary>

                                        <article class="px-4 pb-4">
                                            <p class="mb-2">مراحل تکمیل سفارش</p>
                                            <ul class="list-disc">
                                                <li class="mb-1">از بین محصولات سایت، محصول مورد نظرتو انتخاب کن</li>
                                                <li class="mb-1">روی دکمه افزودن به سبد خرید کلیک کن</li>
                                                <li class="mb-1">به صفحه سبد خرید برو و روی دکمه تکمیل سفارش کلیک کن</li>
                                                <li class="mb-1">فرم تسویه حساب رو تکمیل کن</li>
                                                <li class="mb-1">از طریق درگاه پرداخت آنلاین یا کارت به کارت میتونی پرداختتو تکمیل کنی</li>
                                                <li class="mb-1">بعداز پرداخت سفارش تکمیل میشه و کالا و خدمات برات ارسال میشن</li>
                                                <li class="mb-1">اگه نیاز به راهنمایی بیشتر داری به پشتیبانی پیام ارسال کن تا کمکت کنیم</li>

                                            </ul>
                                        </article>
                                    </details>
                                </li>
                                <li>
                                    <details class="group">
                                        <summary class="flex items-center gap-3 px-4 py-3 font-medium marker:content-none hover:cursor-pointer">
                                            <svg class="w-5 h-5 text-gray-500 transition group-open:rotate-90" xmlns="http://www.w3.org/2000/svg"
                                                 width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                      d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z">
                                                </path>
                                            </svg>
                                            <span class="text-blue-700">چطور قسطی خرید کنم؟</span>
                                        </summary>

                                        <article class="px-4 pb-4">
                                            <p class="mb-2">مراحل خرید قسطی</p>
                                            <ul class="list-disc">
                                                <li class="mb-1">از بین محصولات سایت، محصول مورد نظرتو انتخاب کن</li>
                                                <li class="mb-1">روی دکمه افزودن به سبد خرید کلیک کن</li>
                                                <li class="mb-1">به صفحه سبد خرید برو و روی دکمه تکمیل سفارش کلیک کن</li>
                                                <li class="mb-1">فرم تسویه حساب رو تکمیل کن</li>
                                                <li class="mb-1">از بین روش های پرداخت میتونی از ترب پی، دیجی پی یا اسنپ پی استفاده کنی</li>
                                                <li class="mb-1">اگه نیاز به راهنمایی بیشتر داری به پشتیبانی پیام ارسال کن تا کمکت کنیم</li>
                                            </ul>
                                        </article>
                                    </details>
                                </li>
                                <li>
                                    <details class="group">
                                        <summary class="flex items-center gap-3 px-4 py-3 font-medium marker:content-none hover:cursor-pointer">
                                            <svg class="w-5 h-5 text-gray-500 transition group-open:rotate-90" xmlns="http://www.w3.org/2000/svg"
                                                 width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                      d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z">
                                                </path>
                                            </svg>
                                            <span class="text-blue-700">چطور از کد تخفیف استفاده کنم؟</span>
                                        </summary>

                                        <article class="px-4 pb-4">
                                            <p class="mb-2">مراحل استفاده از کد تخفیف</p>
                                            <ul class="list-disc">
                                                <li class="mb-1">از بین محصولات سایت، محصول مورد نظرتو انتخاب کن</li>
                                                <li class="mb-1">روی دکمه افزودن به سبد خرید کلیک کن</li>
                                                <li class="mb-1">به صفحه سبد خرید برو</li>
                                                <li class="mb-1">در صفحه سبد خرید امکان ثبت کوپن تخفیف وجود داره</li>
                                                <li class="mb-1">کد تخفیف خودتو در فیلد مربوطه وارد کن و بر روی دکمه اعمال تخفیف کلیک کن</li>
                                                <li class="mb-1">در صورت فعال بودن کد تخفیف، مبلغ تخفیفی از جمع سفارش کسر خواهد شد</li>
                                                <li class="mb-1">اگه نیاز به راهنمایی بیشتر داری به پشتیبانی پیام ارسال کن تا کمکت کنیم</li>
                                            </ul>
                                        </article>
                                    </details>
                                </li>
                            </ul>
                            <p class="mt-3">اگه جواب سوالت اینجا نبود، میتونی سوالتو بصورت یک درخواست پشتیبانی برامون ارسال کنی</p>

                        </div>
                    </div>

                </div>

            </div>
            <div class="w-full card border border-gray-100 rounded-md mb-5 shadow">
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



    </AppLayout>
</template>
