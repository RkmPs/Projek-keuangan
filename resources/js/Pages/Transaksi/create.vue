<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    kategori: Object,
});

const form = useForm({
    amount: "",
    type: "",
    categories_id: "",
    description: "",
});

console.log(form);

const submit = () => {
    form.post(route("transaksi.store"));
};
</script>

<template>
    <Head title="Create" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Transaksi
            </h2>
        </template>

        <div class="bg-main">
            <div class="flex items-center justify-center h-screen">
                <div
                    class="w-full max-w-sm p-4 bg-testiary border border-testiary rounded-lg shadow sm:p-6 md:p-8 dark:bg- dark:testiary"
                >
                    <form @submit.prevent="submit" class="max-w-sm mx-auto">
                        <div class="mb-5">
                            <label
                                for="large-input"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white transition-all focus:text-white focus:bg-headline"
                                >Nominal</label
                            >
                            <input
                                placeholder="Masukan Nominal"
                                type="text"
                                v-model="form.amount"
                                id="large-input"
                                class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:placeholder-gray-400 dark:text-headline dark:focus:ring-head dark:focus:border-headline transition-all focus:text-white focus:bg-headline"
                            />
                        </div>

                        <label
                            for="tipe"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Tipe</label
                        >
                        <select
                            id="tipe"
                            v-model="form.type"
                            class="bg-gray-50 mb-4 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:placeholder-gray-400 dark:text-headline dark:focus:ring-headline dark:focus:border-headline transition-all focus:text-white focus:bg-headline"
                        >
                            <option value="">Pilih Kategori</option>
                            <option value="Income">Pemasukan</option>
                            <option value="Expense">Pengeluaran</option>
                        </select>

                        <label
                            for="kategori"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Kategori</label
                        >
                        <select
                            id="kategori"
                            v-model="form.categories_id"
                            class="bg-white mb-4 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:placeholder-gray-400 dark:text-headline dark:focus:ring-headline dark:focus:border-headline transition-all focus:bg-headline focus:text-white"
                            onanimationend="this.classList.remove('animate-ping')"
                        >
                            <option value="">Pilih Kategori</option>
                            <option
                                v-for="k in kategori"
                                :key="k.id"
                                :value="k.id"
                            >
                                {{ k.name }}
                            </option>
                        </select>

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
                                v-model="form.description"
                                class="bg-white mb-4 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:placeholder-gray-400 dark:text-headline dark:focus:ring-headline dark:focus:border-headline transition-all focus:bg-headline focus:text-white"
                            />
                        </div>
                        <div class="w-full flex justify-end">
                            <button
                                type="submit"
                                class="bg-white text-headline px-4 py-2 rounded-lg duration-500 hover:bg-headline hover:text-white"
                            >
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
