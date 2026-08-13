<script setup>
import { ref } from "vue";

const props = defineProps({
    tabs: Array,
});

const activeTab = ref(props.tabs[0].key);
</script>

<template>
    <div class="w-full">
        <!-- Tabs -->
        <div class="flex flex-wrap border-b mb-4">
            <div  v-for="tab in props.tabs"  :key="tab.key">
                <button v-if="tab.status"
                    @click="activeTab = tab.key"
                    class="px-4 py-2 text-sm font-medium border-b-2 cursor-pointer"
                    :class="activeTab === tab.key
                    ? 'border-blue-600 text-blue-600'
                    : 'border-transparent text-gray-600 hover:text-black'"
                >
                    {{ tab.label }}
                </button>
            </div>

        </div>

        <!-- Content -->
        <div class="mt-4">
            <slot :activeTab="activeTab"></slot>
        </div>
    </div>
</template>

<style scoped>
button {
    transition: all .2s;
}
</style>
