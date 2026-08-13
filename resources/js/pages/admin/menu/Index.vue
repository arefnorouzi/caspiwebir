<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import {Head, Link, router, useForm} from '@inertiajs/vue3';
import FlashMessage from '@/components/FlashMessage.vue';
import MenuRow from "@/components/admin/menu/MenuRow.vue";
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'مدیریت منوی سایت',
        href: '/admin/brand',
    },
];
interface Props {
    models: object;
}
const props = defineProps<Props>()

const headerMenuForm = useForm({
    name: null,
    slug: null,
    status: 1,
    css_class: null,
    parent_id: null,
    rank: 10,
})

async function storeItem() {

}

</script>

<template>
    <Head title="مدیریت منو" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">لیست منوها</h3>

                    </div>
                </div>

                <div class="my-2 p-2 rounded-md">
                    <FlashMessage />
                </div>
                <div class="relative flex mt-2 flex-wrap w-full h-full overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
                    <div v-if="models?.main_menu" class="w-full p-2">
                        <div class="w-full p-2 border bg-gray-200 rounded-md mb-2">
                            <h4>منوی اصلی (هدر)</h4>
                        </div>
                        <Link href="/admin/menu/create">
                            <button
                                class="me-1 cursor-pointer text-oklch(44.8% 0.119 151.328) bg-green-200 hover:bg-green-300 focus:ring-4 focus:ring-green-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                                <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6 12H18M12 6V18" stroke="#008080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                <span class="ms-1"> افزودن آیتم</span>
                            </button>
                        </Link>
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
                                        عنوان
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        لینک
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        ترتیب
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        وضعیت
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        عملیات
                                    </p>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                <MenuRow
                                    v-for="item in models?.main_menu"
                                    :key="item.id"
                                    :menu="item"
                                    :level="0"
                                />

                            </tbody>
                        </table>

                    </div>

                    <hr class="mt-5" />

                    <div v-if="models?.footer_menu" class="w-full p-2">
                        <div class="w-full p-2 border bg-gray-200 rounded-md mb-2">
                            <h4>منوی فوتر</h4>
                        </div>
                        <Link href="/admin/menu/create?position=footer_menu">
                            <button
                                class="me-1 cursor-pointer text-oklch(44.8% 0.119 151.328) bg-green-200 hover:bg-green-300 focus:ring-4 focus:ring-green-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                                <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6 12H18M12 6V18" stroke="#008080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                <span class="ms-1"> افزودن آیتم</span>
                            </button>
                        </Link>
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
                                        عنوان
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        لینک
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        ترتیب
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        وضعیت
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        عملیات
                                    </p>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <MenuRow
                                v-for="item in models?.footer_menu"
                                :key="item.id"
                                :menu="item"
                                :level="0"
                            />
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
