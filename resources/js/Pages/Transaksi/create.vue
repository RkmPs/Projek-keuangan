<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
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

        <div class="py-16">
            <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-3xl">
                    <div class="p-6 text-gray-900">
                        <h1 class="py-6 px-10 text-xl font-semibold">
                            Transaksi
                        </h1>

                        <form
                            @submit.prevent="submit"
                            class="max-w-4xl mx-auto"
                        >
                            <div class="mb-5">
                                <InputLabel for="nominal" value="Nominal" />

                                <TextInput
                                    id="nominal"
                                    type="text"
                                    class="bg-gray-50 border mt-1 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:placeholder-gray-400 dark:text-headline dark:focus:ring-headline dark:focus:border-headline transition-all focus:text-white focus:bg-headline"
                                    v-model="form.amount"
                                    placeholder="Masukan Nominal"
                                    autofocus
                                    autocomplete="name"
                                />

                                <InputError :message="form.errors.amount" />
                            </div>

                            <div>
                                <div
                                    class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4"
                                >
                                    <div>
                                        <InputLabel for="tipe" value="Tipe" />

                                        <select
                                            id="tipe"
                                            v-model="form.type"
                                            class="bg-gray-50 border mt-1 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:placeholder-gray-400 dark:text-headline dark:focus:ring-headline dark:focus:border-headline transition-all focus:text-white focus:bg-headline"
                                        >
                                            <option value="">
                                                Pilih Kategori
                                            </option>
                                            <option value="Income">
                                                Pemasukan
                                            </option>
                                            <option value="Expense">
                                                Pengeluaran
                                            </option>
                                        </select>

                                        <InputError
                                            class="mb-4"
                                            :message="form.errors.type"
                                        />
                                    </div>

                                    <div class="flex flex-col gap-1">
                                        <InputLabel
                                            for="Kategori"
                                            value="Kategori"
                                        />

                                        <select
                                            id="Kategori"
                                            v-model="form.categories_id"
                                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:placeholder-gray-400 dark:text-headline dark:focus:ring-headline dark:focus:border-headline transition-all focus:bg-headline focus:text-white"
                                            onanimationend="this.classList.remove('animate-ping')"
                                        >
                                            <option value="">
                                                Pilih Kategori
                                            </option>
                                            <option
                                                v-for="k in kategori"
                                                :key="k.id"
                                                :value="k.id"
                                            >
                                                {{ k.name }}
                                            </option>
                                        </select>

                                        <div class="flex items-center justify-between">
                                            <a
                                                href="/kategori"
                                                class="text-headline text-lg flex items-center rounded-lg "
                                            >
                                                <span class="w-6 text-center ">+</span>
                                            </a>
                                        </div>

                                        <InputError
                                            class="mb-4"
                                            :message="form.errors.categories_id"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div>
                                <InputLabel
                                    for="Keterangan"
                                    value="Keterangan"
                                />

                                <TextInput
                                    id="Keterangan"
                                    type="text"
                                    class="bg-gray-50 border mt-1 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:placeholder-gray-400 dark:text-headline dark:focus:ring-headline dark:focus:border-headline transition-all focus:text-white focus:bg-headline"
                                    v-model="form.description"
                                    placeholder="Deskripsi Transaksi"
                                    autocomplete="name"
                                />

                                <InputError
                                    class="mb-4"
                                    :message="form.errors.description"
                                />
                            </div>
                            <div class="w-full flex justify-end py-3">
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
        </div>
    </AuthenticatedLayout>
</template>
