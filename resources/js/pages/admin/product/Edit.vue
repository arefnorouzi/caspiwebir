<script setup lang="ts">
import TabContainer from "@/components/admin/TabContainer.vue";
import ProductVariantsTab from '@/components/admin/ProductVariantsTab.vue';
import ProductInventoryTab from '@/components/admin/ProductInventoryTab.vue';
import ProductPricingTab from '@/components/admin/ProductPricingTab.vue';
import ProductAttributesTab from '@/components/admin/ProductAttributesTab.vue';
import ProductInfoTab from '@/components/admin/ProductInfoTab.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import {watch, ref} from 'vue';
import { type BreadcrumbItem } from '@/types';
import ProductSeoTab from '@/components/admin/ProductSeoTab.vue';
import FlashMessage from "@/components/FlashMessage.vue";
import ProductDescription from "@/components/admin/ProductDescription.vue";
import ProductCourseTab from "@/components/admin/ProductCourseTab.vue";
import ProductGalleryTab from "@/components/admin/ProductGalleryTab.vue";
import {showToast} from "@/composables/useToast";
import ProductSizeTab from "@/components/admin/ProductSizeTab.vue";
import ProductRelatedTab from "@/components/admin/ProductRelatedTab.vue";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'ویرایش محصول',
        href: '/admin/product',
    },
];


const props = defineProps({
    categories: Object,
    brands: Object,
    model: Object,
    variants: Object,
    properties: Object,
    colors: Object,
    sizes: Object,
    selected_categories: Array,
    product_role_prices: Object,
    roles: Object,
    inventories: Object,
    inventory_product: Object,
    product_units: Object,
    related_items: Object
});

const form = useForm({
    name: props.model.name,
    sku: props.model.sku,
    slug: props.model.slug,
    guarantee: props.model.guarantee,
    warranty: props.model.warranty,
    podcast: props.model.podcast,
    video: props.model.video,
    video_poster: props.model.video_poster,
    note: props.model.note,
    stock: props.model.stock,
    min_buy: props.model.min_buy,
    price: props.model.price,
    offer_price: props.model.offer_price,
    offer_end_date: props.model.offer_end_date,
    meta: props.model.meta,
    description: props.model.description,
    excerpt_review: props.model.excerpt_review,
    image: props.model.image,
    status: props.model.status,
    pinned: props.model.pinned,
    source: props.model.source,
    buyable: props.model.buyable,
    pre_order: props.model.pre_order,
    call_to_price: props.model.call_to_price,
    installment_purchase: props.model.installment_purchase,
    amazing: props.model.amazing,
    suggested: props.model.suggested,
    downloadable: props.model.downloadable,
    is_service: props.model.is_service,
    is_addon: props.model.is_addon,
    course_time: props.model.course_time,
    duration: props.model.duration,
    brand_id: props.model.brand_id,
    product_unit_id: props.model.product_unit_id,
    categories: [...props.selected_categories]
})
async function submit() {
    form.patch("/admin/product/" + props.model.id, {
        onError(error){
            showToast(error, "error")
        }
    })
}

const form_tabs = ref([
    { key: 'info', label: 'اطلاعات محصول', status: true },
    { key: 'description', label: 'توضیحات محصول' , status: true },
    { key: 'attributes', label: 'ویژگی‌ها' , status: true },
    { key: 'galleries', label: 'گالری' , status: true },
    { key: 'pricing', label: 'قیمت‌گذاری' , status: true },
    { key: 'seo', label: 'سئو' , status: true },
    { key: 'courses', label: 'دروس' , status: false },
    { key: 'dimensions', label: 'ابعاد و وزن' , status: true },
    { key: 'inventory', label: 'موجودی انبار' , status: true },
    { key: 'variants', label: 'متغیرها' , status: true },
    { key: 'related', label: 'محصولات مشابه' , status: true },
])

watch(() => form.downloadable, (newVal) => {
    if (Number(newVal)) {
        const coursesTab = form_tabs.value.find(tab => tab.key === 'courses');
        if (coursesTab) {
            coursesTab.status = true;
        }
        const variantTab = form_tabs.value.find(tab => tab.key === 'variants');
        if (variantTab) {
            variantTab.status = false;
        }
        const dimensionsTab = form_tabs.value.find(tab => tab.key === 'dimensions');
        if (dimensionsTab) {
            dimensionsTab.status = false;
        }
        const inventoryTab = form_tabs.value.find(tab => tab.key === 'inventory');
        if (inventoryTab) {
            inventoryTab.status = false;
        }
    }
    else {
        const coursesTab = form_tabs.value.find(tab => tab.key === 'courses');
        if (coursesTab) {
            coursesTab.status = false;
        }
        const variantTab = form_tabs.value.find(tab => tab.key === 'variants');
        if (variantTab) {
            variantTab.status = true;
        }
        const dimensionsTab = form_tabs.value.find(tab => tab.key === 'dimensions');
        if (dimensionsTab) {
            dimensionsTab.status = true;
        }
        const inventoryTab = form_tabs.value.find(tab => tab.key === 'inventory');
        if (inventoryTab) {
            inventoryTab.status = true;
        }
    }
});


</script>

