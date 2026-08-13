<script setup lang="ts" xmlns="http://www.w3.org/1999/html">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import Pagination from '@/components/Pagination.vue';
import { ref, watch, computed } from 'vue';
import _ from 'lodash';
import FlashMessage from '@/components/FlashMessage.vue';
import QuickEditRow from '@/components/admin/QuickEditRow.vue'
import BaseSwitch from '@/components/admin/BaseSwitch.vue';
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
    category: props.filters.category ?? null,
    brand: props.filters.brand ?? null,
})

const discount_types = [
    {id: 'percent', name: 'تخفیف درصدی'},
    {id: 'fixed', name: 'تخفیف مبلغ ثابت'},
]

const search = ref(props.filters.search);
watch(search, _.debounce(
    (q) => router.get('/admin/products', {search: q}, {preserveState: true}
    ), 1000));


const applyFilters = _.debounce(() => {
    router.get('/admin/products',
        filterForm,
        {
            preserveState: true,
            replace: true,
        }
    )
}, 400)

const resetFilters = () => {
    filterForm.search = '';
    filterForm.pinned = null;
    filterForm.status = null;
    filterForm.amazing = null;
    filterForm.suggested = null;
    filterForm.torobpay = null;
    filterForm.buyable = null;
    filterForm.pre_order = null;
    filterForm.category = null;
    filterForm.brand = null;
    applyFilters()
}

const selectedIds = ref([]);
const selectAll = computed({
    get: () => {
        return props?.models?.data?.length > 0 &&
            selectedIds.value.length === props?.models?.data?.length;
    },
    set: (value) => {
        if (value) {
            selectedIds.value = props?.models?.data.map(p => p.id);
            discount_form.ids = props?.models?.data.map(p => p.id)
        } else {
            selectedIds.value = [];
            discount_form.ids = []
        }
    }
});



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
const openQuickEdit = (product: any) => {
    selectedProduct.value = product
}
const formatDate = (d) =>
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'numeric', day: 'numeric' })


const discount_form = useForm({
    discount_type: 'percent',
    discount_value: 0,
    ids: [],
    offer_end_date: null,
    min_price: null,
    max_off_amount: null
});

const bulkDiscount = () => {
    if (confirm(`برای ${selectedIds.value.length} محصول تخفیف اعمال شود؟`)) {
        router.patch('/admin/products/group-discount', discount_form, {
            preserveScroll: true,
            onSuccess: () => { selectedIds.value = []; }
        });
    }
};

</script>

