<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    obj_model: Object,
})

const form = useForm({
    name: props.obj_model.name,
    status: props.obj_model.status,
    image: props.obj_model.image,
    is_default: props.obj_model.is_default,
    description: props.obj_model.description,
    base_cost: props.obj_model.base_cost,
    box_cost: props.obj_model.box_cost,
    weight_cost: props.obj_model.weight_cost,
    code: props.obj_model.code,
})
const emit = defineEmits(['close'])
const submit = () => {
    form.patch('/admin/shipping/' + props.obj_model.id,
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
                ویرایش: {{obj_model?.name}}
            </h2>

            <div class="grid grid-cols-1 gap-2 mb-4">
                <div>
                    <label class="text-xs text-gray-500">عنوان</label>
                    <input
                        v-model="form.name"
                        type="text"
                        class="w-full border rounded px-3 py-2  text-sm"
                    />
                </div>
                <div class="">
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
                    class="px-4 py-2 rounded bg-green-700 text-white text-sm cursor-pointer
                    disabled:opacity-50"
                >
                    بروزرسانی
                </button>
            </div>
        </div>
    </div>
</template>
