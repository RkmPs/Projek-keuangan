<script setup>
import { router, Head } from "@inertiajs/vue3";
import { computed, ref, watch } from "vue";
import dayjs from "dayjs";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

//Menerima data
const props = defineProps({
    historys: Object,
    categories:  {
        type: Array,
        required: true,
        default: () => []
    },
    years: Array,
});

//Memformat data agar lebih user friendly
const formattedHistorys = computed(() => {
    return props.historys.data.map((history) => ({
        ...history,
        formattedDate: dayjs(history.created_at).format("DD-MM-YYYY HH:mm:ss"),
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

const filteredKategori = computed(() => {
    if(!filters.value.type){ return props.categories}
    return props.categories.filter(item => item.type === filters.value.type)
})

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

                <div class="flex items-center justify-between gap-4 mb-4">
    <!-- Bagian Kiri (Sort) -->
    <div class="flex items-center gap-4">
        <div class="flex items-center gap-2">
            <label class="text-sm font-medium text-gray-700">Sort By:</label>
            <select 
                v-model="filters.sort_by" 
                @change="applySort"
                class="pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
            >
                <option value="created_at">Tanggal</option>
                <option value="amount">Nominal</option>
            </select>
        </div>

        <div class="flex items-center gap-2">
            <label class="text-sm font-medium text-gray-700">Order:</label>
            <select 
                v-model="filters.sort_order" 
                @change="applySort"
                class="pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
            >
                <option value="asc">Asc</option>
                <option value="desc">Desc</option>
            </select>
        </div>
    </div>

    <!-- Bagian Kanan (Filter Tahun & Bulan) -->
    <div class="flex items-center gap-4">
        <div class="flex-1 min-w-[150px]">
            <select 
                v-model="filters.year"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
            >
                <option value="">Semua Tahun</option>
                <option 
                    v-for="year in years" 
                    :key="year"
                    :value="year"
                >
                    {{ year }}
                </option>
            </select>
        </div>

        <div class="flex-1 min-w-[150px]">
            <select 
                v-model="filters.month"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
            >
                <option value="">Semua Bulan</option>
                <option 
                    v-for="item in month" 
                    :key="item.value"
                    :value="item.value"
                >
                    {{ item.name }}
                </option>
            </select>
        </div>
    </div>
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
                                                v-if="filteredKategori.length"
                                                v-for="k in filteredKategori"
                                                :key="k.id"
                                                :value="k.id"
                                            >
                                                {{ k.name }}
                                            </option>
                                            <option v-else disabled value="">
                                                {{ filters.type ? 'Tambah kategori dengan tombol + dibawah' : 'Pilih tipe terlebih dahulu' }}
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
