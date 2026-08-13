<script setup>
import { computed } from 'vue'
import Multiselect from 'vue-multiselect'
const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({
            slider_type: 'latest',
            brand_ids: [],
            category_ids: [],
            limit: 10,
        }),
    },
    brands: Array,
    categories: Array,
})
const selectedBrands = computed({
    get() {
        return props.modelValue.brand_ids
            ?.map(id => props.brands.find(b => b.id === id))
            .filter(Boolean)
    },
    set(values) {
        update(
            'brand_ids',
            values.map(v => v.id)
        )
    },
})

const selectedCategories = computed({
    get() {
        return props.modelValue.category_ids
            ?.map(id => props.categories.find(b => b.id === id))
            .filter(Boolean)
    },
    set(values) {
        update(
            'category_ids',
            values.map(v => v.id)
        )
    },
})

const emit = defineEmits(['update:modelValue'])

const update = (key, value) => {
    emit('update:modelValue', {
        ...props.modelValue,
        [key]: value,
    })
}
</script>

<template>

    <div class="grid gap-2 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                انتخاب اسلایدر</label>
            <select @change="update('slider_type', $event.target.value)"
                    class="w-full rounded-md border p-2 border-gray-300"
            >
                <option value="latest">جدیدترین‌ها</option>
                <option value="best_seller">پرفروش‌ترین‌ها</option>
                <option value="popular">محبوب‌ترین‌ها</option>
            </select>

        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                انتخاب برندها</label>
            <Multiselect
                v-model="selectedBrands"
                :options="brands"
                label="name"
                track-by="id"
                :multiple="true"
                placeholder="انتخاب برند"
                class="w-full rounded-md border p-2 border-gray-300"
                @update:modelValue="v => update('brand_ids', v.map(b => b.id))"
            />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                انتخاب دسته بندی ها</label>
            <Multiselect
                v-model="selectedCategories"
                :options="categories"
                label="name"
                track-by="id"
                :multiple="true"
                placeholder="انتخاب برند"
                class="w-full rounded-md border p-2 border-gray-300"
                @update:modelValue="v => update('category_ids', v.map(c => c.id))"
            />

        </div>
        <div>
            <input type="number" v-model="modelValue.limit"
                   class="w-full rounded-md border p-2 border-gray-300" placeholder="تعداد محصول اسلایدر"
            />
        </div>
    </div>





</template>
<style>

.multiselect__tag {
    margin-left: .7rem !important;
}
</style>
