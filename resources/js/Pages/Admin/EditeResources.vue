<script setup>
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Layouts/Sidebar.vue';
const Resource = {
    name: '',
    links: [],
    count: 0,
    price: 0,
    category: '',
    
}
</script>
<template>
<Sidebar>
    <Head title="Resource Control Edit"></Head>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" :style="{ overflowY: 'auto', maxHeight: '95vh' }">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3">
                
            </div>
        </div>
    </div>
    </Sidebar>
</template>