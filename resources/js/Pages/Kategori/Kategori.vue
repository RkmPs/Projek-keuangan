<script setup>
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { Head, Link, useForm, router } from "@inertiajs/vue3";
    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

    defineProps({
        categories: Object,
    });

    const form = useForm({
        name: "",
        type: "",
    });

    console.log(form);

    const submit = () => {
        form.post(route("kategori.store"));
    };

    const update = (id) => {
            router.get(`/kategori/${id}/edit`);
        
    };

    const destroy = (id) => {
        if (confirm("Yakin ingin menghapus data ini?")) {
            router.delete(`/kategori/${id}`);
        }
    };
</script>

<template>
    <Head title="Kategori" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Kategori
            </h2>
        </template>

        <div class="py-16">
            <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-3xl"
                >
                    <div class="p-6 text-gray-900">

                        <h1 class="py-4 px-8 text-xl font-semibold"> Kategori </h1>
    
                    <form @submit.prevent="submit" class="max-w-4xl mx-auto">


                        <div class="py-3">
                                <InputLabel for="tipe" value="Tipe" />

                                <select
                                    id="tipe"
                                   v-model="form.type"
                                    class="bg-gray-50 border mt-1 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:placeholder-gray-400 dark:text-headline dark:focus:ring-headline dark:focus:border-headline transition-all focus:text-white focus:bg-headline"
                                    >
                                    <option value="">Pilih Kategori</option>
                                    <option value="Income">Pemasukan</option>
                                    <option value="Expense">Pengeluaran</option>
                                </select>

                                 <InputError class="mb-4" :message="form.errors.type" />

                        </div>
                        
                        <div>
                            <InputLabel for="Name" value="Nama Kategori" />

                            <TextInput
                                id="Name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                placeholder="Nama Kategori"
                                autofocus
                                autocomplete="name"
                            />
    
                            <InputError class="mb-4" :message="form.errors.name" />
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

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Nama Kategori
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Jenis Kategori
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr  v-for="category in categories" :key="category.id" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                <td class="px-6 py-4">
                                    {{ category.name }}
                                </td>
                                
                                <td class="px-6 py-4">
                                    {{ category.type }}
                                </td>

                                <td class="text-center">
                                    <button
                                        @click="update(category.id)"
                                        class="text-blue-600 hover:underline me-2"
                                    >
                                        EDIT
                                    </button>
                                    <button
                                        @click="destroy(category.id)"
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
            </div>
        </div>

    </AuthenticatedLayout>
</template>