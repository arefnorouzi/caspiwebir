<!-- CheckboxComponent.vue -->
<template>
    <div>
        <label :for="id">
            <input
                type="checkbox"
                :id="id"
                :checked="value"
                @change="$emit('update:modelValue', $event.target.checked)"
            />
            {{ label }}
        </label>
        <div v-if="input_error" class="text-red-500 text-sm mt-1">
            {{ input_error }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        value: Boolean,
        label: String,
        id: String,
        input_error: {
            type: String,
            default: ''
        },
    }
}
</script>
