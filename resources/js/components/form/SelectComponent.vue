<!-- SelectComponent.vue -->
<template>
    <div>
        <label :for="id" class="text-xs font-medium text-gray-900 block mb-2">{{ label }}</label>
        <select :id="id" @change="$emit('update:modelValue', $event.target.value)"
                class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-xs text-gray-900 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                :class="css_class"
                :value="value"
        >
            <option v-if="value == null" :value="null">انتخاب کنید</option>
            <option v-for="(option, opt) in options" :key="opt" :value="option.id">
                {{ option.name }}
            </option>
        </select>
        <div v-if="input_error" class="text-red-500 text-sm mt-1">
            {{ input_error }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        value: {
            type: [Number, Boolean, null],
            default: null
        },
        label: String,
        id: String,
        css_class: {
            type: String,
            default: ''
        },
        options: {
            type: Array,
            required: true
        },
        input_error: {
            type: String,
            default: ''
        },
    }
}
</script>
<style scoped>
@media only screen and (max-width: 650px) {
    select{max-width: 90%; font-size: .7rem}
}
</style>
