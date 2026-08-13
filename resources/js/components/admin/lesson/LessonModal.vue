<script setup>
import { useForm } from '@inertiajs/vue3'
import InputComponent from "@/components/form/InputComponent.vue";
import SelectComponent from "@/components/form/SelectComponent.vue";

const props = defineProps({
    course: Object,
    lesson: Object
})


const lesson_form = useForm({
    name: props.lesson.name,
    course_id: props?.course?.id,
    status: props.lesson.status,
    free: props.lesson.free,
    lesson_time: props.lesson.lesson_time,
    image: props.lesson.image,
    demo_link: props.lesson.demo_link,
    rank: props.lesson.rank,
})

async function submit() {
    lesson_form.patch("/admin/lesson/" + props?.lesson?.id, {
        onSuccess: () => {
            lesson_form.reset()
            emit('close')
        }
    })
}


const emit = defineEmits(['close'])

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
                ویرایش: {{props?.lesson?.name}}
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-2 mb-4">
                <div>
                    <InputComponent v-model="lesson_form.name"
                                    label="عنوان جلسه"
                                    :value="lesson_form.name"
                                    id="name"
                                    placeholder="عنوان را وارد کنید"
                                    :input_error="lesson_form?.errors?.name"
                    />
                </div>
                <div>
                    <InputComponent v-model="lesson_form.lesson_time"
                                    label="مدت زمان جلسه"
                                    :value="lesson_form.lesson_time"
                                    id="lesson_time"
                                    placeholder="2:30"
                                    :input_error="lesson_form?.errors?.lesson_time"
                                    css_class="ltr"
                    />
                </div>
                <div>
                    <SelectComponent label="وضعیت" id="status"
                                     v-model="lesson_form.status"
                                     :input_error="lesson_form?.errors?.status"
                                     :value="lesson_form.status"
                                     :options="[{id: 0, name: 'غیرفعال'}, {id: 1, name: 'فعال'}]"
                    />
                </div>
                <div>
                    <SelectComponent label="رایگان" id="is_free"
                                     v-model="lesson_form.free"
                                     :input_error="lesson_form?.errors?.free"
                                     :value="lesson_form.free"
                                     :options="[{id: 0, name: 'خیر'}, {id: 1, name: 'بله'}]"
                    />
                </div>
                <div>
                    <InputComponent v-model="lesson_form.demo_link"
                                    label="لینک دمو"
                                    :value="lesson_form.demo_link"
                                    id="demo_link"
                                    placeholder="https://aparat.com/123"
                                    :input_error="lesson_form?.errors?.demo_link"
                                    css_class="ltr"
                    />
                </div>

            </div>

            <div class="flex justify-end gap-2">
                <button
                    @click="emit('close')"
                    class="px-4 py-2 rounded bg-gray-100 text-sm cursor-pointer"
                >
                    انصراف
                </button>


                <button @click="submit"
                    class="me-1 cursor-pointer text-oklch(44.8% 0.119 151.328) border-2 border-blue-500 hover:border-green-300 focus:ring-4 focus:ring-green-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                    بروزرسانی اطلاعات
                </button>

            </div>
        </div>
    </div>
</template>
