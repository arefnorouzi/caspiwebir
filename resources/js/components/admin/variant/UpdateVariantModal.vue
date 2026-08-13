<script setup>
import { useForm } from '@inertiajs/vue3'
import InputComponent from "@/components/form/InputComponent.vue";
import SelectComponent from "@/components/form/SelectComponent.vue";
import MediaPicker from "@/components/admin/MediaPicker.vue";

const props = defineProps({
    variant: Object,
    lesson: Object
})


const update_variant_form = useForm({
    product_id: props?.variant?.product_id,
    stock: props?.variant?.stock,
    sales: props?.variant?.sales,
    price: props?.variant?.price,
    offer_price: props?.variant?.offer_price,
    offer_end_date: props?.variant?.offer_end_date,
    name: props?.variant?.name,
    meta: props?.variant?.meta,
    image: props?.variant?.image,
    status: !!props?.variant?.status,
    is_default: !!props?.variant?.is_default,
    sku: props?.variant?.sku,
});

async function updateVariant() {
    update_variant_form.patch("/admin/variant/" + props?.variant?.id, {
        onSuccess: () => {
            update_variant_form.reset()
            emit('close')
        }
    })
}


const emit = defineEmits(['close'])

</script>

<template>
    <div class="fixed inset-0 z-50 flex items-center justify-center">
        <!-- Backdrop -->
        <div
            class="absolute inset-0 bg-black/40"
            @click="emit('close')"
        ></div>

        <!-- Modal -->
        <div
            class="relative w-full max-w-lg bg-white rounded-lg shadow-lg p-6"
        >
            <h2 class="text-lg font-semibold mb-4">
                ویرایش: {{props?.variant?.name}}
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-2 mb-4">
                <div class="col-span-2">
                    <InputComponent v-model="update_variant_form.name"
                                    label="عنوان"
                                    :value="update_variant_form.name"
                                    id="variant-name"
                                    placeholder="عنوان را وارد کنید"
                                    :input_error="update_variant_form?.errors?.name"
                    />
                </div>
                <div>
                    <InputComponent v-model="update_variant_form.sku"
                                    label="کد یکتای محصول"
                                    :value="update_variant_form.sku"
                                    id="variant-sku"
                                    placeholder="p-12345"
                                    :input_error="update_variant_form?.errors?.sku"
                                    css_class="ltr"
                    />
                </div>
                <div>
                    <InputComponent v-model="update_variant_form.stock"
                                    label="موجودی انبار"
                                    :value="update_variant_form.stock"
                                    id="variant-stock"
                                    placeholder="1"
                                    :input_error="update_variant_form?.errors?.stock"
                                    css_class="ltr"
                    />
                </div>
                <div>
                    <SelectComponent label="وضعیت" id="variant-status"
                                     v-model="update_variant_form.status"
                                     :input_error="update_variant_form?.errors?.status"
                                     :value="update_variant_form.status"
                                     :options="[{id: false, name: 'غیرفعال'}, {id: true, name: 'فعال'}]"
                    />
                </div>
                <div>
                    <SelectComponent label="پیشفرض" id="is_free"
                                     v-model="update_variant_form.is_default"
                                     :input_error="update_variant_form?.errors?.is_default"
                                     :value="update_variant_form.is_default"
                                     :options="[{id: false, name: 'خیر'}, {id: true, name: 'بله'}]"
                    />
                </div>
                <div>
                    <InputComponent v-model="update_variant_form.price"
                                    label="قیمت"
                                    :value="update_variant_form.price"
                                    id="variant-price"
                                    placeholder="10000"
                                    :input_error="update_variant_form?.errors?.price"
                                    css_class="ltr"
                    />
                </div>
                <div>
                    <label for="variant_image" class="text-sm font-medium text-gray-900 block mb-2">تصویر محصول</label>
                    <MediaPicker @select="(url) => update_variant_form.image = url" />
                    <div v-if="update_variant_form.errors.image" class="text-red-500 text-sm mt-1">
                        {{ update_variant_form.errors.image }}
                    </div>
                </div>
                <div>
                    <InputComponent v-model="update_variant_form.image"
                                    label="آدرس تصویر"
                                    :value="update_variant_form.image"
                                    id="variant-image-url"
                                    placeholder="image-url"
                                    :input_error="update_variant_form?.errors?.image"
                                    css_class="ltr"
                    />
                </div>
                <div>
                    <div v-if="update_variant_form.image" class="mt-2">
                        <img :src="update_variant_form.image" class="w-20 h-20 object-fill border rounded" />
                    </div>
                </div>

            </div>

            <div class="flex justify-end gap-2">
                <button
                    @click="emit('close')"
                    class="px-4 py-2 rounded bg-gray-100 text-sm cursor-pointer"
                >
                    انصراف
                </button>


                <button @click="updateVariant"
                        class="me-1 cursor-pointer text-oklch(44.8% 0.119 151.328) border-2 border-blue-500 hover:border-green-300 focus:ring-4 focus:ring-green-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                    بروزرسانی اطلاعات
                </button>

            </div>
        </div>
    </div>
</template>
