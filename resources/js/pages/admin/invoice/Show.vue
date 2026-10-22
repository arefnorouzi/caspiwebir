<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import {Head, Link, router, useForm} from '@inertiajs/vue3';
import { ref } from 'vue';
import TabContainer from "@/components/admin/TabContainer.vue";
import InvoiceDocumentsTab from "@/components/admin/invoice/InvoiceDocumentsTab.vue";
import InvoiceCheckTab from "@/components/admin/invoice/InvoiceCheckTab.vue";
import InvoiceReviewTab from "@/components/admin/invoice/InvoiceReviewTab.vue";
import InvoiceDetailsTab from "@/components/admin/invoice/InvoiceDetailsTab.vue";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'جزئیات فاکتور',
        href: '/dashboard/invoice',
    },
];

interface Props {
    invoice: object;
    documents: object;
    shop_setting: object;
    statuses: object;
    payment_methods: object;
    shipping_methods: object;
    document_types: object;
    invoice_steps: object;
    status_steps: object;
}
const props = defineProps<Props>()

const form = useForm({
    payment_method_id: props.invoice.payment_method_id,
    invoice_status_id: props.invoice.invoice_status_id,
    payment_status: Number(props.invoice.payment_status),
    payable: Number(props.invoice.payable),
    customer_name: props.invoice.customer_name,
    customer_mobile: props.invoice.customer_mobile,
    customer_note: props.invoice.customer_note,
    confirmed_by_user: Number(props.invoice.confirmed_by_user),
    shipping_method_id: props.invoice.shipping_method_id,
    post_tracking_code: props.invoice.post_tracking_code,
    customer_review: props.invoice.customer_review,
    customer_score: props.invoice.customer_score,
    description: props.invoice.description,
    official_invoice: props.invoice.official_invoice,
    official_invoice_number: props.invoice.official_invoice_number,
});



const formatDate = (d) =>
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' })


async function updateItemStepStatus(invoice_item_id: number, invoice_item_step_id: number){
    if (confirm('از تغییر وضعیت آیتم مطمئنی؟')) {
        router.post('/admin/invoice-item-step/' + props?.invoice?.id, {
            invoice_item_id: invoice_item_id,
            invoice_item_step_id: invoice_item_step_id
        }, {
            preserveScroll: true,
        })
    }
}
//product_stock_deducted
async function product_stock_deducted(invoice_item_id: number){
    if (confirm('از کسر تعداد موجودی انبار مطمئنی؟')) {
        router.put('/admin/product_stock_deducted/' + invoice_item_id, {}, {
            preserveScroll: true,
        })
    }
}

const form_tabs = ref([
    { key: 'details', label: 'جزئیات فاکتور', status: true },
    { key: 'documents', label: 'اسناد', status: true },
    { key: 'bank_check', label: 'شرایط پرداخت' , status: true },
    { key: 'review', label: 'نظر مشتری' , status: true },
])

</script>

