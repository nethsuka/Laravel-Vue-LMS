<script setup>
import Sidebar from '@/Layouts/Sidebar.vue';
import { Head } from '@inertiajs/vue3';
import {
    FwbHeading, FwbA,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
    FwbInput
} from 'flowbite-vue'
</script>
<template>
    <Head title="Student's Classes"></Head>
    <div>
        <Sidebar>
            <div class="py-12">
                <div class="max-w-6xl mx-auto sm:px-6 lg:px-8" :style="{ overflowY: 'auto', maxHeight: '85vh' }">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3 mb-4">
                        <fwb-heading tag="h2">Extra Classes</fwb-heading>
                        <fwb-input v-model="name" label="Search" placeholder="enter your search query" style="widows: 50%;">
                            <template #prefix>
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </template>
                        </fwb-input>
                        <fwb-table striped>
                            <fwb-table-head>
                                <fwb-table-head-cell>Name</fwb-table-head-cell>
                                <fwb-table-head-cell>Email</fwb-table-head-cell>
                                <fwb-table-head-cell>Video name</fwb-table-head-cell>
                                <fwb-table-head-cell>URL</fwb-table-head-cell>
                                <fwb-table-head-cell>Expire Date</fwb-table-head-cell>
                            </fwb-table-head>
                            <fwb-table-body>
                                <fwb-table-row>
                                    <fwb-table-cell>Apple MacBook Pro 17"</fwb-table-cell>
                                    <fwb-table-cell>Sliver</fwb-table-cell>
                                    <fwb-table-cell>Laptop</fwb-table-cell>
                                    <fwb-table-cell>$2999</fwb-table-cell>
                                    <fwb-table-cell>
                                        <fwb-a href="#">
                                            Edit
                                        </fwb-a>
                                    </fwb-table-cell>
                                </fwb-table-row>
                                <fwb-table-row>
                                    <fwb-table-cell>Microsoft Surface Pro</fwb-table-cell>
                                    <fwb-table-cell>White</fwb-table-cell>
                                    <fwb-table-cell>Laptop PC</fwb-table-cell>
                                    <fwb-table-cell>$1999</fwb-table-cell>
                                    <fwb-table-cell>
                                        <fwb-a href="#">
                                            Edit
                                        </fwb-a>
                                    </fwb-table-cell>
                                </fwb-table-row>
                                <fwb-table-row>
                                    <fwb-table-cell>Magic Mouse 2</fwb-table-cell>
                                    <fwb-table-cell>Black</fwb-table-cell>
                                    <fwb-table-cell>Accessories</fwb-table-cell>
                                    <fwb-table-cell>$99</fwb-table-cell>
                                    <fwb-table-cell>
                                        <fwb-a href="#">
                                            Edit
                                        </fwb-a>
                                    </fwb-table-cell>
                                </fwb-table-row>
                            </fwb-table-body>
                        </fwb-table>
                    </div>
                </div>
            </div>
        </Sidebar>
    </div>
</template>