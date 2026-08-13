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
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' })



async function payInvoice() {
    await axios.post('/payment', form)
        .then(res => {
            showToast("درگاه با موفقیت انتخاب شد", "success")
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
                showToast("خطا در انتخاب درگاه", "error")
            }
        })
}



</script>

<template>
    <Head title="جزئیات فاکتور" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex flex-wrap mt-2 p-2">

            <div class="lg:w-2/3 md:w-1/1 sm:w-1/1 w-1/1 p-1">
                <div class="card border border-gray-100 rounded-md shadow-md">

                    <!-- جدول کالاها -->
                    <div class="p-2 my-3">
                        <h2 class="text-lg text-indigo-500">جزئیات سفارش</h2>
                    </div>
                    <div class="p-2 my-3 overflow-x-scroll">
                        <table class="w-full text-right table-auto min-w-max mb-5">
                            <thead>
                            <tr>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        ردیف
                                    </p>
                                </th>


                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        محصول
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        تعداد
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        قیمت واحد (تومان)
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        جمع واحد (تومان)
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        تخفیف (تومان)
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        جمع (تومان)
                                    </p>
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, i) in invoice.items" :key="item.id">
                                <td class="p-4 border-b border-slate-200 py-2">
                                    <p class="block font-semibold text-sm text-blue-800">{{ i + 1 }}</p>

                                </td>

                                <td class="p-4 border-b border-slate-200 py-2">
                                    <p v-if="item.product_id">
                                        <a :href="`/shop/product/${item?.product_id}`" target="_blank">
                                            {{ item?.name }}
                                        </a>
                                    </p>

                                </td>

                                <td class="p-4 border-b border-slate-200 py-2">
                                    <p class="text-sm text-slate-500">{{ Number(item.qty).toLocaleString()}}</p>
                                </td>
                                <td class="p-4 border-b border-slate-200 py-2">
                                    <p class="text-sm text-slate-500">{{ Number(item.item_price).toLocaleString()}}</p>
                                </td>
                                <td class="p-4 border-b border-slate-200 py-2">
                                    <p class="text-sm text-slate-500">{{ Number(item.item_price * item.qty).toLocaleString()}}</p>
                                </td>
                                <td class="p-4 border-b border-slate-200 py-2">
                                    <p class="text-sm text-slate-500">{{ Number(item.discount * item.qty).toLocaleString()}}</p>
                                </td>
                                <td class="p-4 border-b border-slate-200 py-2">
                                    <p class="text-sm text-slate-500">{{ Number(item.unit_price * item.qty).toLocaleString()}}</p>
                                </td>

                            </tr>
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>

            <div class="lg:w-1/3 md:w-1/1 sm:w-1/1 w-1/1 p-1">
                <div class="card border border-gray-100 rounded-md mb-2 shadow">
                    <div class="card-header bg-gray-100 p-2">
                        <h4>روش های پرداخت</h4>
                    </div>
                    <div class="card-body px-2 py-4">
                        <div class="mb-4 border border-gray-200 p-2">
                            <h3 class="text-sm font-bold text-gray-800">جمع آیتم ها: {{Number(invoice.sub_total).toLocaleString()}} تومان</h3>
                        </div>

                        <div class="mb-4 border border-gray-200 p-2">
                            <h3 class="text-sm font-bold text-gray-800">هزینه ارسال: {{Number(invoice.shipping_cost).toLocaleString()}} تومان</h3>
                        </div>

                        <div class="mb-4 border border-gray-200 p-2">
                            <h3 class="text-sm font-bold text-gray-800">مالیات: {{Number(invoice.tax).toLocaleString()}} تومان</h3>
                        </div>

                        <div class="mb-4 border border-gray-200 p-2">
                            <h3 class="text-sm font-bold text-rose-800">تخفیف: {{Number(invoice.discount).toLocaleString()}} تومان</h3>
                        </div>

                        <div class="mb-4 border border-gray-200 p-2">
                            <h3 class="text-sm font-bold text-green-800">مبلغ قابل پرداخت: {{Number(invoice.amount).toLocaleString()}} تومان</h3>
                        </div>


                        <div class="mb-3 mt-5">
                            <label for="stock" class="text-sm font-bold p-2 block mb-2">انتخاب روش پرداخت</label>
                            <div v-for="pament_method in payment_methods" class="mb-1" :key="pament_method.id">
                                <input type="radio" v-model="form.payment_method_id" :value="pament_method.id"
                                       class="w-4 h-4 text-blue-800 focus:ring-blue-500 focus:ring-2 mb-5"
                                >
                                <span class="ms-2 text-sm">{{pament_method.name}}</span>
                            </div>
                        </div>

                        <div v-if="form.payment_method_id == 5" class="mb-2 px-2 py-4 bg-blue-100 text-blue-800 rounded-md">
                            <h4 class="mb-2 text-sm font-bold">صاحب حساب: شرکت رخشان مطبوع سازان نوین</h4>

                            <p class="mb-4 border border-gray-200 p-2">
                                <span>شماره کارت: </span> <strong>6037691990547879</strong>
                            </p>
                            <p class="mb-4 border border-gray-200 p-2">
                                <span>شماره شبا: </span> <strong>IR220190000000117069147000</strong>
                            </p>
                            <p class="mb-2 text-sm border border-gray-200 p-2">
                                ارسال فیش یا رسید واریزی
                            </p>
                            <div class="text-center flex flex-wrap gap-2 justify-center">
                                <div>
                                    <a href="https://wa.me/989111355171" class="share-btn" target="_blank">
                                        <button class="cursor-pointer bg-green-700 rounded-md py-2 px-4 flex">
                                        <span>
                                            <svg width="25px" height="25px" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M16 31C23.732 31 30 24.732 30 17C30 9.26801 23.732 3 16 3C8.26801 3 2 9.26801 2 17C2 19.5109 2.661 21.8674 3.81847 23.905L2 31L9.31486 29.3038C11.3014 30.3854 13.5789 31 16 31ZM16 28.8462C22.5425 28.8462 27.8462 23.5425 27.8462 17C27.8462 10.4576 22.5425 5.15385 16 5.15385C9.45755 5.15385 4.15385 10.4576 4.15385 17C4.15385 19.5261 4.9445 21.8675 6.29184 23.7902L5.23077 27.7692L9.27993 26.7569C11.1894 28.0746 13.5046 28.8462 16 28.8462Z" fill="#BFC8D0"></path> <path d="M28 16C28 22.6274 22.6274 28 16 28C13.4722 28 11.1269 27.2184 9.19266 25.8837L5.09091 26.9091L6.16576 22.8784C4.80092 20.9307 4 18.5589 4 16C4 9.37258 9.37258 4 16 4C22.6274 4 28 9.37258 28 16Z" fill="url(#paint0_linear_87_7264)"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M16 30C23.732 30 30 23.732 30 16C30 8.26801 23.732 2 16 2C8.26801 2 2 8.26801 2 16C2 18.5109 2.661 20.8674 3.81847 22.905L2 30L9.31486 28.3038C11.3014 29.3854 13.5789 30 16 30ZM16 27.8462C22.5425 27.8462 27.8462 22.5425 27.8462 16C27.8462 9.45755 22.5425 4.15385 16 4.15385C9.45755 4.15385 4.15385 9.45755 4.15385 16C4.15385 18.5261 4.9445 20.8675 6.29184 22.7902L5.23077 26.7692L9.27993 25.7569C11.1894 27.0746 13.5046 27.8462 16 27.8462Z" fill="white"></path> <path d="M12.5 9.49989C12.1672 8.83131 11.6565 8.8905 11.1407 8.8905C10.2188 8.8905 8.78125 9.99478 8.78125 12.05C8.78125 13.7343 9.52345 15.578 12.0244 18.3361C14.438 20.9979 17.6094 22.3748 20.2422 22.3279C22.875 22.2811 23.4167 20.0154 23.4167 19.2503C23.4167 18.9112 23.2062 18.742 23.0613 18.696C22.1641 18.2654 20.5093 17.4631 20.1328 17.3124C19.7563 17.1617 19.5597 17.3656 19.4375 17.4765C19.0961 17.8018 18.4193 18.7608 18.1875 18.9765C17.9558 19.1922 17.6103 19.083 17.4665 19.0015C16.9374 18.7892 15.5029 18.1511 14.3595 17.0426C12.9453 15.6718 12.8623 15.2001 12.5959 14.7803C12.3828 14.4444 12.5392 14.2384 12.6172 14.1483C12.9219 13.7968 13.3426 13.254 13.5313 12.9843C13.7199 12.7145 13.5702 12.305 13.4803 12.05C13.0938 10.953 12.7663 10.0347 12.5 9.49989Z" fill="white"></path> <defs> <linearGradient id="paint0_linear_87_7264" x1="26.5" y1="7" x2="4" y2="28" gradientUnits="userSpaceOnUse"> <stop stop-color="#5BD066"></stop> <stop offset="1" stop-color="#27B43E"></stop> </linearGradient> </defs> </g></svg>
                                        </span>
                                            <span class="ms-3 text-white text-sm">ارسال در واتساپ</span>
                                        </button>
                                    </a>
                                </div>

                            </div>
                        </div>
                        <div v-else class="mb-2 px-2 py-2 bg-blue-100 text-blue-800 rounded-md">
                            <p class="p-2">
                                امکان پرداخت با تمامی کارت های عضو شتاب
                            </p>

                        </div>


                        <div class="my-2">
                            <ValidationErrors :errors="validation_errors" />

                        </div>
                        <div v-if="form.payment_method_id" class="my-2 text-center">

                            <button @click="payInvoice" class="cursor-pointer border border-2 bg-teal-700 text-gray-100 rounded-md py-2 px-3 m-1">تایید و پرداخت</button>
                       </div>

                    </div>
                </div>
            </div>

        </div>

    </AppLayout>
</template>

<style scoped>

</style>
