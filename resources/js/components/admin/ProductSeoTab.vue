<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    model: Object
})
const seo_form = useForm({
    seo_title: props.model.seo_title,
    seo_meta: props.model.seo_meta,
    seo_keywords: props.model.seo_keywords,
    seo_tags: props.model.seo_tags,
})
async function storeSeo() {
    seo_form.patch('/admin/product-seo/' + props.model.id)
}


</script>

<template>
    <div class="border border-gray-200 rounded-md mb-5 flex flex-wrap">
        <div class="w-full p-2">
            <div class="w-full p-2 border bg-gray-200 rounded-md">
                <h4>متاتگ های سئو</h4>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-3">
                <div>
                    <label for="stock" class="text-sm font-medium text-gray-900 block mb-2">عنوان</label>
                    <input type="text" minlength="5" maxlength="68" v-model="seo_form.seo_title" name="stock" id="stock" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-1.5"
                           placeholder="عنوان سئو را وارد نمایید" required="">
                    <p class="my-1">عنوان سئو بهتر از کمتر از 68 کاراکتر باشد</p>
                </div>

                <div>
                    <label for="stock" class="text-sm font-medium text-gray-900 block mb-2">توضیحات متا</label>
                    <textarea rows="2" minlength="5" maxlength="157" v-model="seo_form.seo_meta" name="stock" id="stock" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-1.5"
                              placeholder="توضیحات متا را وارد نمایید"></textarea>
                    <p class="my-1">توضیحات متا بهتر از کمتر از 157 کاراکتر باشد</p>
                </div>
                <div>
                    <label for="stock" class="text-sm font-medium text-gray-900 block mb-2">کلمات کلیدی</label>
                    <input type="text" minlength="3" maxlength="200" v-model="seo_form.seo_keywords" name="stock" id="stock" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-1.5"
                           placeholder="کلمات کلیدی سئو را وارد نمایید">
                    <p class="my-2">کلمات کلیدی را با <span class="bg-blue-200 px-2 text-xl rounded-md">،</span> از هم جدا نمایید.</p>
                </div>
                <div>
                    <label for="stock" class="text-sm font-medium text-gray-900 block mb-2">برچسب ها</label>
                    <input type="text" minlength="3" maxlength="200" v-model="seo_form.seo_tags" name="stock" id="stock" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-1.5"
                           placeholder="برچسب ها را وارد نمایید">
                    <p class="my-2">برچسب را با <span class="bg-blue-200 px-2 text-xl rounded-md">،</span> از هم جدا نمایید.</p>
                </div>

                <div class="col-span-2 text-center">
                    <button @click="storeSeo()" class="p-2 border bg-green-200 hover:bg-green-300 cursor-pointer rounded-md">ذخیره اطلاعات</button>
                </div>



            </div>
        </div>
    </div>

</template>

<style scoped>

</style>
