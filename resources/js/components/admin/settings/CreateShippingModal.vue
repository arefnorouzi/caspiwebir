<script setup>
import { useForm } from '@inertiajs/vue3'
import QuillEditor from "@/components/admin/QuillEditor.vue";

const props = defineProps({
    provinces: Object
})

const form = useForm({
    name: '',
    status: 1,
    image: null,
    is_default: 0,
    description: null,
    base_cost: 0,
    box_cost: 0,
    weight_cost: 0,
    code: '',
    province_id: null
})
const emit = defineEmits(['close'])
const submit = () => {
    form.post('/admin/shipping',
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
                افزودن رکورد جدید
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 mb-4">
                <div class="">
                    <label class="text-xs text-gray-500">عنوان</label>
                    <input
                        v-model="form.name"
                        type="text"
                        class="w-full border rounded px-3 py-2  text-sm"
                    />
                </div>
                <div>
                    <label class="text-xs text-gray-500">کد</label>
                    <input
                        v-model="form.code"
                        placeholder="tipax"
                        type="text"
                        class="w-full border rounded px-3 py-2 text-left  text-sm"
                    />

                </div>
                <div>
                    <label class="text-xs text-gray-500">هزینه ارسال</label>
                    <input
                        v-model="form.base_cost"
                        type="number" min="0"
                        class="w-full border rounded px-3 py-2 text-sm"
                    />
                </div>
                <div>
                    <label class="text-xs text-gray-500">هزینه بسته بندی</label>
                    <input
                        v-model="form.box_cost"
                        type="number" min="0"
                        class="w-full border rounded px-3 py-2 text-sm"
                    />
                </div>
                <div>
                    <label class="text-xs text-gray-500">هزینه هر کیلو</label>
                    <input
                        v-model="form.weight_cost"
                        type="number" min="0"
                        class="w-full border rounded px-3 py-2 text-sm"
                    />
                </div>
                <div>
                    <label class="text-xs text-gray-500">وضعیت</label>
                    <select v-model="form.status"
                            class="w-full border rounded px-3 py-2 text-sm"
                    >
                        <option :value="0">غیرفعال</option>
                        <option :value="1">فعال</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs text-gray-500">روش پیشفرض</label>
                    <select v-model="form.is_default"
                            class="w-full border rounded px-3 py-2 text-sm"
                    >
                        <option :value="0">خیر</option>
                        <option :value="1">بله</option>
                    </select>
                </div>


                <div class="">
                    <label class="text-xs text-gray-500">توضیحات</label>
                    <input
                        v-model="form.description"
                        type="text" maxlength="150"
                        class="w-full border rounded px-3 py-2 text-sm"
                    />
                </div>
            </div>

            <div class="flex justify-end gap-2 my-2">
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
                    ذخیره
                </button>
            </div>
        </div>
    </div>
</template>
