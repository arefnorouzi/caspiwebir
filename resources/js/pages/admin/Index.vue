<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import Pagination from '@/components/Pagination.vue';
import { Chart } from 'chart.js/auto'
import ChartBox from '@/components/admin/ChartBox.vue';
import { ref, watch } from 'vue';
import _ from "lodash";
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'پنل مدیریت',
        href: '/admin',
    },
];
Chart.defaults.font.family = 'iransans'
Chart.defaults.font.size = window.innerWidth < 768 ? 10 : 12
interface Props {
    invoices: object;
    users_count: number;
    open_tickets: number;
    open_comments: number;
    open_carts: number;
    search_text: string;
    month_sell: number;
    month_invoces_count: number;
    purchased_invoces_count: number;
    invoices_chart: object;
    out_of_stock_products_count: number;
    active_products_count: number;
}
const props = defineProps<Props>()
const search = ref(props.search_text)
watch(search, _.debounce(
    (q) => router.get("/admin/invoice", {search: q}, {preserveState: true}
    ), 1000));

const formatDate = (d) =>
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'numeric', day: 'numeric'})

</script>
<template>
    <Head title="پنل مدیریت" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl md:min-h-min"
            >
                <div class="w-full p-1 mb-5">
                    <div
                        class="grid auto-rows-min grid-cols-1 gap-3 md:grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 mb-3"
                    >
                        <div
                            class="card border-2 border-gray-300 rounded-md mb-2 shadow-md" style="align-content: center">
                            <div class="card-body text-center py-2 px-3">
                                <div class="mb-4 text-center p-2">
                                    <h3 class="text-sm font-bold mb-3">مدیریت فروشگاه</h3>
                                    <Link href="/admin/brand" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">مدیریت برندها</h5>
                                    </Link>
                                    <Link href="/admin/category" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">دسته بندی محصولات</h5>
                                    </Link>
                                    <Link href="/admin/product" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">مدیریت محصولات</h5>
                                    </Link>
                                    <Link href="/admin/coupon" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">کد تخفیف</h5>
                                    </Link>
                                    <Link href="/admin/products" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">تخفیف گروهی</h5>
                                    </Link>
                                    <Link href="/admin/inventory" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">انبارها</h5>
                                    </Link>
                                    <Link href="/admin/payment" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">تنظیمات درگاه پرداخت</h5>
                                    </Link>
                                    <Link href="/admin/shipping" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">تنظیمات حمل و نقل</h5>
                                    </Link>

                                </div>
                            </div>
                        </div>
                        <div
                            class="card border-2 border-gray-300 rounded-md mb-2 shadow-md" style="align-content: center">
                            <div class="card-body text-center py-2 px-3">
                                <div class="mb-4 text-center p-2">
                                    <h3 class="text-sm font-bold mb-3">مدیریت محتوا</h3>
                                    <Link href="/admin/blog/category" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">دسته بندی مقالات</h5>
                                    </Link>
                                    <Link href="/admin/post" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">مدیریت مقالات</h5>
                                    </Link>
                                    <Link href="/admin/page" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">مدیریت صفحات</h5>
                                    </Link>
                                    <Link href="/admin/media" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">مدیریت فایل</h5>
                                    </Link>
                                    <Link href="/admin/slider" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">اسلایدر صفحه اصلی</h5>
                                    </Link>
                                    <Link href="/admin/product-slider" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">اسلایدر محصولات</h5>
                                    </Link>
                                    <Link href="/admin/banner" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">بنرهای سایت</h5>
                                    </Link>

                                </div>
                            </div>
                        </div>
                        <div
                            class="card border-2 border-gray-300 rounded-md mb-2 shadow-md" style="align-content: center">
                            <div class="card-body text-center py-2 px-3">
                                <div class="mb-4 text-center p-2">
                                    <h3 class="text-sm font-bold mb-3">اطلاعات سایت</h3>
                                    <Link href="/admin/user" class="w-full mb-2">
                                    <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">تعداد کاربران:
                                        {{Number(users_count).toLocaleString()}}
                                    </h5>
                                    </Link>
                                    <Link href="/admin/role" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">سطوح کاربری</h5>
                                    </Link>
                                    <Link href="/admin/comment" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">نظرات تایید نشده:
                                            {{Number(open_comments).toLocaleString()}}
                                        </h5>
                                    </Link>

                                    <Link href="/admin/ticket" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">تیکت باز:
                                            {{Number(open_tickets).toLocaleString()}}
                                        </h5>
                                    </Link>
                                    <Link href="/admin/product" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">تعداد محصولات:
                                            {{Number(active_products_count).toLocaleString()}}
                                        </h5>
                                    </Link>
                                    <Link href="/admin/product?outofstock=true" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100"> محصولات ناموجود:
                                            {{Number(out_of_stock_products_count).toLocaleString()}}
                                        </h5>
                                    </Link>


                                </div>
                            </div>
                        </div>


                        <div
                            class="card border-2 border-gray-300 rounded-md mb-2 shadow" style="align-content: center">
                            <div class="card-body text-center py-2 px-3">
                                <div class="mb-4 text-center p-2">
                                    <h3 class="text-sm font-bold mb-3">سفارشات 30 روز اخیر</h3>
                                    <Link href="/admin/invoice" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">سبد خرید کاربران:
                                            {{Number(open_carts).toLocaleString()}}
                                        </h5>
                                    </Link>
                                    <Link href="/admin/invoice" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">تعداد سفارشات:
                                            {{Number(month_invoces_count).toLocaleString()}}
                                        </h5>
                                    </Link>
                                    <Link href="/admin/invoice" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">پرداخت شده:
                                            {{Number(purchased_invoces_count).toLocaleString()}}
                                        </h5>
                                    </Link>

                                    <h5 v-if="purchased_invoces_count > 0" class="text-sm mb-2 border border-gray-400 p-2 rounded-md">درصد فروش: %{{Number((purchased_invoces_count / month_invoces_count) * 100).toFixed(0)}}</h5>
                                    <h5 v-else class="text-sm mb-2 border border-gray-400 p-2 rounded-md">درصد فروش: %0</h5>
                                    <Link href="/admin/invoice" class="w-full mb-2">
                                        <h5 class="text-sm mb-2 border border-gray-400 p-2 rounded-md hover:bg-gray-100">فروش ماه:
                                            {{Number(month_sell).toLocaleString()}}
                                            تومان
                                        </h5>
                                    </Link>

                                </div>

                            </div>
                        </div>




                    </div>
                    <div
                        class="card border-2 border-gray-300 rounded-md mb-2  shadow" style="align-content: center">
                        <div class="card-body text-center py-2 px-3">
                            <ChartBox
                                title="آمار فاکتورها (۳۰ روز گذشته)"
                                :labels="invoices_chart.labels"
                                :datasets="[
                              { label: 'کل فاکتورها', data: invoices_chart.total },
                              { label: 'پرداخت‌شده', data: invoices_chart.paid }
                            ]"
                            />
                        </div>
                    </div>
                </div>
                <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                    <div>
                        <h3 class="text-md font-bold text-slate-800">آخرین پرداخت ها
                            <small>(
                            <Link class="text-blue-700" href="/admin/invoice">مشاهده همه</Link>
                                )</small></h3>

                    </div>

                </div>

                <div class="relative flex mt-2 flex-col w-full h-full overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">

                    <table class="w-full text-right table-auto min-w-max">
                        <thead>
                        <tr>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    #
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    مشتری
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    نوع
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    وضعیت
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    مبلغ
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    تاریخ
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    عملیات
                                </p>
                            </th>
                        </tr>
                        </thead>
                        <tbody v-if="invoices && invoices.data">
                        <tr v-for="(item, index) in invoices.data" :key="index" :class="item.deleted_at ? 'bg-red-100' : ''">
                            <td class="p-4 border-b border-slate-200 py-1">
                                <a :href="`/admin/invoice/${item.id}`" target="_blank">
                                    <p class="block font-semibold text-sm text-blue-600">{{ item.id }}</p>
                                </a>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <a :href="`/admin/user/${item.user_id}`" target="_blank"
                                   class="text-sm text-blue-500">{{ item?.user?.name}}</a>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <div class="w-max">
                                    <div
                                        :class="`relative grid items-center px-2 py-1 font-sans text-xs font-bold uppercase rounded-md select-none whitespace-nowrap ${item.invoice_type.css_class}`">
                                        <span class="">{{ item?.invoice_type?.name }}</span>
                                    </div>

                                </div>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <div class="w-max">
                                    <div
                                        :class="`relative grid items-center px-2 py-1 font-sans text-xs font-bold uppercase rounded-md select-none whitespace-nowrap ${item.status.css_class}`">
                                        <span class="">{{ item?.status?.name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <p class="text-sm text-slate-500">{{ Number(item.amount).toLocaleString()}}</p>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1" style="direction: ltr">
                                <p class="text-sm text-slate-500">{{ formatDate(item.created_at) }}</p>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <a :href="`/admin/invoice/${item.id}`" target="_blank">
                                    <button
                                        class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                    >
                                  <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                      <svg fill="#000000" height="20px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 495.558 495.558" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M492.538,242.716c-3.702-6.173-92.288-151.327-244.76-151.327c-152.476,0-241.063,145.154-244.76,151.327L0,247.774 l3.019,5.058c3.697,6.173,92.284,151.337,244.76,151.337c152.471,0,241.058-145.164,244.76-151.337l3.019-5.058L492.538,242.716z M247.779,384.476c-125.769,0-207.625-111.394-224.587-136.702c16.962-25.298,98.817-136.692,224.587-136.692 s207.625,111.394,224.587,136.692C455.404,273.082,373.548,384.476,247.779,384.476z"></path> </g> </g> <g> <g> <path d="M247.779,140.505c-59.149,0-107.274,48.125-107.274,107.269c0,59.154,48.125,107.279,107.274,107.279 c59.154,0,107.279-48.125,107.279-107.279C355.058,188.63,306.933,140.505,247.779,140.505z M247.779,335.361 c-48.293,0-87.582-39.288-87.582-87.587c0-48.288,39.288-87.577,87.582-87.577c48.298,0,87.587,39.288,87.587,87.577 C335.365,296.072,296.077,335.361,247.779,335.361z"></path> </g> </g> <g> <g> <path d="M247.779,207.438c-22.24,0-40.337,18.096-40.337,40.336c0,22.24,18.096,40.337,40.337,40.337 c22.24,0,40.337-18.096,40.337-40.337C288.115,225.534,270.019,207.438,247.779,207.438z M247.779,268.418 c-11.385,0-20.644-9.26-20.644-20.644c0-11.385,9.26-20.644,20.644-20.644c11.385,0,20.644,9.26,20.644,20.644 C268.423,259.159,259.163,268.418,247.779,268.418z"></path> </g> </g> </g></svg>
                                  </span>
                                    </button>
                                </a>


                            </td>
                        </tr>
                        </tbody>
                    </table>


                    <div class="my-3" v-if="invoices">
                        <Pagination :links="invoices.links" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>

</template>


