<template>
    <div>
        <!-- دکمه باز کردن مودال -->
        <button type="button" @click="openModal"
                class="cursor-pointer text-black bg-orange-200 hover:bg-orange-300 focus:ring-4 focus:ring-orange-500 rounded-md inline-flex items-center px-5 py-2.5 text-center">
            انتخاب تصویر
        </button>

        <!-- مودال -->
        <Teleport to="body">
            <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                <div class="bg-white rounded-lg w-11/12 max-w-5xl max-h-[90vh] flex flex-col">
                    <div class="flex justify-between items-center p-4 border-b">
                        <h3 class="text-lg font-bold">گالری رسانه</h3>
                        <button @click="closeModal" class="text-gray-500 hover:text-gray-700">&times;</button>
                    </div>

                    <div class="p-4 border-b">
                        <!-- ناحیه آپلود درگ/دراپ یا فایل -->
                        <div
                            class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:bg-gray-50"
                            @dragover.prevent
                            @drop.prevent="onDrop"
                            @click="$refs.fileInput.click()"
                        >
                            <input type="file" ref="fileInput" class="hidden" accept="image/*" @change="onFileSelect" />
                            <span>کلیک کنید یا تصویر را بکشید و رها کنید</span>
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto p-4">
                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-4">
                            <div
                                v-for="item in mediaList"
                                :key="item.id"
                                class="relative aspect-square rounded-lg overflow-hidden border-2 cursor-pointer hover:border-blue-500"
                                :class="{ 'border-blue-500': selectedId === item.id }"
                                @click="selectImage(item)"
                            >
                                <img :src="item.media_path" class="w-full h-full object-cover" />
                                <div v-if="selectedId === item.id" class="absolute inset-0 bg-blue-500/20 flex items-center justify-center">
                                    <CheckIcon class="w-8 h-8 text-blue-600" />
                                </div>
                            </div>
                        </div>
                        <!-- Pagination ساده -->
                        <div class="mt-4 flex justify-center">
                            <button
                                v-for="link in paginationLinks"
                                :key="link.label"
                                @click="fetchMedia(link.url)"
                                v-html="link.label"
                                class="mx-1 px-3 py-1 border rounded"
                                :class="{ 'bg-blue-500 text-white': link.active }"
                            ></button>
                        </div>
                    </div>

                    <div class="p-4 border-t flex justify-end gap-2">
                        <button @click="closeModal" class="px-4 py-2 border rounded">انصراف</button>
                        <button @click="confirmSelection" class="px-4 py-2 bg-blue-500 text-white rounded" :disabled="!selectedId">
                            انتخاب
                        </button>
                    </div>
                </div>
            </div>
        </Teleport>
    </div>
</template>

<script setup>
import {ref} from 'vue'
import axios from 'axios'
import {CheckIcon} from "lucide-vue-next";

const emit = defineEmits(['select'])

const isOpen = ref(false)
const mediaList = ref([])
const paginationLinks = ref([])
const selectedId = ref(null)
const selectedMedia = ref(null)

const fetchMedia = async (url = '/admin/media-list') => {
    try {
        const res = await axios.get(url)
        mediaList.value = res.data.data
        // ساخت لینک‌های پیجینیشن (ساده)
        paginationLinks.value = res.data.links
    } catch (error) {
        console.error(error)
    }
}

const openModal = () => {
    fetchMedia()
    isOpen.value = true
}

const closeModal = () => {
    isOpen.value = false
    selectedId.value = null
    selectedMedia.value = null
}

const selectImage = (item) => {
    selectedId.value = item.id
    selectedMedia.value = item
}

const confirmSelection = () => {
    if (selectedMedia.value) {
        // آدرس کامل تصویر را برمی‌گردانیم (قابل ذخیره در فیلد string)
        const imageUrl = selectedMedia.value.media_path
        emit('select', imageUrl)
        closeModal()
    }
}

// آپلود فایل
const fileInput = ref(null)
const onFileSelect = async (e) => {
    const file = e.target.files[0]
    if (!file) return
    await uploadFile(file)
}

const onDrop = async (e) => {
    const file = e.dataTransfer.files[0]
    if (file) await uploadFile(file)
}

const uploadFile = async (file) => {
    const formData = new FormData()
    formData.append('file', file)
    try {
        await axios.post('/upload', formData, {
            headers: {'Content-Type': 'multipart/form-data'}
        })
        await fetchMedia();
        // const newMedia = response.data.path
        // // بعد از آپلود موفق، تصویر جدید را به لیست اضافه و خودکار انتخاب کنید
        // mediaList.value.unshift(newMedia) // اضافه به اول لیست
        // selectedId.value = newMedia.id
        // selectedMedia.value = newMedia
    } catch (err) {
        console.error(err)
    }
}
</script>
