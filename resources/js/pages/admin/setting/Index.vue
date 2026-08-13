<script setup lang="ts">

import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'تنظیمات',
        href: '/admin/setting',
    },
];
</script>

<template>
    <Head title="تنظیمات" />
    <AppLayout :breadcrumbs="breadcrumbs">

        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="my-2 p-2">
                    <h2 class="text-primary-500 font-bold text-2xl mb-3">تنظیمات سیستم</h2>

                    <div class="grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 gap-4 mt-3">
                        <div class="card mb-2 border border-gray-300 rounded-md">
                            <div class="card-title bg-gray-100 p-2 text-black">
                                تنظیمات عمومی
                            </div>
                            <div class="card-body p-2" style="word-wrap: break-word">
                                <div class="mb-2">
                                    <p>تنظیمات عمومی سایت مانند، عنوان سایت، آدرس، تلفن، لوگو و ...</p>
                                </div>
                            </div>
                            <div class="card-footer p-2">
                               <Link href="/admin/setting/website">
                                   <button class="bg-gray-500 w-50 text-white rounded-md shadow-md px-4 py-2 cursor-pointer">ویرایش تنظیمات</button>
                               </Link>
                            </div>
                        </div>

                        <div class="card mb-2 border border-gray-300 rounded-md">
                            <div class="card-title bg-gray-100 p-2 text-black">
                                تنظیمات فروشگاه
                            </div>
                            <div class="card-body p-2" style="word-wrap: break-word">
                                <div class="mb-2">
                                    <p>تنظیمات فروشگاه: مانند تنظیم نرخ مالیات، اطلاعات صفحه فاکتور، فعال/غیرفعال کردن سیستم فروش</p>
                                </div>
                            </div>
                            <div class="card-footer p-2">
                                <Link href="/admin/setting/shop">
                                    <button class="bg-gray-500 w-50 text-white rounded-md shadow-md px-4 py-2 cursor-pointer">ویرایش تنظیمات</button>
                                </Link>
                            </div>
                        </div>


                        <div class="card mb-2 border border-gray-300 rounded-md">
                            <div class="card-title bg-gray-100 p-2 text-black">
                                تنظیمات درگاه پرداخت
                            </div>
                            <div class="card-body p-2" style="word-wrap: break-word">
                                <div class="mb-2">
                                    <p>تنظیمات درگاه پرداخت و روش های پرداخت فروشگاه</p>
                                </div>
                            </div>
                            <div class="card-footer p-2">
                                <Link href="/admin/payment">
                                    <button class="bg-gray-500 w-50 text-white rounded-md shadow-md px-4 py-2 cursor-pointer">ویرایش تنظیمات</button>
                                </Link>
                            </div>
                        </div>


                        <div class="card mb-2 border border-gray-300 rounded-md">
                            <div class="card-title bg-gray-100 p-2 text-black">
                                تنظیمات حمل و نقل
                            </div>
                            <div class="card-body p-2" style="word-wrap: break-word">
                                <div class="mb-2">
                                    <p>تنظیمات روش های ارسال کالا، تنظیم نرخ حمل و نقل</p>
                                </div>
                            </div>
                            <div class="card-footer p-2">
                                <Link href="/admin/shipping">
                                    <button class="bg-gray-500 w-50 text-white rounded-md shadow-md px-4 py-2 cursor-pointer">ویرایش تنظیمات</button>
                                </Link>
                            </div>
                        </div>

                        <div class="card mb-2 border border-gray-300 rounded-md">
                            <div class="card-title bg-gray-100 p-2 text-black">
                                شبکه های اجتماعی
                            </div>
                            <div class="card-body p-2" style="word-wrap: break-word">
                                <div class="mb-2">
                                    <p>تنظیمات شبکه های اجتماعی</p>
                                </div>
                            </div>
                            <div class="card-footer p-2">
                                <Link href="/admin/social">
                                    <button class="bg-gray-500 w-50 text-white rounded-md shadow-md px-4 py-2 cursor-pointer">ویرایش تنظیمات</button>
                                </Link>
                            </div>
                        </div>

                        <div class="card mb-2 border border-gray-300 rounded-md">
                            <div class="card-title bg-gray-100 p-2 text-black">
                                منوی سایت
                            </div>
                            <div class="card-body p-2" style="word-wrap: break-word">
                                <div class="mb-2">
                                    <p>تنظیمات منوی هدر و فوتر سایت</p>
                                </div>
                            </div>
                            <div class="card-footer p-2">
                                <Link href="/admin/menu">
                                    <button class="bg-gray-500 w-50 text-white rounded-md shadow-md px-4 py-2 cursor-pointer">ویرایش تنظیمات</button>
                                </Link>
                            </div>
                        </div>

                        <div class="card mb-2 border border-gray-300 rounded-md">
                            <div class="card-title bg-gray-100 p-2 text-black">
                                تنظیمات سطوح کاربری
                            </div>
                            <div class="card-body p-2" style="word-wrap: break-word">
                                <div class="mb-2">
                                    <p>تنظیمات مربوط به سطوح کاربری. مشتری، همکار سطح 1، همکار سطح 2 و ...</p>
                                </div>
                            </div>
                            <div class="card-footer p-2">
                                <Link href="/admin/role">
                                    <button class="bg-gray-500 w-50 text-white rounded-md shadow-md px-4 py-2 cursor-pointer">ویرایش تنظیمات</button>
                                </Link>
                            </div>
                        </div>

                        <div class="card mb-2 border border-gray-300 rounded-md">
                            <div class="card-title bg-gray-100 p-2 text-black">
                                تنظیمات واحدهای کالا
                            </div>
                            <div class="card-body p-2" style="word-wrap: break-word">
                                <div class="mb-2">
                                    <p>تنظیمات مربوط به واحدهای کالا: عدد، دستگاه، جعبه، متر و ...</p>
                                </div>
                            </div>
                            <div class="card-footer p-2">
                                <Link href="/admin/unit">
                                    <button class="bg-gray-500 w-50 text-white rounded-md shadow-md px-4 py-2 cursor-pointer">ویرایش تنظیمات</button>
                                </Link>
                            </div>
                        </div>

                        <div class="card mb-2 border border-gray-300 rounded-md">
                            <div class="card-title bg-gray-100 p-2 text-black">
                                تنظیمات سیستم
                            </div>
                            <div class="card-body p-2" style="word-wrap: break-word">
                                <div class="mb-2">
                                    <p>تنظیمات سیستمی پروژه</p>
                                </div>
                            </div>
                            <div class="card-footer p-2">
                                <Link href="/admin/system">
                                    <button class="bg-gray-500 w-50 text-white rounded-md shadow-md px-4 py-2 cursor-pointer">ویرایش تنظیمات</button>
                                </Link>
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
