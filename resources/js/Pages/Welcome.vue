<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <section class="py-56 bg-main">
        <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16">
            <h1
                class="mb-4 text-4xl font-bold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-headline"
            >
                Selamat Datang
            </h1>
            <p
                class="mb-8 text-lg font-normal text-white lg:text-xl sm:px-16 lg:px-48 dark:text-white"
            >
                Manajeman Keuangan
            </p>
            <div
                class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0"
            >
                <Link
                    href="/register"
                    class="py-3 px-5 sm:ms-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg transition duration-500 hover:bg-gray-100 hover:text-blue-700 dark:bg-testiary dark:headline dark:hover:text-testiary dark:hover:bg-headline"
                >
                    Sign Up
                </Link>

                <Link
                    href="/login"
                    class="py-3 px-5 sm:ms-4 text-sm font-medium text-testiary focus:outline-none bg-white rounded-lg transition duration-500 border border-gray-200 hover:bg-gray-100 hover:text-blue-700 dark:bg-headline dark:text-testiary dark:border-gray-600 dark:hover:border-testiary dark:hover:text-headline dark:hover:bg-testiary"
                >
                    Log In
                </Link>
            </div>
        </div>
    </section>
</template>
