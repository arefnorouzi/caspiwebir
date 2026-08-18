<script setup lang="ts">
import SelectComponent from "@/components/form/SelectComponent.vue";
import InputComponent from "@/components/form/InputComponent.vue";

const props = defineProps({
    model: Object,
    form: Object,
    shipping_methods: Object,
    payment_methods: Object,
    statuses: Object
})

async function updateInvoice() {
    props.form.patch('/admin/invoice/' + props.model.id)
}
</script>

<template>
    <div class="card border border-gray-100 rounded-md mb-2 shadow">
        <div class="card-header bg-gray-100 p-2">
            <h4>بروزرسانی فاکتور</h4>
        </div>
        <div class="card-body px-1 py-4">
            <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-1 mt-3">
                <div class="mb-1 border border-gray-200 p-2">
                    <InputComponent v-model="props.form.customer_name"
                                    :value="props.form.customer_name"
                                    label="نام مشتری"
                                    id="customer_name"
                                    placeholder="مهراد شاهرخی"
                                    :input_error="form?.errors?.customer_name"
                    />
                </div>
                <div class="mb-1 border border-gray-200 p-2">
                    <InputComponent v-model="props.form.customer_mobile"
                                    :value="props.form.customer_mobile"
                                    label="شماره تماس مشتری"
                                    id="customer_mobile"
                                    placeholder="09123456789"
                                    :input_error="form?.errors?.customer_mobile"
                                    css_class="ltr"
                    />
                </div>
                <div class="mb-1 border border-gray-200 p-2">
                    <SelectComponent label="امکان پرداخت"
                                     :value="props.form.payable"
                                     id="brand" v-model="props.form.payable"
                                     :input_error="form?.errors?.payable"
                                     :options="[{id: 0, name: 'غیرفعال'}, {id: 1, name: 'فعال'}]"
                    />
                </div>
                <div class="mb-1 border border-gray-200 p-2">
                    <SelectComponent label="وضعیت پرداخت"
                                     :value="props.form.payment_status"
                                     id="brand" v-model="props.form.payment_status"
                                     :input_error="form?.errors?.payment_status"
                                     :options="[{id: 0, name: 'در انتظار پرداخت'}, {id: 1, name: 'پرداخت شده'}]"
                    />
                </div>
                <div class="mb-1 border border-gray-200 p-2">
                    <SelectComponent label="تایید توسط مشتری"
                                     :value="props.form.confirmed_by_user"
                                     id="brand" v-model="props.form.confirmed_by_user"
                                     :input_error="form?.errors?.confirmed_by_user"
                                     :options="[{id: 0, name: 'تایید نشده'}, {id: 1, name: 'تایید شده'}]"
                    />
                </div>
                <div class="mb-1 border border-gray-200 p-2">
                    <SelectComponent label="وضعیت فاکتور"
                                     :value="props.form.invoice_status_id"
                                     id="brand" v-model="props.form.invoice_status_id"
                                     :input_error="form?.errors?.invoice_status_id"
                                     :options="statuses"
                    />
                </div>

                <div class="mb-1 border border-gray-200 p-2">
                    <SelectComponent label="انتخاب روش ارسال"
                                     :value="props.form.shipping_method_id"
                                     id="brand" v-model="props.form.shipping_method_id"
                                     :input_error="form?.errors?.shipping_method_id"
                                     :options="shipping_methods"
                    />
                </div>
                <div class="mb-1 border border-gray-200 p-2">
                    <SelectComponent label="انتخاب روش پرداخت"
                                     :value="props.form.payment_method_id"
                                     id="brand" v-model="props.form.payment_method_id"
                                     :input_error="form?.errors?.payment_method_id"
                                     :options="payment_methods"
                    />
                </div>
                <div class="mb-1 border border-gray-200 p-2 col-span-2">
                    <InputComponent v-model="props.form.post_tracking_code"
                                    :value="props.form.post_tracking_code"
                                    label="بارکد بسته پستی"
                                    id="post_tracking_code"
                                    placeholder="123456"
                                    :input_error="form?.errors?.post_tracking_code"
                                    css_class="ltr"
                    />
                </div>
                <div class="mb-1 border border-gray-200 p-2 col-span-2">
                    <label for="product-name" class="text-xs font-medium text-gray-900 block mb-2">یادداشت مشتری</label>
                    <textarea rows="3" v-model="props.form.customer_note" class="border border-gray-300 p-2 rounded-md w-full text-xs" placeholder="یادداشت مشتری"></textarea>
                </div>

                <div class="my-1 text-center">
                    <button @click="updateInvoice" class="confirm-btn">بروزرسانی فاکتور</button>
                </div>
            </div>



        </div>
    </div>

</template>

<style scoped>

</style>
