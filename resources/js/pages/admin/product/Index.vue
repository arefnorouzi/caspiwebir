<script setup lang="ts" xmlns="http://www.w3.org/1999/html">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import Pagination from '@/components/Pagination.vue';
import { ref, watch, computed } from 'vue';
import _ from 'lodash';
import FlashMessage from '@/components/FlashMessage.vue';
import QuickEditRow from '@/components/admin/QuickEditRow.vue'
import ProductExportModal from "@/components/admin/excel/ProductExportModal.vue";
import BaseSwitch from '@/components/admin/BaseSwitch.vue';
import ProductImportModal from "@/components/admin/excel/ProductImportModal.vue";
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'مدیریت محصولات',
        href: '/admin/product'
    }
];
interface Props {
    models: object;
    filters: object;
    today: string;
    categories: object;
    brands: object;
}
const props = defineProps<Props>();

const filterForm = useForm({
    search: props.filters.search ?? '',
    status: props.filters.status ?? null,
    amazing: props.filters.amazing ?? null,
    suggested: props.filters.suggested ?? null,
    pinned: props.filters.pinned ?? null,
    torobpay: props.filters.torobpay ?? null,
    buyable: props.filters.buyable ?? null,
    pre_order: props.filters.pre_order ?? null,
})

const search = ref(props.filters.search);
watch(search, _.debounce(
    (q) => router.get('/admin/product', {search: q}, {preserveState: true}
    ), 1500));


const applyFilters = _.debounce(() => {
    router.get('/admin/product',
        filterForm,
        {
            preserveState: true,
            replace: true,
        }
    )
}, 500)

const resetFilters = () => {
    filterForm.search = '';
    filterForm.pinned = null;
    filterForm.status = null;
    filterForm.amazing = null;
    filterForm.suggested = null;
    filterForm.torobpay = null;
    filterForm.buyable = null;
    filterForm.pre_order = null;
    applyFilters()
}

const selectedIds = ref([]);
const selectAll = computed({
    get: () => {
        return props.models.data.length > 0 &&
            selectedIds.value.length === props.models.data.length;
    },
    set: (value) => {
        if (value) {
            selectedIds.value = props.models.data.map(p => p.id);
        } else {
            selectedIds.value = [];
        }
    }
});

const bulkDelete = () => {
    if (confirm(`${selectedIds.value.length} محصول حذف شوند؟`)) {
        router.delete('/admin/products/bulk', {
            data: { ids: selectedIds.value },
            preserveScroll: true,
            onSuccess: () => { selectedIds.value = []; }
        });
    }
};

const bulkRestore = () => {
    if (confirm(`${selectedIds.value.length} محصول بازیابی شوند؟`)) {
        router.delete('/admin/products/bulk-restore', {
            data: { ids: selectedIds.value },
            preserveScroll: true,
            onSuccess: () => { selectedIds.value = []; }
        });
    }
};

const bulkDeactivate = () => {
    if (confirm(`${selectedIds.value.length} محصول غیرفعال شوند؟`)) {
        router.patch('/admin/products/bulk/deactivate', {
            ids: selectedIds.value,
        }, {
            preserveScroll: true,
            onSuccess: () => { selectedIds.value = []; }
        });
    }
};

const bulkActivate = () => {
    if (confirm(`${selectedIds.value.length} محصول فعال شوند؟`)) {
        router.patch('/admin/products/bulk/activate', {
            ids: selectedIds.value,
        }, {
            preserveScroll: true,
            onSuccess: () => { selectedIds.value = []; }
        });
    }
};

const bulkSoldOut = () => {
    if (confirm(`${selectedIds.value.length} محصول ناموجود شوند؟`)) {
        router.patch('/admin/products/bulk/soldout', {
            ids: selectedIds.value,
        }, {
            preserveScroll: true,
            onSuccess: () => { selectedIds.value = []; }
        });
    }
};

const bulkInstock = () => {
    if (confirm(`${selectedIds.value.length} محصول موجود شوند؟`)) {
        router.patch('/admin/products/bulk/instock', {
            ids: selectedIds.value,
        }, {
            preserveScroll: true,
            onSuccess: () => { selectedIds.value = []; }
        });
    }
};

async function destroy(id: number) {
    if (confirm('از حذف رکورد مطمئنی؟')) {
        router.delete('/admin/product/' + id, {
            preserveScroll: true,
            preserveState: true,
        });
    }
}

