<script setup lang="ts" xmlns="http://www.w3.org/1999/html">
import AppLayout from '@/layouts/DashboardLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ValidationErrors from '@/components/validation/ValidationErrors.vue';
import { onMounted, ref, nextTick  } from 'vue';
import { showToast } from '@/composables/useToast.js';
import axios from 'axios';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'جزئیات درخواست',
        href: '/dashboard/ticket'
    }
];
const chatContainer = ref(null);
const scrollToBottom = () => {
    nextTick(() => {
        chatContainer.value.scrollTop = chatContainer.value.scrollHeight;
    });
};
onMounted(scrollToBottom);

interface Props {
    ticket: object;
}
const props = defineProps<Props>();

const form = useForm({
    ticket_id: props.ticket.id,
    description: ''
});


const validation_errors = ref(null);


const formatDate = (dateStr) => {
    const date = new Date(dateStr);
    return date.toLocaleString('fa-IR', { hour: '2-digit', minute: '2-digit', day: '2-digit', month: 'short' });
};

async function replayTicket() {
    await axios.patch('/dashboard/ticket/' + props.ticket.id, form)
        .then(res => {
            showToast('پاسخ شما با موفقیت ثبت شد', 'success');
            window.location.reload();
        })
        .catch(err => {
            if (err?.response?.data?.errors)
            {
                validation_errors.value = err.response.data.errors;
            }
            if (err?.response?.data?.message)
            {
                showToast(err.response.data.message, 'error');
            }
            else {
                showToast('خطا در ثبت رکورد', 'error');
            }
        });
}


</script>

<template>
    <Head title="جزئیات درخواست پشتیبانی" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex flex-col h-[85vh] max-w-4xl mx-auto bg-white shadow-md rounded-2xl overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-3 bg-gray-100 border-b">
                <h2 class="text-lg font-bold text-gray-700">تیکت شماره: {{ ticket.id }}</h2>
                <p class="text-sm text-gray-500">{{ ticket.title }}</p>
                <p class="text-sm text-gray-500 text-left">{{ formatDate(ticket.updated_at)}}</p>
            </div>

            <!-- Messages Area -->
            <div ref="chatContainer" class="flex-1 overflow-y-auto p-6 space-y-3 bg-gray-50">
                <div
                    class="flex justify-start"
                >
                    <div class="max-w-[75%] bg-gray-100 text-gray-800 px-4 py-2 rounded-2xl rounded-bl-sm shadow-sm">
                        <p class="whitespace-pre-line">{{ ticket.description }}</p>
                        <span class="block text-xs text-gray-500 mt-1 text-left">
                {{ formatDate(ticket.created_at) }}
              </span>
                    </div>
                </div>
                <template v-for="message in ticket.sub_tickets" :key="message.id">
                    <!-- Message from user -->
                    <div
                        v-if="message.user_id"
                        class="flex justify-start"
                    >
                        <div class="max-w-[75%] bg-gray-100 text-gray-800 px-4 py-2 rounded-2xl rounded-bl-sm shadow-sm">
                            <p class="whitespace-pre-line">{{ message.description }}</p>
                            <span class="block text-xs text-gray-500 mt-1 text-left">
                {{ formatDate(message.created_at) }}
              </span>
                        </div>
                    </div>

                    <!-- Message from admin -->
                    <div
                        v-else
                        class="flex justify-end"
                    >
                        <div class="max-w-[75%] bg-blue-600 text-white px-4 py-2 rounded-2xl rounded-br-sm shadow-sm">
                            <p class="whitespace-pre-line">{{ message.description }}</p>
                            <span class="block text-xs text-blue-100 mt-1 text-right">
                {{ formatDate(message.created_at) }}
              </span>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Input Area -->
            <form @submit.prevent="replayTicket" class="border-t bg-white p-4">
                <textarea
                    v-model="form.description"
                    rows="5"
                    minlength="1" maxlength="250"
                    placeholder="پیام خود را بنویسید..."
                    class="w-full mb-3 border rounded-md px-4 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200"
                ></textarea>
                <button
                    type="submit"
                    class="ml-3 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full transition"
                    :disabled="form.processing || !form.description"
                >
                    ارسال پاسخ
                </button>
            </form>
        </div>

    </AppLayout>
</template>

<style scoped>

</style>