<template>
    <Head title="ویرایش محصول" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-wrap gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                    <div>
                        <h3 class="text-lg mb-3 font-semibold text-slate-800 sm-text">ویرایش محصول: {{props?.model.name}}</h3>
                    </div>
                    <div class="ml-3">
                        <Link :href="`/admin/product`">
                            <button
                                class="me-1 cursor-pointer text-black bg-white border border-gray-200 hover:border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-md inline-flex items-center px-3 py-2.5 text-center mr-2">
                                <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20 10L20.7071 10.7071L21.4142 10L20.7071 9.29289L20 10ZM3 18C3 18.5523 3.44772 19 4 19C4.55229 19 5 18.5523 5 18L3 18ZM15.7071 15.7071L20.7071 10.7071L19.2929 9.29289L14.2929 14.2929L15.7071 15.7071ZM20.7071 9.29289L15.7071 4.29289L14.2929 5.70711L19.2929 10.7071L20.7071 9.29289ZM20 9L10 9L10 11L20 11L20 9ZM3 16L3 18L5 18L5 16L3 16ZM10 9C6.13401 9 3 12.134 3 16L5 16C5 13.2386 7.23858 11 10 11L10 9Z" fill="#33363F"></path> </g></svg>

                                <span class="ms-1">بازگشت</span>
                            </button>
                        </Link>
                    </div>
                </div>



                <div class="w-full lg:w-1/2 md:w-1/2 sm:w-1/2">
                    <FlashMessage />
                </div>

                <div class="w-full my-2">
                    <button @click="submit"
                            class="me-1 cursor-pointer text-oklch(44.8% 0.119 151.328) bg-green-200 hover:bg-green-300 focus:ring-4 focus:ring-green-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                        <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M18.1716 1C18.702 1 19.2107 1.21071 19.5858 1.58579L22.4142 4.41421C22.7893 4.78929 23 5.29799 23 5.82843V20C23 21.6569 21.6569 23 20 23H4C2.34315 23 1 21.6569 1 20V4C1 2.34315 2.34315 1 4 1H18.1716ZM4 3C3.44772 3 3 3.44772 3 4V20C3 20.5523 3.44772 21 4 21L5 21L5 15C5 13.3431 6.34315 12 8 12L16 12C17.6569 12 19 13.3431 19 15V21H20C20.5523 21 21 20.5523 21 20V6.82843C21 6.29799 20.7893 5.78929 20.4142 5.41421L18.5858 3.58579C18.2107 3.21071 17.702 3 17.1716 3H17V5C17 6.65685 15.6569 8 14 8H10C8.34315 8 7 6.65685 7 5V3H4ZM17 21V15C17 14.4477 16.5523 14 16 14L8 14C7.44772 14 7 14.4477 7 15L7 21L17 21ZM9 3H15V5C15 5.55228 14.5523 6 14 6H10C9.44772 6 9 5.55228 9 5V3Z" fill="#008040"></path> </g></svg>
                        <span class="ms-1">ذخیره اطلاعات</span>
                    </button>
                </div>

                <div class="relative flex flex-wrap w-full h-full text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">


                    <TabContainer
                        :tabs="form_tabs"
                    >
                        <!-- Slot برای نمایش محتوا -->
                        <template #default="{ activeTab }">

                            <div v-if="activeTab === 'info'">
                                <ProductInfoTab
                                    :model="props.model"
                                    :categories="props.categories"
                                    :selected_categories="props.selected_categories"
                                    :brands="props.brands"
                                    :product_units="props.product_units"
                                    :form="form"
                                    :tabs="form_tabs"
                                />
                            </div>
                            <div v-if="activeTab === 'description'">
                                <ProductDescription
                                    :model="props.model"
                                    :form="form"
                                />
                            </div>

                            <div v-if="activeTab === 'attributes'">
                                <ProductAttributesTab
                                    :product_id="props?.model?.id"
                                    :properties="props.properties"
                                />
                            </div>

                            <div v-if="activeTab === 'galleries'">
                                <ProductGalleryTab
                                    :product_id="props?.model?.id"
                                    :galleries="props?.model?.galleries"
                                />
                            </div>

                            <div v-if="activeTab === 'courses'">
                                <ProductCourseTab
                                    :product_id="props.model.id"
                                    :courses="props?.model?.courses"
                                />
                            </div>

                            <div v-if="activeTab === 'pricing'">
                                <ProductPricingTab
                                    :model="props.model"
                                    :prices="product_role_prices"
                                    :roles="props.roles"
                                />
                            </div>

                            <div v-if="activeTab === 'inventory'">
                                <ProductInventoryTab
                                    :product_id="props?.model?.id"
                                    :inventories="props.inventories"
                                    :inventory_product="props.inventory_product"
                                />
                            </div>

                            <div v-if="activeTab === 'dimensions'">
                                <ProductSizeTab
                                    :model="props.model"
                                />
                            </div>

                            <div v-if="activeTab === 'seo'">
                                <ProductSeoTab
                                    :model="props.model"
                                />
                            </div>

                            <div v-if="activeTab === 'variants'">
                                <ProductVariantsTab
                                    :model="props.model"
                                    :variants="props.model?.variants"
                                    :colors="props.colors"
                                    :sizes="props.sizes"

                                />
                            </div>
                            <div v-if="activeTab === 'related'">
                                <ProductRelatedTab
                                    :product_id="props?.model?.id"
                                    :related_items="props?.related_items"
                                />
                            </div>

                        </template>
                    </TabContainer>
                </div>

            </div>
        </div>
    </AppLayout>


</template>
