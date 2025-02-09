<script setup>
import Sidebar from '@/Layouts/Sidebar.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue'
import {
    FwbTab, FwbTabs, FwbA,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
} from 'flowbite-vue'
const activeTab = ref('first')
</script>
<template>

    <Head title="Student's Classes"></Head>
    <div>
        <Sidebar>
            <div class="py-12">
                <div class="max-w-6xl mx-auto sm:px-6 lg:px-8" :style="{ overflowY: 'auto', maxHeight: '85vh' }">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3 mb-4">
                        <fwb-tabs v-model="activeTab" class="p-5">
                            <fwb-tab name="Acept Payments" title="First">
                                <fwb-table striped>
                                    <fwb-table-head>
                                        <fwb-table-head-cell>Student Name</fwb-table-head-cell>
                                        <fwb-table-head-cell>Email</fwb-table-head-cell>
                                        <fwb-table-head-cell>Joined Classes</fwb-table-head-cell>
                                        <fwb-table-head-cell>Paid Classes</fwb-table-head-cell>
                                        <fwb-table-head-cell>Slip Data</fwb-table-head-cell>
                                        <fwb-table-head-cell>Action</fwb-table-head-cell>
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
                            </fwb-tab>
                            <fwb-tab name="Undo Payments" title="Second">
                                <fwb-table striped>
                                    <fwb-table-head>
                                        <fwb-table-head-cell>Student Name</fwb-table-head-cell>
                                        <fwb-table-head-cell>Email</fwb-table-head-cell>
                                        <fwb-table-head-cell>Joined Classes</fwb-table-head-cell>
                                        <fwb-table-head-cell>Paid Classes</fwb-table-head-cell>
                                        <fwb-table-head-cell>Slip Data</fwb-table-head-cell>
                                        <fwb-table-head-cell>Action</fwb-table-head-cell>
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
                            </fwb-tab>

                        </fwb-tabs>
                    </div>
                </div>
            </div>
        </Sidebar>
    </div>
</template>