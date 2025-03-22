<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, onMounted, nextTick, watch } from "vue";
import { Head, router } from "@inertiajs/vue3";
import LineChart from "@/Components/LineChart.vue";
import PieChart from "@/Components/PieChart.vue";
import axios from "axios";
import feather from "feather-icons";

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

const incomeData = ref({
    labels: [],
    datasets: [],
});
const expenseData = ref({
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
        chartData.value = response.data.chartData || {
            labels: [],
            datasets: [
                {
                    label: "Saldo",
                    data: [],
                    backgroundColor: "rgba(54, 162, 235, 0.5)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 1,
                },
            ],
        };

        const pieResponse1 = await axios.get("/expense-data");
        expenseData.value = pieResponse1.data.pieChartData || {
            labels: [],
            datasets: [],
        };
        const pieResponse2 = await axios.get("/income-data");
        incomeData.value = pieResponse2.data.pieChartData || {
            labels: [],
            datasets: [],
        };

    } catch (error) {
        console.error("Error saat mengambil chart data:", error);
    }
};

//memformat nominal
const formatCurrency = (value) => {
    return new Intl.NumberFormat({
        minimumFractionDigits: 0
    }).format(value);
};

const filters = ref({
    filter: 'monthly'
})

//watch untuk mengirim request otomatis
watch(
    () => filters.value.filter,
    (newFilter) => {
        router.get(
            "/dashboard",
            { filter: newFilter },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true 
            }
        );
    },
    { immediate: true } 
);
onMounted(async () => {
    await nextTick();
    loadChartData();
    feather.replace();
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
                class="flex space-x-16 shadow-lg bg-white text-headline p-4 rounded-[32px] w-2/3 h-14 mt-10"
            >

                <div class="ml-14 font-bold">Saldo</div>
                <div class=" relative text-blue-500">
                    <span class="absolute text-black text-xs -top-2 right-16 opacity-50">Rp</span>
                    {{ formatCurrency(balance) }}
                </div>

                <div class="border-l border-gray-300 h-full"></div>
                <div class="flex items-center space-x-7">
                    <div class="font-bold">Income</div>
                    <div class="relative text-green-500">
                        <span class="absolute text-black text-xs -top-2 right-16 opacity-50">Rp</span>
                        {{ formatCurrency(totalIncome) }}
                    </div>

                    <select
                        class="border-none outline-none focus:ring-0 focus:border-transparent w-6 h-6"
                    >
                        <option value="all">Mingguan</option>
                        <option value="in">Bulanan</option>
                    </select>
                </div>

                <div class="border-l border-gray-300 h-full"></div>

                <div class="flex items-center space-x-7">
                    <div class="font-bold">Expense</div>
                    <div class="relative text-red-500">
                        <span class="absolute text-black text-xs -top-2 right-16 opacity-50">Rp</span>
                        {{ formatCurrency(totalExpense) }}
                    </div>

                    <select
                        class="border-none outline-none focus:ring-0 focus:border-transparent w-6 h-6"
                        v-model="filters.filter"
                    >
                        <option value="monthly">Bulanan</option>
                        <option value="weekly">Mingguan</option>
                        <option value="">Semua waktu</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-center">
                            <div class="p-6 bg-white rounded-lg shadow-lg mb-10 w-full">
                                <h2
                                    class="text-xl font-semibold mb-4 text-center"
                                >
                                    Sales Chart
                                </h2>
                                <div class="chart-container h-80 w-full">
                                    <LineChart :chart-data="chartData" />
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-row justify-center space-x-36 mb-10">
                            <div class="flex flex-col items-center rounded-3xl shadow-lg mb-5 w-1/3">
                                <h2 class="text-lg font-semibold mb-2 text-center">Pemasukan</h2>
                                <PieChart :pie-chart-data="incomeData" />
                            </div>
                                
                            <div class="flex flex-col items-center rounded-3xl shadow-lg mb-5 w-1/3">
                                <h2 class="text-lg font-semibold mb-2 text-center">Pengeluaran</h2>
                                <PieChart :pie-chart-data="expenseData" />
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
