<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>
        <div
            class="bg-testiary text-white p-4 rounded-[32px] w-100 h-35 ml-60 mt-10"
        >
            <div class="bg-opacity-100">Saldo</div>
        </div>
    </AuthenticatedLayout>
</template>
