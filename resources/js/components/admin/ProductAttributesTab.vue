<script setup lang="ts">
import {router, useForm} from '@inertiajs/vue3';
import InputComponent from "@/components/form/InputComponent.vue";
import SelectComponent from "@/components/form/SelectComponent.vue";

const props = defineProps({
    product_id: Number,
    properties: Object
})

const property_form = useForm({
    property_name: '',
    property_value: '',
    pinned: 1,
    property_status: 1,
    product_id: props.product_id
})

const edit_form = useForm({
    id: null,
    property_name: '',
    property_value: '',
    pinned: 0,
    property_status: 1,
    product_id: props.product_id
})

async function setEditForm(property: object)
{
    edit_form.id = property.id;
    edit_form.property_name = property.property_name;
    edit_form.property_value = property.property_value;
    edit_form.pinned = property.pinned;
    edit_form.property_status = property.property_status;
}

async function storeProperty() {
    property_form.post('/admin/property', {
        onSuccess(){
            property_form.reset()
        }
    })
}

async function updateProperty() {
    edit_form.patch('/admin/property/' + edit_form.id, {
        onSuccess(){
            edit_form.reset()
        }
    })
}

async function deleteProperty(property_id: number) {
    if (confirm('از حذف رکورد مطمئنی؟')) {
        router.delete('/admin/property/' + property_id)
    }
}
const togglePin = (id: number) => {
    router.put('/admin/property-pin/' + id,
        {
            preserveScroll: true,
            preserveState: true,
        }
    )
}
const toggleStatus = (id: number) => {
    router.put('/admin/property-status/' + id,
        {
            preserveScroll: true,
            preserveState: true,
        }
    )
}
</script>

