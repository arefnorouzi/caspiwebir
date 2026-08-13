<script>
export default {
    props: {
        value: {
            type: String,
            default: null
        },
        label: String,
        placeholder: {
            type: String,
            default: ''
        },
        css_class: {
            type: String,
            default: ''
        },
        id: String,
        rows: {
            type: Number,
            default: 2
        },
        input_error: {
            type: String,
            default: ''
        },
    }
}
</script>

<template>
    <div class="">
        <label :for="id" class="text-sm font-medium text-gray-900 block mb-2">{{ label }}</label>
        <textarea :rows="rows"
                  :id="id"
                  :value="value"
                  @input="$emit('update:modelValue', $event.target.value)"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-4"
                  :class="css_class"
                  :placeholder="placeholder"
        ></textarea>
        <div v-if="input_error" class="text-red-500 text-sm mt-1">
            {{ input_error }}
        </div>
    </div>
</template>

<style scoped>
@media only screen and (max-width: 650px) {
    select{max-width: 90%; font-size: .7rem}
}
</style>
