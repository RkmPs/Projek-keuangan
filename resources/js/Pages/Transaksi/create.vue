<script></script>
<template>
    <div class="flex items-center justify-center h-screen">
        <div
            class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700"
        >
            <form class="max-w-sm mx-auto">
                <div class="mb-5">
                    <label
                        for="large-input"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Nominal</label
                    >
                    <input
                        type="text"
                        id="large-input"
                        class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    />
                </div>

                <label
                    for="countries_disabled"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Tipe</label
                >
                <select
                    id="countries_disabled"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                >
                    <option selected>Select</option>
                    <option value="Pemasukan">Pemasukan</option>
                    <option value="Pengeluaran">Pengeluaran</option>
                </select>

                <div>
                    <label for="kategori_id">Kategori</label>
                    <select v-model="sparepart.kategori_id" id="kategori_id">
                        <option value="">Pilih Kategori</option>
                        <option v-for="k in kategori" :key="k.id" :value="k.id">
                            {{ k.nama_kategori }}
                        </option>
                    </select>
                    <span v-if="errors.kategori_id">{{
                        errors.kategori_id
                    }}</span>
                </div>

                <div>
                    <label
                        for="small-input"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Keterangan</label
                    >
                    <input
                        type="text"
                        id="small-input"
                        class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    />
                </div>
            </form>
        </div>
    </div>
</template>
