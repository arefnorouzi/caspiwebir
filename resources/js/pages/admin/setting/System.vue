<script setup lang="ts">

import {Head, Link, router} from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import FlashMessage from "@/components/FlashMessage.vue";
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'تنظیمات سیستم',
        href: '/admin/system',
    },
];

async function updateDatabase() {
    if (confirm('از بروزرسانی دیتابیس مطمئنی؟')) {
        router.get('/admin/db-migrate')
    }
}

async function backupDatabase(){
    if (confirm('از بکاپ دیتابیس مطمئنی؟')) {
        router.get('/admin/db-backup')
    }
}
async function clearCache() {
    if (confirm('از پاک کردن کش مطمئنی؟')) {
        router.get('/admin/cache-clear')
    }
}

async function clearRoute() {
    if (confirm('از تازه سازی مسیردهی مطمئنی؟')) {
        router.get('/admin/route-clear')
    }
}

</script>

<template>
    <Head title="تنظیمات سیستم" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessage />

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
                                بروزرسانی پایگاه داده
                            </div>
                            <div class="card-body p-2" style="word-wrap: break-word">
                                <div class="mb-2">
                                    <p>بروزرسانی پایگاه داده و همگام سازی</p>
                                </div>
                            </div>
                            <div class="card-footer p-2">
                                 <button @click="updateDatabase"
                                         class="bg-gray-500 w-50 text-white rounded-md shadow-md px-4 py-2 cursor-pointer">بروزرسانی دیتابیس</button>
                            </div>
                        </div>

                        <div class="card mb-2 border border-gray-300 rounded-md">
                            <div class="card-title bg-gray-100 p-2 text-black">
                                پاک کردن کش سیستم
                            </div>
                            <div class="card-body p-2" style="word-wrap: break-word">
                                <div class="mb-2">
                                    <p>پاک کردن و تازه سازی کش سیستم</p>
                                </div>
                            </div>
                            <div class="card-footer p-2">
                                <button @click="clearCache"
                                        class="bg-gray-500 w-50 text-white rounded-md shadow-md px-4 py-2 cursor-pointer">پاک کردن کش</button>

                            </div>
                        </div>


                        <div class="card mb-2 border border-gray-300 rounded-md">
                            <div class="card-title bg-gray-100 p-2 text-black">
                                کش مسیردهی
                            </div>
                            <div class="card-body p-2" style="word-wrap: break-word">
                                <div class="mb-2">
                                    <p>پاک کردن و تازه سازی مسیردهی پروژه</p>
                                </div>
                            </div>
                            <div class="card-footer p-2">

                                <button @click="clearRoute"
                                        class="bg-gray-500 w-50 text-white rounded-md shadow-md px-4 py-2 cursor-pointer">تازه سازی مسیردهی</button>

                            </div>
                        </div>

                        <div class="card mb-2 border border-gray-300 rounded-md">
                            <div class="card-title bg-gray-100 p-2 text-black">
                                بکاپ پایگاه داده
                            </div>
                            <div class="card-body p-2" style="word-wrap: break-word">
                                <div class="mb-2">
                                    <p>بگاپ گرفتن از پایگاه داده سایت</p>
                                </div>
                            </div>
                            <div class="card-footer p-2">

                                <button
                                    @click="backupDatabase"
                                    class="bg-gray-500 w-50 text-white rounded-md shadow-md px-4 py-2 cursor-pointer">بکاپ دیتابیس</button>

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