<template>
    <Head title="جزئیات فاکتور" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex flex-wrap p-2">

            <div class="lg:w-full p-1">
                <div class="card border border-gray-100 rounded-md shadow-md">
                    <div class="p-2 my-1">
                        <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                            <div>
                                <h3 class="text-lg font-semibold text-indigo-800">جزئیات فاکتور: {{props.invoice.id}}</h3>
                            </div>
                            <div class="ml-3">
                                <Link :href="`/admin/invoice/${invoice.id}/edit`" class="m-1">
                                    <button
                                        class="me-1 cursor-pointer text-blue-600 border border-blue-600 hover:border-indigo-600 focus:ring-4 focus:ring-indigo-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                                             class="w-4 h-4">
                                            <path
                                                d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z">
                                            </path>
                                        </svg>
                                        <span class="ms-1"> ویرایش فاکتور</span>
                                    </button>
                                </Link>
                                <a :href="`/admin/factor/${invoice.id}`" class="m-1" target="_blank">
                                    <button
                                        class="me-1 cursor-pointer text-indigo-500 border border-indigo-500 hover:border-indigo-600 focus:ring-4 focus:ring-indigo-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                                        <svg fill="#000000" width="20px" height="20px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M691.2 410V256H333v154h-77v256h76.8v102h358.4V666H768V410h-76.8zM640 717H384V589h256v128zM384 410V307h256v103H384zm307.2 102c-14.1 0-25.6-11.5-25.6-25.6 0-14.1 11.5-25.6 25.6-25.6 14.1 0 25.6 11.5 25.6 25.6 0 14.1-11.5 25.6-25.6 25.6z"></path></g></svg>
                                        <span class="ms-1"> چاپ فاکتور</span>
                                    </button>
                                </a>
                                <Link :href="`/admin/invoice`">
                                    <button
                                        class="me-1 cursor-pointer text-black bg-white border border-gray-200 hover:border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-md inline-flex items-center px-3 py-2.5 text-center mr-2">
                                        <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20 10L20.7071 10.7071L21.4142 10L20.7071 9.29289L20 10ZM3 18C3 18.5523 3.44772 19 4 19C4.55229 19 5 18.5523 5 18L3 18ZM15.7071 15.7071L20.7071 10.7071L19.2929 9.29289L14.2929 14.2929L15.7071 15.7071ZM20.7071 9.29289L15.7071 4.29289L14.2929 5.70711L19.2929 10.7071L20.7071 9.29289ZM20 9L10 9L10 11L20 11L20 9ZM3 16L3 18L5 18L5 16L3 16ZM10 9C6.13401 9 3 12.134 3 16L5 16C5 13.2386 7.23858 11 10 11L10 9Z" fill="#33363F"></path> </g></svg>

                                        <span class="ms-1">بازگشت</span>
                                    </button>
                                </Link>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 mb-2 ">
                        <p class="bg-orange-200 text-black p-2 rounded-md mb-2">قیمت ها براساس تومان میباشد</p>
                        <table class="w-full text-right table-auto min-w-max mb-5">
                            <thead>
                            <tr>
                                <th class="p-2 border border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        ردیف
                                    </p>
                                </th>


                                <th class="p-2 border border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        محصول
                                    </p>
                                </th>
                                <th class="p-2 border border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        تعداد
                                    </p>
                                </th>
                                <th class="p-2 border border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        قیمت واحد
                                    </p>
                                </th>
                                <th class="p-2 border border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        جمع واحد
                                    </p>
                                </th>
                                <th class="p-2 border border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        تخفیف
                                    </p>
                                </th>
                                <th class="p-2 border border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        جمع
                                    </p>
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, i) in invoice.items" :key="item.id">
                                <td class="p-2 border border-slate-200 py-2">
                                    <p class="block font-semibold text-sm text-blue-800">{{ i + 1 }}</p>

                                </td>

                                <td class="p-2 border border-slate-200 py-2">
                                    <p v-if="item.product_id">
                                        <a :href="`/shop/p/${item?.product_id}`" target="_blank">
                                            {{ item?.name }}
                                        </a>
                                    </p>
                                    <p v-else>{{item?.name}}</p>

                                </td>

                                <td class="p-2 border border-slate-200 py-2">
                                    <p class="text-sm text-slate-500">{{ Number(item.qty).toLocaleString()}}</p>
                                </td>
                                <td class="p-2 border border-slate-200 py-2">
                                    <p class="text-sm text-slate-500">{{ Number(item.item_price).toLocaleString()}}</p>
                                </td>
                                <td class="p-2 border border-slate-200 py-2">
                                    <p class="text-sm text-slate-500">{{ Number(item.item_price * item.qty).toLocaleString()}}</p>
                                </td>
                                <td class="p-2 border border-slate-200 py-2">
                                    <p class="text-sm text-slate-500">{{ Number(item.discount * item.qty).toLocaleString()}}</p>
                                </td>
                                <td class="p-2 border border-slate-200 py-2">
                                    <p class="text-sm text-slate-500">{{ Number(item.unit_price * item.qty).toLocaleString()}}</p>
                                </td>

                            </tr>
                            </tbody>
                            <tfoot>
                            <tr class="text-teal-800">
                                <td class="p-2 border border-slate-200">+</td>
                                <td colspan="2" class="p-2 border border-slate-200 text-xs">جمع سفارش</td>
                                <td colspan="4" class="p-2 border border-slate-200 text-xs">{{Number(invoice.sub_total).toLocaleString()}} تومان</td>
                            </tr>
                            <tr class="text-teal-800">
                                <td class="p-2 border border-slate-200">+</td>
                                <td colspan="2" class="p-2 border border-slate-200 text-xs">مالیات</td>
                                <td colspan="4" class="p-2 border border-slate-200 text-xs">{{Number(invoice.tax).toLocaleString()}} تومان</td>
                            </tr>
                            <tr class="text-teal-800">
                                <td class="p-2 border border-slate-200">+</td>
                                <td colspan="2" class="p-2 border border-slate-200 text-xs">هزینه ارسال</td>
                                <td colspan="4" class="p-2 border border-slate-200 text-xs">{{Number(invoice.shipping_cost).toLocaleString()}} تومان</td>
                            </tr>

                            <tr class="text-red-800">
                                <td class="p-2 border border-slate-200">-</td>
                                <td colspan="2" class="p-2 border border-slate-200 text-xs">تخفیف</td>
                                <td colspan="4" class="p-2 border border-slate-200 text-xs">{{Number(invoice.discount).toLocaleString()}} تومان</td>
                            </tr>
                            <tr class="text-blue-800">
                                <td class="p-2 border border-slate-200">=</td>
                                <td colspan="2" class="p-2 border border-slate-200 font-bold">جمع نهایی <small>(پرداخت نقدی)</small></td>
                                <td colspan="4" class="p-2 border border-slate-200 text-sm">{{Number(invoice.amount).toLocaleString()}} تومان</td>
                            </tr>
                            <tr v-if="invoice.interest_amount" class="text-teal-800">
                                <td class="p-2 border border-slate-200">+</td>
                                <td colspan="2" class="p-2 border border-slate-200 text-xs">کارمزد پرداخت قسطی</td>
                                <td colspan="4" class="p-2 border border-slate-200 text-xs">{{Number(invoice.interest_amount).toLocaleString()}} تومان</td>
                            </tr>
                            <tr v-if="invoice.interest_amount"  class="text-blue-800">
                                <td class="p-2 border border-slate-200">=</td>
                                <td colspan="2" class="p-2 border border-slate-200 font-bold">جمع نهایی <small>(پرداخت قسطی)</small></td>
                                <td colspan="4" class="p-2 border border-slate-200 text-sm">{{Number(invoice.amount + invoice.interest_amount).toLocaleString()}} تومان</td>
                            </tr>
                            </tfoot>
                        </table>

                        <hr class="my-1">

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-1 mt-3">
                            <div class="mb-1 border border-gray-200 p-2">
                                <p class="text-sm">نام مشتری:
                                    <a :href="`/admin/user/${invoice.user_id}`" target="_blank">
                                        {{invoice.customer_name ?? invoice?.user?.name }}</a>
                                </p>
                            </div>
                            <div class="mb-1 border border-gray-200 p-2">
                                <p class="text-sm">شماره تماس:
                                    {{invoice.customer_mobile ?? invoice?.user?.mobile }}
                                </p>
                            </div>

                            <div class="mb-1 border border-gray-200 p-2">
                                <p class="text-sm">تاریخ سفارش:
                                    {{formatDate(invoice.created_at) }}
                                </p>
                            </div>
                            <div class="mb-1 border border-gray-200 p-2">
                                <p class="text-sm">تاریخ پرداخت:
                                    <span v-if="invoice.pusrchased_at">{{formatDate(invoice.purchased_at) }}</span>
                                    <span v-else class="text-red-600">پرداخت نشده</span>
                                </p>
                            </div>

                            <div class="mb-1 border border-gray-200 p-2">
                                <p class="text-xs">استان / شهر:
                                    {{invoice.customer_state }} - {{invoice.customer_city ?? invoice.user.city}}
                                </p>
                            </div>

                            <div class="mb-1 border border-gray-200 p-2">
                                <p class="text-sm">کد پستی:
                                    {{invoice.customer_zip_code ?? invoice.user.zip_code}}
                                </p>
                            </div>
                            <div class="mb-1 border border-gray-200 p-2 col-span-2">
                                <p class="text-xs">آدرس:
                                    {{invoice.customer_address ?? invoice.user.address}}
                                </p>
                            </div>
                            <div class="mb-1 border border-gray-200 p-2 col-span-2">
                                <p class="text-xs">یادداشت مشتری:
                                    {{invoice.customer_note}}
                                </p>
                            </div>
                        </div>


                    </div>

                </div>

            </div>


            <div class="my-2 w-full">
                <TabContainer
                    :tabs="form_tabs"
                >
                    <!-- Slot برای نمایش محتوا -->
                    <template #default="{ activeTab }">

                        <div v-if="activeTab === 'details'">
                            <InvoiceDetailsTab
                                :model="props.invoice"
                                :form="form"
                                :shipping_methods="shipping_methods"
                                :payment_methods="payment_methods"
                                :statuses="statuses"
                            />
                        </div>

                        <div v-if="activeTab === 'documents'">
                            <InvoiceDocumentsTab
                                :model="props.invoice"
                                :documents="props.documents"
                                :document_types="props.document_types"
                            />
                        </div>

                        <div v-if="activeTab === 'bank_check'">
                            <InvoiceCheckTab
                                :model="props.invoice"
                            />
                        </div>


                        <div v-if="activeTab === 'review'">
                            <InvoiceReviewTab
                                :model="props.invoice"
                                :form="form"
                            />
                        </div>

                    </template>
                </TabContainer>
            </div>

