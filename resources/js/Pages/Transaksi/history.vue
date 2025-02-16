<script setup>
import { router, Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    historys: Object,
});

const updateHistory = (id) => {
    if (
        confirm(
            "Mengupdate history transaksi dapat mengubah statistik dan balance"
        )
    ) {
        router.get(`/transaksi/${id}/edit`);
    }
};

const deleteHistory = (id) => {
    if (confirm("Yakin ingin menghapus data ini?")) {
        router.delete(`/transaksi/${id}`);
    }
};
</script>

<template>
    <Head title="Aktivitas" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Aktivitas
            </h2>
        </template>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-testiary">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Nominal</th>
                        <th class="px-6 py-3">
                            <select
                                v-model="sortOrder"
                                class="rounded-[32px] text-bold text-xs text-gray-700 uppercase bg-testiary border-none outline-none focus:ring-0 focus:border-transparent"
                            >
                                <option value="all">Tipe</option>
                                <option value="in">Income</option>
                                <option value="out">Expense</option>
                            </select>
                        </th>

                        <th class="px-6 py-3">
                            <select
                                v-model="sortOrder"
                                class="rounded-[32px] text-bold text-xs text-gray-700 uppercase bg-testiary border-none outline-none focus:ring-0 focus:border-transparent"
                            >
                                <option value="all">Kategori</option>
                                <option value="in">Income</option>
                                <option value="out">Expense</option>
                            </select>
                        </th>
                        <th class="px-6 py-3">Keterangan</th>
                        <th class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="history in historys"
                        :key="history.id"
                        class="border-b border-gray-200 bg-bg"
                    >
                        <td
                            class="px-6 py-4 font-medium text-gray-900 bg-black-50"
                        >
                            {{ history.id }}
                        </td>
                        <td class="px-6 py-4 bg-main">{{ history.amount }}</td>
                        <td class="px-6 py-4">{{ history.type }}</td>
                        <td class="px-6 py-4 bg-main">
                            {{ history.categories.name }}
                        </td>
                        <td class="px-6 py-4">{{ history.description }}</td>
                        <td class="px-6 py-4 text-center bg-main">
                            <button
                                @click="updateHistory(history.id)"
                                class="text-headline hover:underline me-2"
                            >
                                EDIT
                            </button>
                            <button
                                @click="deleteHistory(history.id)"
                                class="text-red-500 hover:underline"
                            >
                                DELETE
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>
