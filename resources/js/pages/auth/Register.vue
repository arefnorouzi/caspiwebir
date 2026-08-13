<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head } from '@inertiajs/vue3';

import { useForm } from '@inertiajs/vue3'
import {ref} from "vue";
import {showToast} from "@/composables/useToast";

const form = useForm({
    name: '',
    mobile: '',
    password: '',
    password_confirmation: ''
})
const mobile = ref("09")
const error_message = ref("")
const processing = ref(false)

function submit() {
    error_message.value = ""
    form.mobile = mobile.value
    if (form.mobile.length != 11)
    {
        error_message.value = "شماره موبایل باید بصورت 11 رقمی وارد شود."
        showToast("شماره موبایل نامعتبر است.", "error")
    }
    else if (!/^09\d{9}$/.test(form.mobile)) {
        error_message.value = "شماره موبایل نامعتبر است."
        showToast("شماره موبایل نامعتبر است.", "error")
    }
    else {
        processing.value = true
        form.post("/authentication/register")
        processing.value = false
    }


}
</script>

<template>
    <AuthBase
        title="ساخت حساب کاربری"
        description="ثبت نام و ساخت حساب کاربری"
    >
        <Head title="ثبت نام" />


            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name">نام و نام خانوادگی (فارسی)</Label>
                    <Input
                        id="name"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="name"
                        name="name"
                        v-model="form.name"
                        placeholder="مهرداد شاهرخی"
                    />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="mobile"></Label>
                    <Input
                        v-model="mobile"
                        id="mobile"
                        type="tel"
                        required
                        :tabindex="2"
                        autocomplete="mobile"
                        name="mobile"
                        placeholder="09123456789"
                    />
                    <InputError :message="form.errors.mobile" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">رمز عبور</Label>
                    <Input
                        v-model="form.password"
                        id="password"
                        type="password"
                        required
                        :tabindex="3"
                        autocomplete="new-password"
                        name="password"
                        placeholder="رمز عبور"
                    />
                    <InputError :message="form.errors.password" />

                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">تکرار رمز عبور</Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        required
                        :tabindex="4"
                        autocomplete="new-password"
                        name="password_confirmation"
                        placeholder="تکرار رمز عبور"
                        v-model="form.password_confirmation"
                    />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <Button
                    type="submit"
                    @click="submit"
                    size="lg"
                    class="mt-2 w-full bg-teal-600 hover:bg-teal-700 text-gray-100 cursor-pointer"
                    tabindex="5"
                    :disabled="processing"
                >
                    <Spinner v-if="processing" />
                    ثبت نام
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                قبلا ثبت نام کردی؟
                <TextLink
                    href="/login"
                    class="underline underline-offset-4"
                    :tabindex="6"
                    >ورود به حساب کاربری</TextLink
                >
            </div>

    </AuthBase>
</template>
