<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { ref } from 'vue';
import axios from 'axios';
import { showToast } from '@/composables/useToast.js'
import ValidationErrors from '@/components/validation/ValidationErrors.vue';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const mobile = ref("")
const processing = ref(false)
const error_message = ref("")
const validation_errors = ref(null)
const login_form = useForm({
    mobile: "",
    password: ""
});

async function login(){
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
        await axios.post('/authentication/login', login_form)
            .then((res) => {
                if(res?.data?.successful)
                {
                    showToast("خوش آمدید", "success")
                    if(res?.data?.url)
                    {
                        window.location.replace(res?.data?.url);
                    }
                    else {
                        window.location.replace("/dashboard");
                    }
                }


            })
            .catch(err => {
                if (err?.response?.data?.errors)
                {
                    validation_errors.value = err.response.data.errors
                }
                if (err?.response?.data?.error)
                {
                    showToast(err?.response?.data?.error, "error")

                }

            })
        processing.value = false
    }


}

function validateInput(e) {
    if (e.data && !/^[0-9]$/.test(e.data)) {
        e.preventDefault()
    }
}
</script>

<template>
    <AuthBase
        title="ورود به حساب کاربری"
        description="ورود با شماره موبایل و رمز عبور"
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
                </div>
                <div class="grid gap-2">
                    <Label for="password">رمز عبور</Label>
                    <Input
                        id="password"
                        type="password"
                        name="password"
                        minlength="6"
                        maxlength="32"
                        v-model="login_form.password"
                        required
                        autofocus
                        :tabindex="2"
                        style="direction: ltr; text-align: left"
                    />
                </div>


                <Button
                        @click="login"
                        class="mt-4 p-3 w-full bg-green-800 hover:bg-green-600 cursor-pointer"
                        :tabindex="4"
                        :disabled="processing"
                        data-test="login-button"
                >
                    <LoaderCircle
                        v-if="processing"
                        class="h-4 w-4 animate-spin"
                    />ورود به حساب کاربری
                </Button>
            </div>

            <div class="text-center text-sm text-blue-500">
                <Link href="/authentication/otp">ورود با رمز یکبار مصرف</Link>
            </div>
        </div>
    </AuthBase>
</template>
