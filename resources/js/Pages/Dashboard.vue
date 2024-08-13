<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const activeTab = ref('profile');

function setActiveTab(tab) {
  activeTab.value = tab;
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3">
                    <!-- <div class="p-6 text-gray-900">You're logged in!</div> -->
                    <!-- <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p> -->

                    <div class="md:flex">
                        <ul class="flex-column space-y space-y-4 text-sm font-medium text-gray-500 dark:text-gray-400 md:me-4 mb-4 md:mb-0">
                        <li>
                            <a
                            href="#"
                            class="inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white"
                            :class="{ 'back-color': activeTab === 'profile', 'dark:bg-blue-600': activeTab === 'profile' }"
                            @click.prevent="setActiveTab('profile')"
                            aria-current="page"
                            >
                            2023&nbsp;A/L
                            </a>
                        </li>
                        <li>
                            <a
                            href="#"
                            class="inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white"
                            :class="{ 'back-color': activeTab === 'dashboard', 'dark:bg-gray-800': activeTab === 'dashboard' }"
                            @click.prevent="setActiveTab('dashboard')"
                            >
                            2024&nbsp;A/L
                            </a>
                        </li>
                        <li>
                            <a
                            href="#"
                            class="inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white"
                            :class="{ 'back-color': activeTab === 'settings', 'dark:bg-gray-800': activeTab === 'settings' }"
                            @click.prevent="setActiveTab('settings')"
                            >
                            2025&nbsp;A/L
                            </a>
                        </li>
                        <li>
                            <a
                            href="#"
                            class="inline-flex items-center px-4 py-3 text-gray-400 rounded-lg cursor-not-allowed bg-gray-50 w-full dark:bg-gray-800 dark:text-gray-500"
                            :class="{ 'back-color': activeTab === 'disabled', 'dark:bg-gray-800': activeTab === 'disabled' }"
                            >
                            Disabled
                            </a>
                        </li>
                        </ul>

                        <div class="p-6 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full">
                        <template v-if="activeTab === 'profile'">

                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">2023 A/L Class</h3>
                            <!-- <p class="mb-2">This is some placeholder content for the Profile tab's associated content. Clicking another tab will toggle the visibility of this one.</p>
                            <p>The tab JavaScript swaps classes to control the content visibility and styling.</p> -->
                            <div class="mt-5 mb-10">
                            <a href="#" class="text-white bg-gradient-to-r from-pink-400 via-pink-500 to-pink-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-pink-300 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                Join Online Class
                            </a>
                            <a href="#" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                Telegram Group
                            </a>
                        </div>

                        <div class="pb-9">
                            <h6 class="pb-1"><b>Papers</b></h6>
                            <hr class="pb-3">
                            <a href="#" class="block max-w-sm p-3 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                            <!-- <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5> -->
                            <p class="font-normal text-gray-700 dark:text-gray-400">My_file.pdf</p>
                            </a>
                        </div>


                        <h6 class="pb-1"><b>Recordings</b></h6>
                        <hr class="pb-3">
                        <iframe src="https://player.vimeo.com/video/910151320?h=2dbfbb67e8" width="640" height="360" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>

                        </template>
                        <template v-if="activeTab === 'dashboard'">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Dashboard Tab</h3>
                            <p class="mb-2">This is some placeholder content for the Dashboard tab's associated content.</p>
                        </template>
                        <template v-if="activeTab === 'settings'">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Settings Tab</h3>
                            <p class="mb-2">This is some placeholder content for the Settings tab's associated content.</p>
                        </template>
                        <template v-if="activeTab === 'contact'">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Contact Tab</h3>
                            <p class="mb-2">This is some placeholder content for the Contact tab's associated content.</p>
                        </template>
                        </div>
                    </div>
                                        

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.back-color { 
    background-color: #2f7dd1; 
    color: white;
}
</style>
