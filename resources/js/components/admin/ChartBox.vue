<script setup>
import { onMounted, ref } from 'vue'
import { Chart } from 'chart.js/auto'

const props = defineProps({
    title: String,
    labels: Array,
    datasets: Array
})

const canvasRef = ref(null)

onMounted(() => {
    new Chart(canvasRef.value, {
        type: 'line',
        data: {
            labels: props.labels,
            datasets: props.datasets.map(ds => ({
                ...ds,
                tension: 0.4
            }))
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    })
})
</script>

<template>
    <div class="bg-white p-4 rounded-xl">
        <h3 class="font-bold mb-4">{{ title }}</h3>
        <div class="relative h-[300px]">
            <canvas ref="canvasRef"></canvas>
        </div>
    </div>
</template>
