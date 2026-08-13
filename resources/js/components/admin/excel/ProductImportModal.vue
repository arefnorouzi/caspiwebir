<script setup>
import { useForm } from '@inertiajs/vue3'

const import_form = useForm({
    file: null
});

const import_excel = async () => {
    import_form.post("/admin/products-import", {
        forceFormData: true,   // مهم برای ارسال فایل
        onSuccess: () => {
            import_form.reset('file')
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
                خروجی اکسل
            </h2>

            <div class="my-2 relative">
                <form @submit.prevent="import_excel">
                    <p class="p-2 rounded-md bg-amber-100 text-amber-700">فایل اکسل را از کامپیوتر خود انتخاب نمایید و بارگزاری کنید.</p>
                    <input
                        type="file"
                        class="border-blue-500 my-2 p-2 rounded w-[250px] border-2"
                        @change="import_form.file = $event.target.files[0]"
                        accept=".xlsx"
                    />

                    <div v-if="import_form.errors.file" class="text-red-600 mt-2">
                        {{ import_form.errors.file }}
                    </div>

                    <button
                        type="submit"
                        class="me-1  cursor-pointer text-oklch(44.8% 0.119 151.328) border border-blue-500 hover:border-blue-700 focus:ring-4 focus:ring-blue-500 rounded-md inline-flex items-center px-5 py-1.5 text-center mr-2"
                        :disabled="import_form.processing"
                    >
                        <svg width="15px" height="15px" viewBox="0 0 192 192" xmlns="http://www.w3.org/2000/svg" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M56 30c0-1.662 1.338-3 3-3h108c1.662 0 3 1.338 3 3v132c0 1.662-1.338 3-3 3H59c-1.662 0-3-1.338-3-3v-32m0-68V30" style="fill-opacity:.402658;stroke:#000000;stroke-width:12;stroke-linecap:round;paint-order:stroke fill markers"></path><rect width="68" height="68" x="-58.1" y="40.3" rx="3" style="fill:none;fill-opacity:.402658;stroke:#000000;stroke-width:12;stroke-linecap:round;stroke-linejoin:miter;stroke-dasharray:none;stroke-opacity:1;paint-order:stroke fill markers" transform="translate(80.1 21.7)"></rect><path d="M138.79 164.725V27.175M56.175 58.792H170M170 96H90.328M169 133.21H56.175M44.5 82l23 28m0-28-23 28" style="fill:none;stroke:#000000;stroke-width:12;stroke-linecap:round;stroke-linejoin:round;stroke-dasharray:none;stroke-opacity:1"></path></g></svg>
                        <span class="p-1">{{ import_form.processing ? 'در حال پردازش...' : 'آپلود اکسل' }}</span>
                    </button>
                    <button
                        @click="emit('close')"
                        class="px-5 py-1.5 border rounded bg-gray-100 text-sm cursor-pointer"
                    >
                        انصراف
                    </button>
                </form>

            </div>

        </div>
    </div>
</template>
