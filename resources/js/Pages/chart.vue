<script setup>
import { ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import LineChart from '@/Components/LineChart.vue'

const chartData = ref({
  labels: [],
  datasets: []
});

const chartOptions = ref({
  responsive: true,
  maintainAspectRatio: false
});

const loadChartData = async () => {   
    try {
        const response = await axios.get('/chart-data');
        chartData.value = response.data.chartData;
  } catch (error) {
        console.error("Error saat mengambil chart data:", error);
  }
};

onMounted(() => {
    loadChartData();
})
</script>

<template>
  <div class="p-6 bg-white rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4">Sales Chart</h2>
    <div class="chart-container h-96">
      <LineChart :chart-data="chartData" />
    </div>
  </div>
</template>