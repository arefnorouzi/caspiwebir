<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { ref } from 'vue';
import axios from 'axios';
import { showToast } from '@/composables/useToast.js'
import ValidationErrors from '@/components/validation/ValidationErrors.vue';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const sms_status = ref(false)
const mobile = ref("")
const code = ref("")
const processing = ref(false)
const error_message = ref("")
const validation_errors = ref(null)
const login_form = useForm({
    mobile: ""
});

const verify_form = useForm({
    mobile: "",
    code: 0,
    type: 'sms'
});

const errors = {
    mobile: "",
    sms: ""
}
async function send_sms(){
    error_message.value = ""
    login_form.mobile = mobile.value
    if (login_form.mobile.length != 11)
    {
        error_message.value = "شماره موبایل باید بصورت 11 رقمی وارد شود."
        showToast("شماره موبایل نامعتبر است.", "error")
    }
    else if (!/^09\d{9}$/.test(login_form.mobile)) {
        error_message.value = "شماره موبایل نامعتبر است."
        showToast("شماره موبایل نامعتبر است.", "error")
    }
    else {
        processing.value = true
        await axios.post('/authentication/mobile', login_form)
            .then((res) => {
                const response = res.data
                showToast(response?.message, "success")
                sms_status.value = true
            })
            .catch(err => {
                if (err?.response?.data?.errors)
                {
                    validation_errors.value = err.response.data.errors
                }
                if (err?.response?.data?.message)
                {
                    showToast(err.response.data.message, "error")
                }
                else {
                    showToast("خطا در ارسال کد تایید", "error")
                }
                sms_status.value = false
            })
        processing.value = false
    }


}

async function verify_code(){
    error_message.value = ""
    processing.value = true
    verify_form.mobile = mobile.value
    verify_form.code = Number(code.value)
    if (verify_form.code < 1024 || verify_form.code > 9876)
    {
        error_message.value = "کد تایید نامعتبر است."
        showToast("کد تایید نامعتبر است.", "error")
    }
    else {
        await axios.post('/authentication/verify-code', verify_form)
            .then((res) => {
                const response = res.data
                showToast(response?.message, "success")
                window.location.replace("/dashboard");
            })
            .catch(err => {
                if (err?.response?.data?.errors)
                {
                    validation_errors.value = err.response.data.errors
                }
                if (err?.response?.data?.message)
                {
                    showToast(err.response.data.message, "error")
                }
                else {
                    showToast("خطا در تایید کد", "error")
                }
            })
    }

    processing.value = false
}

function validateInput(e) {
    if (e.data && !/^[0-9]$/.test(e.data)) {
        e.preventDefault()
    }
}
</script>

<template>
    <AuthBase
        title="ورود/ثبت نام"
        description="شماره موبایل خود را وارد نمایید و بر روی دکمه ارسال کد تایید بزنید"
    >
        <Head title="ورود به حساب کاربری" />

        <div
            v-if="status"
            class="mb-4 text-center text-sm font-medium text-green-600"
        >
            {{ status }}
        </div>

        <div
            class="flex flex-col gap-6"
        >
            <div class="my-2">
                <ValidationErrors :errors="validation_errors" />
                <p v-if="error_message" class="bg-rose-100 text-rose-600 my-1 p-2 rounded-md">{{error_message}}</p>
            </div>
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="mobile">شماره موبایل (11 رقمی)</Label>
                    <Input
                        id="mobile"
                        type="tel"
                        minlength="11"
                        maxlength="11"
                        pattern="[0-9]*"
                        inputmode="numeric"
                        @beforeinput="validateInput"
                        name="mobile"
                        v-model="mobile"
                        required
                        autofocus
                        :tabindex="1"
                        placeholder="09123456789"
                    />
                    <InputError :message="errors?.mobile" />
                </div>
                <div v-if="sms_status" class="grid gap-2">
                    <Label for="code">کد تایید پیامک شده را وارد نمایید</Label>
                    <Input
                        id="code"
                        type="text"
                        name="code"
                        minlength="4"
                        maxlength="6"
                        pattern="[0-9]*"
                        @beforeinput="validateInput"
                        inputmode="numeric"
                        v-model="code"
                        required
                        autofocus
                        :tabindex="2"
                    />
                    <InputError :message="errors?.mobile" />
                </div>


                <Button v-if="sms_status"
                        @click="verify_code"
                        class="mt-4 p-3 w-full bg-green-800 hover:bg-green-600 cursor-pointer"
                        :tabindex="4"
                        :disabled="processing"
                        data-test="login-button"
                >
                    <LoaderCircle
                        v-if="processing"
                        class="h-4 w-4 animate-spin"
                    />تایید کد
                </Button>
                <Button v-else
                        @click="send_sms()"
                        class="mt-4 py-3 w-full bg-indigo-600 text-gray-100 hover:bg-indigo-600 cursor-pointer"
                        :tabindex="3"
                        :disabled="processing"
                        data-test="login-button"
                >
                    <LoaderCircle
                        v-if="processing"
                        class="h-4 w-4 animate-spin"
                    />ارسال کد
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground my-2">
                پیامک دریافت نشد؟
                <button :tabindex="4" @click="send_sms">ارسال مجدد کد</button>
            </div>

            <div class="text-center text-sm text-blue-500">
                <Link href="/login">ورود با شماره موبایل و رمز ثابت</Link>
            </div>
        </div>
    </AuthBase>
</template>
