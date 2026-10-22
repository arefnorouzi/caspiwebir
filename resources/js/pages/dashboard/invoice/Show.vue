<script setup lang="ts">
import AppLayout from '@/layouts/DashboardLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ValidationErrors from '@/components/validation/ValidationErrors.vue';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import SelectComponent from "@/components/form/SelectComponent.vue";
import TextareaComponent from "@/components/form/TextareaComponent.vue";
import InputComponent from "@/components/form/InputComponent.vue";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'جزئیات فاکتور',
        href: '/dashboard/invoice',
    },
];

interface Props {
    user: object;
    invoice: object;
    payment_methods: object;
    shop_setting: object;
    documents: object;
    check_method: object;
    banks: object;
    checks: object;
    check_amount: number,
    ctc_method: object
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
const payment_description = ref('')
const interest = ref(0)


const formatDate = (d) =>
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' })

const check_form = useForm({
    invoice_id: props.invoice.id,
    check_count: 1,
    check_request: null,
});
const upload_check_form = useForm({
    invoice_id: props.invoice.id,
    bank_id: 1,
    serial: '',
    seri: '',
    sheba: 'IR',
    sayadi: '',
    note: '',
    check_front: '',
    check_back: ''
});

const receipt_form = useForm({
    invoice_id: props.invoice.id,
    note: '',
    image: null,
});
async function store_receipt(){
    receipt_form.post('/dashboard/document/receipt',{
        onSuccess(){
            receipt_form.reset()
        }
    })
}

async function store_check(){
    upload_check_form.post('/dashboard/document/check',{
        onSuccess(){
            upload_check_form.reset()
        }
    })
}

async function handleReceiptFileChange(e) {
    const file = e.target.files[0]
    if (!file) return
    const formData = new FormData()
    formData.append('file', file)
    formData.append('folder_name', 'receipt')
    try {
        const res = await axios.post('/upload', formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        })

        receipt_form.image = res.data.path   // آدرس در دیتابیس ذخیره میشه
        await store_receipt()
    } catch (err) {
        alert('خطا در آپلود تصویر')
    }
}

async function handleCheckFront(e) {
    const file = e.target.files[0]
    if (!file) return
    const formData = new FormData()
    formData.append('file', file)
    formData.append('folder_name', 'checks')
    try {
        const res = await axios.post('/upload', formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        })

        upload_check_form.check_front = res.data.path   // آدرس در دیتابیس ذخیره میشه
    } catch (err) {
        alert('خطا در آپلود تصویر')
    }
}

async function handleCheckBackend(e) {
    const file = e.target.files[0]
    if (!file) return
    const formData = new FormData()
    formData.append('file', file)
    formData.append('folder_name', 'checks')
    try {
        const res = await axios.post('/upload', formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        })

        upload_check_form.check_back = res.data.path   // آدرس در دیتابیس ذخیره میشه
    } catch (err) {
        alert('خطا در آپلود تصویر')
    }
}

async function click_file_input(input_id: string)
{
   document.getElementById(input_id).click()
}

</script>

