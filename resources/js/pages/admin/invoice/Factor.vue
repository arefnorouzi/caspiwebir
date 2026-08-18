<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'جزئیات فاکتور',
        href: '/dashboard/invoice',
    },
];

interface Props {
    invoice: object;
    shop_setting: object;
}
const props = defineProps<Props>()



const formatDate = (d) =>
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'numeric', day: 'numeric' })


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

          /*th{font-size: 11px;}*/
          /*td{font-size: 10px;}*/
          /*p{font-size: 11px;}*/
          /* کاهش فونت و فاصله‌ها */
      th { font-size: 8px; padding: 2px !important; }
      td { font-size: 7px; padding: 2px !important; }
      p { font-size: 8px; margin: 1px 0; }
      .border, .border-gray-800, .border-gray-400 { border-width: 0.5px !important; }
      .p-1 { padding: 2px !important; }
      .px-4 { padding-left: 5px !important; padding-right: 5px !important; }
      .py-2 { padding-top: 1px !important; padding-bottom: 2px !important; }
      .pt-2 { padding-top: 1px !important; }
      .pb-1 { padding-bottom: 1px !important; }
      .mt-1 { margin-top: 1px !important; }
      .mb-1 { margin-bottom: 1px !important; }
      .text-base { font-size: 10px !important; }

      /* فشرده‌تر کردن هدر و فوتر */
      .grid { gap: 0 !important; }
      #invoice > div:first-child { padding-top: 2px !important; padding-bottom: 2px !important; }
      #invoice > div:nth-child(2) { padding-top: 2px !important; padding-bottom: 2px !important; }
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
                        <div class="flex flex-wrap justify-between items-center pt-2 px-4">
                            <div>
                                <div class="border border-gray-800 rounded-md bg-gray-100 p-1 mb-1">
                                    <strong>{{ shop_setting.site_domain }}</strong>
                                </div>
                            </div>
                            <div>
                                <h3 style="font-size: 16px; font-weight: bold">پیش فاکتور</h3>
                            </div>
                            <div>
                                <img :src="shop_setting.factor_logo" style="max-width: 70px">
                            </div>
                        </div>
                        <!-- هدر -->
                        <div class="flex flex-wrap justify-between px-4 pt-2 pb-1 border-b border-gray-400">
                            <div class="w-full border border-gray-800 rounded-md p-1.5 mb-1">
                                <div class="grid grid-cols-5 gap-2 text-center">
                                    <div>
                                        <span>شماره سفارش: {{invoice.id}}</span>
                                    </div>
                                    <div>
                                        <span>وضعیت:
                                            <span v-if="invoice.payment_status">پرداخت شده</span>
                                            <span v-else>پرداخت نشده</span>
                                        </span>
                                    </div>
                                    <div>
                                        <span>پرداخت: {{invoice?.payment_method?.name}}</span>
                                    </div>
                                    <div>
                                        <span>روش ارسال: {{invoice?.shipping_method?.name}}</span>
                                    </div>
                                    <div>
                                        <span>تاریخ: {{formatDate(invoice.created_at)}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="w-[48%] border border-gray-800 rounded-md p-1">
                                <h4 class="text-sm font-bold mb-0.5">فروشنده: {{shop_setting.name}}</h4>
                                <p>تلفن: {{shop_setting.phone}}
                                 | ایمیل: {{shop_setting.email}}
                                </p>
                                <p>کد پستی: {{ shop_setting.zip_code }}</p>
                                <p>آدرس: {{ shop_setting.address }}</p>
                            </div>
                            <div class="text-right border border-gray-800 w-[48%] p-1 rounded-md">
                                <h4 class="text-sm font-bold mb-0.5">خریدار: {{ invoice.customer_name }}</h4>
                                <p>
                                  شناسه ملی: {{ invoice?.user?.national_code }}
                                 | تلفن: {{ invoice?.customer_mobile }}
                                </p>
                                <p>کد پستی: {{ invoice.customer_zip_code }}</p>
                                <p>آدرس:
                                    ({{invoice.customer_state}} - {{invoice.customer_city ?? invoice?.user?.city}})
                                    {{ invoice.customer_address }}</p>

                            </div>
                        </div>

                        <!-- جدول کالاها -->
                        <div class="px-4 py-1.5">
                            <table class="w-full border-collapse border border-gray-300 text-right" id="items-table">
                                <thead class="bg-gray-100 font-semibold">
                                <tr>
                                    <th class="border border-gray-500 p-1 w-10">ردیف</th>
                                    <th class="border border-gray-400 p-1 text-right">محصول</th>
                                    <th class="border border-gray-400 p-1 text-right">تعداد</th>
                                    <th class="border border-gray-400 p-1 w-28">قیمت واحد</th>
                                    <th class="border border-gray-400 p-1 w-28">تخفیف</th>
                                    <th class="border border-gray-400 p-1 w-28">مبلغ کل</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, i) in invoice.items" :key="item.id"
                                    class="border border-gray-200">
                                    <td class="border border-gray-200 text-center p-1">{{ i + 1 }}</td>
                                    <td class="border border-gray-400 p-1">{{ item.name }}</td>
                                    <td class="border border-gray-400 p-1">{{ item.qty }}</td>
                                    <td class="border border-gray-400 p-1">
                                        {{ Number(item.item_price).toLocaleString() }}
                                    </td>
                                    <td class="border border-gray-400 p-1">
                                        {{ Number(item.discount * item.qty).toLocaleString() }}
                                    </td>
                                    <td class="border border-gray-400 p-1">
                                        {{ Number(item.unit_price * item.qty).toLocaleString() }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>

                        <div class="flex flex-wrap justify-between px-4">
                            <div class="text-right border border-gray-800 w-[30%] mt-1 p-1 rounded-md">
                                <p>جمع پیش فاکتور:
                                    {{ Number(invoice.sub_total).toLocaleString() }} تومان</p>
                                <p>هزینه ارسال:
                                    {{ Number(invoice.shipping_cost).toLocaleString() }} تومان</p>
                                <p>مالیات:
                                    {{ Number(invoice.tax).toLocaleString() }} تومان</p>
                                <p>تخفیف:
                                    {{Number(invoice.discount).toLocaleString()}} تومان</p>
                                <p class="font-bold">قابل پرداخت:
                                    {{ Number(invoice.amount).toLocaleString() }} تومان</p>

                            </div>
                            <div class="text-right border border-gray-800 w-[65%] mt-1 p-1 rounded-md flex flex-wrap justify-around items-center">
                                <div>
                                    <span>امضا و تایید فروشنده</span>
                                </div>
                                <div>
                                    <span>امضا و تایید مشتری</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mx-auto mt-2 text-center">
                        <button
                            @click="printSection('invoice')"
                            class="ml-3 h-fit text-sm bg-indigo-500 text-gray-100 px-4 py-2 rounded cursor-pointer print:hidden"
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
#items-table tr{
    border: 1px solid #7b7b7b;
}
#items-table td{
    border: 1px solid #7b7b7b;
}

</style>
