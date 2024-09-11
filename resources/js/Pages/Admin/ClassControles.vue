<script setup>
import Sidebar from '@/Layouts/Sidebar.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { FwbTab, FwbTabs } from 'flowbite-vue'
import { ref } from 'vue'

const activeTab = ref('2025 Theory')

</script>

<template>
    <Head title="Admin Panel" />

        <Sidebar>
        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8" :style="{ overflowY: 'auto', maxHeight: '85vh' }">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3">
                    <!-- content -->
                    <button type="button" class="float-end focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 mt-5">+ Add Class</button><br><br>
                    <fwb-tabs v-model="activeTab" class="p-5">
                        <fwb-tab name="2025 Theory" title="2025 Theory">
                            
                            <form class="max-w-lg mx-auto mt-6">
                            <div class="mb-5 flex items-center">
                                <label for="l1" class="text-sm font-medium text-gray-900 dark:text-white mr-3 whitespace-nowrap">Class Name</label>
                                <input type="email" id="l1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 flex-grow" placeholder="2025 Theory" required />
                            </div>
                            <div class="mb-5 flex items-center">
                                <label for="l2" class="text-sm font-medium text-gray-900 dark:text-white mr-3 whitespace-nowrap">Zoom Link</label>
                                <textarea id="l2" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter your content here..."></textarea>
                            </div>
                            <div class="mb-5 flex items-center">
                                <label for="l3" class="text-sm font-medium text-gray-900 dark:text-white mr-3 whitespace-nowrap">Telegram Link</label>
                                <textarea id="l3" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter your content here..."></textarea>
                            </div>
                            <div class="mb-5 flex items-center">
                                <label for="l3" class="text-sm font-medium text-gray-900 dark:text-white mr-8 whitespace-nowrap">Tutes : </label>
                                <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                                    </svg>
                                    <span>&nbsp;Add Tute</span>
                                </button>
                            </div>
                            <div class="mb-5 flex items-center">
                                <label for="l3" class="text-sm font-medium text-gray-900 dark:text-white mr-8 whitespace-nowrap">Video : </label>
                                <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                                    </svg>
                                    <span>&nbsp;Add Video</span>
                                </button>
                            </div>
                            <button type="submit" class="text-white float-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                            </form>

                        </fwb-tab>
                        <fwb-tab name="2025 Paper" title="2025 Paper">
                            Lorem ipsum dolor... 2
                        </fwb-tab>
                        <fwb-tab name="2026 Theory" title="2026 Theory">
                            Lorem ipsum dolor... 3
                        </fwb-tab>
                        <fwb-tab name="fourth" title="Fourth" disabled>
                            Lorem ipsum dolor... 4
                        </fwb-tab>
                    </fwb-tabs>
                </div>
            </div>
        </div>
        </Sidebar>
</template>