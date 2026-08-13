<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import {Head, Link, router, useForm} from '@inertiajs/vue3';
import ValidationErrors from '@/components/validation/ValidationErrors.vue';
import { ref } from 'vue';
import SelectComponent from "@/components/form/SelectComponent.vue";
import InputComponent from "@/components/form/InputComponent.vue";
import FlashMessage from "@/components/FlashMessage.vue";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'جزئیات فاکتور',
        href: '/dashboard/invoice',
    },
];

interface Props {
    invoice: object;
    shop_setting: object;
    statuses: object;
    payment_methods: object;
    shipping_methods: object;
}
const props = defineProps<Props>()

const form = useForm({
    payment_method_id: props.invoice.payment_method_id,
    invoice_status_id: props.invoice.invoice_status_id,
    payment_status: props.invoice.payment_status,
    payable: props.invoice.payable,
    customer_name: props.invoice.customer_name,
    customer_mobile: props.invoice.customer_mobile,
    customer_note: props.invoice.customer_note,
    confirmed_by_user: props.invoice.confirmed_by_user,
    shipping_method_id: props.invoice.shipping_method_id,
    post_tracking_code: props.invoice.post_tracking_code,
});


const validation_errors = ref(null)


const formatDate = (d) =>
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' })


async function updateInvoice() {
    form.patch('/admin/invoice/' + props.invoice.id)
}

</script>

