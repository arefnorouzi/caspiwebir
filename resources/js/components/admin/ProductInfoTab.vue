<script setup lang="ts">
import MediaPicker from "@/components/admin/MediaPicker.vue";
import InputComponent from "@/components/form/InputComponent.vue";
import SelectComponent from "@/components/form/SelectComponent.vue";
import CheckboxComponent from '@/components/form/CheckboxComponent.vue';
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
            <div class="border border-gray-200 rounded-md p-2 lg:w-3/4 w-full mb-5">
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

            <div class="mb-2 px-1 lg:w-1/4 w-full">
                <div class="grid grid-cols-1 gap-2">
                    <div class="border border-gray-200 mb-3">
                        <div class="bg-gray-100 p-1">
                            <h4 class="text-sm">تنظیمات محصول</h4>
                        </div>
                        <div class="px-1 py-3">
                            <div class="mb-2">
                                <CheckboxComponent label="افزودنی (addons)"
                                                   :value="props.form.is_addon"
                                                   id="is_addon" v-model="props.form.is_addon"
                                                   />

                            </div>
                            <div class="mb-2">
                                <CheckboxComponent label="سرویس یا خدمات"
                                                   :value="props.form.is_service"
                                                   id="is_service" v-model="props.form.is_service"
                                />

                            </div>
                            <div class="mb-2">
                                <CheckboxComponent label="دانلودی"
                                                   :value="props.form.downloadable"
                                                   id="downloadable" v-model="props.form.downloadable"
                                />

                            </div>

                            <div class="mb-2">
                                <CheckboxComponent
                                    label="وضعیت فروش" id="buyable" v-model="props.form.buyable"
                                    :value="props.form.buyable"
                                    :input_error="props.form?.errors?.buyable"
                                />

                            </div>

                            <div class="mb-2">
                                <CheckboxComponent
                                    label="پیش فروش" id="pre_order" v-model="props.form.pre_order"
                                    :value="props.form.pre_order"
                                    :input_error="props.form?.errors?.pre_order"
                                />

                            </div>

                            <div class="mb-2">
                                <CheckboxComponent
                                    label="فروش قسطی" id="installment_purchase" v-model="props.form.installment_purchase"
                                    :value="props.form.installment_purchase"
                                />

                            </div>

                            <div class="mb-2 mt-5">
                                <CheckboxComponent
                                    label="انتشار / پیشنویس" id="status" v-model="props.form.status"
                                    :value="props.form.status"
                                    :input_error="props.form?.errors?.status"
                                />
                            </div>

                            <div class="mb-2">
                                <CheckboxComponent
                                    label="محصول ویژه" id="pinned" v-model="props.form.pinned"
                                    :value="props.form.pinned"
                                    :input_error="props.form?.errors?.pinned"
                                />
                            </div>

                            <div class="mb-2">
                                <CheckboxComponent
                                    label="برای قیمت تماس بگیرید" id="call_to_price"
                                    v-model="props.form.call_to_price"
                                    :value="props.form.call_to_price"
                                    :input_error="props.form?.errors?.call_to_price"
                                />
                            </div>

                        </div>
                    </div>

                    <div v-if="!props.form.call_to_price" class="border border-gray-200">
                        <div class="bg-gray-100 p-1">
                            <h4 class="text-sm">قیمت گذاری</h4>
                        </div>
                        <div class="px-1 py-3">

                            <div class="mb-2">
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
                            <div class="mb-2">
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
                            <div class="mb-2">
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
                            <div class="mb-2">
                                <InputComponent v-model="props.form.offer_end_date"
                                                :value="props.form.offer_end_date"
                                                label="انقضای تخفیف"
                                                id="offer_end_date_input"
                                                placeholder="2030-01-01"
                                                :input_error="props.form?.errors?.offer_end_date"
                                                css_class="ltr"
                                />
                            </div>

                        </div>
                    </div>

                    <div class="border border-gray-200">
                        <div class="bg-gray-100 p-1">
                            <h4 class="text-sm">تصویر محصول</h4>
                        </div>
                        <div class="px-1 py-3">

                            <div class="mb-2">
                                <label for="product_image" class="text-sm font-medium text-gray-900 block mb-2">تصویر محصول</label>
                                <MediaPicker @select="(url) => props.form.image = url" />
                            </div>
                            <div class="mb-2">
                                <InputComponent v-model="props.form.image"
                                                label="آدرس تصویر"
                                                :value="props.form.image"
                                                id="image-url"
                                                placeholder="image-url"
                                                :input_error="props.form?.errors?.image"
                                                css_class="ltr"
                                />
                            </div>
                            <div  v-if="props.form.image" class="mb-2">
                                <img :src="props.form.image" class="w-32 h-32 object-fill border rounded" />
                            </div>




                        </div>
                    </div>

                    <div class="border border-gray-200">
                        <div class="bg-gray-100 p-1">
                            <h4 class="text-sm">ویدیو محصول</h4>
                        </div>
                        <div class="px-1 py-3">

                            <div class="mb-2">
                                <label for="product_image" class="text-sm font-medium text-gray-900 block mb-2">تصویر کاور ویدیو</label>
                                <MediaPicker @select="(url) => props.form.video_poster = url" />
                            </div>
                            <div class="mb-2">
                                <InputComponent v-model="props.form.video_poster"
                                                label="تصویر کاور ویدیو"
                                                :value="props.form.video_poster"
                                                id="video_poster-url"
                                                placeholder="video_poster-url"
                                                :input_error="props.form?.errors?.video_poster"
                                                css_class="ltr"
                                />
                            </div>
                            <div  v-if="props.form.video_poster" class="mb-2">
                                <img :src="props.form.video_poster" class="w-32 h-32 object-fill border rounded" />
                            </div>


                            <div class="mb-2">
                                <InputComponent v-model="props.form.video"
                                                label="آدرس ویدیو"
                                                :value="props.form.video"
                                                id="video-url"
                                                placeholder="video_poster-url"
                                                :input_error="props.form?.errors?.video"
                                                css_class="ltr"
                                />
                            </div>

                        </div>
                    </div>

                    <div v-if="props.form.downloadable" class="border border-gray-200">
                        <div class="bg-gray-100 p-1">
                            <h4 class="text-sm">مشخصات دوره</h4>
                        </div>
                        <div class="px-1 py-3">

                            <div class="mb-2">
                                <SelectComponent label="دسترسی به منابع"
                                                 :value="props.form.source"
                                                 id="source" v-model="props.form.source"
                                                 :input_error="form?.errors?.source"
                                                 :options="[{id: 0, name: 'ندارد'}, {id: 1, name: 'دارد'}]"
                                />
                            </div>
                            <div class="mb-2">
                                <InputComponent v-model="props.form.duration"
                                                :value="props.form.duration"
                                                label="تعداد جلسات"
                                                id="duration"
                                                placeholder="1"
                                                :input_error="props.form?.errors?.duration"
                                                type="number"
                                />
                            </div>
                            <div class="mb-2">
                                <InputComponent v-model="props.form.course_time"
                                                :value="props.form.course_time"
                                                label="زمان دوره"
                                                id="course_time"
                                                placeholder="3 ساعت"
                                                :input_error="props.form?.errors?.course_time"
                                />

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
