<script setup>
import { useForm } from '@inertiajs/vue3'
import BaseSwitch from '@/components/admin/BaseSwitch.vue'
const props = defineProps({
    product: Object,
})

const form = useForm({
    name: props.product.name,
    status: props.product.status,
    image: props.product.image,
    price: props.product.price,
    offer_price: props.product.offer_price,
    offer_end_date: props.product.offer_end_date,
    stock: props.product.stock,
    amazing: props.product.amazing,
    pinned: props.product.pinned,
    suggested: props.product.suggested,
    pre_order: props.product.pre_order,
    buyable: props.product.buyable,
    torobpay: props.product.torobpay,
    min_buy: props.product.min_buy,
})
const emit = defineEmits(['close'])
const submit = () => {
    form.patch('/admin/update-product/' + props.product.id,
        {
            preserveScroll: true,
            onSuccess: () => emit('close'),
        }
    )
}
</script>

<template>
    <div class="fixed inset-0 z-50 flex items-center justify-center">
        <!-- Backdrop -->
        <div
            class="absolute inset-0 bg-black/40"
            @click="emit('close')"
        ></div>

        <!-- Modal -->
        <div
            class="relative w-full max-w-lg bg-white rounded-lg shadow-lg p-6"
        >
            <h2 class="text-lg font-semibold mb-4">
                ویرایش سریع محصول: {{product?.id}}
            </h2>

            <div class="grid grid-cols-2 lg:grid-cols-3 gap-2 mb-4">
                <div class="sm:col-span-3">
                    <label class="text-xs text-gray-500">نام محصول</label>
                    <input
                        v-model="form.name"
                        type="text"
                        class="w-full border rounded px-3 py-2  text-sm"
                    />
                </div>
                <div>
                    <label class="text-xs text-gray-500">قیمت</label>
                    <input
                        v-model="form.price"
                        type="number"
                        class="w-full border rounded px-3 py-2  text-sm"
                    />
                    <small v-if="form.price > 0">{{Number(form.price).toLocaleString()}}</small>
                </div>

                <div>
                    <label class="text-xs text-gray-500">قیمت تخفیفی</label>
                    <input
                        v-model="form.offer_price"
                        type="number"
                        class="w-full border rounded px-3 py-2  text-sm"
                    />
                    <small v-if="form.offer_price > 0">{{Number(form.offer_price).toLocaleString()}}</small>
                </div>
                <div>
                    <label class="text-xs text-gray-500">انقضای تخفیف</label>
                    <input
                        v-model="form.offer_end_date"
                        type="text"
                        class="w-full border rounded px-3 py-2 text-left  text-sm"
                        style="direction: ltr"
                    />

                </div>

                <div>
                    <label class="text-xs text-gray-500">موجودی</label>
                    <input
                        v-model="form.stock"
                        type="number"
                        class="w-full border rounded px-3 py-2 text-sm"
                    />
                    <small v-if="form.stock > 0">{{Number(form.stock).toLocaleString()}}</small>
                </div>
                <div>
                    <label class="text-xs text-gray-500">حداقل خرید (عدد)</label>
                    <input
                        v-model="form.min_buy"
                        type="number"
                        class="w-full border rounded px-3 py-2 text-sm"
                    />
                    <small v-if="form.min_buy > 0">{{Number(form.min_buy).toLocaleString()}}</small>
                </div>
                <div>
                    <label class="text-xs text-gray-500 block mb-1">وضعیت</label>
                    <BaseSwitch v-model="form.status" class="" />
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1">فروش ویژه</label>
                    <BaseSwitch v-model="form.pinned" class="" />
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1"> پیشنهادی</label>
                    <BaseSwitch v-model="form.suggested" class="" />
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1"> شگفت انگیز</label>
                    <BaseSwitch v-model="form.amazing" class="" />
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1">فقط پیش سفارش</label>
                    <BaseSwitch v-model="form.pre_order" class="" />
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1">فروش/توقف فروش</label>
                    <BaseSwitch v-model="form.buyable" class="" />
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1">فروش قسطی</label>
                    <BaseSwitch v-model="form.torobpay" class="" />
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <button
                    @click="emit('close')"
                    class="px-4 py-2 rounded bg-gray-100 text-sm cursor-pointer"
                >
                    انصراف
                </button>

                <button
                    @click="submit"
                    :disabled="form.processing"
                    class="px-4 py-2 rounded bg-indigo-600 text-white text-sm cursor-pointer
                    disabled:opacity-50"
                    >
                    بروزرسانی
                </button>
            </div>
        </div>
    </div>
</template>