async function restore(id: number) {
    if (confirm('از بازیابی رکورد مطمئنی؟')) {
        router.delete('/admin/restore-product/' + id,
        {
            preserveScroll: true,
            preserveState: true,
        });
    }
}

const toggleStatus = (id: number) => {
    router.put('/admin/product-publish/' + id,
        {
            preserveScroll: true,
            preserveState: true,
        }
    )
}

const selectedProduct = ref(null)
const selectedExport = ref(false)
const selectedImport = ref(false)
const openQuickEdit = (product: any) => {
    selectedProduct.value = product
}
const formatDate = (d) =>
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'numeric', day: 'numeric' })

</script>

<template>
    <Head title="مدیریت محصولات" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-wrap gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >

                <hr class="my-2" />
                <div class="w-full flex flex-wrap justify-between items-center mb-3 mt-1 p-2">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">لیست محصولات</h3>
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
                <div class="flex flex-wrap">
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2">
                        <Link :href="`/admin/product/create`" class="m-1">
                            <button
                                class="me-1 cursor-pointer text-oklch(44.8% 0.119 151.328) bg-green-200 hover:bg-green-300 focus:ring-4 focus:ring-green-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                                <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6 12H18M12 6V18" stroke="#008080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                <span class="ms-1"> افزودن آیتم</span>
                            </button>
                        </Link>
                        <Link :href="`/admin/product`" class="m-1">
                            <button
                                class="me-1 cursor-pointer text-blue-700 bg-blue-200 hover:bg-blue-300 focus:ring-4 focus:ring-blue-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                                <svg width="15px" height="15px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M18 5.65l-8-3.555L2 5.65V19H0V5c0-.396.232-.753.594-.913l9-4a.999.999 0 01.812 0l9 4A1 1 0 0120 5v14h-2V5.65z" fill="#5C5F62"></path><path d="M9 15a.997.997 0 01-.707-.293l-2-2a1 1 0 011.414-1.414L9 12.586l3.293-3.293a1 1 0 111.414 1.415l-4 4A.999.999 0 019 15z" fill="#5C5F62"></path></g></svg>
                                <span class="ms-1">همه محصولات</span>
                            </button>
                        </Link>
                        <Link :href="`/admin/product?outofstock=true`" class="m-1">
                            <button
                                class="me-1 cursor-pointer text-black bg-orange-200 hover:bg-orange-300 focus:ring-4 focus:ring-orange-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                                <svg width="15px" height="15px" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M18.7071 4.69719C19.0976 4.30667 19.7308 4.30667 20.1213 4.69719L28.6066 13.1825C28.9971 13.573 28.9971 14.2062 28.6066 14.5967C28.216 14.9872 27.5829 14.9872 27.1924 14.5967L18.7071 6.1114C18.3166 5.72088 18.3166 5.08771 18.7071 4.69719Z" fill="#333333"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M28.7071 4.7068C29.0976 5.09733 29.0976 5.73049 28.7071 6.12102L20.2218 14.6063C19.8313 14.9968 19.1981 14.9968 18.8076 14.6063C18.4171 14.2158 18.4171 13.5826 18.8076 13.1921L27.2929 4.7068C27.6834 4.31628 28.3166 4.31628 28.7071 4.7068Z" fill="#333333"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M24.3162 15.0513C24.111 14.9829 23.8891 14.9829 23.6838 15.0513L8.86851 19.9889C8.64603 20.063 8.463 20.2102 8.34247 20.3985L4.39805 25.4613C4.1985 25.7175 4.13573 26.0545 4.2297 26.3653C4.32367 26.6761 4.56269 26.922 4.87072 27.0246L8.19325 28.1319L8.19595 36.7634C8.19636 38.0544 9.02257 39.2003 10.2473 39.6085L23.6291 44.0691C23.7475 44.1164 23.8738 44.1406 24.0009 44.1405C24.1293 44.141 24.2569 44.1168 24.3765 44.069L37.7577 39.6086C38.9827 39.2003 39.8089 38.054 39.809 36.7628L39.8096 28.1328L43.1346 27.0246C43.4427 26.922 43.6817 26.6761 43.7757 26.3653C43.8696 26.0545 43.8069 25.7175 43.6073 25.4613L39.6117 20.3327C39.4927 20.176 39.3274 20.0542 39.1315 19.9889L24.3162 15.0513ZM9.54341 22.1112L22.346 26.378L19.6478 29.8413L6.8452 25.5745L9.54341 22.1112ZM24.0025 24.8203L35.6526 20.9376L24 17.0541L12.35 20.9367L24.0025 24.8203ZM10.196 36.7628L10.1935 28.7986L19.686 31.9622C20.088 32.0962 20.5307 31.9623 20.7911 31.6281L23.0003 28.7924L23.0001 41.7513L10.8797 37.7112C10.4715 37.5751 10.1961 37.1931 10.196 36.7628ZM37.8095 28.7993L28.3193 31.9622C27.9174 32.0962 27.4747 31.9623 27.2143 31.6281L25.0013 28.7876L25.0049 41.7514L37.1252 37.7113C37.5336 37.5752 37.809 37.1931 37.809 36.7627L37.8095 28.7993ZM28.3576 29.8413L25.6583 26.3767L38.4609 22.1099L41.1602 25.5745L28.3576 29.8413Z" fill="#333333"></path> </g></svg>
                                <span class="ms-1"> محصولات ناموجود</span>
                            </button>
                        </Link>
                        <Link :href="`/admin/product?trash=true`" class="m-1">
                            <button
                                class="me-1 cursor-pointer text-red-500 border border-red-200 hover:border-red-300 focus:ring-4 focus:ring-red-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                                <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14px" height="14px" viewBox="0 0 488.936 488.936" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M381.16,111.948H107.376c-6.468,0-12.667,2.819-17.171,7.457c-4.504,4.649-6.934,11.014-6.738,17.477l9.323,307.69 c0.39,12.92,10.972,23.312,23.903,23.312h20.136v-21.012c0-24.121,19.368-44.049,43.488-44.049h127.896 c24.131,0,43.893,19.928,43.893,44.049v21.012h19.73c12.933,0,23.52-10.346,23.913-23.268l9.314-307.7 c0.195-6.462-2.234-12.863-6.738-17.513C393.821,114.767,387.634,111.948,381.16,111.948z"></path> <path d="M309.166,435.355H181.271c-6.163,0-11.915,4.383-11.915,11.516v30.969c0,6.672,5.342,11.096,11.915,11.096h127.895 c6.323,0,11.366-4.773,11.366-11.096v-30.969C320.532,440.561,315.489,435.355,309.166,435.355z"></path> <path d="M427.696,27.106C427.696,12.138,415.563,0,400.591,0H88.344C73.372,0,61.239,12.138,61.239,27.106v30.946 c0,14.973,12.133,27.106,27.105,27.106H400.59c14.973,0,27.105-12.133,27.105-27.106L427.696,27.106L427.696,27.106z"></path> </g> </g> </g></svg>
                                <span class="ms-1"> سطل زباله</span>
                            </button>
                        </Link>
                        <button @click="selectedExport=true"
                                class="me-1 cursor-pointer text-green-900 border border-green-700 hover:border-green-700 focus:ring-4 focus:ring-green-700 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" width="15px" height="15px" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#507C5C;" d="M438.557,512H19.785c-8.216,0-14.876-6.66-14.876-14.876V256.916c0-8.216,6.66-14.876,14.876-14.876 s14.876,6.66,14.876,14.876v225.332h389.021v-32.833c0-8.216,6.661-14.876,14.876-14.876c8.215,0,14.876,6.66,14.876,14.876v47.709 C453.433,505.34,446.772,512,438.557,512z"></path> <g> <polygon style="fill:#CFF09E;" points="19.785,177.122 19.785,172.332 175.581,14.876 175.581,177.122 "></polygon> <rect x="196.154" y="219.435" style="fill:#CFF09E;" width="296.061" height="163.65"></rect> </g> <g> <path style="fill:#507C5C;" d="M492.215,204.559h-38.782V14.876C453.433,6.66,446.772,0,438.557,0H175.581 c-0.183,0-0.363,0.021-0.546,0.027c-0.167,0.006-0.332,0.013-0.498,0.025c-0.643,0.046-1.282,0.118-1.909,0.245 c-0.013,0.003-0.027,0.007-0.042,0.01c-0.617,0.126-1.22,0.305-1.815,0.509c-0.155,0.054-0.309,0.109-0.463,0.167 c-0.585,0.222-1.159,0.469-1.711,0.762c-0.019,0.01-0.042,0.018-0.061,0.03c-0.568,0.305-1.108,0.66-1.635,1.04 c-0.135,0.098-0.268,0.196-0.4,0.299c-0.522,0.402-1.028,0.827-1.497,1.3L9.21,161.868c-0.35,0.353-0.678,0.721-0.988,1.104 c-0.207,0.254-0.388,0.521-0.576,0.784c-0.092,0.131-0.195,0.256-0.283,0.388c-0.214,0.324-0.405,0.66-0.592,0.998 c-0.046,0.083-0.1,0.162-0.143,0.245c-0.183,0.347-0.342,0.701-0.495,1.056c-0.037,0.086-0.082,0.168-0.116,0.256 c-0.14,0.341-0.256,0.689-0.369,1.038c-0.036,0.112-0.08,0.219-0.113,0.33c-0.095,0.321-0.17,0.646-0.242,0.971 c-0.033,0.147-0.076,0.293-0.106,0.442c-0.058,0.3-0.095,0.604-0.134,0.907c-0.024,0.177-0.057,0.351-0.074,0.53 c-0.028,0.303-0.034,0.607-0.045,0.912c-0.006,0.167-0.024,0.332-0.024,0.498v4.792c0,8.216,6.66,14.876,14.876,14.876h155.796 c8.216,0,14.876-6.66,14.876-14.876V29.752h233.225v174.807H196.156c-8.216,0-14.876,6.66-14.876,14.876v163.644 c0,8.216,6.66,14.876,14.876,14.876h296.059c8.215,0,14.876-6.66,14.876-14.876V219.435 C507.091,211.219,500.43,204.559,492.215,204.559z M50.691,162.246L160.705,51.06v111.186H50.691z M477.339,368.203H211.032 V234.311h266.308V368.203z"></path> <path style="fill:#507C5C;" d="M255.692,313.875l-16.073,27.302c-0.771,1.211-2.312,1.761-4.073,1.761 c-4.734,0-11.45-3.743-11.45-8.476c0-0.991,0.33-1.981,0.992-3.082l19.046-29.393l-18.275-29.283 c-0.771-1.211-1.101-2.312-1.101-3.413c0-4.623,6.275-8.148,11.12-8.148c2.422,0,4.073,0.881,5.174,2.862l14.642,25.54 l14.641-25.54c1.101-1.981,2.754-2.862,5.175-2.862c4.844,0,11.12,3.523,11.12,8.148c0,1.101-0.332,2.202-1.101,3.413 l-18.275,29.283l19.046,29.393c0.66,1.101,0.991,2.092,0.991,3.082c0,4.734-6.715,8.476-11.449,8.476 c-1.761,0-3.413-0.55-4.073-1.761L255.692,313.875z"></path> <path style="fill:#507C5C;" d="M301.595,342.277c-3.744,0-7.487-1.761-7.487-5.284v-70.017c0-3.633,4.295-5.174,8.586-5.174 c4.295,0,8.586,1.541,8.586,5.174v60.329h25.1c3.304,0,4.955,3.744,4.955,7.487c0,3.743-1.651,7.486-4.955,7.486h-34.786V342.277z"></path> <path style="fill:#507C5C;" d="M381.294,320.7c0-13.321-34.899-11.01-34.899-36.77c0-16.514,14.422-22.788,28.182-22.788 c5.836,0,21.909,1.101,21.909,9.689c0,2.972-1.981,9.027-6.827,9.027c-3.963,0-6.055-4.183-15.083-4.183 c-7.816,0-11.008,3.192-11.008,6.605c0,11.01,34.899,8.918,34.899,36.66c0,15.853-11.56,24.44-27.523,24.44 c-14.421,0-26.531-7.045-26.531-14.312c0-3.744,3.304-9.248,7.486-9.248c5.175,0,8.476,8.148,18.715,8.148 C375.68,327.967,381.294,325.985,381.294,320.7z"></path> <path style="fill:#507C5C;" d="M433.473,313.875l-16.073,27.302c-0.772,1.211-2.313,1.761-4.073,1.761 c-4.735,0-11.449-3.743-11.449-8.476c0-0.991,0.33-1.981,0.991-3.082l19.046-29.393l-18.275-29.283 c-0.771-1.211-1.101-2.312-1.101-3.413c0-4.623,6.276-8.148,11.12-8.148c2.422,0,4.073,0.881,5.175,2.862l14.642,25.54 l14.642-25.54c1.099-1.981,2.752-2.862,5.174-2.862c4.845,0,11.12,3.523,11.12,8.148c0,1.101-0.33,2.202-1.101,3.413 l-18.274,29.283l19.046,29.393c0.66,1.101,0.991,2.092,0.991,3.082c0,4.734-6.717,8.476-11.449,8.476 c-1.763,0-3.414-0.55-4.073-1.761L433.473,313.875z"></path> </g> </g></svg>
                            <span class="ms-1"> خروجی اکسل</span>
                        </button>
                        <button @click="selectedImport=true"
                                class="me-1 cursor-pointer text-blue-700 border border-blue-700 hover:border-blue-300 focus:ring-4 focus:ring-blue-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" width="15px" height="15px" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#2D527C;" d="M438.557,512H19.785c-8.216,0-14.876-6.66-14.876-14.876V256.916c0-8.216,6.66-14.876,14.876-14.876 s14.876,6.66,14.876,14.876v225.332h389.021v-32.833c0-8.216,6.661-14.876,14.876-14.876c8.215,0,14.876,6.66,14.876,14.876v47.709 C453.433,505.34,446.772,512,438.557,512z"></path> <g> <polygon style="fill:#CEE8FA;" points="19.785,177.122 19.785,172.332 175.581,14.876 175.581,177.122 "></polygon> <rect x="196.154" y="219.435" style="fill:#CEE8FA;" width="296.061" height="163.65"></rect> </g> <g> <path style="fill:#2D527C;" d="M492.215,204.559h-38.782V14.876C453.433,6.66,446.772,0,438.557,0H175.581 c-0.183,0-0.363,0.021-0.546,0.027c-0.167,0.006-0.332,0.013-0.498,0.025c-0.643,0.046-1.282,0.118-1.909,0.245 c-0.013,0.003-0.027,0.007-0.042,0.01c-0.617,0.126-1.22,0.305-1.815,0.509c-0.155,0.054-0.309,0.109-0.463,0.167 c-0.585,0.222-1.159,0.469-1.711,0.762c-0.019,0.01-0.042,0.018-0.061,0.03c-0.568,0.305-1.108,0.66-1.635,1.04 c-0.135,0.098-0.268,0.196-0.4,0.299c-0.522,0.402-1.028,0.827-1.497,1.3L9.21,161.868c-0.35,0.353-0.678,0.721-0.988,1.104 c-0.207,0.254-0.388,0.521-0.576,0.784c-0.092,0.131-0.195,0.256-0.283,0.388c-0.214,0.324-0.405,0.66-0.592,0.998 c-0.046,0.083-0.1,0.162-0.143,0.245c-0.183,0.347-0.342,0.701-0.495,1.056c-0.037,0.086-0.082,0.168-0.116,0.256 c-0.14,0.341-0.256,0.689-0.369,1.038c-0.036,0.112-0.08,0.219-0.113,0.33c-0.095,0.321-0.17,0.646-0.242,0.971 c-0.033,0.147-0.076,0.293-0.106,0.442c-0.058,0.3-0.095,0.604-0.134,0.907c-0.024,0.177-0.057,0.351-0.074,0.53 c-0.028,0.303-0.034,0.607-0.045,0.912c-0.006,0.167-0.024,0.332-0.024,0.498v4.792c0,8.216,6.66,14.876,14.876,14.876h155.796 c8.216,0,14.876-6.66,14.876-14.876V29.752h233.225v174.807H196.156c-8.216,0-14.876,6.66-14.876,14.876v163.644 c0,8.216,6.66,14.876,14.876,14.876h296.059c8.215,0,14.876-6.66,14.876-14.876V219.435 C507.091,211.219,500.43,204.559,492.215,204.559z M50.691,162.246L160.705,51.06v111.186H50.691z M477.339,368.203H211.032 V234.311h266.308V368.203z"></path> <path style="fill:#2D527C;" d="M255.692,313.875l-16.073,27.302c-0.771,1.211-2.312,1.761-4.073,1.761 c-4.734,0-11.45-3.743-11.45-8.476c0-0.991,0.33-1.981,0.992-3.082l19.046-29.393l-18.275-29.283 c-0.771-1.211-1.101-2.312-1.101-3.413c0-4.623,6.275-8.148,11.12-8.148c2.422,0,4.073,0.881,5.174,2.862l14.642,25.54 l14.641-25.54c1.101-1.981,2.754-2.862,5.175-2.862c4.844,0,11.12,3.523,11.12,8.148c0,1.101-0.332,2.202-1.101,3.413 l-18.275,29.283l19.046,29.393c0.66,1.101,0.991,2.092,0.991,3.082c0,4.734-6.715,8.476-11.449,8.476 c-1.761,0-3.413-0.55-4.073-1.761L255.692,313.875z"></path> <path style="fill:#2D527C;" d="M301.595,342.277c-3.744,0-7.487-1.761-7.487-5.284v-70.017c0-3.633,4.295-5.174,8.586-5.174 c4.295,0,8.586,1.541,8.586,5.174v60.329h25.1c3.304,0,4.955,3.744,4.955,7.487c0,3.743-1.651,7.486-4.955,7.486h-34.786V342.277z"></path> <path style="fill:#2D527C;" d="M381.294,320.7c0-13.321-34.899-11.01-34.899-36.77c0-16.514,14.422-22.788,28.182-22.788 c5.836,0,21.909,1.101,21.909,9.689c0,2.972-1.981,9.027-6.827,9.027c-3.963,0-6.055-4.183-15.083-4.183 c-7.816,0-11.008,3.192-11.008,6.605c0,11.01,34.899,8.918,34.899,36.66c0,15.853-11.56,24.44-27.523,24.44 c-14.421,0-26.531-7.045-26.531-14.312c0-3.744,3.304-9.248,7.486-9.248c5.175,0,8.476,8.148,18.715,8.148 C375.68,327.967,381.294,325.985,381.294,320.7z"></path> <path style="fill:#2D527C;" d="M433.473,313.875l-16.073,27.302c-0.772,1.211-2.313,1.761-4.073,1.761 c-4.735,0-11.449-3.743-11.449-8.476c0-0.991,0.33-1.981,0.991-3.082l19.046-29.393l-18.275-29.283 c-0.771-1.211-1.101-2.312-1.101-3.413c0-4.623,6.276-8.148,11.12-8.148c2.422,0,4.073,0.881,5.175,2.862l14.642,25.54 l14.642-25.54c1.099-1.981,2.752-2.862,5.174-2.862c4.845,0,11.12,3.523,11.12,8.148c0,1.101-0.33,2.202-1.101,3.413 l-18.274,29.283l19.046,29.393c0.66,1.101,0.991,2.092,0.991,3.082c0,4.734-6.717,8.476-11.449,8.476 c-1.763,0-3.414-0.55-4.073-1.761L433.473,313.875z"></path> </g> </g></svg>
                            <span class="ms-1"> بارگزاری اکسل</span>
                        </button>
                    </div>
                </div>

                <div class="my-2 p-2 flex flex-wrap rounded-md">
                    <div class="w-full">
                        <button
                            @click="resetFilters"
                            class="text-sm border border-red-500 p-2 rounded-md text-red-600 cursor-pointer"
                        >
                            حذف فیلترها
                        </button>
                    </div>
                    <div class="grid grid-cols-2 lg:grid-cols-5 xl:grid-cols-6 md:grid-cols-4 sm:grid-cols-2 gap-3 mt-2">

                        <div>
                            <span class="text-sm">وضعیت انتشار</span>
                            <BaseSwitch v-model="filterForm.status" @update:modelValue="applyFilters" />
                        </div>
                        <div>
                            <span class="text-sm">وضعیت فروش</span>
                            <BaseSwitch v-model="filterForm.buyable" @update:modelValue="applyFilters" />
                        </div>
                        <div>
                            <span class="text-sm">فروش ویژه</span>
                            <BaseSwitch v-model="filterForm.pinned" @update:modelValue="applyFilters" />
                        </div>

                        <div>
                            <span class="text-sm">شگفت انگیز</span>
                            <BaseSwitch v-model="filterForm.amazing" @update:modelValue="applyFilters" />
                        </div>

                        <div>
                            <span class="text-sm">پیشنهادی</span>
                            <BaseSwitch v-model="filterForm.suggested" @update:modelValue="applyFilters" />
                        </div>
                        <div>
                            <span class="text-sm">فروش قسطی</span>
                            <BaseSwitch v-model="filterForm.torobpay" @update:modelValue="applyFilters" />
                        </div>


                        <div>
                            <span class="text-sm">پیش سفارش</span>
                            <BaseSwitch v-model="filterForm.pre_order" @update:modelValue="applyFilters" />
                        </div>

                    </div>
                </div>
                <div class="my-2 p-2 rounded-md">
                    <FlashMessage />
                </div>
                <hr />
                <div class="my-2 flex flex-wrap p-1">
                    <div class="grid grid-cols-1 lg:grid-cols-3 xl:grid-cols-4 md:grid-cols-2 sm:grid-cols-2 gap-2">
                        <div>
                            <input
                                v-model="filterForm.search"
                                type="text"
                                placeholder="جستجو نام محصول..."
                                class="border border-gray-500 rounded px-3 py-2 text-sm w-full"
                                @input="applyFilters"
                            />
                        </div>

                        <div>
                            <select
                                class="bg-white m-1 p-2 text-slate-700 text-sm border border-slate-200 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md w-full"
                            >
                                <option>انتخاب عملیات گروهی</option>
                                <option @click="bulkDeactivate">غیرفعال کردن</option>
                                <option @click="bulkActivate">فعال سازی</option>
                                <option @click="bulkSoldOut">ناموجود کردن</option>
                                <option @click="bulkInstock">موجود کردن</option>
                                <option @click="bulkDelete">حذف</option>
                                <option @click="bulkRestore">بازیابی</option>
                            </select>

                        </div>
                    </div>

                </div>
                <div class="relative flex flex-wrap w-full overflow-x-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">

                    <table class="w-full text-right table-auto min-w-max">
                        <thead>
                        <tr>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <input type="checkbox" v-model="selectAll" />
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    #
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    تصویر محصول
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    نام محصول
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    برند
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    قیمت
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    موجودی
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    وضعیت
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    انتشار
                                </p>
                            </th>
                            <th class="p-4 border-b border-slate-300 bg-slate-50">
                                <p class="block text-sm font-normal leading-none text-slate-500">
                                    عملیات
                                </p>
                            </th>
                        </tr>
                        </thead>
                        <tbody v-if="models && models.data">
                        <tr v-for="(item, index) in models.data" :key="index" :class="item.deleted_at ? 'bg-red-100' : ''">
                            <td class="p-4 border-b border-slate-200 py-5">
                                <input type="checkbox" v-model="selectedIds" :value="item.id" />
                            </td>
                            <td class="p-4 border-b border-slate-200 py-5">
                                <Link :href="`/admin/product/${item.id}/edit`" class="cursor-pointer text-blue-500">
                                <p class="block font-semibold text-sm">{{ item.id }}</p>
                                </Link>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <div v-if="item.image" class="mt-2">
                                    <img :src="item.image" class="border rounded object-fill table-img" />
                                </div>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <Link :href="`/admin/product/${item.id}/edit`" class="cursor-pointer text-blue-500">
                                <p class="text-sm">{{ item.name }}</p>
                                </Link>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <p class="text-sm text-slate-500">{{ item?.brand?.name }}</p>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <p class="text-sm text-slate-500">
                                    <span v-if="(item.offer_price && item.offer_price < item.price && item.offer_end_date > props.today) || (item.offer_price && item.offer_price < item.price)">
                                        <span class="text-red-800/80">{{ Number(item.offer_price).toLocaleString() }}</span>
                                        <br />
                                        <span class="text-gray-600/50">{{Number(item.price).toLocaleString()}}</span>
                                    </span>
                                    <span v-else>
                                        {{ Number(item.price).toLocaleString() }}
                                    </span>

                                </p>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <p class="text-sm text-slate-500">{{ item.stock }}</p>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1" style="direction: ltr">
                                <button
                                    @click="toggleStatus(item.id)"
                                    class="relative inline-flex h-4 w-8 items-center rounded-full transition-colors duration-300 cursor-pointer"
                                    :class="item.status ? 'bg-green-700' : 'bg-gray-300'"
                                >
                                  <span
                                      class="inline-block h-3 w-3 transform rounded-full bg-gray-200 transition-transform duration-300"
                                      :class="item.status ? 'translate-x-1' : 'translate-x-5'"
                                  />
                                </button>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <p v-if="item.published_at" class="text-sm text-slate-500">{{ formatDate(item.published_at) }}</p>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <button @click="openQuickEdit(item)" title="ویرایش سریع"
                                    class="relative cursor-pointer h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                    type="button">
                                     <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                         <svg width="16px" height="16px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title></title> <g id="Complete"> <g id="edit"> <g> <path d="M20,16v4a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V6A2,2,0,0,1,4,4H8" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path> <polygon fill="none" points="12.5 15.8 22 6.2 17.8 2 8.3 11.5 8 16 12.5 15.8" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></polygon> </g> </g> </g> </g></svg>

                                     </span>
                                </button>
                                <Link :href="`/admin/product/${item.id}/edit`">
                                    <button title="ویرایش کامل"
                                        class="relative cursor-pointer h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                        type="button">
                                     <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">

  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
       class="w-4 h-4">
                                      <path
                                          d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z">
                                      </path>
                                    </svg>
                                     </span>
                                    </button>
                                </Link>
                                <a :href="`/shop/product/${item.slug}`" target="_blank">
                                    <button title="نمایش محصول"
                                        class="relative cursor-pointer h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                        type="button">
                                     <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                            <svg fill="#000000" width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M21.92,11.6C19.9,6.91,16.1,4,12,4S4.1,6.91,2.08,11.6a1,1,0,0,0,0,.8C4.1,17.09,7.9,20,12,20s7.9-2.91,9.92-7.6A1,1,0,0,0,21.92,11.6ZM12,18c-3.17,0-6.17-2.29-7.9-6C5.83,8.29,8.83,6,12,6s6.17,2.29,7.9,6C18.17,15.71,15.17,18,12,18ZM12,8a4,4,0,1,0,4,4A4,4,0,0,0,12,8Zm0,6a2,2,0,1,1,2-2A2,2,0,0,1,12,14Z"/></svg>
                                     </span>
                                    </button>
                                </a>



                                <button title="بازیابی رکورد" v-if="item.deleted_at" @click="restore(item.id)"
                                        class="relative cursor-pointer h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                        type="button">
                                  <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                    <svg width="25px" height="25px" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg"><path d="M25 38c-5.1 0-9.7-3-11.8-7.6l1.8-.8c1.8 3.9 5.7 6.4 10 6.4 6.1 0 11-4.9 11-11s-4.9-11-11-11c-4.6 0-8.5 2.8-10.1 7.3l-1.9-.7c1.9-5.2 6.6-8.6 12-8.6 7.2 0 13 5.8 13 13s-5.8 13-13 13z"/><path d="M20 22h-8v-8h2v6h6z"/></svg>
                                  </span>
                                </button>
                                <button v-else title="حذف رکورد" @click="destroy(item.id)"
                                        class="relative cursor-pointer h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                        type="button">
                                      <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                          <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14px" height="14px" viewBox="0 0 488.936 488.936" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M381.16,111.948H107.376c-6.468,0-12.667,2.819-17.171,7.457c-4.504,4.649-6.934,11.014-6.738,17.477l9.323,307.69 c0.39,12.92,10.972,23.312,23.903,23.312h20.136v-21.012c0-24.121,19.368-44.049,43.488-44.049h127.896 c24.131,0,43.893,19.928,43.893,44.049v21.012h19.73c12.933,0,23.52-10.346,23.913-23.268l9.314-307.7 c0.195-6.462-2.234-12.863-6.738-17.513C393.821,114.767,387.634,111.948,381.16,111.948z"></path> <path d="M309.166,435.355H181.271c-6.163,0-11.915,4.383-11.915,11.516v30.969c0,6.672,5.342,11.096,11.915,11.096h127.895 c6.323,0,11.366-4.773,11.366-11.096v-30.969C320.532,440.561,315.489,435.355,309.166,435.355z"></path> <path d="M427.696,27.106C427.696,12.138,415.563,0,400.591,0H88.344C73.372,0,61.239,12.138,61.239,27.106v30.946 c0,14.973,12.133,27.106,27.105,27.106H400.59c14.973,0,27.105-12.133,27.105-27.106L427.696,27.106L427.696,27.106z"></path> </g> </g> </g></svg>
                                      </span>
                                </button>
                        </td>

                    </tr>

                    </tbody>
                </table>

                    <QuickEditRow
                        v-if="selectedProduct"
                        :product="selectedProduct"
                        @close="selectedProduct = null"
                    />

                    <ProductExportModal
                        v-if="selectedExport"
                        :brands="brands" :categories="categories"
                        @close="selectedExport = null"
                    />

                    <ProductImportModal
                        v-if="selectedImport"
                        @close="selectedImport = null"
                    />

                    <div class="my-3" v-if="models">
                        <Pagination :links="models.links" />
                    </div>
            </div>
            </div>
        </div>
    </AppLayout>
</template>
