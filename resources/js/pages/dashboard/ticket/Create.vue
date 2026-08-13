<script setup lang="ts">
import AppLayout from '@/layouts/DashboardLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';
import { showToast } from '@/composables/useToast.js'
import ValidationErrors from '@/components/validation/ValidationErrors.vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'ارسال درخواست پشتیبانی',
        href: '/dashboard/ticket',
    },
];
interface Props {
    departments: object;
}
const props = defineProps<Props>()

const levels = [
    {id: 1, name: 'پایین'},
    {id: 2, name: 'متوسط'},
    {id: 3, name: 'بالا'},
    {id: 4, name: 'فوری'},
]

const form = useForm({
    title: '',
    description: '',
    department_id: 1,
    level: 1
})
const validation_errors = ref(null)
async function storeRecord() {
    validation_errors.value = null
    await axios.post('/dashboard/ticket', form)
        .then(res => {
            showToast("درخواست پشتیبانی با موفقیت ثبت شد", "success")
            window.location.replace('/dashboard/ticket/show/' + res.data.ticket_id)
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

</script>

<template>
    <Head title="ارسال درخواست پشتیبانی" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-wrap mt-2 justify-center p-2 w-full">
            <div class="w-1/2 card border border-gray-100 rounded-md mb-5 shadow">
                <div class="card-header bg-gray-100 p-2 flex">
                    <h4>ارسال درخواست جدید</h4>
                    <Link class="ms-auto" href="/dashboard/ticket">
                        <button class="py-1 px-2 cursor-pointer bg-black text-white rounded-md">بازگشت</button>
                    </Link>
                </div>
                <div class="card-body p-2">

                    <div class="my-2">
                        <label class="text-sm text-gray-700 mb-1">عنوان پیام</label>
                        <input type="text" v-model="form.title"
                               placeholder="عنوان پیام را وارد نمایید" required minlength="3" maxlength="150"
                               class="w-full border border-gray-200 p-2 rounded-md">
                    </div>
                    <div class="my-2">
                        <label class="text-sm text-gray-700 mb-1">انتخاب دپارتمان</label>
                        <select v-model="form.department_id"
                               class="w-full border border-gray-200 p-2 rounded-md">
                            <option v-for="(department, index) in departments" :key="index"
                            :value="department.id">
                                {{department.name}}
                            </option>
                        </select>
                    </div>
                    <div class="my-2">
                        <label class="text-sm text-gray-700 mb-1">اولویت درخواست</label>
                        <select v-model="form.level"
                                class="w-full border border-gray-200 p-2 rounded-md">
                            <option v-for="(level, index) in levels" :key="index"
                                    :value="level.id">
                                {{level.name}}
                            </option>
                        </select>
                    </div>
                    <div class="my-2">
                        <label class="text-sm text-gray-700 mb-1">متن پیام</label>
                        <textarea type="text" v-model="form.description"
                                  rows="5"
                               placeholder="متن پیام را وارد نمایید"
                                  minlength="5" maxlength="250"
                                  class="w-full border border-gray-200 p-2 rounded-md" required></textarea>
                    </div>
                    <div class="w-full">
                        <ValidationErrors :errors="validation_errors" />
                    </div>
                    <div class="my-3 text-center">
                        <button @click="storeRecord" class="px-5 py-3 text-sm rounded-md cursor-pointer bg-black text-gray-100">ارسال پیام</button>
                    </div>
                </div>
            </div>


        </div>

    </AppLayout>
</template>
