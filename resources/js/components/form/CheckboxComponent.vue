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
    </div>
</template>

<script>
export default {
    props: {
        value: Boolean,
        label: String,
        id: String
    }
}
</script>
