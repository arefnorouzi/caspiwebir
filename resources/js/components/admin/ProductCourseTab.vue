<script setup lang="ts">
import {Link, router, useForm} from '@inertiajs/vue3';
import MediaPicker from "@/components/admin/MediaPicker.vue";
import InputComponent from "@/components/form/InputComponent.vue";
import TextareaComponent from "@/components/form/TextareaComponent.vue";
import SelectComponent from "@/components/form/SelectComponent.vue";
import LessonModal from "@/components/admin/lesson/LessonModal.vue";
import {ref} from "vue";
import {Button} from "@/components/ui/button";

const props = defineProps({
    product_id: Number,
    courses: Object
})

const course_form = useForm({
    name: null,
    meta: null,
    status: true,
    course_time: null,
    demo_link: null,
    image: null,
    rank: 1,
    user_id: 1,
    product_id: props.product_id
})

const rank_items = [
    {id: 1, name: 1},
    {id: 2, name: 2},
    {id: 3, name: 3},
    {id: 4, name: 4},
    {id: 5, name: 5},
    {id: 6, name: 6},
    {id: 7, name: 7},
    {id: 8, name: 8},
    {id: 9, name: 9},
    {id: 10, name: 10},
    {id: 11, name: 11},
    {id: 12, name: 12},
    {id: 13, name: 13},
    {id: 14, name: 14},
    {id: 15, name: 15},
]

const selectedCourse = ref(null)
const selectedLesson = ref(null)
const editLessonModal = ref(false)
async function openLessonModal(course: any, lesson: any){
    selectedCourse.value = course
    selectedLesson.value = lesson
    editLessonModal.value = true
}
async function storeCourse() {
    course_form.post('/admin/course')
    course_form.reset()
}
const lesson_form = useForm({
    name: null,
    course_id: null,
    status: true,
    free: false,
    lesson_time: null,
    image: null,
    demo_link: null,
    rank: 1,
})

async function storeLesson() {
    lesson_form.post("/admin/lesson", {
        onSuccess: () => {
            lesson_form.reset()
        }
    })
}

async function deleteProperty(item_id: number) {
    if (confirm('از حذف رکورد مطمئنی؟')) {
        router.delete('/admin/course/' + item_id)
    }
}

</script>

