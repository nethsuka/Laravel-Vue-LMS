<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { usePreventDevTools } from '@/Components/DisableDevTools';
usePreventDevTools()
const Arrays = defineProps({
    extraLessons: Array,
});

onMounted(() => {
    console.log(Arrays.extraLessons);
})

const { props } = usePage();

</script>

<template>
    <Head title="Additional Lessons" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Additional Lessons</h2>
                <div>
                    <a href="/more-classes">
                        <button type="button"
                        class="text-white bg-gradient-to-r from-sky-500 to-sky-700 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-4 py-1.5 text-center shadow-lg shadow-sky-500/50 dark:shadow-lg dark:shadow-cyan-800/80 ml-3">
                            Add More Classes
                        </button>
                    </a>
                    <a href="/student-controls" v-if="props.auth.user.role === 'admin'">
                        <button type="button"
                        class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-sm px-4 py-1.5 text-center me-2 mb-2 ml-2">
                            Admin Panel
                        </button>
                    </a>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3">
                    <div class="text-center text-3xl font-semibold text-gray-800 pt-2">
                        Additional Lessons
                    </div>
                    <hr class="h-px my-6 bg-gray-200 border-0 dark:bg-gray-700">
                    <div class="py-3 max-w-full sm:px-6 lg:px-8 overflow-y-auto h-full">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- <div class="bg-gray-300 p-4"> -->
                            <template v-if="Arrays.extraLessons.length !== 0">
                                <template v-for="video in Arrays.extraLessons" :key="video.id">
                                    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                        <div class="p-2" v-html="video.video_link"></div>
                                        <div class="py-1 px-5">
                                            <a href="#">
                                                <p :title="video.video_name" class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white truncate">{{ video.video_name }}</p>
                                            </a>
                                            <p class="mb-3 text-sm text-gray-700 dark:text-gray-400 mt-2">
                                                Expiry Date:  
                                                <span class="bg-gray-100 text-gray-800 text-sm font-medium inline-flex items-center px-2.5 py-0.5 rounded me-2 dark:bg-gray-700 dark:text-gray-400 border border-gray-500 ">
                                                    <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                                                    </svg>
                                                    {{ video.expiry_date }} | Time : 11:59 PM
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </template>
                            </template>
                            <template v-else>
                                <p class="pb-3 pl-3">No videos available for you.</p>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>