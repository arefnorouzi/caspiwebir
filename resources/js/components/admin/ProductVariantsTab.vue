<script setup lang="ts">

import {router} from '@inertiajs/vue3';
import { ref } from 'vue';
import UpdateVariantModal from "@/components/admin/variant/UpdateVariantModal.vue";
import CreateVariantModal from "@/components/admin/variant/CreateVariantModal.vue";
const props = defineProps({
    model: Object,
    variants: Object,
    colors: Object,
    sizes: Object
})
const selectedVariant = ref(null)
const editVariantModal = ref(false)
const createVariantModal = ref(false)


async function deleteVariant(variant_id: number) {
    if (confirm('از حذف رکورد مطمئنی؟')) {
        router.delete('/admin/variant/' + variant_id)
    }
}
async function restoreVariant(variant_id: number) {
    if (confirm('از حذف رکورد مطمئنی؟')) {
        router.delete('/admin/restore-variant/' + variant_id)
    }
}

async function variantCreateModal(){
    createVariantModal.value = true
}

async function variantEditModal(variant: any){
    selectedVariant.value = variant
    editVariantModal.value = true

}

</script>

<template>
    <div class="border border-gray-200 rounded-md mb-5">
        <div class="box-title bg-gray-200 p-2">
            <h3 class="text-md">تنوع محصول (محصول متغیر)</h3>
        </div>
        <div class="box-content p-2">
            <div class="mb-5">
                <button @click="variantCreateModal()"
                        class="me-1 cursor-pointer text-black border border-gray-300 hover:bg-gray-200 focus:ring-4 focus:ring-blue-300 text-sm rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2">
                    افزودن تنوع محصول
                </button>
            </div>

            <CreateVariantModal
                v-if="createVariantModal"
                :product="props?.model"
                @close="createVariantModal = false"
            />
            <UpdateVariantModal
                v-if="editVariantModal"
                :variant="selectedVariant"
                @close="editVariantModal = false"
            />

            <div class="relative flex mt-2 flex-col w-full h-full overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
                <table class="w-full text-right table-auto min-w-max">
                    <thead>
                    <tr>
                        <th class="p-4 border-b border-slate-300 bg-slate-50">
                            <p class="block text-sm font-normal leading-none text-slate-500">
                                #
                            </p>
                        </th>
                        <th class="p-4 border-b border-slate-300 bg-slate-50">
                            <p class="block text-sm font-normal leading-none text-slate-500">
                                کد کالا
                            </p>
                        </th>
                        <th class="p-4 border-b border-slate-300 bg-slate-50">
                            <p class="block text-sm font-normal leading-none text-slate-500">
                                تصویر
                            </p>
                        </th>
                        <th class="p-4 border-b border-slate-300 bg-slate-50">
                            <p class="block text-sm font-normal leading-none text-slate-500">
                                وضعیت
                            </p>
                        </th>
                        <th class="p-4 border-b border-slate-300 bg-slate-50">
                            <p class="block text-sm font-normal leading-none text-slate-500">
                                قیمت
                            </p>
                        </th>

                        <th class="p-4 border-b border-slate-300 bg-slate-50">
                            <p class="block text-sm font-normal leading-none text-slate-500">
                                موجودی
                            </p>
                        </th>

                        <th class="p-4 border-b border-slate-300 bg-slate-50">
                            <p class="block text-sm font-normal leading-none text-slate-500">
                                عملیات
                            </p>
                        </th>
                    </tr>
                    </thead>
                    <tbody v-if="props?.variants && props?.variants.length">
                    <tr v-for="(variant, i) in props?.variants" :key="i">
                        <td class="p-4 border-b border-slate-200 py-1">
                            <p class="block font-semibold text-sm text-slate-800">{{ variant.id }}</p>
                        </td>
                        <td class="p-4 border-b border-slate-200 py-1">
                            <p class="text-sm text-slate-500">{{ variant.sku }}</p>
                        </td>
                        <td class="p-4 border-b border-slate-200 py-1">
                            <div v-if="variant.image" class="mt-2">
                                <img :src="variant.image" class="border rounded object-fill table-img" />
                            </div>
                        </td>


                        <td class="p-4 border-b border-slate-200 py-1">
                            <div class="w-max">
                                <div v-if="variant.status"
                                     class="relative grid items-center px-2 py-1 font-sans text-xs font-bold text-green-900 uppercase rounded-md select-none whitespace-nowrap bg-green-500/20">
                                    <span class="">فعال</span>
                                </div>
                                <div v-else
                                     class="relative grid items-center px-2 py-1 font-sans text-xs font-bold uppercase rounded-md select-none whitespace-nowrap bg-amber-500/20 text-amber-900">
                                    <span class="">غیرفعال</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 border-b border-slate-200 py-1">
                            <p class="text-sm text-slate-500">
                                                <span v-if="(variant.offer_price && variant.offer_price < variant.price)">
                                                    <span class="text-red-800/80">{{ Number(variant.offer_price).toLocaleString() }}</span>
                                                    <br />
                                                    <span class="text-gray-600/50">{{Number(variant.price).toLocaleString()}}</span>
                                                </span>
                                <span v-else>
                                                    {{ Number(variant.price).toLocaleString() }}
                                                </span>

                            </p>
                        </td>
                        <td class="p-4 border-b border-slate-200 py-1">
                            <p class="text-sm text-slate-500">{{ variant.stock }}</p>
                        </td>
                        <td class="p-4 border-b border-slate-200 py-1">
                            <button @click="variantEditModal(variant)"
                                    class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                    type="button">
                                  <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
     class="w-4 h-4">
                                      <path
                                          d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z">
                                      </path>
                                    </svg>
                                  </span>
                            </button>

                            <button v-if="variant.status" @click="deleteVariant(variant.id, i)"
                                    class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                    type="button">
                                                      <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                                          <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14px" height="14px" viewBox="0 0 488.936 488.936" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M381.16,111.948H107.376c-6.468,0-12.667,2.819-17.171,7.457c-4.504,4.649-6.934,11.014-6.738,17.477l9.323,307.69 c0.39,12.92,10.972,23.312,23.903,23.312h20.136v-21.012c0-24.121,19.368-44.049,43.488-44.049h127.896 c24.131,0,43.893,19.928,43.893,44.049v21.012h19.73c12.933,0,23.52-10.346,23.913-23.268l9.314-307.7 c0.195-6.462-2.234-12.863-6.738-17.513C393.821,114.767,387.634,111.948,381.16,111.948z"></path> <path d="M309.166,435.355H181.271c-6.163,0-11.915,4.383-11.915,11.516v30.969c0,6.672,5.342,11.096,11.915,11.096h127.895 c6.323,0,11.366-4.773,11.366-11.096v-30.969C320.532,440.561,315.489,435.355,309.166,435.355z"></path> <path d="M427.696,27.106C427.696,12.138,415.563,0,400.591,0H88.344C73.372,0,61.239,12.138,61.239,27.106v30.946 c0,14.973,12.133,27.106,27.105,27.106H400.59c14.973,0,27.105-12.133,27.105-27.106L427.696,27.106L427.696,27.106z"></path> </g> </g> </g></svg>
                                                      </span>
                            </button>
                            <button v-else @click="restoreVariant(variant.id, i)"
                                    class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                    type="button">
                                  <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
<svg width="25px" height="25px" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg"><path d="M25 38c-5.1 0-9.7-3-11.8-7.6l1.8-.8c1.8 3.9 5.7 6.4 10 6.4 6.1 0 11-4.9 11-11s-4.9-11-11-11c-4.6 0-8.5 2.8-10.1 7.3l-1.9-.7c1.9-5.2 6.6-8.6 12-8.6 7.2 0 13 5.8 13 13s-5.8 13-13 13z"/><path d="M20 22h-8v-8h2v6h6z"/></svg>
                                  </span>
                            </button>

                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>


        </div>

    </div>


</template>

<style scoped>

</style>
