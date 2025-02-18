<script setup>
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { Head, Link, useForm, router } from "@inertiajs/vue3";
    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
    import { watchEffect } from 'vue';

    const props = defineProps({
                categories: Object,
            })

    const form = useForm({
        id: props.categories?.id || '',
        name: props.categories?.name || '',
        type: props.categories?.type || '', 
    });


    watchEffect(() => {
    if (props.categories) {
        form.id = props.categories.id;
        form.amount = props.categories.name;
        form.type = props.categories.type;
    }});

    console.log(form);

    const submit = () => {
        form.put(route('kategori.update', {id: form.id}));
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

       
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
    
                    <form @submit.prevent="submit" class="max-w-3xl mx-auto">


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
    </AuthenticatedLayout>
    </template>