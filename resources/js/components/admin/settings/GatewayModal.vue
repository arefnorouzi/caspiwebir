<script setup>
import { useForm } from '@inertiajs/vue3'
import QuillEditor from "@/components/admin/QuillEditor.vue";

const props = defineProps({
    obj_model: Object,
})

const form = useForm({
    name: props.obj_model.name,
    status: props.obj_model.status,
    image: props.obj_model.image,
    is_default: props.obj_model.is_default,
    is_gateway: props.obj_model.is_gateway,
    description: props.obj_model.description,
    interest_rate: props.obj_model.interest_rate,
    terminal_id: props.obj_model.terminal_id,
    merchant: props.obj_model.merchant,
    username: props.obj_model.username,
    password: props.obj_model.password,
})
const emit = defineEmits(['close'])
const submit = () => {
    form.patch('/admin/payment/' + props.obj_model.id,
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

            <div class="grid grid-cols-2 lg:grid-cols-3 gap-2 mb-4">
                <div>
                    <label class="text-xs text-gray-500">عنوان</label>
                    <input
                        v-model="form.name"
                        type="text"
                        class="w-full border rounded px-3 py-2  text-sm"
                    />
                </div>



                <div>
                    <label class="text-xs text-gray-500">نرخ کارمزد (100-0) %</label>
                    <input
                        v-model="form.interest_rate"
                        type="number" min="0" max="100"
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
                    <label class="text-xs text-gray-500">درگاه پیشفرض</label>
                    <select v-model="form.is_default"
                            class="w-full border rounded px-3 py-2 text-sm"
                    >
                        <option :value="0">خیر</option>
                        <option :value="1">بله</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs text-gray-500">نوع سرویس</label>
                    <select v-model="form.is_gateway"
                            class="w-full border rounded px-3 py-2 text-sm"
                    >
                        <option :value="0">کارت به کارت / چک / فیش</option>
                        <option :value="1">درگاه پرداخت بانکی</option>
                    </select>
                </div>

                <div class="sm:col-span-2 lg:col-span-3">
                    <label class="text-xs text-gray-500">شماره ترمینال</label>
                    <input
                        v-model="form.terminal_id"
                        placeholder="TerminalID"
                        type="text"
                        class="w-full border rounded px-3 py-2 text-left  text-sm"
                        style="direction: ltr"
                    />
                </div>
                <div class="sm:col-span-2 lg:col-span-3">
                    <label class="text-xs text-gray-500">کد مرچنت درگاه</label>
                    <input
                        v-model="form.merchant"
                        placeholder="Merchant / Client_ID"
                        type="text"
                        class="w-full border rounded px-3 py-2 text-left  text-sm"
                        style="direction: ltr"
                    />

                </div>
                <div class="sm:col-span-2 lg:col-span-3">
                    <label class="text-xs text-gray-500">نام کاربری</label>
                    <input
                        v-model="form.username"
                        placeholder="username"
                        type="text"
                        class="w-full border rounded px-3 py-2 text-left  text-sm"
                        style="direction: ltr"
                    />

                </div>
                <div class="sm:col-span-2 lg:col-span-3">
                    <label class="text-xs text-gray-500">رمز (password)</label>
                    <input
                        v-model="form.password"
                        placeholder="password"
                        type="text"
                        class="w-full border rounded px-3 py-2 text-left  text-sm"
                        style="direction: ltr"
                    />

                </div>
                <div class="sm:col-span-2 lg:col-span-3">
                    <label class="text-xs text-gray-500">توضیحات</label>
                    <QuillEditor v-model="form.description" />

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
