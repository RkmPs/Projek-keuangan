<script setup>
import { usePage, router } from "@inertiajs/vue3";

const page = usePage();
const admins = page.props.admins; // Ambil data dari Laravel

const deleteAdmin = (id) => {
    if (confirm("Yakin ingin menghapus data ini?")) {
        router.delete(`/admin/${id}`);
    }
};
</script>

<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">Nominal</th>
                    <th class="px-6 py-3">Tipe</th>
                    <th class="px-6 py-3">Kategori</th>
                    <th class="px-6 py-3">Keterangan</th>
                    <th class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="admin in admins"
                    :key="admin.id"
                    class="border-b border-gray-200"
                >
                    <td class="px-6 py-4 font-medium text-gray-900 bg-gray-50">
                        {{ admin.username }}
                    </td>
                    <td class="px-6 py-4">{{ admin.nama_admin }}</td>
                    <td class="px-6 py-4 bg-gray-50">{{ admin.email }}</td>
                    <td class="px-6 py-4">{{ admin.no_telp }}</td>
                    <td class="px-6 py-4 text-center">
                        <a
                            :href="`/admin/${admin.id}/edit`"
                            class="text-blue-500 hover:underline me-2"
                            >EDIT</a
                        >
                        <button
                            @click="deleteAdmin(admin.id)"
                            class="text-red-500 hover:underline"
                        >
                            DELETE
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