<template>
    <div class="border border-gray-200 rounded-md mb-5 flex flex-wrap">
        <div class="w-full lg:w-2/5 p-2">
            <div class="w-full p-2 border bg-gray-200 rounded-md">
                <h4>افزودن ویژگی های محصول</h4>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-3">
                <div>
                    <SelectComponent label="سنجاق شده" id="pinned" v-model="property_form.pinned"
                                     :input_error="property_form?.errors?.pinned"
                                     :value="property_form.pinned"
                                     :options="[{id: 0, name: 'خیر'}, {id: 1, name: 'بله'}]"
                    />
                </div>
                <div>
                    <SelectComponent label="نوع نمایش" id="status" v-model="property_form.property_status"
                                     :input_error="property_form?.errors?.property_status"
                                     :value="property_form.property_status"
                                     :options="[{id: 0, name: 'منفی'}, {id: 1, name: 'مثبت'}]"
                    />
                </div>
                <div>
                    <InputComponent v-model="property_form.property_name"
                                    :value="property_form.property_name"
                                    label="نام ویژگی"
                                    id="property_name"
                                    placeholder="عنوان را وارد کنید"
                                    :input_error="property_form?.errors?.property_name"
                    />

                </div>
                <div>
                    <InputComponent v-model="property_form.property_value"
                                    :value="property_form.property_value"
                                    label="مقدار ویژگی"
                                    id="property_value"
                                    placeholder="مقدار را وارد کنید"
                                    :input_error="property_form?.errors?.property_value"
                    />

                </div>


                <div class="text-center">
                    <button @click="storeProperty()" class="p-2 border bg-green-200 hover:bg-green-300 cursor-pointer rounded-md">ذخیره ویژگی</button>
                </div>



            </div>
        </div>
        <div class="w-full lg:w-3/5 p-2">
            <div class="w-full p-2 border bg-gray-200 rounded-md">
                <h4>لیست ویژگی های محصول</h4>
            </div>
            <table class="w-full text-right table-auto min-w-max">
                <thead>
                <tr>
                    <th class="p-2 border-b border-slate-300 bg-slate-50">
                        <p class="block text-sm font-normal leading-none text-slate-500">
                            #
                        </p>
                    </th>
                    <th class="p-2 border-b border-slate-300 bg-slate-50">
                        <p class="block text-sm font-normal leading-none text-slate-500">
                            نام ویژگی
                        </p>
                    </th>
                    <th class="p-2 border-b border-slate-300 bg-slate-50">
                        <p class="block text-sm font-normal leading-none text-slate-500">
                            مقدار ویژگی
                        </p>
                    </th>
                    <th class="p-2 border-b border-slate-300 bg-slate-50 sm-hidden">
                        <p class="block text-sm font-normal leading-none text-slate-500">
                            سنجاق
                        </p>
                    </th>
                    <th class="p-2 border-b border-slate-300 bg-slate-50 sm-hidden">
                        <p class="block text-sm font-normal leading-none text-slate-500">
                            مثبت/منفی
                        </p>
                    </th>

                    <th class="p-2 border-b border-slate-300 bg-slate-50">
                        <p class="block text-sm font-normal leading-none text-slate-500">
                            عملیات
                        </p>
                    </th>
                </tr>
                </thead>
                <tbody v-if="properties && properties.length">
                <tr v-for="(property, p) in properties" :key="p">
                    <td class="p-2 border-b border-slate-200 py-1">
                        <p class="block text-sm text-slate-800">{{ property.id }}</p>
                    </td>
                    <td class="p-2 border-b border-slate-200 py-1">
                        <p class="text-sm text-slate-500">{{ property.property_name }}</p>
                    </td>
                    <td class="p-2 border-b border-slate-200 py-1">
                        <p class="text-sm text-slate-500">{{ property.property_value }}</p>
                    </td>

                    <td class="p-2 border-b border-slate-200 py-1 sm-hidden" style="direction: ltr;">
                        <button
                            @click="togglePin(property.id)"
                            class="relative inline-flex h-4 w-8 items-center rounded-full transition-colors duration-300 cursor-pointer"
                            :class="property.pinned ? 'bg-green-700' : 'bg-gray-300'"
                        >
                                  <span
                                      class="inline-block h-3 w-3 transform rounded-full bg-gray-200 transition-transform duration-300"
                                      :class="property.pinned ? 'translate-x-1' : 'translate-x-5'"
                                  />
                        </button>
                    </td>
                    <td class="p-2 border-b border-slate-200 py-1 sm-hidden" style="direction: ltr;">
                        <button
                            @click="toggleStatus(property.id)"
                            class="relative inline-flex h-4 w-8 items-center rounded-full transition-colors duration-300 cursor-pointer"
                            :class="property.property_status ? 'bg-green-700' : 'bg-gray-300'"
                        >
                                  <span
                                      class="inline-block h-3 w-3 transform rounded-full bg-gray-200 transition-transform duration-300"
                                      :class="property.property_status ? 'translate-x-1' : 'translate-x-5'"
                                  />
                        </button>
                    </td>
                    <td class="p-2 border-b border-slate-200 py-1">
                        <button @click="setEditForm(property)"
                                class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                type="button">
                                     <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="w-4 h-4">
                                      <path
                                          d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z">
                                      </path>
                                    </svg>
                                  </span>
                        </button>
                        <button @click="deleteProperty(property.id)"
                                class="relative cursor-pointer h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                type="button">
                                                      <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                                          <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14px" height="14px" viewBox="0 0 488.936 488.936" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M381.16,111.948H107.376c-6.468,0-12.667,2.819-17.171,7.457c-4.504,4.649-6.934,11.014-6.738,17.477l9.323,307.69 c0.39,12.92,10.972,23.312,23.903,23.312h20.136v-21.012c0-24.121,19.368-44.049,43.488-44.049h127.896 c24.131,0,43.893,19.928,43.893,44.049v21.012h19.73c12.933,0,23.52-10.346,23.913-23.268l9.314-307.7 c0.195-6.462-2.234-12.863-6.738-17.513C393.821,114.767,387.634,111.948,381.16,111.948z"></path> <path d="M309.166,435.355H181.271c-6.163,0-11.915,4.383-11.915,11.516v30.969c0,6.672,5.342,11.096,11.915,11.096h127.895 c6.323,0,11.366-4.773,11.366-11.096v-30.969C320.532,440.561,315.489,435.355,309.166,435.355z"></path> <path d="M427.696,27.106C427.696,12.138,415.563,0,400.591,0H88.344C73.372,0,61.239,12.138,61.239,27.106v30.946 c0,14.973,12.133,27.106,27.105,27.106H400.59c14.973,0,27.105-12.133,27.105-27.106L427.696,27.106L427.696,27.106z"></path> </g> </g> </g></svg>
                                                      </span>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>

        <div v-if="edit_form.id" class="w-full lg:w-1/2 md:w-1/2 p-2">
            <div class="w-full p-2 border bg-gray-200 rounded-md">
                <h4>ویرایش ویژگی محصول</h4>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-3">

                <div>
                    <SelectComponent label="سنجاق شده" id="pinned" v-model="edit_form.pinned"
                                     :input_error="edit_form?.errors?.pinned"
                                     :value="edit_form.pinned"
                                     :options="[{id: 0, name: 'خیر'}, {id: 1, name: 'بله'}]"
                    />
                </div>
                <div>
                    <SelectComponent label="نوع نمایش" id="status" v-model="edit_form.property_status"
                                     :input_error="edit_form?.errors?.property_status"
                                     :value="edit_form.property_status"
                                     :options="[{id: 0, name: 'منفی'}, {id: 1, name: 'مثبت'}]"
                    />
                </div>
                <div>
                    <InputComponent v-model="edit_form.property_name"
                                    :value="edit_form.property_name"
                                    label="نام ویژگی"
                                    id="property_name"
                                    placeholder="عنوان را وارد کنید"
                                    :input_error="edit_form?.errors?.property_name"
                    />

                </div>
                <div>
                    <InputComponent v-model="edit_form.property_value"
                                    :value="edit_form.property_value"
                                    label="مقدار ویژگی"
                                    id="property_value"
                                    placeholder="مقدار را وارد کنید"
                                    :input_error="edit_form?.errors?.property_value"
                    />

                </div>



                <div class="text-center">
                    <button @click="updateProperty()"
                            class="p-2 border bg-green-200 hover:bg-green-300 cursor-pointer rounded-md">بروزرسانی ویژگی</button>
                </div>



            </div>
        </div>
    </div>

</template>

<style scoped>

</style>
