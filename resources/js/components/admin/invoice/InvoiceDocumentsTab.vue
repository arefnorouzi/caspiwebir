<script setup lang="ts">
import {router, useForm} from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';
import SelectComponent from "@/components/form/SelectComponent.vue";
import {Button} from "@/components/ui/button";
const props = defineProps({
    model: Object,
    documents: Object,
    document_types: Object
})

const document_form = useForm({
    name: '',
    image: '',
    invoice_id: props.model.id,
    invoice_item_id: null,
    document_type_id: 4
});
const preview = ref("")
const uploading = ref(false)

async function handleFileChange(e) {
    const file = e.target.files[0]
    if (!file) return

    uploading.value = true
    const formData = new FormData()
    formData.append('file', file)
    formData.append('folder_name', 'doc')

    try {
        const res = await axios.post('/upload', formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        })
        if(res.data.url.includes(".pdf"))
        {
            preview.value = "/icons/pdf.svg" // نمایش پیش‌نمایش
        }
        else{
            preview.value = res.data.url // نمایش پیش‌نمایش
        }
        document_form.image = res.data.path
    } catch (err) {
        alert('خطا در آپلود تصویر')
    } finally {
        uploading.value = false
    }
}
async function save_document() {
    document_form.post("/admin/invoice-document/" + props?.model?.id, {
        onSuccess: () => {
            document_form.reset()
        }
    })
}

async function destroyDocument(id: number) {
    if (confirm('از حذف سند مطمئنی؟')) {
        router.delete('/admin/document/' + id)
    }
}
</script>

<template>
    <div class="card border border-gray-100 rounded-md mb-2 shadow">
        <div class="card-header bg-gray-100 p-2">
            <h4>اسناد</h4>
        </div>
        <div class="card-body px-2 py-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 mt-3">
                <div>
                    <SelectComponent label="نوع سند"
                                     :value="document_form.document_type_id"
                                     id="document_type_id" v-model="document_form.document_type_id"
                                     :input_error="document_form?.errors?.document_type_id"
                                     :options="document_types"
                    />
                </div>
                <div>
                    <label for="document-name"
                           class="text-xs font-medium text-gray-900 block mb-2"
                    >نام سند</label>
                    <input id="document-name" v-model="document_form.name" type="text"
                           class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-xs rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                           maxlength="150" placeholder="نام سند را وارد نمایید" required>
                    <div v-if="document_form.errors.name" class="text-red-500 text-sm mt-1">
                        {{ document_form.errors.name }}
                    </div>
                </div>
                <div>
                    <label for="document-image" class="text-xs font-medium text-gray-900 block mb-2">انتخاب فایل</label>
                    <input type="file" @change="handleFileChange" name="image" id="document-image"
                           class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-xs rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                    >

                    <div v-if="uploading">در حال آپلود...</div>
                    <div v-if="document_form.errors.image" class="text-red-500 text-sm mt-1">
                        {{ document_form.errors.image }}
                    </div>
                </div>
                <div>
                    <div v-if="preview" class="mt-2">
                        <img :src="preview" class="w-20 h-20 object-cover border rounded" />
                    </div>
                </div>

                <div>
                    <button
                        @click="save_document"
                        class="bg-blue-500 rounded-md text-white px-3 py-2 text-sm cursor-pointer">ثبت سند</button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 mt-10">

                <div v-for="(doc, dc) in documents"
                     :key="dc"
                     class="card border border-gray-200 bg-gray-100 rounded-md mb-2 shadow">
                    <div class="card-body my-1  flex flex-wrap justify-between p-1">
                        <div class="text-sm text-gray-800">
                            <h5 class="text-sm">{{doc.name}}</h5>
                        </div>
                        <div class="text-sm">
                            <button @click="destroyDocument(doc.id)"
                               target="_blank"
                               class="m-1 p-1 rounded-md border border-red-500 text-red-500 text-xs">حذف</button>

                            <a :href="`/dashboard/download-document/${doc.id}`"
                               target="_blank"
                               class="m-1 p-1 rounded-md border border-blue-500 text-blue-500 text-xs">دانلود</a>
                        </div>
                        <a v-if="doc.image1" :href="doc.image1" target="_blank" class="cursor-pointer">
                            <img  :src="doc.image1" class="m-1 document-image">
                        </a>
                        <a v-if="doc.image2" :href="doc.image2" target="_blank" class="cursor-pointer">
                            <img  :src="doc.image2" class="m-1 document-image">
                        </a>
                        <a v-if="doc.image3" :href="doc.image3" target="_blank" class="cursor-pointer">
                            <img  :src="doc.image3" class="m-1 document-image">
                        </a>
                        <a v-if="doc.image4" :href="doc.image4" target="_blank" class="cursor-pointer">
                            <img  :src="doc.image4" class="m-1 document-image">
                        </a>

                    </div>


                </div>


            </div>


        </div>
    </div>
</template>

<style scoped>
.document-image{
    width: 100px;
}
</style>