<template>
    <div class="border border-gray-200 rounded-md mb-5 flex flex-wrap">
        <div class="w-full lg:w-1/2 md:w-1/2 p-2">
            <div class="w-full p-2 border bg-gray-200 rounded-md">
                <h4>افزودن سرفصل ها</h4>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-3">
                <div>
                    <InputComponent v-model="course_form.name"
                                    :value="course_form.name"
                                    label="نام سرفصل"
                                    id="name"
                                    placeholder="عنوان را وارد کنید"
                                    :input_error="course_form?.errors?.name"
                    />
                </div>
                <div>
                    <InputComponent v-model="course_form.course_time"
                                    :value="course_form.course_time"
                                    label="مدت زمان سرفصل"
                                    id="course_time"
                                    placeholder="2:35"
                                    :input_error="course_form?.errors?.course_time"
                    />
                </div>

                <div class="col-span-2">
                    <TextareaComponent
                        id="product-meta"
                        label="توضیحات متا"
                        placeholder="توضیحات متا"
                        v-model="course_form.meta"
                        :value="course_form.meta"
                        :input_error="course_form?.errors?.meta"
                    />
                </div>
                <div class="col-span-2">
                    <InputComponent v-model="course_form.demo_link"
                                    label="لینک دمو"
                                    :value="course_form.demo_link"
                                    id="demo_link"
                                    placeholder="https://youtube.com/@caspiweb_ir"
                                    :input_error="course_form?.errors?.demo_link"
                                    css_class="ltr"
                    />

                </div>
                <div>
                    <SelectComponent label="وضعیت" id="status" v-model="course_form.status"
                                     :value="course_form.status"
                                     :input_error="course_form?.errors?.status"
                                     :options="[{id: false, name: 'غیرفعال'}, {id: true, name: 'فعال'}]"
                    />
                </div>
                <div>
                    <SelectComponent label="ترتیب فصل" id="status" v-model="course_form.rank"
                                     :value="course_form.rank"
                                     :input_error="course_form?.errors?.rank"
                                     :options="rank_items"
                    />
                </div>
                <div>
                    <label for="product_image" class="text-sm font-medium text-gray-900 block mb-2">تصویر</label>
                    <MediaPicker @select="(url) => course_form.image = url" />
                </div>
                <div>
                    <InputComponent v-model="course_form.image"
                                    label="آدرس تصویر"
                                    :value="course_form.image"
                                    id="image-url"
                                    placeholder="image-url"
                                    :input_error="course_form?.errors?.image"
                                    css_class="ltr"
                    />
                </div>
                <div v-if="course_form.image">
                    <img :src="course_form.image" class="w-32 h-32 object-fill border rounded" />
                    <div v-if="course_form.errors.image" class="text-red-500 text-sm mt-1">
                        {{ course_form.errors.image }}
                    </div>
                </div>

                <div class="col-span-2 text-center">
                    <button @click="storeCourse()"
                            class="p-2 border bg-green-200 hover:bg-green-300 cursor-pointer rounded-md"
                    >ذخیره درس</button>
                </div>



            </div>
        </div>
        <div class="w-full lg:w-1/2 md:w-1/2 p-2">
            <div class="w-full p-2 border bg-gray-200 rounded-md">
                <h4>افزودن جلسه به فصل</h4>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-3">
                <div>
                    <SelectComponent label="انتخاب سرفصل" id="course_id"
                                     v-model="lesson_form.course_id"
                                     :input_error="lesson_form?.errors?.course_id"
                                     :value="lesson_form.course_id"
                                     :options="courses"
                    />
                </div>
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
                                     :options="[{id: false, name: 'غیرفعال'}, {id: true, name: 'فعال'}]"
                    />
                </div>
                <div>
                    <SelectComponent label="رایگان" id="is_free"
                                     v-model="lesson_form.free"
                                     :input_error="lesson_form?.errors?.free"
                                     :value="lesson_form.free"
                                     :options="[{id: false, name: 'خیر'}, {id: true, name: 'بله'}]"
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
                <div>
                    <button @click="storeLesson"
                            class="me-1 cursor-pointer text-oklch(44.8% 0.119 151.328) border-2 border-blue-500 hover:border-green-300 focus:ring-4 focus:ring-green-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                        ثبت جلسه
                    </button>
                </div>
            </div>
        </div>
        <LessonModal
            v-if="editLessonModal"
            :course="selectedCourse"
            :lesson="selectedLesson"
            @close="editLessonModal = false"
        />
        <div class="w-full lg:w-1/1 md:w-1/1 p-2">
            <div class="w-full p-2 border bg-gray-200 rounded-md">
                <h4>لیست دروس</h4>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-2 mb-4">
                <div v-for="(course_item, c_i) in courses" :key="c_i"
                     class="border border-gray-300 rounded-xl shadow-md p-3">
                    <div class="bg-gray-100 p-2 text-lg">{{course_item?.name}}</div>
                    <div class="">
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
                                        عنوان
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        زمان
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        وضعیت
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        عملیات
                                    </p>
                                </th>
                            </tr>
                            </thead>
                            <tbody v-if="course_item?.lessons" class="text-right">
                            <tr v-for="(item, index) in course_item?.lessons" :key="index"
                                :class="item.deleted_at ? 'bg-red-100' : ''">
                                <td class="p-4 border-b border-slate-200 py-1">
                                    <p class="block font-semibold text-sm text-slate-800">{{ item.id }}</p>
                                </td>
                                <td class="p-4 border-b border-slate-200 py-1">
                                    <p class="text-sm text-slate-500">{{ item.name }}</p>
                                </td>

                                <td class="p-4 border-b border-slate-200 py-1">
                                    <p class="text-sm text-slate-500">{{ item.lesson_time }}</p>
                                </td>
                                <td class="p-4 border-b border-slate-200 py-1">
                                    <p class="text-sm text-slate-500">
                                        <span v-if="item.status">فعال</span>
                                        <span v-else>غیرفعال</span>
                                    </p>
                                </td>
                                <td class="p-4 border-b border-slate-200 py-1">
                                    <button @click="openLessonModal(course_item, item)"
                                        class="relative h-10 max-h-[40px] w-10 max-w-[40px] border border-gray-300 rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                        type="button">
                                     <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="w-4 h-4">
                                      <path
                                          d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z">
                                      </path>
                                    </svg>
                                  </span>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

</template>

<style scoped>

</style>
