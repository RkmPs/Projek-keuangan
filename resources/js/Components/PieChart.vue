<script setup>
import { Pie } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    ArcElement,
    CategoryScale,
} from "chart.js";

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale);


const props = defineProps({
    pieChartData: {
        type: Object,
        required: true,
    },
    options: {
        type: Object,
        default: () => ({
            responsive: true,
            maintainAspectRatio: false,
        }),
    },
});
</script>

<template>
    <div class="w-full h-72 mb-3">
        <Pie :data="pieChartData" :options="options" />
    </div>
</template>
