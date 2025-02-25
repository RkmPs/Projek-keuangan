<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, onMounted } from "vue";
import { Head } from "@inertiajs/vue3";
import LineChart from "@/Components/LineChart.vue";

defineProps({
    transaksi: Object,
    balance: Number,
    totalIncome: Number,
    totalExpense: Number,
    weekly: Number,
    montly: Number,
});

const chartData = ref({
    labels: [],
    datasets: [],
});

const chartOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
});

const loadChartData = async () => {
    try {
        const response = await axios.get("/chart-data");
        chartData.value = response.data.chartData;
    } catch (error) {
        console.error("Error saat mengambil chart data:", error);
    }
};

onMounted(() => {
    loadChartData();
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>
        <div class="flex justify-center">
            <div
                class="flex space-x-20 shadow-lg bg-white text-headline p-4 rounded-[32px] w-2/3 h-14 mt-10"
            >
                <div class="ml-4 font-bold">Saldo</div>
                <div class="text-blue-500">
                    {{ balance[balance.length - 1]?.balance }}
                </div>

                <div class="border-l border-gray-300 h-full"></div>

                <div class="flex items-center space-x-6">
                    <div class="font-bold">Income</div>
                    <div class="text-green-500">{{ totalIncome }}</div>
                    <select
                        class="border-none outline-none focus:ring-0 focus:border-transparent w-6 h-6"
                    >
                        <option value="all">Mingguan</option>
                        <option value="in">Bulanan</option>
                    </select>
                </div>

                <div class="border-l border-gray-300 h-full"></div>

                <div class="flex items-center space-x-6">
                    <div class="font-bold">Expense</div>
                    <div class="text-red-500">{{ totalExpense }}</div>
                    <select
                        class="border-none outline-none focus:ring-0 focus:border-transparent w-6 h-6"
                    >
                        <option value="all">Mingguan</option>
                        <option value="in">Bulanan</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-center mb-">
                            <div class="p-6 bg-white rounded-lg shadow w-3/4">
                                <h2
                                    class="text-xl font-semibold mb-4 text-center"
                                >
                                    Sales Chart
                                </h2>
                                <div class="chart-container h-96">
                                    <LineChart :chart-data="chartData" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
