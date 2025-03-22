<script setup>
import { router, Head } from "@inertiajs/vue3";
import { computed, ref, watch } from "vue";
import dayjs from "dayjs";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

//Menerima data
const props = defineProps({
    historys: Object,
    categories: Object,
});

//Memformat data agar lebih user friendly
const formattedHistorys = computed(() => {
    return props.historys.data.map((history) => ({
        ...history,
        formattedDate: dayjs(history.updated_at).format("DD-MM-YYYY HH:mm:ss"),
    }));
});

//memformat nominal
const formatCurrency = (value) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(value);
};

//paginate
const goToPage = (url) => {
    if (url) {
        router.get(url, {}, { preserveState: true, preserveScroll: true });
    }
};

//Filter
const filters = ref({
    type: '',
    categories_id: '',
    month: '',
    year: '',
    sort_by: 'created_at',
    sort_order: 'desc',
})

//watch untuk mengirim request otomatis
watch(
    filters,
    (newFilters) => {
        router.get("/transaksi/history", newFilters, {
            preserveState: true,
            preserveScroll: true,
        });
    },
    { deep: true }
);

//variable month
const month = computed(() => {
    const monthNames = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ];
    return monthNames.map((name, index) => ({ value: index + 1, name }));
});

const years = computed(() => {
    const currentYear = new Date().getFullYear();
    return Array.from({ length: 3 }, (_, i) => currentYear - i);
});

//update and delete buttons
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
    if (
        confirm(
            "Yakin ingin menghapus data ini? akan mengubah statistik dan balance"
        )
    ) {
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

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg py-3">
            <div class="py-6">
            <div class="mx-auto max-w-7xl shadow-2xl">

                <!-- Dropdown Sort By -->
        <div class="flex items-center gap-2 mb-2">
            <label class="text-sm font-medium">Sort By:</label>

            <select v-model="filters.sort_by" @change="applySort" class="px-7 py-1 rounded">
                <option value="created_at">Tanggal</option>
                <option value="amount">Nominal</option>
            </select>

            <select v-model="filters.sort_by" @change="applySort" class="px-7 py-1 rounded">
                <option value="created_at">Asc</option>
                <option value="amount">Desc</option>
            </select>

            <button @click="toggleSortOrder" class="px-3 py-1 border rounded bg-gray-200 hover:bg-gray-300">
                {{ filters.sort_order === 'asc' ? 'Asc' : 'Desc' }}
            </button>
        </div>

                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >

            <table class="w-full text-sm text-center text-gray-500">
                <thead class="text-s text-paragraph uppercase bg-headline">
                    <tr class="text-paragraph">
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Tanggal Transaksi</th>
                        <th class="px-6 py-3">Nominal</th>

                                    <th class="px-6 py-3">
                                        <select
                                            v-model="filters.type"
                                            class="rounded-[32px] text-bold text-xs text-paragraph bg-headline border-none outline-none focus:ring-0 focus:border-transparent"
                                        >
                                            <option value="">Tipe (All)</option>
                                            <option value="Income">
                                                Income
                                            </option>
                                            <option value="Expense">
                                                Expense
                                            </option>
                                        </select>
                                    </th>

                                    <th class="px-6 py-3">
                                        <select
                                            v-model="filters.categories_id"
                                            class="rounded-[32px] text-bold text-xs text-paragraph bg-headline border-none outline-none focus:ring-0 focus:border-transparent"
                                        >
                                            <option value="">
                                                Kategori (All)
                                            </option>
                                            <option
                                                v-for="category in categories"
                                                :key="category.id"
                                                :value="category.id"
                                            >
                                                {{ category.name }}
                                            </option>
                                        </select>
                                    </th>

                                    <th class="px-6 py-3">Keterangan</th>
                                    <th class="px-6 py-3">Action</th>
                                </tr>
                            </thead>

                            <tbody class="text-headline">
                                <tr
                                    v-for="history in formattedHistorys"
                                    :key="history.id"
                                    class="border-b border-gray-200 bg-bg"
                                >
                                    <td
                                        class="px-6 py-4 font-medium text-gray-900 bg-black-50"
                                    >
                                        {{ history.id }}
                                    </td>
                                    <td class="px-6 py-4 bg-main">
                                        {{ history.formattedDate }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ formatCurrency(history.amount) }}
                                    </td>
                                    <td
                                        class="px-6 py-4 bg-main"
                                        :class="{
                                            'text-red-800':
                                                history.type === 'Expense',
                                            'text-green-700':
                                                history.type !== 'Expense',
                                        }"
                                    >
                                        {{ history.type }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ history.categories.name }}
                                    </td>
                                    <td class="px-6 py-4 bg-main">
                                        {{ history.description }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
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
                </div>

                <!-- ✅ PAGINATION BUTTONS -->
                <div class="flex justify-center items-center space-x-2 my-4">
                    <button
                        v-for="link in props.historys.links"
                        :key="link.label"
                        @click="goToPage(link.url)"
                        v-html="link.label"
                        class="px-4 py-2 border rounded-md"
                        :class="{
                            'bg-headline text-white': link.active,
                            'text-gray-700 hover:bg-gray-200': !link.active,
                        }"
                        :disabled="!link.url"
                    ></button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
