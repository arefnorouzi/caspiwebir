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
        title: 'ارسال چک',
        href: '/dashboard/document/check',
    },
];

interface Props {
    invoice: object;
    docs: object;
    banks: object
}
const props = defineProps<Props>()
const form = useForm({
    invoice_id: props.invoice.id,
    bank: '',
    serial: '',
    seri: '',
    shaba: '',
    sayadi: '',
    note: '',
    check_front: '',
    check_back: ''
});

const preview = ref(null)
const uploading = ref(false)

const back_preview = ref(null)
const back_uploading = ref(false)

const validation_errors = ref(null)

async function submitForm() {
    await axios.post('/dashboard/document/check', form)
        .then(res => {
            showToast("چک با موفقیت بارگزاری شد", "success")
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
                showToast("خطا در ثبت چک", "error")
            }
        })
}

const formatDate = (d) =>
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' })

async function handleFileChange(e) {
    const file = e.target.files[0]
    if (!file) return

    uploading.value = true
    const formData = new FormData()
    formData.append('file', file)
    formData.append('folder_name', 'check')

    try {
        const res = await axios.post('/upload', formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        })

        form.check_front = res.data.path   // آدرس در دیتابیس ذخیره میشه
        preview.value = res.data.url // نمایش پیش‌نمایش
    } catch (err) {
        alert('خطا در آپلود تصویر')
    } finally {
        uploading.value = false
    }
}

async function handleCheckImage(e) {
    const file = e.target.files[0]
    if (!file) return

    uploading.value = true
    const formData = new FormData()
    formData.append('file', file)
    formData.append('folder_name', 'check')

    try {
        const res = await axios.post('/upload', formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        })

        form.check_back = res.data.path   // آدرس در دیتابیس ذخیره میشه
        preview.value = res.data.url // نمایش پیش‌نمایش
    } catch (err) {
        alert('خطا در آپلود تصویر')
    } finally {
        uploading.value = false
    }
}

</script>

<template>
    <Head title="ارسال چک" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex flex-wrap mt-2 p-2">

            <div class="lg:w-1/3 md:w-1/1 sm:w-1/1 w-1/1 p-1">

                <div
                    class="card border border-gray-100 rounded-md mb-2 shadow col-span-1">
                    <div class="card-header bg-gray-100 p-2">
                        <h4>شماره فاکتور: {{ invoice?.id }}</h4>
                    </div>
                    <div class="card-body p-2">
                        <p class="mb-4 border border-gray-200 p-2">
                            <span>مبلغ فاکتور: </span> <strong>{{Number(invoice.amount + invoice.interest_amount)}}</strong></p>
                        <p class="mb-4 border border-gray-200 p-2">
                            <span>وضعیت فاکتور: </span> <strong :class="invoice.status.css_class">{{invoice.status.name}}</strong></p>
                        <p class="mb-4 border border-gray-200 p-2">
                            <span>تاریخ: </span>
                            <strong>{{formatDate(invoice.created_at)}}</strong>
                        </p>

                    </div>
                </div>

            </div>

            <div class="lg:w-2/3 md:w-1/1 sm:w-1/1 w-1/1 p-1">

                <div class="card border border-gray-100 rounded-md mb-2 shadow">
                    <div class="card-header bg-gray-100 p-2">
                        <h4>بارگزاری چک صیادی</h4>
                    </div>
                    <div class="card-body px-2 py-4">
                        <div
                            class="grid auto-rows-min gap-3 grid-cols-1 md:grid-cols-3 lg:grid-cols-5 mb-3"
                        >
                            <div class="my-1">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">انتخاب بانک</label>
                                <select class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                        v-model="form.bank"
                                >
                                    <option :value="null">انتخاب بانک</option>
                                    <option v-for="(bank, index) in banks"
                                            :value="bank" :key="index">{{ bank }}</option>

                                </select>
                            </div>
                            <div class="my-1">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">سریال *</label>
                                <input type="text" class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                       v-model="form.serial" required
                                >
                            </div>
                            <div class="my-1">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">سری *</label>
                                <input type="text" class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                       v-model="form.seri" required
                                >
                            </div>

                            <div class="my-1">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">شماره شبا (با IR)</label>
                                <input type="text" minlength="26" maxlength="26" class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                       v-model="form.shaba" required
                                >
                            </div>
                            <div class="my-1">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">شماره صیادی</label>
                                <input type="text"  class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                       v-model="form.sayadi" required
                                >
                            </div>

                            <div class="my-1">
                                <label for="stock" class="text-sm font-bold p-2 block mb-2">توضیحات</label>
                                <textarea rows="2" class="text-sm p-2 border border-gray-200 rounded-md w-full"
                                       v-model="form.note"
                                ></textarea>
                            </div>
                            <div>
                                <label for="product_image" class="text-sm font-medium text-gray-900 block mb-2">تصویر جلو چک</label>
                                <input type="file" @change="handleFileChange" name="image" id="product_image" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                <div v-if="uploading">در حال آپلود...</div>
                            </div>
                            <div v-if="preview">
                                <img :src="preview" class="w-32 h-32 object-cover border rounded" />

                            </div>

                            <div>
                                <label for="product_image" class="text-sm font-medium text-gray-900 block mb-2">تصویر پشت چک</label>
                                <input type="file" @change="handleCheckImage" name="check-image" id="check_image" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                <div v-if="back_uploading">در حال آپلود...</div>
                            </div>
                            <div v-if="back_preview">
                                <img :src="back_preview" class="w-32 h-32 object-cover border rounded" />

                            </div>

                        </div>
                        <div class="my-2">
                            <ValidationErrors :errors="validation_errors" />

                        </div>
                        <div class="my-2 w-full text-center">
                            <button @click="submitForm" class="confirm-btn">ثبت چک</button>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </AppLayout>
</template>

<style scoped>

</style>
