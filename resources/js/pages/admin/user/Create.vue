<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import ValidationErrors from '@/components/validation/ValidationErrors.vue';
import FlashMessage from "@/components/FlashMessage.vue";


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'پروفایل کاربر',
        href: '/admin/user',
    },
];

interface Props {
    provinces: object;
    roles: object;
}
const props = defineProps<Props>()

const form = useForm({
    name: '',
    mobile: '',
    email: null,
    mobile_verified: 0,
    national_code: null,
    authenticated: 0,
    ban: 0,
    is_active: 1,
    subscribe: 1,
    role_id: 6,
    password: null,
    province_id: null,
    city: null,
    address: null,
    zip_code: null,
});

async function submit() {
    form.post("/admin/user")
}
</script>

<template>
    <Head title="افزودن کاربر" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessage />
        <div class="flex flex-wrap items-center justify-center mt-2 p-2">

            <div class="lg:w-2/3 md:w-1/2 sm:w-1/1 w-1/1 p-1">
                <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">افزودن کاربر</h3>
                    </div>
                    <div class="ml-3">
                        <Link href="/admin/user">
                            <button
                                class="me-1 cursor-pointer text-black bg-white border border-gray-200 hover:border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-md inline-flex items-center px-3 py-2.5 text-center mr-2">
                                <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20 10L20.7071 10.7071L21.4142 10L20.7071 9.29289L20 10ZM3 18C3 18.5523 3.44772 19 4 19C4.55229 19 5 18.5523 5 18L3 18ZM15.7071 15.7071L20.7071 10.7071L19.2929 9.29289L14.2929 14.2929L15.7071 15.7071ZM20.7071 9.29289L15.7071 4.29289L14.2929 5.70711L19.2929 10.7071L20.7071 9.29289ZM20 9L10 9L10 11L20 11L20 9ZM3 16L3 18L5 18L5 16L3 16ZM10 9C6.13401 9 3 12.134 3 16L5 16C5 13.2386 7.23858 11 10 11L10 9Z" fill="#33363F"></path> </g></svg>

                                <span class="ms-1">بازگشت</span>
                            </button>
                        </Link>
                    </div>
                </div>
                <div class="card border border-gray-100 rounded-md mb-2 shadow">
                    <div class="card-body px-2 py-4">
                        <form @submit.prevent="submit" class="space-y-4 p-2">

                        <div
                            class="grid auto-rows-min gap-3 md:grid-cols-3 lg:grid-cols-5 mb-3"
                        >
                            <div class="mb-3 mt-5">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">سطح کاربر</label>
                                <select class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                        v-model="form.role_id"
                                >
                                    <option v-for="(role, r) in roles"
                                            :key="r"
                                            :value="role.id">{{ role.name }}</option>
                                </select>
                            </div>
                            <div class="mb-3 mt-5">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">وضعیت کاربر</label>
                                <select class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                        v-model="form.is_active"
                                >
                                    <option :value="0">غیرفعال</option>
                                    <option :value="1">فعال</option>
                                </select>
                            </div>

                            <div class="mb-3 mt-5">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">احراز هویت</label>
                                <select class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                        v-model="form.authenticated"
                                >
                                    <option :value="0">احراز هویت نشده</option>
                                    <option :value="1">احراز هویت شده</option>
                                </select>
                            </div>
                            <div class="mb-3 mt-5">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">نام کاربر</label>
                                <input type="text" class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                       v-model="form.name"
                                >
                            </div>
                            <div class="mb-3 mt-5">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">موبایل کاربر</label>
                                <input type="text" minlength="11" maxlength="11" class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                       v-model="form.mobile"
                                >
                            </div>
                            <div class="mb-3 mt-5">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">ایمیل کاربر</label>
                                <input type="email" minlength="10" maxlength="70" class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                       v-model="form.email"
                                >
                            </div>
                            <div class="mb-3 mt-5">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">کد ملی</label>
                                <input type="text" minlength="10" maxlength="10" class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                       v-model="form.national_code"
                                >
                            </div>
                            <div class="mb-3 mt-5">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">استان</label>
                                <select class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                        v-model="form.province_id"
                                >
                                    <option :value="null">انتخاب استان</option>
                                    <option v-for="(province, index) in provinces"
                                            :value="province.id" :key="index">{{ province.name }}</option>

                                </select>
                            </div>
                            <div class="mb-3 mt-5">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">شهر</label>
                                <input type="text" class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                       v-model="form.city"
                                >
                            </div>

                            <div class="mb-3 mt-5">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">کد پستی</label>
                                <input type="text" minlength="10" maxlength="10" class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                       v-model="form.zip_code"
                                >
                            </div>

                            <div class="mb-3 mt-5">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">رمز عبور</label>
                                <input type="text" minlength="8" maxlength="32" class="text-sm text-left p-2 border border-gray-200 rounded-md w-full"
                                       v-model="form.password" placeholder="password"
                                >
                            </div>

                        </div>
                        <div class="mb-3 mt-5">
                            <label for="stock" class="text-sm font-bold p-2 block mb-2">آدرس</label>
                            <textarea type="text" rows="2" minlength="2" maxlength="150" class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                      v-model="form.address"
                            ></textarea>
                        </div>

                        <div class="my-2 w-full text-center">
                            <button type="submit" class="pay-btn">ذخیره کاربر</button>
                        </div>

                        </form>


                    </div>
                </div>

            </div>

        </div>

    </AppLayout>
</template>

<style scoped>

</style>
