<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import MediaPicker from "@/components/admin/MediaPicker.vue";
import InputComponent from '@/components/form/InputComponent.vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'تنظیمات عمومی سایت',
        href: '/admin/setting/website',
    },
];
interface Props {
    model: object;
}
const props = defineProps<Props>()


const form = useForm({
    name: props.model.name,
    meta: props.model.meta,
    mobile: props.model.mobile,
    logo: props.model.logo,
    favicon: props.model.favicon,
    email: props.model.email,
    phone: props.model.phone,
    x: props.model.x,
    youtube: props.model.youtube,
    telegram: props.model.telegram,
    instagram: props.model.instagram,
    whatsapp: props.model.whatsapp,
    ita: props.model.ita,
    rubika: props.model.rubika,
    igap: props.model.igap,
    soroush: props.model.soroush,
    aparat: props.model.aparat,
    address: props.model.address,
    enamad: props.model.enamad,
});

function removeImage(){
    form.logo = props.model.logo
}
function removeFavicon(){
    form.favicon = props.model.favicon
}
async function updateRecord() {
    form.post('/admin/setting/website')
}

</script>

<template>
    <Head title="تنظیمات عمومی سایت" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">تنظیمات عمومی سایت</h3>
                    </div>
                    <div class="ml-3">
                        <Link :href="`/admin/setting`">
                            <button
                                class="me-1 cursor-pointer text-black bg-white border border-gray-200 hover:border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-md inline-flex items-center px-3 py-2.5 text-center mr-2">
                                <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20 10L20.7071 10.7071L21.4142 10L20.7071 9.29289L20 10ZM3 18C3 18.5523 3.44772 19 4 19C4.55229 19 5 18.5523 5 18L3 18ZM15.7071 15.7071L20.7071 10.7071L19.2929 9.29289L14.2929 14.2929L15.7071 15.7071ZM20.7071 9.29289L15.7071 4.29289L14.2929 5.70711L19.2929 10.7071L20.7071 9.29289ZM20 9L10 9L10 11L20 11L20 9ZM3 16L3 18L5 18L5 16L3 16ZM10 9C6.13401 9 3 12.134 3 16L5 16C5 13.2386 7.23858 11 10 11L10 9Z" fill="#33363F"></path> </g></svg>

                                <span class="ms-1">بازگشت</span>
                            </button>
                        </Link>
                    </div>
                </div>
                <div class="relative flex mt-2 flex-col w-full h-full overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">

                    <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 gap-4 mt-3 p-1">
                        <div>
                            <InputComponent v-model="form.name"
                                            :value="form.name"
                                            label="نام سایت"
                                            id="name"
                                            placeholder="عنوان را وارد کنید"
                                            :input_error="form?.errors?.name"
                            />

                        </div>

                        <div>
                            <InputComponent v-model="form.phone"
                                            :value="form.phone"
                                            label="تلفن"
                                            id="phone"
                                            placeholder="0213456789"
                                            :input_error="form?.errors?.phone"
                            />

                        </div>

                        <div>
                            <InputComponent v-model="form.email"
                                            :value="form.email"
                                            label="ایمیل"
                                            id="email"
                                            placeholder="info@site.com"
                                            type="email"
                                            :input_error="form?.errors?.email"
                            />

                        </div>

                        <div>
                            <InputComponent v-model="form.address"
                                            :value="form.address"
                                            label="آدرس شرکت / فروشگاه"
                                            id="address"
                                            placeholder="تهران، میدان آزادی"
                                            :input_error="form?.errors?.address"
                            />

                        </div>

                        <div>
                            <InputComponent v-model="form.telegram"
                                            :value="form.telegram"
                                            label="پروفایل تلگرام"
                                            id="telegram"
                                            placeholder="https://t.me/username"
                                            :input_error="form?.errors?.telegram"
                            />

                        </div>

                        <div>
                            <InputComponent v-model="form.instagram"
                                            :value="form.instagram"
                                            label="پروفایل اینستاگرام"
                                            id="instagram"
                                            placeholder="https://instagram.com/username"
                                            :input_error="form?.errors?.instagram"
                            />

                        </div>

                        <div>
                            <InputComponent v-model="form.whatsapp"
                                            :value="form.whatsapp"
                                            label="پروفایل واتساپ"
                                            id="whatsapp"
                                            placeholder="https://wa.me/989123456789"
                                            :input_error="form?.errors?.whatsapp"
                            />

                        </div>

                        <div>
                            <InputComponent v-model="form.meta"
                                            :value="form.meta"
                                            label="توضیحات متا"
                                            id="meta"
                                            placeholder="معرفی کوتاه شرکت / فروشگاه"
                                            :input_error="form?.errors?.meta"
                            />

                        </div>

                        <div>
                            <InputComponent v-model="form.enamad"
                                            :value="form.enamad"
                                            label="کد اینماد"
                                            id="enamad"
                                            placeholder=""
                                            :input_error="form?.errors?.enamad"
                            />

                        </div>

                        <div>
                            <InputComponent v-model="form.x"
                                            :value="form.x"
                                            label="پروفایل ایکس (توییتر)"
                                            id="twitter"
                                            placeholder="https://x.com/username"
                                            :input_error="form?.errors?.x"
                            />

                        </div>

                        <div>
                            <InputComponent v-model="form.youtube"
                                            :value="form.youtube"
                                            label="کانال یوتیوب"
                                            id="youtube"
                                            placeholder="https://youtube.com/username"
                                            :input_error="form?.errors?.youtube"
                            />

                        </div>


                        <div>
                            <InputComponent v-model="form.aparat"
                                            :value="form.aparat"
                                            label="کانال آپارات"
                                            id="aparat"
                                            placeholder="https://aparat.com/username"
                                            :input_error="form?.errors?.aparat"
                            />

                        </div>

                        <div>
                            <InputComponent v-model="form.rubika"
                                            :value="form.rubika"
                                            label="روبیکا"
                                            id="rubika"
                                            placeholder=""
                                            :input_error="form?.errors?.rubika"
                            />

                        </div>

                        <div>
                            <InputComponent v-model="form.igap"
                                            :value="form.igap"
                                            label="آیگپ"
                                            id="igap"
                                            placeholder=""
                                            :input_error="form?.errors?.igap"
                            />

                        </div>

                        <div>
                            <InputComponent v-model="form.soroush"
                                            :value="form.soroush"
                                            label="سروش"
                                            id="soroush"
                                            placeholder=""
                                            :input_error="form?.errors?.soroush"
                            />

                        </div>

                        <div>
                            <InputComponent v-model="form.ita"
                                            :value="form.ita"
                                            label="ایتا"
                                            id="ita"
                                            placeholder=""
                                            :input_error="form?.errors?.ita"
                            />

                        </div>


                        <div>
                            <label for="product_image" class="text-sm font-medium text-gray-900 block mb-2">تصویر لوگو</label>
                            <MediaPicker @select="(url) => form.logo = url" />
                            <div v-if="form.errors.logo" class="text-red-500 text-sm mt-1">
                                {{ form.errors.logo }}
                            </div>
                        </div>
                        <div v-if="form.logo">
                            <img :src="form.logo" class="object-cover border rounded" />

                            <button @click="removeImage" class="py-1 px-2 rounded-md bg-red-500 text-white">حذف</button>

                        </div>

                        <div>
                            <label for="product_image" class="text-sm font-medium text-gray-900 block mb-2">تصویر فاوایکون</label>
                            <MediaPicker @select="(url) => form.favicon = url" />
                            <div v-if="form.errors.favicon" class="text-red-500 text-sm mt-1">
                                {{ form.errors.favicon }}
                            </div>
                        </div>
                        <div v-if="form.favicon && form.favicon != props?.model?.favicon">
                            <img :src="form.favicon" class="object-cover border rounded" />

                            <button @click="removeFavicon" class="py-1 px-2 rounded-md bg-red-500 text-white">حذف</button>

                        </div>
                    </div>

                    <div class="my-5 text-center">
                        <button type="submit" @click="updateRecord"
                                class="bg-gray-500 w-50 text-white rounded-md shadow-md px-4 py-2 cursor-pointer">ذخیره تنظیمات</button>

                    </div>


                </div>
            </div>
        </div>
    </AppLayout>
</template>
