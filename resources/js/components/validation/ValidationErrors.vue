<script setup lang="ts">
const props = defineProps({
    errors: Object
})
</script>

<template>
    <div v-if="props.errors" class="my-2 border border-red-200 bg-red-100 rounded-md text-red-500 p-2">
        <p class="mb-1 font-bold">اطلاعات وارد شده برای فیلدهای زیر نادرست است. لطفا بعداز اصلاح مجدد درخواست ارسال نمایید.</p>

        <p v-for="(validation_error, key) in props.errors" :key="key"
           class="mb-2">{{validation_error[0]}}</p>
    </div>
</template>

<style scoped>

</style>
