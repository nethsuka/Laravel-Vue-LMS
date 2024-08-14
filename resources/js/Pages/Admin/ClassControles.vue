<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

</script>

<template>
    <Head title="Admin Panel" />

    <AdminAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Panel</h2>
        </template>

        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3">
                    <!-- jjj -->
                </div>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>