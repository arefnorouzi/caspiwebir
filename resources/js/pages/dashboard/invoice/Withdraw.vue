<script setup lang="ts">
import AppLayout from '@/layouts/DashboardLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ValidationErrors from '@/components/validation/ValidationErrors.vue';
import { onMounted, ref } from 'vue';
import { showToast } from '@/composables/useToast.js'
import axios from 'axios';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'جزئیات فاکتور',
        href: '/dashboard/invoice',
    },
];

interface Props {
    user: object;
    invoice: object;
    wallet: object;
    payment_methods: object;
    shop_setting: object;
}
const props = defineProps<Props>()

const form = useForm({
    payment_method_id: null,
    invoice_id: props.invoice.id,
    uuid: props.invoice.uuid,
});
onMounted(() => {
    // همه‌ی attributesها رو به object واقعی تبدیل کن
    props.payment_methods.forEach((item) => {
        if (item.is_default) {
            form.payment_method_id = item.id
        }
    })
})

const validation_errors = ref(null)


const formatDate = (d) =>
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' })



async function payInvoice() {
    await axios.post('/payment', form)
        .then(res => {
            showToast("درگاه با موفقیت شد", "success")
            window.location.replace(res.data.link)
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
    <Head title="جزئیات فاکتور" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex flex-wrap justify-center mt-2 p-2">

            <div class="lg:w-1/3 md:w-2/3 sm:w-1/1 w-1/1 p-1">
                <div
                    class="card border border-gray-100 rounded-md mb-2 shadow col-span-1">
                    <div class="card-header bg-gray-100 p-2">
                        <h4>نام کاربر: {{ user?.name }}</h4>
                    </div>
                    <div class="card-body p-2">
                        <p class="mb-4 border border-gray-200 p-2">
                            <span>کد ملی: </span> <strong>{{user.national_code}}</strong></p>
                        <p class="mb-4 border border-gray-200 p-2">
                            <span>شماره موبایل: </span> <strong>{{user.mobile}}</strong></p>
                        <p class="mb-4 border border-gray-200 p-2">
                            <span>شماره شبا: </span>
                            <strong>{{invoice.customer_shaba}}</strong>
                        </p>
                        <p class="mb-4 border border-gray-200 p-2">
                            <span>مبلغ: </span>
                            <strong>{{Number(invoice.amount).toLocaleString()}} تومان</strong>
                        </p>

                        <p class="mb-4 border border-gray-200 p-2">
                            <span>وضعیت درخواست: </span>
                            <strong :class="invoice.status.css_class">{{ invoice.status.name }}</strong>
                        </p>

                        <p class="mb-4 border border-gray-200 p-2">
                            <span>تاریخ درخواست: </span> <strong>{{formatDate(invoice.created_at)}}</strong></p>
                        <p class="mb-4 border border-gray-200 p-2">
                            <span>آخرین بروزرسانی: </span> <strong>{{formatDate(invoice.updated_at)}}</strong></p>
                        <p v-if="invoice.purchased_at" class="mb-4 border border-gray-200 p-2">
                            <span>تاریخ پرداخت: </span> <strong>{{formatDate(invoice.purchased_at)}}</strong></p>


                    </div>
                </div>
            </div>


        </div>

    </AppLayout>
</template>

<style scoped>

</style>
