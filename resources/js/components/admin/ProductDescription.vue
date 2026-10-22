<script setup lang="ts">
import QuillEditor from "@/components/admin/QuillEditor.vue";
import TextareaComponent from "@/components/form/TextareaComponent.vue";
import SmallQuillEditor from '@/components/admin/SmallQuillEditor.vue';
const props = defineProps({
    form: Object
})


</script>

<template>
    <div class="space-y-2">

            <div class="flex flex-wrap p-2">
                <div class="grid grid-cols-1 gap-4 mt-3 w-full">

                    <div class="">
                        <TextareaComponent
                            id="product-meta"
                            label="توضیحات متا"
                            placeholder="توضیحات متا"
                            v-model="props.form.meta"
                            :value="props.form.meta"
                            :input_error="props.form?.errors?.meta"
                        />
                    </div>
                    <div class="mb-10">
<!--                        <TextareaComponent-->
<!--                            id="product-note"-->
<!--                            label="یادداشت محصول"-->
<!--                            placeholder="نکته و یادداشت برای محصول"-->
<!--                            v-model="props.form.note"-->
<!--                            :value="props.form.note"-->
<!--                            :input_error="props.form?.errors?.note"-->
<!--                        />-->
                        <label for="product-details"
                               class="text-sm font-medium text-gray-900 block mb-2">یادداشت محصول</label>

                        <SmallQuillEditor v-model="props.form.note" />
                        <div v-if="props.form.errors.note" class="text-red-500 text-sm mt-1">
                            {{ props.form.errors.note }}
                        </div>
                    </div>
                    <div class=" my-10">
                        <TextareaComponent
                            id="excerpt_review"
                            label="بررسی تخصصی"
                            placeholder="توضیحات بخش بررسی تخصصی محصول"
                            v-model="props.form.excerpt_review"
                            :value="props.form.excerpt_review"
                            :input_error="props.form?.errors?.excerpt_review"
                        />
                    </div>
                    <div class="">
                        <label for="product-details" class="text-sm font-medium text-gray-900 block mb-2">توضیحات محصول</label>
                        <QuillEditor v-model="props.form.description" />
                        <div v-if="props.form.errors.description" class="text-red-500 text-sm mt-1">
                            {{ props.form.errors.description }}
                        </div>
                    </div>
                </div>

            </div>


    </div>
</template>

<style scoped>

</style>
