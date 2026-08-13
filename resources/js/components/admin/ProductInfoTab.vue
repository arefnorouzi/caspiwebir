<script setup lang="ts">
import MediaPicker from "@/components/admin/MediaPicker.vue";
import InputComponent from "@/components/form/InputComponent.vue";
import SelectComponent from "@/components/form/SelectComponent.vue";
const props = defineProps({
    model: Object,
    categories: Object,
    selected_categories: Object,
    brands: Object,
    product_units: Object,
    form: Object
})

</script>

<template>
<div class="space-y-2">


        <div class="flex flex-wrap">
            <div class="border border-gray-200 rounded-md mb-2 p-2 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 mt-3">
                    <div class="">
                        <InputComponent v-model="props.form.name"
                                        label="نام محصول"
                                        :value="props.form.name"
                                        id="name"
                                        placeholder="عنوان را وارد کنید"
                                        :input_error="props.form?.errors?.name"
                        />

                    </div>

                    <div>
                        <InputComponent v-model="props.form.slug"
                                        :value="props.form.slug"
                                        label="لینک محصول"
                                        id="slug"
                                        placeholder="product-slug"
                                        :input_error="props.form?.errors?.slug"
                                        css_class="ltr"
                        />
                    </div>

                </div>
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mt-3">
                    <div>
                        <InputComponent v-model="props.form.sku"
                                        :value="props.form.sku"
                                        label="کد محصول"
                                        id="sku"
                                        placeholder="123456"
                                        :input_error="props.form?.errors?.sku"
                                        css_class="ltr"
                        />

                    </div>
                    <div>
                        <InputComponent v-model="props.form.guarantee"
                                        :value="props.form.guarantee"
                                        label="گارانتی"
                                        id="guarantee"
                                        placeholder="ضمانت اصالت کالا"
                                        :input_error="props.form?.errors?.guarantee"
                        />

                    </div>
                    <div>
                        <InputComponent v-model="props.form.warranty"
                                        :value="props.form.warranty"
                                        label="وارنتی"
                                        id="warranty"
                                        placeholder="ضمانت بازگشت وجه"
                                        :input_error="props.form?.errors?.warranty"
                        />

                    </div>
                    <div>
                        <SelectComponent label="انتخاب برند"
                                         id="brand" v-model="props.form.brand_id"
                                         :value="props.form.brand_id"
                                         :input_error="form?.errors?.brand_id"
                                         :options="brands"
                        />

                    </div>
                    <div>
                        <SelectComponent label="نوع محصول"
                                         :value="props.form.downloadable"
                                         id="brand" v-model="props.form.downloadable"
                                         :input_error="form?.errors?.downloadable"
                                         :options="[{id: 0, name: 'فیزیکی'}, {id: 1, name: 'دانلودی'}]"
                        />
                    </div>
                    <div v-if="props.form.downloadable == 1">
                        <SelectComponent label="دسترسی به منابع"
                                         :value="props.form.source"
                                         id="brand" v-model="props.form.source"
                                         :input_error="form?.errors?.source"
                                         :options="[{id: 0, name: 'ندارد'}, {id: 1, name: 'دارد'}]"
                        />
                    </div>
                    <div>
                        <SelectComponent label="واحد شمارش محصول"
                                         :value="props.form.product_unit_id"
                                         id="brand" v-model="props.form.product_unit_id"
                                         :input_error="form?.errors?.product_unit_id"
                                         :options="product_units"
                        />
                    </div>
                    <div>
                        <InputComponent v-model="props.form.stock"
                                        :value="props.form.stock"
                                        label="موجودی انبار"
                                        id="stock"
                                        placeholder="1"
                                        :input_error="props.form?.errors?.stock"
                                        css_class="ltr"
                                        type="number"
                        />
                    </div>

                    <div>
                        <SelectComponent label="برای قیمت تماس بگیرید" id="call_to_price"
                                         v-model="props.form.call_to_price"
                                         :value="props.form.call_to_price"
                                         :input_error="props.form?.errors?.call_to_price"
                                         :options="[{id: 0, name: 'غیرفعال'}, {id: 1, name: 'فعال'}]"
                        />
                    </div>
                    <div v-if="props.form.call_to_price == 0">
                        <InputComponent v-model="props.form.price"
                                        :value="props.form.price"
                                        label="قیمت عادی"
                                        id="price"
                                        placeholder="1000"
                                        :input_error="props.form?.errors?.price"
                                        css_class="ltr"
                                        type="number"
                        />
                    </div>
                    <div v-if="props.form.call_to_price == 0">
                        <InputComponent v-model="props.form.offer_price"
                                        :value="props.form.offer_price"
                                        label="قیمت تخفیفی"
                                        id="offer_price"
                                        placeholder=""
                                        :input_error="props.form?.errors?.offer_price"
                                        css_class="ltr"
                                        type="number"
                        />
                    </div>
                    <div v-if="props.form.offer_price && props.form.call_to_price == 0">
                        <InputComponent v-model="props.form.offer_end_date"
                                        :value="props.form.offer_end_date"
                                        label="انقضا تخفیف"
                                        id="offer_end_date"
                                        placeholder=""
                                        :input_error="props.form?.errors?.offer_end_date"
                                        css_class="ltr"
                                        type="date"
                        />
                    </div>
                    <div v-if="props.form.offer_price && props.form.call_to_price == 0">
                        <InputComponent v-model="props.form.offer_end_date"
                                        :value="props.form.offer_end_date"
                                        label="انقضای تخفیف"
                                        id="offer_end_date_input"
                                        placeholder="2030-01-01"
                                        :input_error="props.form?.errors?.offer_end_date"
                                        css_class="ltr"
                        />
                    </div>
                    <div>
                        <InputComponent v-model="props.form.min_buy"
                                        :value="props.form.min_buy"
                                        label="حداقل تعداد خرید"
                                        id="min_buy"
                                        placeholder="1"
                                        :input_error="props.form?.errors?.min_buy"
                                        css_class="ltr"
                                        type="number"
                        />
                    </div>
                    <div>
                        <SelectComponent label="وضعیت" id="status" v-model="props.form.status"
                                         :value="props.form.status"
                                         :input_error="props.form?.errors?.status"
                                         :options="[{id: 0, name: 'پیشنویس'}, {id: 1, name: 'انتشار'}]"
                        />
                    </div>
                    <div>
                        <SelectComponent label="محصول ویژه" id="pinned" v-model="props.form.pinned"
                                         :value="props.form.pinned"
                                         :input_error="props.form?.errors?.pinned"
                                         :options="[{id: 0, name: 'خیر'}, {id: 1, name: 'بله'}]"
                        />
                    </div>
                    <div>
                        <SelectComponent label="وضعیت فروش" id="buyable" v-model="props.form.buyable"
                                         :value="props.form.buyable"
                                         :input_error="props.form?.errors?.buyable"
                                         :options="[{id: 0, name: 'توقف فروش'}, {id: 1, name: 'فعال'}]"
                        />
                    </div>
                    <div>
                        <SelectComponent label="پیش فروش" id="buyable" v-model="props.form.pre_order"
                                         :value="props.form.pre_order"
                                         :input_error="props.form?.errors?.pre_order"
                                         :options="[{id: 0, name: 'غیرفعال'}, {id: 1, name: 'فعال'}]"
                        />
                    </div>
                    <div>
                        <SelectComponent label="فروش قسطی" id="buyable" v-model="props.form.installment_purchase"
                                         :value="props.form.installment_purchase"
                                         :input_error="props.form?.errors?.installment_purchase"
                                         :options="[{id: 0, name: 'غیرفعال'}, {id: 1, name: 'فعال'}]"
                        />
                    </div>
                    <div>
                        <label for="product_image" class="text-sm font-medium text-gray-900 block mb-2">تصویر محصول</label>
                        <MediaPicker @select="(url) => props.form.image = url" />
                    </div>
                    <div>
                        <InputComponent v-model="props.form.image"
                                        label="آدرس تصویر"
                                        :value="props.form.image"
                                        id="image-url"
                                        placeholder="image-url"
                                        :input_error="props.form?.errors?.image"
                                        css_class="ltr"
                        />
                    </div>
                    <div v-if="props.form.image">
                        <img :src="props.form.image" class="w-32 h-32 object-fill border rounded" />
                        <div v-if="props.form.errors.image" class="text-red-500 text-sm mt-1">
                            {{ props.form.errors.image }}
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2 mt-3 w-full">
                    <div class="border border-gray-200 rounded-md w-full mb-2">
                        <div class="box-title bg-gray-200 p-2">
                            <h3 class="text-md">انتخاب دسته بندی</h3>
                        </div>
                        <div class="box-content flex p-2">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 w-full">
                                <div v-for="(cat, index) in categories" :key="index" class="mb-3">
                                    <input :id="`cat-${cat.id}`" type="checkbox" :value="cat.id" v-model="props.form.categories"
                                           class="w-4 h-4 text-blue-800
                          focus:ring-red-500 focus:ring-2">
                                    <label :for="`cat-${cat.id}`" class="ms-2 text-sm font-medium">
                                        {{cat.name}}
                                    </label>
                                    <div v-if="cat.children" class="sub-categories mt-1 ms-5">
                                        <div v-for="(sub_cat, sub_index) in cat.children" :key="sub_index" class="sub-category">
                                            <input :id="`cat-${sub_cat.id}`" type="checkbox" v-model="props.form.categories"
                                                   :value="sub_cat.id"
                                                   class="w-4 h-4 text-blue-800
                          focus:ring-red-500 focus:ring-2">
                                            <label :for="`cat-${sub_cat.id}`" class="ms-2 text-xs">
                                                {{sub_cat.name}}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>

</div>
</template>

<style scoped>

</style>
