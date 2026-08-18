<script setup lang="ts">

import TextareaComponent from "@/components/form/TextareaComponent.vue";
import InputComponent from "@/components/form/InputComponent.vue";
const props = defineProps({
    model: Object,
    form: Object
})
async function updateInvoice() {
    props.form.patch('/admin/invoice/' + props.model.id)
}

</script>

<template>
    <div class="card border border-gray-100 rounded-md mb-2 shadow">
        <div class="card-header bg-gray-100 p-2">
            <h4>نظر مشتری</h4>
        </div>
        <div class="card-body px-1 py-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-1 mt-3">
                <div class="mb-1 border border-gray-200 p-2">
                    <InputComponent v-model="props.form.customer_score"
                                    :value="props.form.customer_score"
                                    label="امتیاز مشتری"
                                    id="customer_score"
                                    type="number" css_class="ltr"
                                    :input_error="form?.errors?.customer_score"
                    />
                </div>
                <div class="mb-1 border border-gray-200 p-2">
                    <TextareaComponent
                        id="customer_review"
                        label="نظر مشتری"
                        placeholder="نظر مشتری"
                        v-model="props.form.customer_review"
                        :value="props.form.customer_review"
                        :input_error="props.form?.errors?.customer_review"
                    />
                </div>

                <div class="mb-1 border border-gray-200 p-2 col-span-2">
                    <TextareaComponent
                        id="description"
                        label="توضیحات ادمین"
                        placeholder="توضیحات ادمین"
                        v-model="props.form.description"
                        :value="props.form.description"
                        :input_error="props.form?.errors?.description"
                    />
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