<!--            <div class="w-full my-3">-->
<!--                <div class="card shadow-md rounded-md">-->
<!--                    <div class="bg-gray-100 p-2">-->
<!--                        <h4 class="text-sm">سیکل سفارش</h4>-->
<!--                    </div>-->
<!--                    <div class="card-body p-1">-->
<!--                        <div class="grid grid-cols-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-9 gap-3 text-center">-->
<!--                            <div v-for="(invoice_status, inv_st) in status_steps" :key="inv_st"-->
<!--                                 class=" max-w-[100px] justify-between text-right cursor-pointer"-->

<!--                            >-->
<!--                                <div :class="invoice_steps.includes(invoice_status.id) ? 'is_done' : 'is_pending'">-->
<!--                                    <div-->
<!--                                        :class="`${invoice_steps.includes(invoice_status.id) ? 'border-green-700' : 'border-gray-500'} border cycle-icon rounded-full w-[50px] h-[50px] items-center content-center text-center`"-->
<!--                                    >-->
<!--                                        <img :src="invoice_status?.image" class="w-[30px] mx-auto">-->
<!--                                    </div>-->
<!--                                    <div class="cycle-name text-xs mt-1" style="word-break: break-word">{{invoice_status?.name}}</div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->


<!--            </div>-->

        </div>

    </AppLayout>
</template>

<style scoped>
.is_pending{
    opacity: 35%;
    color: #7b7b7b;
}
.is_done{
    color: #05392f;
}

</style>
