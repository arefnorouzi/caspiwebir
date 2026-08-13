<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import axios from 'axios';
import _ from "lodash";
import FlashMessage from "@/components/FlashMessage.vue";
import InputComponent from "@/components/form/InputComponent.vue";
import SelectComponent from "@/components/form/SelectComponent.vue";


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'ویرایش فاکتور',
        href: '/dashboard/invoice',
    },
];

interface Props {
    invoice: object;
    shop_setting: object;
    statuses: object;
    payment_methods: object;
    invoice_item_statuses: object;
    role_id: number;
}
const props = defineProps<Props>()

const form_item = useForm({
    product_id: null,
    invoice_item_status_id: 1,
    unit_price: 0,
    item_price: 0,
    qty: 1,
    name: '',
    description: null,
    invoice_id: props.invoice.id,
});

const search = ref('')
const products = ref([])
const loading = ref(false)

const fetchUsers = _.debounce(async () => {
    if (!search.value || search.value.length < 2) {
        products.value = []
        return
    }

    loading.value = true
    const { data } = await axios.get("/admin/products-search",
        { params: { search: search.value, role_id: props.role_id } }
    )
    products.value = data
    loading.value = false
}, 700)

watch(search, fetchUsers)
watch(
    () => form_item.product_id,
    (newProductId) => {
        const product = products.value.find(p => p.id === newProductId)

        if (!product) return

        form_item.name = product.name
        form_item.item_price = product.price
        form_item.unit_price = product.offer_price ?? product.price
    }
)

const formatDate = (d) =>
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' })

async function addItem(){
    form_item.post('/admin/add-invoice-item/' + props?.invoice?.id)
}

async function increaseQty(item_id: number) {
    if (confirm('از افزایش تعداد ردیف مطمئنی؟')) {
        router.put('/admin/invoice-item-increase/' + item_id, {}, {
            preserveScroll: true,
        })
    }
}

async function decreaseQty(item_id: number) {
    if (confirm('از افزایش تعداد ردیف مطمئنی؟')) {
        router.put('/admin/invoice-item-decrease/' + item_id, {}, {
            preserveScroll: true,
        })
    }
}

async function deleteItem(item_id: number) {
    if (confirm('از حذف ردیف مطمئنی؟')) {
        router.delete('/admin/invoice-item/' + item_id,{
            preserveScroll: true,
        })
    }
}
async function changeItemStatus(item: object) {
    router.patch('/admin/invoice-item-status/' + item.id, {
        invoice_item_status_id: item.invoice_item_status_id
    })
}

</script>

