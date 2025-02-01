<script setup>
import Sidebar from '@/Layouts/Sidebar.vue';
import { Head} from '@inertiajs/vue3';

</script>

<template>
    <Head title="Resource Control Panel"></Head>
        <div>
            <Sidebar>
                <div class="py-12" >
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" :style="{ overflowY: 'auto', maxHeight: '95vh' }">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3">
                            <div>
                                Resources Page
                                <br>
                                    <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">+</button>
                                <br>
                            </div>
    
                        </div>
                    </div>
                </div>
            </Sidebar>
        </div> 
</template>