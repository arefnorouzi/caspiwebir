<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { onMounted, ref } from 'vue'
import { Chart } from 'chart.js/auto'
import ChartBox from '@/components/admin/ChartBox.vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'نمودارها',
        href: '/admin/chart',
    },
];
Chart.defaults.font.family = 'iransans'
Chart.defaults.font.size = window.innerWidth < 768 ? 10 : 12
interface Props {
    invoices_chart: object;
    users_chart: object;
}
const props = defineProps<Props>()

const canvasRef = ref(null)

onMounted(() => {
    new Chart(canvasRef.value, {
        type: 'line',
        data: {
            labels: props.invoices_chart.labels,
            datasets: [
                {
                    label: 'کل فاکتورها',
                    data: props.invoices_chart.total,
                    tension: 0.4
                },
                {
                    label: 'فاکتورهای پرداخت‌ شده',
                    data: props.invoices_chart.paid,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels:{
                        font: {
                            family: 'iransans',
                            size: 12
                        }
                    },
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'نمودار سفارشات 30 روز اخیر',
                    font: {
                        family: 'iransans',
                        size: 12
                    }
                }
            }
        },
    })
})

</script>
<template>
    <Head title="نمودارها" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl md:min-h-min"
            >

                <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">نمودارها</h3>

                    </div>
                    <div class="ml-3">
                        <Link href="/admin">
                            <button
                                class="me-1 cursor-pointer text-black bg-white border border-gray-200 hover:border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-md inline-flex items-center px-3 py-2.5 text-center mr-2">
                                <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20 10L20.7071 10.7071L21.4142 10L20.7071 9.29289L20 10ZM3 18C3 18.5523 3.44772 19 4 19C4.55229 19 5 18.5523 5 18L3 18ZM15.7071 15.7071L20.7071 10.7071L19.2929 9.29289L14.2929 14.2929L15.7071 15.7071ZM20.7071 9.29289L15.7071 4.29289L14.2929 5.70711L19.2929 10.7071L20.7071 9.29289ZM20 9L10 9L10 11L20 11L20 9ZM3 16L3 18L5 18L5 16L3 16ZM10 9C6.13401 9 3 12.134 3 16L5 16C5 13.2386 7.23858 11 10 11L10 9Z" fill="#33363F"></path> </g></svg>

                                <span class="ms-1">بازگشت</span>
                            </button>
                        </Link>
                    </div>
                </div>

                <div class="my-3 flex flex-wrap w-full">

                    <div class="grid grid-cols-1 w-full gap-2">

                        <!-- فاکتورها -->
                        <ChartBox
                            title="آمار فاکتورها (۳۰ روز گذشته)"
                            :labels="invoices_chart.labels"
                            :datasets="[
                              { label: 'کل فاکتورها', data: invoices_chart.total },
                              { label: 'پرداخت‌شده', data: invoices_chart.paid }
                            ]"
                        />

                        <!-- کاربران -->
                        <ChartBox
                            title="ثبت‌نام کاربران (۳۰ روز گذشته)"
                            :labels="users_chart.labels"
                            :datasets="[
                              { label: 'کاربران جدید', data: users_chart.total }
                            ]"
                        />

                    </div>
                </div>
            </div>
        </div>
    </AppLayout>

</template>


