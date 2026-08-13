<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import InputComponent from "@/components/form/InputComponent.vue";
import SelectComponent from "@/components/form/SelectComponent.vue";

const props = defineProps({
    model: Object
})
const size_form = useForm({
    weight: props.model.weight,
    width: props.model.width,
    height: props.model.height,
    lenght: props.model.lenght,
    need_box: props.model.need_box,
    huge_box: props.model.huge_box,
})
async function storeSize() {
    size_form.patch('/admin/product-size/' + props.model.id)
}


</script>

<template>
    <div class="border border-gray-200 rounded-md mb-5 flex flex-wrap">
        <div class="w-full p-2">
            <div class="w-full p-2 border bg-gray-200 rounded-md">
                <h4>ابعاد و وزن کالا</h4>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-3">
                <div>
                    <InputComponent v-model="size_form.product_weight"
                                    :value="size_form.product_weight"
                                    label="وزن (گرم)"
                                    id="product_weight"
                                    placeholder="1000"
                                    :input_error="size_form?.errors?.product_weight"
                                    css_class="ltr"
                                    type="number"
                    />
                </div>
                <div>
                    <InputComponent v-model="size_form.product_lenght"
                                    :value="size_form.product_lenght"
                                    label="طول (سانتی متر)"
                                    id="product_lenght"
                                    placeholder="10"
                                    :input_error="size_form?.errors?.product_lenght"
                                    css_class="ltr"
                                    type="number"
                    />
                </div>
                <div>
                    <InputComponent v-model="size_form.product_width"
                                    :value="size_form.product_width"
                                    label="عرض (سانتی متر)"
                                    id="product_width"
                                    placeholder="10"
                                    :input_error="size_form?.errors?.product_width"
                                    css_class="ltr"
                                    type="number"
                    />
                </div>
                <div>
                    <InputComponent v-model="size_form.product_height"
                                    :value="size_form.product_height"
                                    label="ارتفاع (سانتی متر)"
                                    id="product_height"
                                    placeholder="10"
                                    :input_error="size_form?.errors?.product_height"
                                    css_class="ltr"
                                    type="number"
                    />
                </div>
                <div>
                    <SelectComponent label="نیاز به بسته بندی" id="need_box"
                                     v-model="size_form.need_box"
                                     :value="size_form.need_box"
                                     :input_error="size_form?.errors?.need_box"
                                     :options="[{id: 0, name: 'ندارد'}, {id: 1, name: 'دارد'}]"
                    />
                </div>
                <div>
                    <SelectComponent label="کالای حجیم" id="need_box"
                                     v-model="size_form.huge_box"
                                     :value="size_form.huge_box"
                                     :input_error="size_form?.errors?.huge_box"
                                     :options="[{id: 0, name: 'خیر'}, {id: 1, name: 'بله'}]"
                    />
                </div>


                <div class="col-span-2 text-center">
                    <button @click="storeSize()" class="p-2 border bg-green-200 hover:bg-green-300 cursor-pointer rounded-md">ذخیره اطلاعات</button>
                </div>



            </div>
        </div>
    </div>

</template>

<style scoped>

</style>
