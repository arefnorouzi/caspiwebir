<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
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
    invoices: object;
    provinces: object;
    roles: object;
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
    role_id: props.user.role_id,
    password: null,
    province_id: props.user.province_id,
    city: props.user.city,
    address: props.user.address,
    zip_code: props.user.zip_code,
});

const validation_errors = ref(null)

async function updateUser() {
    form.patch('/admin/user/' + props.user.id)
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
                            <span>سطح کاربر: </span> <strong>{{user?.role?.name}}</strong></p>
                        <p class="mb-4 border border-gray-200 p-2">
                            <span>کد ملی: </span> <strong>{{user?.national_code}}</strong></p>
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
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">وضعیت مسدودی</label>
                                <select class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                        v-model="form.ban"
                                >
                                    <option :value="0">کاربر فعال</option>
                                    <option :value="1">کاربر مسدود شده</option>
                                </select>
                            </div>
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
                                       v-model="form.password" placeholder="برای عدم تغییر خالی بگذارید"
                                >
                            </div>

                        </div>
                        <div class="mb-3 mt-5">
                            <label for="stock" class="text-sm font-bold p-2 block mb-2">آدرس</label>
                            <textarea rows="2" minlength="2" maxlength="150" class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                      v-model="form.address"
                            ></textarea>
                        </div>
                        <div class="my-2">
                            <ValidationErrors :errors="validation_errors" />

                        </div>
                        <div class="my-2 w-full text-center">
                            <button @click="updateUser" class="pay-btn">بروزرسانی کاربر</button>
                        </div>




                    </div>
                </div>

            </div>

            <div class="w-1/1 p-1 my-3">
                <div class="card border border-gray-100 rounded-md mb-5 shadow">
                    <div class="card-header bg-gray-100 p-2">
                        <h4>فاکتورهای کاربر</h4>
                    </div>
                    <div class="card-body px-2 py-4">
                        <table class="w-full text-center table-auto">
                            <thead>
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
                                        مبلغ
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        وضعیت
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        ایجاد
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        پرداخت
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        انقضا
                                    </p>
                                </th>

                            </tr>
                            </thead>
                            <tbody v-if="invoices">
                            <tr v-for="(item, index) in invoices.data" :key="index">

                                <td class="p-4 border-b border-slate-200 py-1">
                                    <a :href="`/admin/invoice/${item.id}`" target="_blank"
                                        class="text-sm text-blue-500">{{ item.id}}</a>
                                </td>
                                <td class="p-4 border-b border-slate-200 py-1">
                                    <span :class="`text-sm p-1 rounded-md ${item.invoice_type.css_class}`">{{ item.invoice_type.name }}</span>
                                </td>
                                <td class="p-4 border-b border-slate-200 py-1">
                                    <p class="text-sm text-slate-500">{{ Number(item.amount).toLocaleString() }}</p>
                                </td>
                                <td class="p-4 border-b border-slate-200 py-1">
                                    <span :class="`text-sm p-1 rounded-md ${item.status.css_class}`">{{ item.status.name }}</span>
                                </td>
                                <td class="p-4 border-b border-slate-200 py-2" style="direction: ltr">
                                    <p class="text-sm text-slate-500">{{ item.created_at ? formatDate(item.created_at) : '-'}}</p>
                                </td>
                                <td class="p-4 border-b border-slate-200 py-2" style="direction: ltr">
                                    <p class="text-sm text-slate-500">{{ item.purchased_at ? formatDate(item.purchased_at) : '-'}}</p>
                                </td>
                                <td class="p-4 border-b border-slate-200 py-2" style="direction: ltr">
                                    <p class="text-sm text-slate-500">{{ item.expired_at ? formatDate(item.expired_at) : '-'}}</p>
                                </td>

                            </tr>
                            </tbody>
                        </table>


                    </div>
                </div>

            </div>
        </div>

    </AppLayout>
</template>

<style scoped>

</style>
