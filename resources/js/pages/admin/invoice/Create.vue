<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { ref } from 'vue'
import FlashMessage from "@/components/FlashMessage.vue";
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'ایجاد فاکتور',
        href: '/admin/invoice',
    },
];
const form = useForm({
    user_id: null,
    payment_status: false,
    invoice_status_id: 1,
    invoice_type_id: 3,
    customer_note: null,
    items: [],
});

const validation_errors = ref(null)
const props = defineProps({
    users: Object,
    plans: Object,
    statuses: Object,
    types: Object
})

async function submit() {
    form.post('/admin/invoice')
}

</script>
<template>
    <Head title="ایجاد فاکتور" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">ایجاد فاکتور</h3>
                    </div>
                    <div class="ml-3">
                        <Link :href="`/admin/invoice`">
                            <button
                                class="me-1 cursor-pointer text-black bg-white border border-gray-200 hover:border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-md inline-flex items-center px-3 py-2.5 text-center mr-2">
                                <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20 10L20.7071 10.7071L21.4142 10L20.7071 9.29289L20 10ZM3 18C3 18.5523 3.44772 19 4 19C4.55229 19 5 18.5523 5 18L3 18ZM15.7071 15.7071L20.7071 10.7071L19.2929 9.29289L14.2929 14.2929L15.7071 15.7071ZM20.7071 9.29289L15.7071 4.29289L14.2929 5.70711L19.2929 10.7071L20.7071 9.29289ZM20 9L10 9L10 11L20 11L20 9ZM3 16L3 18L5 18L5 16L3 16ZM10 9C6.13401 9 3 12.134 3 16L5 16C5 13.2386 7.23858 11 10 11L10 9Z" fill="#33363F"></path> </g></svg>

                                <span class="ms-1">بازگشت</span>
                            </button>
                        </Link>
                    </div>
                </div>
                <div class="w-full lg:w-1/2 md:w-1/2 sm:w-1/2">
                   <FlashMessage />
                </div>
                <div class="relative flex flex-col w-full h-full overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
                    <form @submit.prevent="submit" class="space-y-4 p-2">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-3">
                            <div>
                                <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">یادداشت مشتری</label>
                                <input type="text" v-model="form.customer_note" name="product-name" id="product-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                       placeholder="یادداشت برای مشتری">
                            </div>
                            <div>
                                <label for="brand" class="text-sm font-medium text-gray-900 block mb-2">انتخاب کاربر</label>
                                <select v-model="form.user_id"
                                        class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                >
                                    <option v-for="(user, index) in users"
                                            :key="index" :value="user.id"
                                    >{{user.name}} ({{user.mobile}})</option>
                                </select>
                            </div>
                            <div>
                                <label for="brand" class="text-sm font-medium text-gray-900 block mb-2">نوع فاکتور</label>
                                <select v-model="form.invoice_type_id"
                                        class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                >
                                    <option v-for="(type, index) in types"
                                            :key="index" :value="type.id"
                                    >{{type.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-5">
                            <label for="status-radio" class="text-sm font-medium text-gray-900 block mb-2 w-full">لیست سرویس ها</label>
                            <div v-for="plan_type in plans" class="mb-3 shadow shadow-md border rounded-md p-2" :key="plan_type.id">
                                <h4 class="text-lg text-rose-600 mb-2">{{plan_type.name}}</h4>
                                <div v-for="plan in plan_type.plans" :key="plan.id" class="mb-3 flex flex-wrap gap-5">
                                    <input type="checkbox" v-model="form.items" :value="plan.id"
                                           class="w-4 h-4 text-blue-800 focus:ring-blue-500 focus:ring-2"
                                    >
                                    <span class="ms-2">{{plan.name}} <span v-if="plan.duration">({{plan.duration}} ماهه)</span></span>:
                                    <strong class="ms-1" v-if="plan.price">
                                        <strong v-if="plan.offer_price || plan.offer_price == 0" class="text-red-500">{{plan.offer_price ? Number(plan.offer_price).toLocaleString() : 'رایگان'}} <s class="text-gray-500">{{Number(plan.price).toLocaleString()}}</s> <span class="text-gray-500">تومان</span> </strong>
                                        <strong v-else>{{Number(plan.price).toLocaleString()}} تومان</strong>
                                    </strong>
                                    <strong class="ms-1 text-red-500" v-else>رایگان</strong>
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


