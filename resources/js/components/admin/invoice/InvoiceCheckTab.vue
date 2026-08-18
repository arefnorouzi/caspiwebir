<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
const props = defineProps({
    model: Object,
})
const payment_condition_form = useForm({
    check_request: props.model.check_request,
    check_response: props.model.check_response,
    check_status: props.model.check_status,
    check_count: props.model.check_count,
    receipt_status: props.model.receipt_status,
    receipt_count: props.model.receipt_count
});

async function updatePaymentCondition() {
    payment_condition_form.patch('/admin/payment-condition/' + props.model.id)

}

</script>

<template>
    <div class="card border border-gray-100 rounded-md mb-2 shadow">
        <div class="card-header bg-gray-100 p-2">
            <h4>تعیین شرایط پرداخت</h4>
        </div>
        <div class="card-body px-2 py-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-3">
                <div class="mb-1 border border-gray-200 p-2">
                    <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">مجوز ارسال چک</label>
                    <select v-model="payment_condition_form.check_status"
                            class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    >
                        <option :value="0">غیرمجاز</option>
                        <option :value="1">مجاز به ارسال چک</option>
                    </select>
                </div>
                <div class="mb-1 border border-gray-200 p-2">
                    <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">تعداد چک</label>
                    <input type="number" v-model="payment_condition_form.check_count" class="border border-gray-300 p-2 rounded-md w-full">
                </div>


                <div class="mb-1 border border-gray-200 p-2">
                    <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">مجوز ارسال فیش واریزی</label>
                    <select v-model="payment_condition_form.receipt_status"
                            class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    >
                        <option :value="0">غیرمجاز</option>
                        <option :value="1">مجاز به ارسال فیش</option>
                    </select>
                </div>
                <div class="mb-1 border border-gray-200 p-2">
                    <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">تعداد فیش واریزی</label>
                    <input type="number" v-model="payment_condition_form.receipt_count" class="border border-gray-300 p-2 rounded-md w-full">
                </div>

                <div class="mb-1 border border-gray-200 p-2">
                    <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">متن درخواست مشتری</label>
                    <textarea rows="3" v-model="payment_condition_form.check_request" class="border border-gray-300 p-2 rounded-md w-full" placeholder="یادداشت مشتری"></textarea>
                </div>

                <div class="mb-1 border border-gray-200 p-2">
                    <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">پاسخ مدیر سایت</label>
                    <textarea rows="3" v-model="payment_condition_form.check_response" class="border border-gray-300 p-2 rounded-md w-full" placeholder="یادداشت مشتری"></textarea>
                </div>

            </div>

            <div class="my-3 text-center">
                <button @click="updatePaymentCondition" class="confirm-btn">بروزرسانی درخواست</button>
            </div>

        </div>
    </div>

</template>

<style scoped>

</style>
