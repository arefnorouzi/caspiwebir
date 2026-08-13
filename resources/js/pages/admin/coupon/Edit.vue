<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import FlashMessage from "@/components/FlashMessage.vue";
import SelectComponent from "@/components/form/SelectComponent.vue";
import InputComponent from "@/components/form/InputComponent.vue";
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'ویرایش کد تخفیف',
        href: '/admin/coupon',
    },
];

interface Props {
    model: object;
}
const props = defineProps<Props>()

const form = useForm({
    code: props.model.code,
    max_usage: props.model.max_usage,
    value: props.model.value,
    coupon_type: props.model.coupon_type,
    active: props.model.active,
    min_purchase: props.model.min_purchase,
    starts_at: props.model.starts_at,
    expires_at: props.model.expires_at
});
const formatDate = (d) =>
    new Date(d).toLocaleDateString('fa-IR', { year: 'numeric', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' })

async function submit() {
    form.patch("/admin/coupon/" + props.model.id)
}

</script>
<template>
    <Head title="ویرایش کد تخفیف" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessage />
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">ویرایش کد تخفیف</h3>
                    </div>
                    <div class="ml-3">
                        <Link href="/admin/coupon">
                            <button
                                class="me-1 cursor-pointer text-black bg-white border border-gray-200 hover:border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-md inline-flex items-center px-3 py-2.5 text-center mr-2">
                                <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20 10L20.7071 10.7071L21.4142 10L20.7071 9.29289L20 10ZM3 18C3 18.5523 3.44772 19 4 19C4.55229 19 5 18.5523 5 18L3 18ZM15.7071 15.7071L20.7071 10.7071L19.2929 9.29289L14.2929 14.2929L15.7071 15.7071ZM20.7071 9.29289L15.7071 4.29289L14.2929 5.70711L19.2929 10.7071L20.7071 9.29289ZM20 9L10 9L10 11L20 11L20 9ZM3 16L3 18L5 18L5 16L3 16ZM10 9C6.13401 9 3 12.134 3 16L5 16C5 13.2386 7.23858 11 10 11L10 9Z" fill="#33363F"></path> </g></svg>

                                <span class="ms-1">بازگشت</span>
                            </button>
                        </Link>
                    </div>
                </div>

                <div class="relative flex flex-col w-full h-full overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
                    <form @submit.prevent="submit" class="space-y-4 p-2">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-3">
                            <div>
                                <InputComponent v-model="form.code"
                                                :value="form.code"
                                                label="کد تخفیف"
                                                id="code"
                                                placeholder="off-code"
                                                :input_error="form?.errors?.code"
                                                css_class="ltr en-text"
                                />
                            </div>
                            <div>
                                <SelectComponent label="نوع تخفیف" id="status" v-model="form.coupon_type"
                                                 :input_error="form?.errors?.coupon_type"
                                                 :value="form.coupon_type"
                                                 :options="[{id: 'percent', name: 'درصدی'}, {id: 'fixed', name: 'مبلغ ثابت'}]"
                                />
                            </div>
                            <div>
                                <InputComponent v-model="form.value"
                                                :value="form.value"
                                                label="مقدار تخفیف"
                                                id="coupon_value"
                                                placeholder="1000"
                                                :input_error="form?.errors?.value"
                                                css_class="ltr"
                                                type="number"
                                />
                            </div>
                            <div>
                                <InputComponent v-model="form.max_usage"
                                                :value="form.max_usage"
                                                label="تعداد"
                                                id="max_usage"
                                                placeholder="1000"
                                                :input_error="form?.errors?.max_usage"
                                                css_class="ltr"
                                                type="number"
                                />
                            </div>
                            <div>
                                <InputComponent v-model="form.min_purchase"
                                                :value="form.min_purchase"
                                                label="حداقل مبلغ سفارش (اختیاری)"
                                                id="min_purchase"
                                                placeholder="500000"
                                                :input_error="form?.errors?.min_purchase"
                                                css_class="ltr"
                                                type="number"
                                />
                            </div>

                            <div>
                                <SelectComponent label="وضعیت" id="status" v-model="form.active"
                                                 :input_error="form?.errors?.active"
                                                 :value="form.active"
                                                 :options="[{id: 0, name: 'غیرفعال'}, {id: 1, name: 'فعال'}]"
                                />
                            </div>
                            <div>
                                <InputComponent v-model="form.starts_at"
                                                :value="form.starts_at"
                                                label="تاریخ شروع"
                                                id="starts_at"
                                                placeholder="2028-08-22"
                                                :input_error="form?.errors?.starts_at"
                                                css_class="ltr"
                                                type="date"
                                />
                            </div>
                            <div>
                                <InputComponent v-model="form.starts_at"
                                                :value="form.starts_at"
                                                label="تاریخ شروع"
                                                id="starts_at_input"
                                                placeholder="2028-08-22"
                                                :input_error="form?.errors?.starts_at"
                                                css_class="ltr"
                                />
                            </div>
                            <div>
                                <InputComponent v-model="form.expires_at"
                                                :value="form.expires_at"
                                                label="انقضای کوپن تخفیف"
                                                id="expires_at"
                                                placeholder="2029-08-22"
                                                :input_error="form?.errors?.expires_at"
                                                css_class="ltr"
                                                type="date"
                                />
                            </div>
                            <div>
                                <InputComponent v-model="form.expires_at"
                                                :value="form.expires_at"
                                                label="انقضای کوپن تخفیف"
                                                id="expires_at_input"
                                                placeholder="2029-08-22"
                                                :input_error="form?.errors?.expires_at"
                                                css_class="ltr"
                                />
                            </div>

                        </div>

                        <button type="submit"
                                class="me-1 cursor-pointer text-oklch(44.8% 0.119 151.328) bg-green-200 hover:bg-green-300 focus:ring-4 focus:ring-green-500 rounded-md inline-flex items-center px-5 py-2.5 text-center mr-2">
                            <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M18.1716 1C18.702 1 19.2107 1.21071 19.5858 1.58579L22.4142 4.41421C22.7893 4.78929 23 5.29799 23 5.82843V20C23 21.6569 21.6569 23 20 23H4C2.34315 23 1 21.6569 1 20V4C1 2.34315 2.34315 1 4 1H18.1716ZM4 3C3.44772 3 3 3.44772 3 4V20C3 20.5523 3.44772 21 4 21L5 21L5 15C5 13.3431 6.34315 12 8 12L16 12C17.6569 12 19 13.3431 19 15V21H20C20.5523 21 21 20.5523 21 20V6.82843C21 6.29799 20.7893 5.78929 20.4142 5.41421L18.5858 3.58579C18.2107 3.21071 17.702 3 17.1716 3H17V5C17 6.65685 15.6569 8 14 8H10C8.34315 8 7 6.65685 7 5V3H4ZM17 21V15C17 14.4477 16.5523 14 16 14L8 14C7.44772 14 7 14.4477 7 15L7 21L17 21ZM9 3H15V5C15 5.55228 14.5523 6 14 6H10C9.44772 6 9 5.55228 9 5V3Z" fill="#008040"></path> </g></svg>
                            <span class="ms-1">ذخیره اطلاعات</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>

</template>


