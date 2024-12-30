<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
    FwbAccordion,
    FwbAccordionContent,
    FwbAccordionHeader,
    FwbAccordionPanel,
    FwbButton,
    FwbTab,
    FwbTabs,
    FwbHeading,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
    FwbP,
    FwbInput,
    FwbAlert
} from 'flowbite-vue';


const showarray = ref([]);
const query = ref('');
const activebutton = ref('unit');

const objectarray = ref([
    { name: 'Unit 1: Atomic Structure', price: 3000, buy: true, isunit: true },
    { name: 'Unit 2: Structure and Bonding', price: 4000, buy: false, isunit: true },
    { name: 'Unit 3: Chemical Calculations', price: 3000, buy: true, isunit: true },
    { name: 'Unit 4: Gaseous State of Matter', price: 6000, buy: false, isunit: true },
    { name: '2003, 2004, 2005', price: 3000, buy: true, isunit: false },
    { name: 'Unit 5: Energetics', price: 3000, buy: false, isunit: true },
    { name: 'Unit 6: Inorganic chemistry - s-block', price: 2500, buy: true, isunit: true },
    { name: 'Unit 6: Inorganic chemistry - p-block', price: 7000, buy: true, isunit: true },
    { name: 'Unit 6: Inorganic chemistry - d-block + lon analysis', price: 4500, buy: true, isunit: true },
    { name: 'Unit 6: Question Discussion', price: 5500, buy: true, isunit: true },
    { name: 'Unit 7-10: Organic chemistry - unit 7 & 8', price: 6500, buy: true, isunit: true },
    { name: 'Unit 7-10: Organic chemistry - unit 9 & 10', price: 6500, buy: true, isunit: true },
    { name: 'Unit 7-10: Question + Conversion Practice', price: 6500, buy: true, isunit: true },
    { name: '2006, 2007, 2008', price: 3000, buy: true, isunit: false },
    { name: 'Unit 11: Chemical Kinetics', price: 6000, buy: true, isunit: true },
    { name: 'Unit 12: Chemical Equilibrium - Kp & Kc', price: 6500, buy: true, isunit: true },
    { name: 'Unit 12: Chemical Equilibrium - Icon Equilibrium & Buffers', price: 6500, buy: true, isunit: true },
    { name: 'Unit 12: Chemical Equilibrium - Ksp', price: 5500, buy: true, isunit: true },
    { name: '2009, 2010, 2011', price: 3000, buy: true, isunit: false },
    { name: 'Unit 12: Chemical Equilibrium - Phase Equilibrium', price: 5500, buy: true, isunit: true },
    { name: '2012, 2013, 2014', price: 3000, buy: false, isunit: false },
    { name: 'Unit 13: Electrochemistry', price: 1000, buy: true, isunit: true },
    { name: '2015, 2016, 2017', price: 3000, buy: true, isunit: false },
    { name: 'Unit 14 - Industry & polymers', price: 1000, buy: true, isunit: true },
    { name: 'Unit 14 - Plant based products & environmental pollution', price: 1000, buy: true, isunit: true },
])


function getkey(evt) {
    showarray.value = [];
    if (query.value.length > 0) {
        for (const y of objectarray.value) {
            if (y.name.toLowerCase().includes(query.value.toLowerCase())) {
                showarray.value.push(y);
            }
        }
    }
}

</script>

<template>

    <Head title="Resources" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Resources</h2>
                <div>
                    <a href="/more-classes">
                        <button type="button"
                            class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-4 py-1.5 text-center shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80">
                            Add More Classes
                        </button>
                    </a>
                    <a href="/class-controls">
                        <button type="button"
                            class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-4 py-1.5 text-center ml-3">
                            Admin Panel
                        </button>
                    </a>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3">
                    <div class="flex justify-center ">
                        <div class="inline-flex rounded-md shadow-sm" role="group">
                            <button type="button" @click="activebutton = 'unit'"
                                class="px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-s-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                                Unite base lessons
                            </button>
                            <button type="button" @click="activebutton = 'paper'"
                                class="px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border-t border-b border-gray-900 hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                                Past papers
                            </button>
                            <button type="button"
                                class="px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-e-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                                My Resources
                            </button>
                        </div>
                    </div>

                    <hr class="h-px my-6 bg-gray-200 border-2 dark:bg-gray-700">
                    <div v-if="activebutton === 'unit'" style="overflow-x: auto; max-height: 73vh;">
                        <div class="input-border max-w-md mx-auto">

                            <fwb-input v-on:input="getkey" class="max-w-md mx-auto" v-model="query" label="Search"
                                placeholder="Find unit based lessons" size="lg">
                                <template #prefix>
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </template>
                                <template #suffix>
                                    <fwb-button>Search</fwb-button>
                                </template>
                            </fwb-input>
                        </div>
                        <hr class="h-px my-6 bg-gray-200 border-2 dark:bg-gray-700">
                        <fwb-table striped style="margin-top: 20px;">
                            <fwb-table-body>
                                <template v-if="query.length > 0">
                                    <template v-if="showarray.length > 0">
                                        <template v-for="(y, index) in showarray" :key="index">
                                            <fwb-table-row v-if="y.isunit">
                                                <fwb-table-cell>
                                                    <fwb-heading tag="h5">{{ y.name }} </fwb-heading>
                                                </fwb-table-cell>
                                                <fwb-table-cell>{{ y.price }}</fwb-table-cell>
                                                <fwb-table-cell><fwb-button gradient="red" shadow
                                                        v-if="y.buy">BUY</fwb-button></fwb-table-cell>
                                            </fwb-table-row>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <fwb-alert class="border-t-4 rounded-none" icon type="danger">
                                            There is no lesson name '{{ query }}'
                                        </fwb-alert>
                                    </template>
                                </template>
                                <template v-else>
                                    <template v-for="(y, index) in objectarray" :key="index">
                                        <fwb-table-row v-if="y.isunit">
                                            <fwb-table-cell>
                                                <fwb-heading tag="h5">{{ y.name }} </fwb-heading>
                                            </fwb-table-cell>
                                            <fwb-table-cell>{{ y.price }}</fwb-table-cell>
                                            <fwb-table-cell><fwb-button gradient="red" shadow
                                                    v-if="y.buy">BUY</fwb-button></fwb-table-cell>
                                        </fwb-table-row>
                                    </template>
                                </template>
                            </fwb-table-body>
                        </fwb-table>
                    </div>
                    <div v-if="activebutton === 'paper'" style=" overflow-x: auto; max-height: 75vh;">
                        <fwb-table striped>
                            <fwb-table-body>
                                <template v-for="(y, index) in objectarray" :key="index">
                                    <fwb-table-row v-if="!y.isunit">
                                        <fwb-table-cell>
                                            <fwb-heading tag="h5">{{ y.name }} </fwb-heading>
                                        </fwb-table-cell>
                                        <fwb-table-cell>{{ y.price }}</fwb-table-cell>
                                        <fwb-table-cell><fwb-button gradient="red" shadow
                                                v-if="y.buy">BUY</fwb-button></fwb-table-cell>
                                    </fwb-table-row>
                                </template>
                            </fwb-table-body>
                        </fwb-table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style>
.input-border {
    border: 2px solid #ccc; /* Change color and width as needed */
    border-radius: 4px; /* Optional: for rounded corners */
    padding: 20px;
    width: 500px;
    border-radius: 20px;
}
</style>