<template>
    <Head title="جزئیات فاکتور" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="my-2 p-2 rounded-md">
            <FlashMessage />
        </div>
        <div class="flex flex-wrap mt-2 p-2">

            <div class="lg:w-2/3 md:w-1/1 sm:w-1/1 w-1/1 p-1">
                <div class="card border border-gray-100 rounded-md shadow-md">
                    <div class="p-2 my-3">
                        <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-800">جزئیات فاکتور</h3>
                            </div>
                            <div class="ml-3">
                                <a :href="`/admin/invoice/${invoice.id}/edit`" class="m-1" target="_blank">
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
                                </a>
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
                    <div class="p-2 mb-3 ">
                        <p class="bg-orange-200 text-black p-2 rounded-md mb-2">قیمت ها براساس تومان میباشد</p>
                        <table class="w-full text-right table-auto min-w-max mb-5 overflow-x-scroll">
                            <thead>
                            <tr>
                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-xs font-normal leading-none text-slate-500">
                                        ردیف
                                    </p>
                                </th>


                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-xs font-normal leading-none text-slate-500">
                                        محصول
                                    </p>
                                </th>

                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-xs font-normal leading-none text-slate-500">
                                        تعداد
                                    </p>
                                </th>
                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-xs font-normal leading-none text-slate-500">
                                        قیمت واحد
                                    </p>
                                </th>
                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-xs font-normal leading-none text-slate-500">
                                        جمع واحد
                                    </p>
                                </th>
                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-xs font-normal leading-none text-slate-500">
                                        تخفیف
                                    </p>
                                </th>
                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-xs font-normal leading-none text-slate-500">
                                        جمع
                                    </p>
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, i) in invoice.items" :key="item.id">
                                <td class="p-2 border-b border-slate-200">
                                    <p class="block font-semibold text-xs text-blue-800">{{ i + 1 }}</p>

                                </td>

                                <td class="p-2 border-b border-slate-200">
                                    <p v-if="item.product_id" class="text-xs">
                                        <a :href="`/shop/product/${item?.product?.slug}`" target="_blank">
                                            {{ item?.name }}
                                        </a>
                                    </p>
                                </td>

                                <td class="p-2 border-b border-slate-200">
                                    <p class="text-xs text-slate-500">{{ Number(item.qty).toLocaleString()}}</p>
                                </td>
                                <td class="p-2 border-b border-slate-200">
                                    <p class="text-xs text-slate-500">{{ Number(item.item_price).toLocaleString()}}</p>
                                </td>
                                <td class="p-2 border-b border-slate-200">
                                    <p class="text-xs text-slate-500">{{ Number(item.item_price * item.qty).toLocaleString()}}</p>
                                </td>
                                <td class="p-2 border-b border-slate-200">
                                    <p class="text-xs text-slate-500">{{ Number(item.discount * item.qty).toLocaleString()}}</p>
                                </td>
                                <td class="p-2 border-b border-slate-200">
                                    <p class="text-xs text-slate-500">{{ Number(item.unit_price * item.qty).toLocaleString()}}</p>
                                </td>
                            </tr>

                            </tbody>
                        </table>

                        <hr class="my-2">

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-1 mt-3">
                            <div class="mb-1 border border-gray-200 p-2">
                                <h3 class="text-xs text-gray-800">جمع آیتم ها: {{Number(invoice.sub_total).toLocaleString()}} تومان</h3>
                            </div>

                            <div class="mb-1 border border-gray-200 p-2">
                                <h3 class="text-xs text-gray-800">هزینه ارسال: {{Number(invoice.shipping_cost).toLocaleString()}} تومان</h3>
                            </div>

                            <div class="mb-1 border border-gray-200 p-2">
                                <h3 class="text-xs text-gray-800">مالیات: {{Number(invoice.tax).toLocaleString()}} تومان</h3>
                            </div>

                            <div class="mb-1 border border-gray-200 p-2">
                                <h3 class="text-xs text-rose-800">تخفیف: {{Number(invoice.discount).toLocaleString()}} تومان</h3>
                            </div>

                            <div class="mb-1 border border-gray-200 p-2">
                                <h3 class="text-xs text-green-800">مبلغ قابل پرداخت: {{Number(invoice.amount).toLocaleString()}} تومان</h3>
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


            <div class="lg:w-1/3 md:w-1/1 sm:w-1/1 w-1/1 p-1">
                <div class="card border border-gray-100 rounded-md mb-2 shadow">
                    <div class="card-header bg-gray-100 p-2">
                        <h4>بروزرسانی فاکتور</h4>
                    </div>
                    <div class="card-body px-1 py-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-1 mt-3">
                            <div class="mb-1 border border-gray-200 p-2">
                                <InputComponent v-model="form.customer_name"
                                                :value="form.customer_name"
                                                label="نام مشتری"
                                                id="customer_name"
                                                placeholder="مهراد شاهرخی"
                                                :input_error="form?.errors?.customer_name"
                                />
                            </div>
                            <div class="mb-1 border border-gray-200 p-2">
                                <InputComponent v-model="form.customer_mobile"
                                                :value="form.customer_mobile"
                                                label="شماره تماس مشتری"
                                                id="customer_mobile"
                                                placeholder="09123456789"
                                                :input_error="form?.errors?.customer_mobile"
                                                css_class="ltr"
                                />
                            </div>
                            <div class="mb-1 border border-gray-200 p-2">
                                <SelectComponent label="امکان پرداخت"
                                                 :value="form.payable"
                                                 id="brand" v-model="form.payable"
                                                 :input_error="form?.errors?.payable"
                                                 :options="[{id: 0, name: 'غیرفعال'}, {id: 1, name: 'فعال'}]"
                                />
                            </div>
                            <div class="mb-1 border border-gray-200 p-2">
                                <SelectComponent label="وضعیت پرداخت"
                                                 :value="form.payment_status"
                                                 id="brand" v-model="form.payment_status"
                                                 :input_error="form?.errors?.payment_status"
                                                 :options="[{id: 0, name: 'در انتظار پرداخت'}, {id: 1, name: 'پرداخت شده'}]"
                                />
                            </div>
                            <div class="mb-1 border border-gray-200 p-2">
                                <SelectComponent label="تایید توسط مشتری"
                                                 :value="form.confirmed_by_user"
                                                 id="brand" v-model="form.confirmed_by_user"
                                                 :input_error="form?.errors?.confirmed_by_user"
                                                 :options="[{id: 0, name: 'تایید نشده'}, {id: 1, name: 'تایید شده'}]"
                                />
                            </div>
                            <div class="mb-1 border border-gray-200 p-2">
                                <SelectComponent label="وضعیت فاکتور"
                                                 :value="form.invoice_status_id"
                                                 id="brand" v-model="form.invoice_status_id"
                                                 :input_error="form?.errors?.invoice_status_id"
                                                 :options="statuses"
                                />
                            </div>

                            <div class="mb-1 border border-gray-200 p-2">
                                <SelectComponent label="انتخاب روش ارسال"
                                                 :value="form.shipping_method_id"
                                                 id="brand" v-model="form.shipping_method_id"
                                                 :input_error="form?.errors?.shipping_method_id"
                                                 :options="shipping_methods"
                                />
                            </div>
                            <div class="mb-1 border border-gray-200 p-2">
                                <SelectComponent label="انتخاب روش پرداخت"
                                                 :value="form.payment_method_id"
                                                 id="brand" v-model="form.payment_method_id"
                                                 :input_error="form?.errors?.payment_method_id"
                                                 :options="payment_methods"
                                />
                            </div>
                            <div class="mb-1 border border-gray-200 p-2 col-span-2">
                                <InputComponent v-model="form.post_tracking_code"
                                                :value="form.post_tracking_code"
                                                label="بارکد بسته پستی"
                                                id="post_tracking_code"
                                                placeholder="123456"
                                                :input_error="form?.errors?.post_tracking_code"
                                                css_class="ltr"
                                />
                            </div>
                            <div class="mb-1 border border-gray-200 p-2 col-span-2">
                                <label for="product-name" class="text-xs font-medium text-gray-900 block mb-2">یادداشت مشتری</label>
                                <textarea rows="3" v-model="form.customer_note" class="border border-gray-300 p-2 rounded-md w-full text-xs" placeholder="یادداشت مشتری"></textarea>
                            </div>



                            <div class="my-1">
                                <ValidationErrors :errors="validation_errors" />

                            </div>
                            <div v-if="form.payment_method_id != 4" class="my-1 text-center">
                                <button @click="updateInvoice" class="confirm-btn">بروزرسانی فاکتور</button>
                            </div>
                        </div>



                    </div>
                </div>
            </div>

        </div>

    </AppLayout>
</template>

<style scoped>

</style>
