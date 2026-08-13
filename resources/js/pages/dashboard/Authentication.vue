<script setup lang="ts">
import AppLayout from '@/layouts/DashboardLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import ValidationErrors from '@/components/validation/ValidationErrors.vue';
import { showToast } from '@/composables/useToast.js'
import axios from 'axios';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'پروفایل کاربر',
        href: '/admin/user',
    },
];

interface Props {
    user: object;
    provinces: object;
}
const props = defineProps<Props>()

const form = useForm({
    name: props.user.name,
    mobile: props.user.mobile,
    email: props.user.email,
    mobile_verified: props.user.mobile_verified,
    national_code: props.user.national_code,
    authenticated: props.user.authenticated,
    ban: props.user.ban,
    is_active: props.user.is_active,
    subscribe: props.user.subscribe,
    province_id: props.user.province_id,
    city: props.user.city,
    address: props.user.address,
    zip_code: props.user.zip_code,
});

const validation_errors = ref(null)

async function updateUser() {
    await axios.patch('/admin/user/' + props.user.id, form)
        .then(res => {
            showToast("کاربر با موفقیت بروزرسانی شد", "success")
            window.location.reload()
        })
        .catch(err => {
            if (err?.response?.data?.errors)
            {
                validation_errors.value = err.response.data.errors
            }
            if (err?.response?.data?.message)
            {
                showToast(err.response.data.message, "error")
            }
            else {
                showToast("خطا در ثبت رکورد", "error")
            }
        })
}

const formatDate = (d) =>
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' })


</script>

<template>
    <Head title="پروفایل کاربر" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex flex-wrap mt-2 p-2">

            <div class="lg:w-1/3 md:w-1/2 sm:w-1/1 w-1/1 p-1">

                <div
                    class="card border border-gray-100 rounded-md mb-2 shadow col-span-1">
                    <div class="card-header bg-gray-100 p-2">
                        <h4>نام کاربر: {{ user?.name }}</h4>
                    </div>
                    <div class="card-body p-2">
                        <p class="mb-4 border border-gray-200 p-2">
                            <span>شماره موبایل: </span> <strong>{{user.mobile}}</strong></p>
                        <p class="mb-4 border border-gray-200 p-2">
                            <span>ایمیل: </span>
                            <strong>{{user.email}}</strong>
                        </p>
                        <p class="mb-4 border border-gray-200 p-2">
                            <span>وضعیت کاربر: </span>
                            <strong v-if="user.is_active" class="text-green-800">فعال</strong>
                            <strong v-else class="text-red-800">غیرفعال</strong>
                        </p>
                        <p class="mb-4 border border-gray-200 p-2">
                            <span>وضعیت پروفایل: </span>
                            <strong v-if="user.ban" class="text-red-800">مسدود شده</strong>
                            <strong v-else class="text-green-800">فعال</strong>
                        </p>
                        <p class="mb-4 border border-gray-200 p-2">
                            <span>احراز هویت: </span>
                            <strong v-if="user.authenticated" class="text-green-800">انجام شده</strong>
                            <strong v-else class="text-red-800">انجام نشده</strong>
                        </p>
                        <p class="mb-4 border border-gray-200 p-2">
                            <span>عضویت خبرنامه: </span>
                            <strong v-if="user.subscribe" class="text-green-800">فعال</strong>
                            <strong v-else class="text-red-800">غیرفعال</strong>
                        </p>
                        <p class="mb-4 border border-gray-200 p-2">
                            <span>تاریخ ثبت نام: </span> <strong>{{formatDate(user.created_at)}}</strong></p>
                        <p class="mb-4 border border-gray-200 p-2">
                            <span>آخرین بروزرسانی: </span> <strong>{{formatDate(user.updated_at)}}</strong></p>


                    </div>
                </div>

            </div>

            <div class="lg:w-2/3 md:w-1/2 sm:w-1/1 w-1/1 p-1">

                <div class="card border border-gray-100 rounded-md mb-2 shadow">
                    <div class="card-header bg-gray-100 p-2">
                        <h4>ویرایش پروفایل</h4>
                    </div>
                    <div class="card-body px-2 py-4">
                        <div
                            class="grid auto-rows-min gap-3 md:grid-cols-3 lg:grid-cols-5 mb-3"
                        >



                            <div class="mb-3 mt-5">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">عضویت خبرنامه</label>
                                <select class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                        v-model="form.subscribe"
                                >
                                    <option :value="0">خیر</option>
                                    <option :value="1">بله</option>
                                </select>
                            </div>

                            <div class="mb-3 mt-5">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">نام و نام خانوادگی</label>
                                <input type="text" class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                       v-model="form.name"
                                >
                            </div>
                            <div class="mb-3 mt-5">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">موبایل</label>
                                <input type="text" minlength="11" maxlength="11" class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                       v-model="form.mobile"
                                >
                            </div>
                            <div class="mb-3 mt-5">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">ایمیل</label>
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
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">آدرس</label>
                                <input type="text" minlength="2" maxlength="150" class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                       v-model="form.address"
                                >
                            </div>
                            <div class="mb-3 mt-5">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">کد پستی</label>
                                <input type="text" minlength="10" maxlength="10" class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                       v-model="form.zip_code"
                                >
                            </div>

                        </div>
                        <div class="my-2">
                            <ValidationErrors :errors="validation_errors" />

                        </div>
                        <div class="my-2 w-full text-center">
                            <button @click="updateUser" class="pay-btn">بروزرسانی پروفایل</button>
                        </div>




                    </div>
                </div>

            </div>

        </div>

    </AppLayout>
</template>

<style scoped>

</style>
