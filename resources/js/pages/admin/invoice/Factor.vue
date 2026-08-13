<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ValidationErrors from '@/components/validation/ValidationErrors.vue';
import { onMounted, ref } from 'vue';
import { showToast } from '@/composables/useToast.js'
import axios from 'axios';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'چاپ فاکتور',
        href: '/dashboard/invoice',
    },
];

interface Props {
    invoice: object;
    shop_setting: object;
}
const props = defineProps<Props>()


const validation_errors = ref(null)


const formatDate = (d) =>
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' })


const printSection = (elementId) => {
    const element = document.getElementById(elementId)
    if (!element) return

    const content = element.outerHTML
    const styles = Array.from(document.querySelectorAll('link[rel="stylesheet"], style'))
        .map((node) => node.outerHTML)
        .join('\n')

    const printWindow = window.open('', '', 'width=1200,height=800')
    if (!printWindow) return

    printWindow.document.write(`
    <html dir="rtl" lang="fa">
      <head>
        <title>چاپ فاکتور</title>
        ${styles}
        <style>
          @page { size: A5 landscape; margin: 0; }
          html, body {
            width: 21cm;
            height: 14.8cm;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: white;
          }
          * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
          }

          th{font-size: 11px;}
          td{font-size: 10px;}
          p{font-size: 11px;}
        </style>
      </head>
      <body>
        ${content}
      </body>
    </html>
  `)

    printWindow.document.close()
    printWindow.focus()
    printWindow.onload = () => {
        printWindow.print()
        printWindow.close()
    }
}

async function updateInvoice() {
    await axios.patch('/admin/invoice/' + props.invoice.id, form)
        .then(res => {
            showToast("فاکتور با موفقیت بروزرسانی شد", "success")
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

        <div class="flex flex-wrap mt-2 p-2">

            <div class="md:w-2/3 sm:w-1/1 w-1/1 p-1">
                <div class="flex justify-center items-start py-2">
                    <!-- فاکتور -->
                    <div
                        id="invoice"
                        class="bg-white text-gray-800 border border-gray-300 shadow-sm w-[21cm] h-[14.8cm] overflow-hidden text-[11px] leading-relaxed"
                    >
                        <!-- هدر -->
                        <div class="flex justify-between items-start px-4 pt-2 pb-1 border-b border-gray-400">
                            <div class="w-1/2">
                                <h1 class="text-base font-bold mb-0.5">{{ shop_setting.name }}</h1>
                                <p>تلفن: {{shop_setting.phone}}</p>
                                <p>ایمیل: {{shop_setting.email}}</p>
                                <p>کد پستی: {{ shop_setting.zip_code }}</p>
                                <p>آدرس: {{ shop_setting.address }}</p>
                            </div>
                            <div class="text-right w-1/2">
                                <h2 class="text-base font-bold mb-0.5">فاکتور فروش</h2>
                                <p>شماره فاکتور: {{ invoice.id }}</p>
                                <p>وضعیت فاکتور:
                                    <span v-if="invoice.payment_status">پرداخت شده</span>
                                    <span v-else>پرداخت نشده</span>

                                </p>
                                <p>تاریخ: {{ formatDate(invoice.created_at) }}</p>
                            </div>
                        </div>

                        <!-- مشتری -->
                        <div class="px-4 py-1.5 border-b border-gray-400">
                            <h3 class="font-semibold mb-1">مشخصات مشتری</h3>
                            <div class="grid grid-cols-2 gap-x-6">
                                <div>
                                    <p>نام: {{ invoice.customer_name }}</p>
                                    <p>شماره تماس: {{ invoice.customer_mobile }}</p>
                                </div>
                                <div>
                                    <p>آدرس: {{invoice.user.address }}</p>
                                    <p>کد پستی: {{ invoice.user.zip_code }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- جدول کالاها -->
                        <div class="px-4 py-1.5">
                            <table class="w-full border-collapse border border-gray-400">
                                <thead class="bg-gray-100 font-semibold">
                                <tr>
                                    <th class="border border-gray-400 p-1 w-10">ردیف</th>
                                    <th class="border border-gray-400 p-1 text-right">محصول</th>
                                    <th class="border border-gray-400 p-1 w-28">قیمت واحد (تومان)</th>
                                    <th class="border border-gray-400 p-1 w-28">تخفیف (تومان)</th>
                                    <th class="border border-gray-400 p-1 w-28">مبلغ کل (تومان)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, i) in invoice.items" :key="item.id">
                                    <td class="border border-gray-400 text-center p-1">{{ i + 1 }}</td>
                                    <td class="border border-gray-400 p-1">{{ item.name }}</td>
                                    <td class="border border-gray-400 text-center p-1">
                                        {{ Number(item.item_price).toLocaleString() }}
                                    </td>
                                    <td class="border border-gray-400 text-center p-1">
                                        {{ Number(item.discount).toLocaleString() }}
                                    </td>
                                    <td class="border border-gray-400 text-center p-1">
                                        {{ Number(item.unit_price).toLocaleString() }}
                                    </td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td class="border border-gray-400 text-center p-1">*</td>
                                    <td colspan="1" class="border border-gray-400 p-1">جمع آیتم ها</td>
                                    <td colspan="3" class="border border-gray-400 text-center p-1">{{ Number(invoice.sub_total).toLocaleString() }} تومان</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-400 text-center p-1">*</td>
                                    <td colspan="1" class="border border-gray-400 p-1">نصب و راه اندازی</td>
                                    <td colspan="3" class="border border-gray-400 text-center p-1">{{ Number(invoice.shipping_cost).toLocaleString() }} تومان</td>
                                </tr>


                                <tr>
                                    <td class="border border-gray-400 text-center p-1">*</td>
                                    <td colspan="1" class="border border-gray-400 p-1">مالیات</td>
                                    <td colspan="3" class="border border-gray-400 text-center p-1">{{ Number(invoice.tax).toLocaleString() }} تومان</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-400 text-center p-1">*</td>
                                    <td colspan="1" class="border border-gray-400 p-1">جمع کل</td>
                                    <td colspan="3" class="border border-gray-400 text-center p-1">{{ Number(invoice.sub_total + invoice.tax + invoice.shipping_cost).toLocaleString() }} تومان</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-400 text-center p-1">*</td>
                                    <td colspan="1" class="border border-gray-400 p-1">تخفیف</td>
                                    <td colspan="3" class="border border-gray-400 text-center p-1">{{ Number(invoice.discount).toLocaleString() }} تومان</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-400 text-center p-1">*</td>
                                    <td colspan="1" class="border border-gray-400 p-1">قابل پرداخت</td>
                                    <td colspan="3" class="border border-gray-400 text-center p-1">{{ Number(invoice.amount).toLocaleString() }} تومان</td>
                                </tr>
                                </tfoot>

                            </table>
                        </div>


                    </div>

                    <div class="mx-auto mt-2 text-center">
                        <button
                            @click="printSection('invoice')"
                            class="ml-3 h-fit bg-indigo-500 text-gray-100 px-4 py-2 rounded cursor-pointer print:hidden"
                        >
                            چاپ فاکتور
                        </button>
                    </div>
                </div>

            </div>

        </div>

    </AppLayout>
</template>

<style scoped>

</style>