<template>
    <Head title="ویرایش فاکتور" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="">
            <FlashMessage />
        </div>
        <div class="flex flex-wrap mt-2 p-2">
            <div class="lg:w-1/4 md:w-1/4 sm:w-1/1 w-1/1 p-1">
                <div class="card border border-gray-100 rounded-md mb-2 shadow">
                    <div class="card-header bg-gray-100 p-2">
                        <h4>افزودن ردیف</h4>
                    </div>
                    <div class="card-body px-2 py-4">
                        <div class="relative my-5">
                            <input
                                v-model="search"
                                type="text"
                                placeholder="جستجوی محصول (نام یا شناسه)"
                                class="input w-[250px] border border-gray-300 rounded-md p-2"
                            />

                            <p v-if="loading" class="text-xs">در حال جستجو...</p>
                        </div>
                        <div class="mb-1 border border-gray-200 p-2">
                            <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">انتخاب محصول
                                <span v-if="loading">(لیست بروز شد)</span></label>
                            <select v-model="form_item.product_id"
                                    class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            >
                                <option :value="null">ردیف دلخواه</option>
                                <option v-for="(product, prd) in products"
                                        :key="prd" :value="product.id"
                                >{{product.name}} ({{product.sku}})</option>
                            </select>
                        </div>
                        <div class="mb-1 border border-gray-200 p-2">
                            <InputComponent v-model="form_item.name"
                                            :value="form_item.name"
                                            label="عنوان ردیف"
                                            id="customer_name"
                                            placeholder="مهراد شاهرخی"
                                            :input_error="form_item?.errors?.name"
                            />
                        </div>
                        <div class="mb-1 border border-gray-200 p-2">
                            <InputComponent v-model="form_item.item_price"
                                            :value="form_item.item_price"
                                            label="قیمت عادی"
                                            id="item_price"
                                            placeholder="10000"
                                            css_class="ltr"
                                            :input_error="form_item?.errors?.item_price"
                            />
                            <small>{{form_item.item_price ? form_item.item_price.toLocaleString() : ''}}</small>
                        </div>
                        <div class="mb-1 border border-gray-200 p-2">
                            <InputComponent v-model="form_item.unit_price"
                                            :value="form_item.unit_price"
                                            label="قیمت واحد (تخفیفی)"
                                            id="unit_price"
                                            placeholder="10000"
                                            css_class="ltr"
                                            :input_error="form_item?.errors?.unit_price"
                            />
                            <small>{{form_item.unit_price ? form_item.unit_price.toLocaleString() : ''}}</small>

                        </div>
                        <div class="mb-1 border border-gray-200 p-2">
                            <InputComponent v-model="form_item.qty"
                                            :value="form_item.qty"
                                            label="تعداد"
                                            id="qty"
                                            placeholder="1"
                                            css_class="ltr"
                                            :input_error="form_item?.errors?.qty"
                            />
                        </div>
                        <div class="mb-1 border border-gray-200 p-2">
                            <SelectComponent label="وضعیت ردیف"
                                             :value="form_item.invoice_item_status_id"
                                             id="brand" v-model="form_item.invoice_item_status_id"
                                             :input_error="form_item?.errors?.invoice_item_status_id"
                                             :options="invoice_item_statuses"
                            />
                        </div>

                        <div class="my-3 text-center">
                            <button @click="addItem" class="confirm-btn">افزودن ردیف</button>
                            <button @click="form_item.reset()" class="p-3 bg-orange-300 cursor-pointer shadow-md mx-1 rounded-md">خالی کردن فرم</button>
                        </div>

                    </div>
                </div>
            </div>

            <div class="lg:w-3/4 md:w-3/4 sm:w-1/1 w-1/1 p-1">
                <div class="card border border-gray-100 rounded-md shadow-md">

                    <!-- جدول کالاها -->
                    <div class="p-2 my-3">
                        <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800">ویرایش فاکتور</h3>
                            </div>
                            <div class="ml-3">
                                <a :href="`/admin/invoice/${invoice.id}`" class="m-1" target="_blank">
                                    <button
                                        class="me-1 cursor-pointer text-blue-600 border border-blue-600 hover:border-indigo-600 focus:ring-4 focus:ring-indigo-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">

                                        <svg fill="#000000" height="15px" width="15px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 495.558 495.558" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M492.538,242.716c-3.702-6.173-92.288-151.327-244.76-151.327c-152.476,0-241.063,145.154-244.76,151.327L0,247.774 l3.019,5.058c3.697,6.173,92.284,151.337,244.76,151.337c152.471,0,241.058-145.164,244.76-151.337l3.019-5.058L492.538,242.716z M247.779,384.476c-125.769,0-207.625-111.394-224.587-136.702c16.962-25.298,98.817-136.692,224.587-136.692 s207.625,111.394,224.587,136.692C455.404,273.082,373.548,384.476,247.779,384.476z"></path> </g> </g> <g> <g> <path d="M247.779,140.505c-59.149,0-107.274,48.125-107.274,107.269c0,59.154,48.125,107.279,107.274,107.279 c59.154,0,107.279-48.125,107.279-107.279C355.058,188.63,306.933,140.505,247.779,140.505z M247.779,335.361 c-48.293,0-87.582-39.288-87.582-87.587c0-48.288,39.288-87.577,87.582-87.577c48.298,0,87.587,39.288,87.587,87.577 C335.365,296.072,296.077,335.361,247.779,335.361z"></path> </g> </g> <g> <g> <path d="M247.779,207.438c-22.24,0-40.337,18.096-40.337,40.336c0,22.24,18.096,40.337,40.337,40.337 c22.24,0,40.337-18.096,40.337-40.337C288.115,225.534,270.019,207.438,247.779,207.438z M247.779,268.418 c-11.385,0-20.644-9.26-20.644-20.644c0-11.385,9.26-20.644,20.644-20.644c11.385,0,20.644,9.26,20.644,20.644 C268.423,259.159,259.163,268.418,247.779,268.418z"></path> </g> </g> </g></svg>

                                        <span class="ms-1"> جزئیات فاکتور</span>
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
                    <div class="p-2 my-3 overflow-x-scroll">
                        <table class="w-full text-right table-auto min-w-max mb-5">
                            <thead>
                            <tr>
                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        ردیف
                                    </p>
                                </th>

                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        عنوان
                                    </p>
                                </th>
                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        تعداد
                                    </p>
                                </th>
                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        قیمت واحد (تومان)
                                    </p>
                                </th>
                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        جمع واحد (تومان)
                                    </p>
                                </th>
                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        تخفیف (تومان)
                                    </p>
                                </th>
                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        جمع (تومان)
                                    </p>
                                </th>
                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        وضعیت
                                    </p>
                                </th>
                                <th class="p-2 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        عملیات
                                    </p>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, i) in invoice.items" :key="item.id">
                                <td class="p-2 border-b border-slate-200 py-2">
                                    <p class="block font-semibold text-sm text-blue-800">{{ i + 1 }}</p>

                                </td>

                                <td class="p-2 border-b border-slate-200 py-2">
                                    <p class="text-sm text-slate-500">{{ item.name}}</p>

                                </td>

                                <td class="p-2 border-b border-slate-200 py-2">
                                    <p class="text-sm text-slate-500">{{ Number(item.qty).toLocaleString()}}</p>
                                </td>
                                <td class="p-2 border-b border-slate-200 py-2">
                                    <p class="text-sm text-slate-500">{{ Number(item.item_price).toLocaleString()}}</p>
                                </td>
                                <td class="p-2 border-b border-slate-200 py-2">
                                    <p class="text-sm text-slate-500">{{ Number(item.item_price * item.qty).toLocaleString()}}</p>
                                </td>
                                <td class="p-2 border-b border-slate-200 py-2">
                                    <p class="text-sm text-slate-500">{{ Number(item.discount * item.qty).toLocaleString()}}</p>
                                </td>
                                <td class="p-2 border-b border-slate-200 py-2">
                                    <p class="text-sm text-slate-500">{{ Number(item.unit_price * item.qty).toLocaleString()}}</p>
                                </td>
                                <td class="p-2 border-b border-slate-200 py-2">
                                    <select v-model="item.invoice_item_status_id"
                                            @change="changeItemStatus(item)"
                                            class="block w-[120px] rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    >
                                        <option value="" disabled>تعیین وضعیت</option>
                                        <option
                                            v-for="(item_status, i_s) in invoice_item_statuses"
                                            :key="i_s"
                                            :value="item_status.id">{{item_status.name}}</option>
                                    </select>
                                </td>
                                <td class="p-2 border-b border-slate-200 py-2">
                                    <button @click="increaseQty(item.id)" class="p-2 cursor-pointer rounded-md border border-green-800">
                                        <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6 12H18M12 6V18" stroke="#008080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                    </button>
                                    <button @click="decreaseQty(item.id)" class="p-2 mx-1 cursor-pointer rounded-md border border-rose-800">
                                        <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6 12L18 12" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                    </button>
                                    <button @click="deleteItem(item.id)" class="p-2 cursor-pointer rounded-md border border-rose-800">
                                        <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M10 12L14 16M14 12L10 16M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6" stroke="#f80707" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                    </button>

                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <hr class="my-2">
                        <div class="mb-4 border border-gray-200 p-2">
                            <h3 class="text-sm text-gray-800">جمع آیتم ها: {{Number(invoice.sub_total).toLocaleString()}} تومان</h3>
                        </div>

                        <div class="mb-4 border border-gray-200 p-2">
                            <h3 class="text-sm text-gray-800">ارسال: {{Number(invoice.shipping_cost).toLocaleString()}} تومان</h3>
                        </div>

                        <div class="mb-4 border border-gray-200 p-2">
                            <h3 class="text-sm text-gray-800">مالیات: {{Number(invoice.tax).toLocaleString()}} تومان</h3>
                        </div>

                        <div class="mb-4 border border-gray-200 p-2">
                            <h3 class="text-sm text-rose-800">تخفیف: {{Number(invoice.discount).toLocaleString()}} تومان</h3>
                        </div>
                        <div class="mb-4 border border-gray-200 p-2">
                            <h3 class="text-sm text-rose-800">کارمزد: {{Number(invoice.interest_amount).toLocaleString()}} تومان</h3>
                        </div>
                        <div class="mb-4 border border-gray-200 p-2">
                            <h3 class="text-sm text-green-800">مبلغ قابل پرداخت: {{Number(invoice.amount + invoice.interest_amount).toLocaleString()}} تومان</h3>
                        </div>


                    </div>

                </div>

            </div>


        </div>

    </AppLayout>
</template>

<style scoped>

</style>
