<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import FlashMessage from '@/components/FlashMessage.vue';
import GatewayModal from '@/components/admin/settings/GatewayModal.vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'مدیریت روش های پرداخت',
        href: '/admin/payment',
    },
];
interface Props {
    models: object;
}
const props = defineProps<Props>()
const form = useForm({
    name: null,
    image: null,
    status: false,
    api_key: 0,
    terminal_id: null,
    merchant: null,
    username: null,
    password: null,
    note: null,
    is_default: false,
    is_gateway: false,
    description: null
});


const selectedItem = ref(null)

const openQuickEdit = (item: any) => {
    selectedItem.value = item
}


</script>

<template>
    <Head title="روش های پرداخت" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">مدیریت روش های پرداخت</h3>

                    </div>
                    <div class="ml-3">
                        <Link :href="`/admin/setting`">
                            <button
                                class="me-1 cursor-pointer text-black bg-white border border-gray-200 hover:border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-md inline-flex items-center px-3 py-2.5 text-center mr-2">
                                <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20 10L20.7071 10.7071L21.4142 10L20.7071 9.29289L20 10ZM3 18C3 18.5523 3.44772 19 4 19C4.55229 19 5 18.5523 5 18L3 18ZM15.7071 15.7071L20.7071 10.7071L19.2929 9.29289L14.2929 14.2929L15.7071 15.7071ZM20.7071 9.29289L15.7071 4.29289L14.2929 5.70711L19.2929 10.7071L20.7071 9.29289ZM20 9L10 9L10 11L20 11L20 9ZM3 16L3 18L5 18L5 16L3 16ZM10 9C6.13401 9 3 12.134 3 16L5 16C5 13.2386 7.23858 11 10 11L10 9Z" fill="#33363F"></path> </g></svg>

                                <span class="ms-1">بازگشت</span>
                            </button>
                        </Link>
                    </div>
                </div>
                <div class="my-2 p-2 rounded-md">
                    <FlashMessage />
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
                                    عنوان
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    تصویر
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    وضعیت
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    پیشفرض
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    عملیات
                                </p>
                            </th>
                        </tr>
                        </thead>
                        <tbody v-if="models">
                        <tr v-for="(item, index) in models.data" :key="index" :class="item.deleted_at ? 'bg-red-100' : ''">
                            <td class="p-4 border-b border-slate-200 py-1">
                                <p class="block font-semibold text-sm text-slate-800">{{ item.id }}</p>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <p class="text-sm text-slate-500">{{ item.name }}</p>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <div v-if="item.image" class="mt-2">
                                    <img :src="item.image" class="border rounded object-fill table-img" />
                                </div>
                            </td>


                            <td class="p-4 border-b border-slate-200 py-1">
                                <div class="w-max">
                                    <div v-if="item.status"
                                         class="relative grid items-center px-2 py-1 font-sans text-xs font-bold text-green-900 uppercase rounded-md select-none whitespace-nowrap bg-green-500/20">
                                        <span class="">فعال</span>
                                    </div>
                                    <div v-else
                                         class="relative grid items-center px-2 py-1 font-sans text-xs font-bold uppercase rounded-md select-none whitespace-nowrap bg-amber-500/20 text-amber-900">
                                        <span class="">غیرفعال</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <svg v-if="item.is_default" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM16.0303 8.96967C16.3232 9.26256 16.3232 9.73744 16.0303 10.0303L11.0303 15.0303C10.7374 15.3232 10.2626 15.3232 9.96967 15.0303L7.96967 13.0303C7.67678 12.7374 7.67678 12.2626 7.96967 11.9697C8.26256 11.6768 8.73744 11.6768 9.03033 11.9697L10.5 13.4393L12.7348 11.2045L14.9697 8.96967C15.2626 8.67678 15.7374 8.67678 16.0303 8.96967Z" fill="#008040"></path> </g></svg>
                                <svg v-else version="1.1" id="svg2" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" sodipodi:docname="remove.svg" inkscape:version="0.48.4 r9939" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 1200 1200" enable-background="new 0 0 1200 1200" xml:space="preserve" fill="#ff0000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path id="path18404" inkscape:connector-curvature="0" d="M0,264.84L335.16,600L0,935.16L264.84,1200L600,864.84L935.16,1200 L1200,935.16L864.84,600L1200,264.84L935.16,0L600,335.16L264.84,0L0,264.84z"></path> </g></svg>
                            </td>

                            <td class="p-4 border-b border-slate-200 py-1">
                                <button @click="openQuickEdit(item)" title="ویرایش سریع"
                                        class="relative cursor-pointer h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                        type="button">
                                     <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                         <svg width="16px" height="16px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title></title> <g id="Complete"> <g id="edit"> <g> <path d="M20,16v4a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V6A2,2,0,0,1,4,4H8" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path> <polygon fill="none" points="12.5 15.8 22 6.2 17.8 2 8.3 11.5 8 16 12.5 15.8" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></polygon> </g> </g> </g> </g></svg>

                                     </span>
                                </button>


                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <GatewayModal
                        v-if="selectedItem"
                        :obj_model="selectedItem"
                        @close="selectedItem = null"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