<template>
    <Head title="مدیریت محصولات" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >

                <hr class="my-2" />
                <div class="w-full flex justify-between items-center mb-3 mt-1 p-2">
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

                <Link :href="`/admin/products`" class="m-1">
                    <button
                        class="me-1 cursor-pointer text-blue-700 bg-blue-200 hover:bg-blue-300 focus:ring-4 focus:ring-blue-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                        <svg width="15px" height="15px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M18 5.65l-8-3.555L2 5.65V19H0V5c0-.396.232-.753.594-.913l9-4a.999.999 0 01.812 0l9 4A1 1 0 0120 5v14h-2V5.65z" fill="#5C5F62"></path><path d="M9 15a.997.997 0 01-.707-.293l-2-2a1 1 0 011.414-1.414L9 12.586l3.293-3.293a1 1 0 111.414 1.415l-4 4A.999.999 0 019 15z" fill="#5C5F62"></path></g></svg>
                        <span class="ms-1">همه محصولات</span>
                    </button>
                </Link>
                <Link :href="`/admin/products?outofstock=true`" class="m-1">
                    <button
                        class="me-1 cursor-pointer text-black bg-orange-200 hover:bg-orange-300 focus:ring-4 focus:ring-orange-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                        <svg width="15px" height="15px" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M18.7071 4.69719C19.0976 4.30667 19.7308 4.30667 20.1213 4.69719L28.6066 13.1825C28.9971 13.573 28.9971 14.2062 28.6066 14.5967C28.216 14.9872 27.5829 14.9872 27.1924 14.5967L18.7071 6.1114C18.3166 5.72088 18.3166 5.08771 18.7071 4.69719Z" fill="#333333"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M28.7071 4.7068C29.0976 5.09733 29.0976 5.73049 28.7071 6.12102L20.2218 14.6063C19.8313 14.9968 19.1981 14.9968 18.8076 14.6063C18.4171 14.2158 18.4171 13.5826 18.8076 13.1921L27.2929 4.7068C27.6834 4.31628 28.3166 4.31628 28.7071 4.7068Z" fill="#333333"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M24.3162 15.0513C24.111 14.9829 23.8891 14.9829 23.6838 15.0513L8.86851 19.9889C8.64603 20.063 8.463 20.2102 8.34247 20.3985L4.39805 25.4613C4.1985 25.7175 4.13573 26.0545 4.2297 26.3653C4.32367 26.6761 4.56269 26.922 4.87072 27.0246L8.19325 28.1319L8.19595 36.7634C8.19636 38.0544 9.02257 39.2003 10.2473 39.6085L23.6291 44.0691C23.7475 44.1164 23.8738 44.1406 24.0009 44.1405C24.1293 44.141 24.2569 44.1168 24.3765 44.069L37.7577 39.6086C38.9827 39.2003 39.8089 38.054 39.809 36.7628L39.8096 28.1328L43.1346 27.0246C43.4427 26.922 43.6817 26.6761 43.7757 26.3653C43.8696 26.0545 43.8069 25.7175 43.6073 25.4613L39.6117 20.3327C39.4927 20.176 39.3274 20.0542 39.1315 19.9889L24.3162 15.0513ZM9.54341 22.1112L22.346 26.378L19.6478 29.8413L6.8452 25.5745L9.54341 22.1112ZM24.0025 24.8203L35.6526 20.9376L24 17.0541L12.35 20.9367L24.0025 24.8203ZM10.196 36.7628L10.1935 28.7986L19.686 31.9622C20.088 32.0962 20.5307 31.9623 20.7911 31.6281L23.0003 28.7924L23.0001 41.7513L10.8797 37.7112C10.4715 37.5751 10.1961 37.1931 10.196 36.7628ZM37.8095 28.7993L28.3193 31.9622C27.9174 32.0962 27.4747 31.9623 27.2143 31.6281L25.0013 28.7876L25.0049 41.7514L37.1252 37.7113C37.5336 37.5752 37.809 37.1931 37.809 36.7627L37.8095 28.7993ZM28.3576 29.8413L25.6583 26.3767L38.4609 22.1099L41.1602 25.5745L28.3576 29.8413Z" fill="#333333"></path> </g></svg>
                        <span class="ms-1"> محصولات ناموجود</span>
                    </button>
                </Link>

                <div class="my-2 p-2 rounded-md">
                    <div class="grid grid-cols-1 lg:grid-cols-6 xl:grid-cols-8 md:grid-cols-4 sm:grid-cols-2 gap-2">
                        <div>
                            <button
                                @click="resetFilters"
                                class="text-sm border border-red-500 p-2 rounded-md text-red-600 cursor-pointer"
                            >
                                حذف فیلترها
                            </button>
                        </div>
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
                <div class="my-1">
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

                    </div>

                </div>
                <div class="mt-5 bg-gray-100 p-2">
                    <h3 class="font-bold mb-2">فرم اعمال تخفیف گروهی</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-4 xl:grid-cols-6 md:grid-cols-4 sm:grid-cols-2 gap-2">
                        <div>
                            <label class="text-xs text-gray-500">انتخاب دسته بندی</label>
                            <select v-model="filterForm.category" @change="applyFilters"
                                    class="bg-white m-1 p-2 text-slate-700 text-sm w-full border border-slate-200 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md">
                                <option :value="null">انتخاب دسته بندی</option>
                                <option
                                    v-for="category in categories" :key="category.id"
                                    :value="category.id">{{ category.name }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500">انتخاب برند</label>
                            <select v-model="filterForm.brand" @change="applyFilters"
                                    class="bg-white m-1 p-2 text-slate-700 w-full text-sm border border-slate-200 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md">
                                <option :value="null">انتخاب برند</option>
                                <option
                                    v-for="brand in brands" :key="brand.id"
                                    :value="brand.id">{{ brand.name }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500">نوع تخفیف</label>
                            <select v-model="discount_form.discount_type"
                                    class="bg-white m-1 p-2 text-slate-700 w-full text-sm border border-slate-200 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md">
                                <option
                                    v-for="discount_type in discount_types" :key="discount_type.id"
                                    :value="discount_type.id">{{ discount_type.name }}</option>
                            </select>
                            <div v-if="discount_form.errors.discount_type" class="text-red-500 text-sm mt-1">
                                {{ discount_form.errors.discount_type }}
                            </div>
                        </div>
                        <div>
                            <label for="stock" class="text-xs text-gray-500">مبلغ تخفیف (
                                <span v-if="discount_form.discount_type == 'percent'">0-100 بدون علامت %</span>
                                <span v-else>تومان</span>
                                )</label>
                            <input :type="discount_form.discount_type == 'percent' ? 'text' : 'number'"
                                   v-model="discount_form.discount_value" name="stock" id="stock"
                                   class="bg-white m-1 p-2 text-slate-700 w-full text-sm border border-slate-200 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md" placeholder="" required="">
                            <div v-if="discount_form.errors.discount_value" class="text-red-500 text-sm mt-1">
                                {{ discount_form.errors.discount_value }}
                            </div>
                        </div>
                        <div>
                            <label for="offer_end_date" class="text-xs text-gray-500">انقضای تخفیف</label>
                            <input type="date" v-model="discount_form.offer_end_date" name="offer_end_date" id="offer_end_date" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="">
                            <div v-if="discount_form.errors.offer_end_date" class="text-red-500 text-sm mt-1">
                                {{ discount_form.errors.offer_end_date }}
                            </div>
                        </div>
                        <div>
                            <label for="offer_end_date" class="text-xs text-gray-500">انقضای تخفیف</label>
                            <input type="text" v-model="discount_form.offer_end_date" name="offer_end_date" id="offer_end_date" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                   placeholder="">
                        </div>

                        <div class="content-center pt-1 col-span-2">
                            <button @click="bulkDiscount"
                                    class="me-1 cursor-pointer text-oklch(44.8% 0.119 151.328) bg-green-200 hover:bg-green-300 focus:ring-4 focus:ring-green-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M10 8.99998C10.5523 8.99998 11 9.44769 11 9.99998C11 10.5523 10.5523 11 10 11C9.44775 11 9.00004 10.5523 9.00004 9.99998C9.00004 9.44769 9.44775 8.99998 10 8.99998Z" fill="#000000"></path> <path d="M13 14C13 14.5523 13.4478 15 14 15C14.5523 15 15 14.5523 15 14C15 13.4477 14.5523 13 14 13C13.4478 13 13 13.4477 13 14Z" fill="#000000"></path> <path d="M10.7071 14.7071L14.7071 10.7071C15.0977 10.3166 15.0977 9.6834 14.7071 9.29287C14.3166 8.90235 13.6835 8.90235 13.2929 9.29287L9.29293 13.2929C8.90241 13.6834 8.90241 14.3166 9.29293 14.7071C9.68346 15.0976 10.3166 15.0976 10.7071 14.7071Z" fill="#000000"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M16.3117 4.07145L15.1708 4.34503L14.5575 3.34485C13.3869 1.43575 10.6131 1.43575 9.44254 3.34485L8.82926 4.34503L7.68836 4.07145C5.51069 3.54925 3.54931 5.51063 4.07151 7.6883L4.34509 8.8292L3.34491 9.44248C1.43581 10.6131 1.43581 13.3869 3.34491 14.5575L4.34509 15.1708L4.07151 16.3117C3.54931 18.4893 5.51069 20.4507 7.68836 19.9285L8.82926 19.6549L9.44254 20.6551C10.6131 22.5642 13.3869 22.5642 14.5575 20.6551L15.1708 19.6549L16.3117 19.9285C18.4894 20.4507 20.4508 18.4893 19.9286 16.3117L19.655 15.1708L20.6552 14.5575C22.5643 13.3869 22.5643 10.6131 20.6552 9.44248L19.655 8.8292L19.9286 7.6883C20.4508 5.51063 18.4894 3.54925 16.3117 4.07145ZM11.1475 4.3903C11.5377 3.75393 12.4623 3.75393 12.8525 4.3903L13.8454 6.00951C14.0717 6.37867 14.51 6.56019 14.9311 6.45922L16.7781 6.01631C17.504 5.84225 18.1578 6.49604 17.9837 7.22193L17.5408 9.06894C17.4398 9.49003 17.6213 9.92827 17.9905 10.1546L19.6097 11.1475C20.2461 11.5377 20.2461 12.4623 19.6097 12.8525L17.9905 13.8453C17.6213 14.0717 17.4398 14.5099 17.5408 14.931L17.9837 16.778C18.1578 17.5039 17.504 18.1577 16.7781 17.9836L14.9311 17.5407C14.51 17.4398 14.0717 17.6213 13.8454 17.9904L12.8525 19.6097C12.4623 20.246 11.5377 20.246 11.1475 19.6097L10.1547 17.9904C9.92833 17.6213 9.49009 17.4398 9.069 17.5407L7.22199 17.9836C6.4961 18.1577 5.84231 17.5039 6.01637 16.778L6.45928 14.931C6.56026 14.5099 6.37873 14.0717 6.00957 13.8453L4.39036 12.8525C3.75399 12.4623 3.75399 11.5377 4.39036 11.1475L6.00957 10.1546C6.37873 9.92827 6.56026 9.49003 6.45928 9.06894L6.01637 7.22193C5.84231 6.49604 6.4961 5.84225 7.22199 6.01631L9.069 6.45922C9.49009 6.56019 9.92833 6.37867 10.1547 6.00951L11.1475 4.3903Z" fill="#000000"></path> </g></svg>
                                <span class="ms-1">اعمال تخفیف گروهی</span>
                            </button>
                        </div>

                    </div>

                </div>
                <div class="relative flex flex-col w-full h-full overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">

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
                                <p class="block font-semibold text-sm text-slate-800">{{ item.id }}</p>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <div v-if="item.image" class="mt-2">
                                    <img :src="item.image" class="border rounded object-fill table-img" />
                                </div>
                            </td>
                            <td class="p-4 border-b border-slate-200 py-1">
                                <p class="text-sm text-slate-500">{{ item.name }}</p>
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


                    <div class="my-3" v-if="models && models.data && models.data.length">
                        <Pagination :links="models.links" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
