<!-- InputComponent.vue -->
<template>
    <div>
        <label :for="id" class="text-xs font-medium text-gray-900 block mb-2">{{ label }}</label>
        <input
            :id="id"
            :type="type"
            :value="value"
            :placeholder="placeholder"
            @input="$emit('update:modelValue', $event.target.value)"
            @blur="$emit('blur', $event)"
            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-xs rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
            :class="css_class"
        />
        <p v-if="type==='number' && value > 100">{{Number(value).toLocaleString()}}</p>

        <div v-if="input_error" class="text-red-500 text-sm mt-1">
            {{ input_error }}
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    value: {
        type: [String, Number, Date, null],
        default: ''
    },
    input_error: {
        type: String,
        default: ''
    },
    css_class: {
        type: String,
        default: ''
    },
    label: {
        type: String,
        default: ''
    },
    type: {
        type: String,
        default: 'text'
    },
    id: {
        type: String,
        default: () => `input_${Math.random().toString(36).substr(2, 9)}`
    },
    placeholder: {
        type: String,
        default: ''
    },
    disabled: {
        type: Boolean,
        default: false
    },
    required: {
        type: Boolean,
        default: false
    }
})

defineEmits(['update:modelValue', 'blur'])
</script>
<style scoped>
@media only screen and (max-width: 650px) {
    input{max-width: 90%; font-size: .7rem}
}
</style>
