<script></script>

<template>
    <div class="bg-main">
        <div class="flex items-center justify-center h-screen">
            <div
                class="w-full max-w-sm p-4 bg-testiary border border-testiary rounded-lg shadow sm:p-6 md:p-8 dark:bg- dark:testiary"
            >
                <form class="max-w-sm mx-auto">
                    <div class="mb-5">
                        <label
                            for="large-input"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Nominal</label
                        >
                        <input
                            placeholder="Masukan Nominal"
                            type="text"
                            id="large-input"
                            class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:placeholder-gray-400 dark:text-headline dark:focus:ring-head dark:focus:border-headline"
                        />
                    </div>

                    <label
                        for="tipe"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Tipe</label
                    >
                    <select
                        id="tipe"
                        class="bg-gray-50 mb-4 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:placeholder-gray-400 dark:text-headline dark:focus:ring-headline dark:focus:border-headline transition-all focus:bg-blue-100"
                    >
                        <option value="Pemasukan">Pemasukan</option>
                        <option value="Pengeluaran">Pengeluaran</option>
                    </select>

                    <form class="max-w-sm mx-auto">
                        <label
                            for="kategori"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Kategori</label
                        >
                        <select
                            id="kategori"
                            class="bg-white mb-4 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:placeholder-gray-400 dark:text-headline dark:focus:ring-headline dark:focus:border-headline transition-all focus:bg-headline focus:text-white"
                            onanimationend="this.classList.remove('animate-ping')"
                        >
                            <option value="Premier">Premier</option>
                            <option value="Sekunder">Sekunder</option>
                            <option value="Tersier">Tersier</option>
                        </select>
                    </form>

                    <div>
                        <label
                            for="Keterangan"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Keterangan</label
                        >
                        <input
                            placeholder="Masukan Keterangan"
                            type="text"
                            id="Keterangan"
                            class="bg-white mb-4 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:placeholder-gray-400 dark:text-headline dark:focus:ring-headline dark:focus:border-headline transition-all focus:bg-headline focus:text-white"
                        />
                    </div>
                    <div class="w-full flex justify-end">
                        <button
                            type="submit"
                            class="bg-white text-headline px-4 py-2 rounded-lg hover:bg-headline hover:text-white"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
