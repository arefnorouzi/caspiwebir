<script setup lang="ts">
import {router, useForm} from '@inertiajs/vue3';

const props = defineProps({
    model: Object,
    prices: Object,
    roles: Object
})

const role_price_form = useForm({
    role_id: null,
    product_id: props.model.id,
    price: props.model.price,
    offer_price: null
})
async function storeRolePrice() {
    role_price_form.post('/admin/role-price',{
        onSuccess(){
            role_price_form.reset()
        }
    })
}

async function deleteRolePrice(id: number) {
    if (confirm('از حذف رکورد مطمئنی؟')) {
        router.delete('/admin/role-price/' + id)
    }
}

</script>

<template>
    <div class="border border-gray-200 rounded-md mb-5 flex flex-wrap">
        <div class="w-full lg:w-1/2 md:w-1/2 p-2">
            <div class="w-full p-2 border bg-gray-200 rounded-md">
                <h4>قیمت گذاری براساس سطح کاربری</h4>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-3">
                <div>
                    <label for="status-radio" class="text-sm font-medium text-gray-900 block mb-2">انتخاب سطح کاربری</label>
                    <select v-model="role_price_form.role_id"
                            class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    >
                        <option v-for="(role, r) in roles" :key="r"
                                :value="role.id">{{ role.name }}</option>
                    </select>
                </div>
                <div>
                    <label for="stock" class="text-sm font-medium text-gray-900 block mb-2">قیمت</label>
                    <input type="number" min="0" v-model="role_price_form.price" name="stock" id="stock" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-1.5"
                           placeholder="قیمت عادی" required="">
                    <p class="my-1">{{Number(role_price_form.price).toLocaleString()}}</p>
                </div>



                <div class="col-span-2 text-center">
                    <button @click="storeRolePrice()" class="p-2 border bg-green-200 hover:bg-green-300 cursor-pointer rounded-md">ذخیره قیمت</button>
                </div>



            </div>
        </div>
        <div class="w-full lg:w-1/2 md:w-1/2 p-2">
            <div class="w-full p-2 border bg-gray-200 rounded-md">
                <h4>لیست قیمت های محصول</h4>
            </div>
            <table class="w-full text-center table-auto min-w-max">
                <thead>
                <tr>
                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                        <p class="block text-sm font-normal leading-none text-slate-500">
                            حذف
                        </p>
                    </th>
                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                        <p class="block text-sm font-normal leading-none text-slate-500">
                            سطح کاربری
                        </p>
                    </th>
                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                        <p class="block text-sm font-normal leading-none text-slate-500">
                            قیمت عادی
                        </p>
                    </th>
                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                        <p class="block text-sm font-normal leading-none text-slate-500">
                            قیمت تخفیفی
                        </p>
                    </th>

                </tr>
                </thead>
                <tbody v-if="props.prices && props.prices.length">
                <tr v-for="product_role_price in props.prices" :key="product_role_price.id">
                    <td class="p-4 border-b border-slate-200 py-1">
                        <button @click="deleteRolePrice(product_role_price.id)"
                                class="relative cursor-pointer h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                type="button">
                                                      <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                                          <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14px" height="14px" viewBox="0 0 488.936 488.936" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M381.16,111.948H107.376c-6.468,0-12.667,2.819-17.171,7.457c-4.504,4.649-6.934,11.014-6.738,17.477l9.323,307.69 c0.39,12.92,10.972,23.312,23.903,23.312h20.136v-21.012c0-24.121,19.368-44.049,43.488-44.049h127.896 c24.131,0,43.893,19.928,43.893,44.049v21.012h19.73c12.933,0,23.52-10.346,23.913-23.268l9.314-307.7 c0.195-6.462-2.234-12.863-6.738-17.513C393.821,114.767,387.634,111.948,381.16,111.948z"></path> <path d="M309.166,435.355H181.271c-6.163,0-11.915,4.383-11.915,11.516v30.969c0,6.672,5.342,11.096,11.915,11.096h127.895 c6.323,0,11.366-4.773,11.366-11.096v-30.969C320.532,440.561,315.489,435.355,309.166,435.355z"></path> <path d="M427.696,27.106C427.696,12.138,415.563,0,400.591,0H88.344C73.372,0,61.239,12.138,61.239,27.106v30.946 c0,14.973,12.133,27.106,27.105,27.106H400.59c14.973,0,27.105-12.133,27.105-27.106L427.696,27.106L427.696,27.106z"></path> </g> </g> </g></svg>
                                                      </span>
                        </button>
                    </td>
                    <td class="p-4 border-b border-slate-200 py-1">
                        <p class="text-sm text-slate-500">{{ product_role_price.role.name }}</p>
                    </td>
                    <td class="p-4 border-b border-slate-200 py-1">
                        <p class="text-sm text-slate-500">{{ Number(product_role_price.price).toLocaleString() }}</p>
                    </td>

                    <td class="p-4 border-b border-slate-200 py-1">
                        <p v-if="product_role_price.offer_price" class="text-sm text-slate-500">{{ Number(product_role_price.offer_price).toLocaleString() }}</p>

                    </td>

                </tr>
                </tbody>
            </table>

        </div>
    </div>

</template>

<style scoped>

</style>
