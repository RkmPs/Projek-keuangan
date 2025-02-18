<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
    transaksi: Object,
    balance: Object,
    totalIncome: Object,
    totalExpense: Object,
    weekly: Object,
    montly: Object,
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>
        <div class="flex justify-center h-screen">

            <div class="flex space-x-24 shadow-lg bg-white text-headline p-4 rounded-[32px] w-2/3 h-14 mt-10">
            <div class="ml-8 font-bold">Saldo</div>
            <div>1000</div>
            
            <div class="border-l border-gray-300 h-full"></div>

            <div class="flex items-center space-x-6">
                <div class="font-bold">Income</div>
                <div class="text-green-500">2000</div>
                <select class="border-none outline-none focus:ring-0 focus:border-transparent w-6 h-6">

                    <option value="all">Mingguan</option>
                    <option value="in">Bulanan</option>
                    
                </select>
            </div>
        
            <div class="border-l border-gray-300 h-full"></div>

            <div class="flex items-center space-x-6">
                <div class="font-bold">Expense</div>
                <div class="text-red-500">1000</div>
                <select class="border-none outline-none focus:ring-0 focus:border-transparent w-6 h-6">

                    <option value="all">Mingguan</option>
                    <option value="in">Bulanan</option>

                </select>

            </div>

        </div>
    </div>

    </AuthenticatedLayout>
</template>
