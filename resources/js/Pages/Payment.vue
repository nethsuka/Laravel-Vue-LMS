<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const activeTab = ref('profile');

const setActiveTab = (tab) => {
  activeTab.value = tab;
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Payments</h2>
                <a href="/admin">
                    <button type="button" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-4 py-1.5 text-center">Admin Panel</button>
                </a>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3">

                    <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
                        <li class="me-2">
                            <a href="#" @click.prevent="setActiveTab('profile')" :class="{ 'text-blue-600 bg-gray-100 active dark:bg-gray-800 dark:text-blue-500': activeTab === 'profile' }" class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Profile</a>
                        </li>
                        <li class="me-2">
                            <a href="#" @click.prevent="setActiveTab('dashboard')" :class="{ 'text-blue-600 bg-gray-100 active dark:bg-gray-800 dark:text-blue-500': activeTab === 'dashboard' }" class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Dashboard</a>
                        </li>
                        <li class="me-2">
                            <a href="#" @click.prevent="setActiveTab('settings')" :class="{ 'text-blue-600 bg-gray-100 active dark:bg-gray-800 dark:text-blue-500': activeTab === 'settings' }" class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Settings</a>
                        </li>
                        <li class="me-2">
                            <a href="#" @click.prevent="setActiveTab('contacts')" :class="{ 'text-blue-600 bg-gray-100 active dark:bg-gray-800 dark:text-blue-500': activeTab === 'contacts' }" class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Contacts</a>
                        </li>
                        <li>
                            <a class="inline-block p-4 text-gray-400 rounded-t-lg cursor-not-allowed dark:text-gray-500">Disabled</a>
                        </li>
                    </ul>

                    <div class="p-6 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full">
                        <template v-if="activeTab === 'profile'">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Profile Tab</h3>
                            <p>This is some placeholder content for the Profile tab's associated content.</p>
                            <form class="max-w-sm mx-auto">
                            <div class="mb-5">
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                                <input type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@flowbite.com" required />
                            </div>
                            <div class="mb-5">
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
                                <input type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                            </div>
                            <div class="flex items-start mb-5">
                                <div class="flex items-center h-5">
                                <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" required />
                                </div>
                                <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
                            </div>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                            </form>

                        </template>
                        <template v-if="activeTab === 'dashboard'">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Dashboard Tab</h3>
                            <p>This is some placeholder content for the Dashboard tab's associated content.</p>
                        </template>
                        <template v-if="activeTab === 'settings'">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Settings Tab</h3>
                            <p>This is some placeholder content for the Settings tab's associated content.</p>
                        </template>
                        <template v-if="activeTab === 'contacts'">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Contacts Tab</h3>
                            <p>This is some placeholder content for the Contacts tab's associated content.</p>
                        </template>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>