<template>
    <Head title="جزئیات فاکتور" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex flex-wrap p-2">

            <div class="w-full p-1">
                <div class="card border border-gray-100 rounded-md shadow-md">
                    <div class="mb-2 flex flex-wrap justify-between">
                        <div class="p-2 my-1">
                            <h2 class="text-lg text-indigo-600">جزئیات سفارش: {{props.invoice.id}}</h2>
                        </div>
                        <div class="p-2 my-1">
                            <a target="_blank" class="py-2 px-3 border border-indigo-600 text-indigo-600 rounded-md shadow-md"
                               :href="`/dashboard/factor/${props.invoice.id}`">
                                <span>مشاهده و چاپ پیش فاکتور</span>
                            </a>
                        </div>
                    </div>
                    <!-- جدول کالاها -->


                    <div class="p-2 my-3 overflow-x-scroll">
                        <p>* مبالغ به تومان میباشد</p>
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

                    </div>

                </div>

            </div>

            <div v-if="!invoice.payment_status" class="lg:w-1/3 w-full p-1 my-2">
                <div class="card border border-gray-100 rounded-md mb-2 shadow">
                    <div class="card-header bg-gray-100 p-2">
                        <h4>روش های پرداخت</h4>
                    </div>
                    <div class="card-body px-2 py-4">

                        <div class="mb-4 border border-gray-200 p-2">
                            <h3 class="text-sm font-bold text-blue-800 mb-2">مبلغ قابل پرداخت <small>(نقدی)</small>: {{Number(invoice.amount).toLocaleString()}} تومان</h3>
                            <h3 class="text-sm font-bold text-blue-800">مبلغ قابل پرداخت <small>(قسطی)</small>: {{Number(invoice.amount + invoice.interest_amount).toLocaleString()}} تومان</h3>
                        </div>


                        <div class="mb-3 mt-5 grid grid-cols-2 md:grid-cols-2 sm:grid-cols-2 gap-2 w-full">
                            <a v-for="payment_method in payment_methods"
                               :href="`/payment/${payment_method.code}/pay/${props.invoice.id}`"
                                  :key="payment_method.id">
                                <div class="w-full hover:bg-gray-100 text-center border border-teal-700 text-teal-800 rounded-md p-3 mb-1 shadow-md"
                                   >
                                    <div class="payment-icon text-center mb-2">
                                        <img :src="payment_method.image" style="width: 30px; height: 30px; margin: auto">
                                    </div>
                                    <p>پرداخت با
                                        {{payment_method.name}}</p>
                                </div>

                            </a>
                        </div>

                    </div>
                </div>
            </div>

            <div v-if="props.documents.length" class="lg:w-1/3 w-full p-1 my-2">
                <div class="card border border-gray-100 rounded-md mb-2 shadow">
                    <div class="card-header bg-gray-100 p-2">
                        <h4>اسناد</h4>
                    </div>
                    <div class="card-body px-2 py-4">

                        <div v-for="(doc, _d) in props.documents"
                             :key="_d"
                             class="mb-4 border border-gray-200 flex flex-wrap justify-between p-2">
                            <div class="text-sm font-bold text-gray-800">
                                <h5 class="text-sm">{{doc.name}}</h5>
                            </div>
                            <div class="text-sm">
                                <a :href="`/dashboard/download-document/${doc.id}`"
                                   target="_blank"
                                   class="p-2 rounded-md bg-blue-500 text-white">دانلود</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div v-if="!props.invoice.payment_status" class="lg:w-1/3 md:w-1/1 sm:w-1/1 w-1/1 p-1 my-2">
                <div class="card border border-gray-100 rounded-md mb-2 shadow">
                    <div class="card-header bg-gray-100 p-2">
                        <h4>بارگزاری فیش واریز</h4>
                    </div>
                    <div class="card-body px-2 py-4">
                        <div v-if="ctc_method" class="p-2 border border-indigo-500 rounded-md"
                             v-html="ctc_method.description">
                        </div>
                        <p class="mb-2 p-2 rounded-md bg-orange-200">کاربر عزیز چنانچه پرداخت شما از طریق کارت به کارت، حواله پایا، ساتنا، پل و دیگر موارد مشابه بوده، میتوانید برگه فیش یا رسید واریز را در اینجا بارگزاری نمایید.</p>
                        <p class="mb-2 p-2 rounded-md bg-orange-200">پس از بارگزاری فیش، نیاز به تایید امور مالی میباشد.</p>
                        <p class="mb-2 p-2 rounded-md bg-orange-200">حجم فایل زیر 2 مگابایت باشد.</p>

                        <input type="file" id="receiptFile" style="visibility: hidden"
                               accept=".jpg, .jpeg, .png"
                               @change="handleReceiptFileChange">

                        <button @click="click_file_input('receiptFile')"
                            class="cursor-pointer border bg-blue-700 text-gray-100 rounded-md py-2 px-3 m-1">بارگزاری فیش واریز
                        </button>
                    </div>
                </div>
            </div>

            <div v-if="!props.invoice.payment_status && check_method && props.invoice.check_count === 0" class="lg:w-1/3 md:w-1/1 sm:w-1/1 w-1/1 p-1 my-2">
                <div class="card border border-gray-100 rounded-md mb-2 shadow">
                    <div class="card-header bg-gray-100 p-2">
                        <h4>پرداخت با چک صیادی</h4>
                    </div>
                    <div class="card-body px-2 py-4">
                        <p class="mb-2 p-2 rounded-md bg-orange-200">لطفا قبل از ثبت چک با مدیریت سایت هماهنگ نمایید.</p>
                        <p class="mb-2 p-2 rounded-md bg-orange-200">کارمزد پرداخت چکی به ازای هر ماه
                        <strong>{{check_method?.interest_rate}}%</strong> میباشد که به مبلغ فاکتور افزوده میشود.
                        </p>
                        <p class="mb-2 p-2 rounded-md bg-orange-200">پرداخت حداکثر در 3 فقره چک و بصورت 3 ماه متوالی خواهد بود.</p>
                        <p class="mb-4 p-2 rounded-md bg-orange-200">درخواست ثبت چک را ثبت نمایید</p>

                        <div class="my-4">
                            <SelectComponent
                                label="تعداد چک"
                                id="check_count"
                                :value="check_form.check_count"
                                v-model="check_form.check_count"
                                :options="[{id: 1, name: '1 فقره چک'},{id:2, name: '2 فقره چک'}, {id:3, name: '3 فقره چک'}]" />
                        </div>
                        <div class="mb-2">
                            <TextareaComponent
                                label="متن درخواست"
                                id="check_request"
                                placeholder="متن پیام شما در مورد شرایط پرداخت چکی"
                                v-model="check_form.check_request" />
                        </div>
                        <div class="mb-2">
                            <button
                                    class="cursor-pointer pay-btn">ثبت درخواست
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="!props.invoice.payment_status && checks && check_method && props.invoice.check_count >= 0" class="lg:w-1/2 md:w-1/1 sm:w-1/1 w-1/1 p-1 my-2">
                <div class="card border border-gray-100 rounded-md mb-2 shadow">
                    <div class="card-header bg-gray-100 p-2">
                        <h4>ثبت چک صیادی</h4>
                    </div>
                    <div class="card-body px-2 py-4">

                        <p class="mb-2 p-2 rounded-md bg-orange-200">پس از بارگزاری چک، نیاز به تایید امور مالی میباشد.</p>
                        <p class="mb-2 p-2 rounded-md bg-orange-200">لطفا تصویر پشت و رو چک در بخش زیر بارگزاری نمایید.لطفا اطلاعات شناسه صیادی و سریال و ... را به درستی وارد نمایید.</p>
                        <p class="mb-2 p-2 rounded-md bg-orange-200">حجم فایل زیر 2 مگابایت باشد.</p>
                        <p class="mb-2 p-2 rounded-md bg-orange-200">کارمزد پرداخت چکی به ازای هر ماه
                            <strong>{{check_method?.interest_rate}}%</strong> میباشد که به مبلغ فاکتور افزوده میشود.
                        </p>
                        <p class="mb-2 p-2 rounded-md border border-indigo-300 font-bold text-indigo-700">
                            مبلغ فاکتور:
                            {{Number(props.invoice.amount).toLocaleString()}} تومان
                        </p>
                        <p class="mb-2 p-2 rounded-md border border-indigo-300 font-bold text-indigo-700">
                            مبلغ سود پرداخت چکی:
                            {{Number(props.invoice.interest_amount).toLocaleString()}} تومان
                        </p>
                        <p class="mb-2 p-2 rounded-md border border-indigo-300 font-bold text-indigo-700">
                            مبلغ فاکتور برای پرداخت بصورت چک:
                            {{Number(check_amount * props.invoice.check_count).toLocaleString()}} تومان
                        </p>
                        <p class="mb-2 p-2 rounded-md border border-indigo-300 font-bold text-indigo-700">
                            مبلغ هر چک:
                            {{Number(check_amount).toLocaleString()}} تومان
                        </p>


                        <div class="my-1">
                            <input type="file" id="checkFront" style="visibility: hidden"
                                   accept=".jpg, .jpeg, .png"
                                   @change="handleCheckFront"
                            >
                            <input type="file" id="checkBackend" style="visibility: hidden"
                                   accept=".jpg, .jpeg, .png"
                                   @change="handleCheckBackend"
                            >
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <div class="my-2">
                                <SelectComponent
                                    label="انتخاب بانک"
                                    id="bank"
                                    :value="upload_check_form.bank_id"
                                    v-model="check_form.bank_id"
                                    :options="props.banks" />

                            </div>
                            <div class="my-2">
                                <InputComponent
                                    label="سری چک *"
                                    :value="upload_check_form.seri"
                                    id="check_seri" v-model="upload_check_form.seri"
                                    css_class="ltr"
                                />
                            </div>
                            <div class="my-2">
                                <InputComponent
                                    label="سریال چک *"
                                    :value="upload_check_form.serial"
                                    id="serial" v-model="upload_check_form.serial"
                                    css_class="ltr"
                                />
                            </div>
                            <div class="my-2">
                                <InputComponent
                                    label="شناسه صیادی *"
                                    :value="upload_check_form.sayadi"
                                    id="serial" v-model="upload_check_form.sayadi"
                                    css_class="ltr"
                                />
                            </div>
                        </div>

                        <div class="my-2">
                            <InputComponent
                                label="شماره شبا (با IR) *"
                                id="sheba" v-model="upload_check_form.sheba"
                                :value="upload_check_form.sheba"
                                css_class="ltr"
                            />
                        </div>
                        <div class="my-2">
                            <TextareaComponent
                                label="متن یادداشت"
                                id="check_note"
                                placeholder="متن یادداشت در مورد چک"
                                :value="upload_check_form.note"
                                v-model="upload_check_form.note" />
                        </div>
                        <p class="mb-2 p-2 rounded-md text-indigo-500">با لمس یا کلیک روی کادر آبی رنگ زیر، حالت انتخاب تصویر فعال میشود.</p>

                        <div class="my-5 grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <div v-if="!upload_check_form.check_front"
                                @click="click_file_input('checkFront')"
                                class="p-10 cursor-pointer bg-blue-100 text-blue-700 rounded-md content-center items-center text-center">
                                <div class="font-bold">انتخاب تصویر جلو چک</div>
                                <div class="content-center items-center">
                                    <svg width="64px" height="64px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M771.676772 844.966484l-493.818868-2.409202C155.877326 826.595933 63.123554 722.814917 63.123554 597.698178c0-130.716368 102.592286-238.521254 231.509687-246.711313 49.19257-103.481018 153.09031-169.576911 268.529285-169.576911 163.496056 0 296.588862 132.64332 297.338346 295.968388 60.968276 35.243157 98.267394 99.284112 98.267394 170.402163 0 97.314157-71.032044 179.008943-165.167037 194.371318l-21.924457 2.814661z m-459.914953-43.849937l458.661718-0.48225c81.031308-4.62489 144.493769-71.770266 144.493768-152.854816 0-59.084327-33.145216-111.895308-86.501928-137.82418l-12.921432-6.284608 0.888732-19.292047c0.127986-1.87371 0.267234-3.736158 0.267234-5.63137 0-139.772633-113.715776-253.488409-253.488409-253.488409-102.463276 0-194.264834 61.086022-233.875886 155.627498l-5.598605 13.370918-14.495144 0.086007c-111.499064 0.653239-202.219399 91.876302-202.2194 203.353864 0 108.704881 85.142208 197.830003 193.825588 202.904379l10.963764 0.515014z" fill="#22C67F"></path><path d="M532.875998 390.961396L370.321916 553.516502l34.921657 34.921657 102.935287-102.935287V711.5317h49.385061V485.502872l102.934263 102.935287 34.93292-34.921657z" fill="#74E8AE"></path></g></svg>

                                </div>
                            </div>
                            <div v-else
                                 class="p-10 cursor-pointer bg-blue-100 text-blue-700 rounded-md content-center items-center text-center">
                                <img :src="upload_check_form.check_front" style="width: 100%; height: 100%">
                                <button
                                    @click="upload_check_form.check_front = ''"
                                    class="p-2 text-xs bg-red-500 text-white rounded-md">حذف</button>
                            </div>
                            <div v-if="!upload_check_form.check_back"
                                @click="click_file_input('checkBackend')"
                                class="p-10 cursor-pointer bg-blue-100 text-blue-700 rounded-md content-center items-center text-center">
                                <div class="font-bold">انتخاب تصویر پشت چک</div>
                                <div class="content-center items-center">
                                    <svg width="64px" height="64px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M771.676772 844.966484l-493.818868-2.409202C155.877326 826.595933 63.123554 722.814917 63.123554 597.698178c0-130.716368 102.592286-238.521254 231.509687-246.711313 49.19257-103.481018 153.09031-169.576911 268.529285-169.576911 163.496056 0 296.588862 132.64332 297.338346 295.968388 60.968276 35.243157 98.267394 99.284112 98.267394 170.402163 0 97.314157-71.032044 179.008943-165.167037 194.371318l-21.924457 2.814661z m-459.914953-43.849937l458.661718-0.48225c81.031308-4.62489 144.493769-71.770266 144.493768-152.854816 0-59.084327-33.145216-111.895308-86.501928-137.82418l-12.921432-6.284608 0.888732-19.292047c0.127986-1.87371 0.267234-3.736158 0.267234-5.63137 0-139.772633-113.715776-253.488409-253.488409-253.488409-102.463276 0-194.264834 61.086022-233.875886 155.627498l-5.598605 13.370918-14.495144 0.086007c-111.499064 0.653239-202.219399 91.876302-202.2194 203.353864 0 108.704881 85.142208 197.830003 193.825588 202.904379l10.963764 0.515014z" fill="#22C67F"></path><path d="M532.875998 390.961396L370.321916 553.516502l34.921657 34.921657 102.935287-102.935287V711.5317h49.385061V485.502872l102.934263 102.935287 34.93292-34.921657z" fill="#74E8AE"></path></g></svg>

                                </div>
                            </div>
                            <div v-else
                                 class="p-10 cursor-pointer bg-blue-100 text-blue-700 rounded-md content-center items-center text-center">
                                <img :src="upload_check_form.check_back" style="width: 100%; height: 100%">
                                <button @click="upload_check_form.check_back = ''"
                                    class="p-2 text-xs bg-red-500 text-white rounded-md">حذف</button>

                            </div>
                        </div>

                        <div class="mb-2">
                            <button @click="store_check" class="pay-btn">ثبت چک</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </AppLayout>
</template>

<style scoped>

.is_pending{
    opacity: 25%;
}

</style>
