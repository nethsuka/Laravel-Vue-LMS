<script setup>
import Sidebar from '@/Layouts/Sidebar.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
    FwbA,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
    FwbSelect,
    FwbHeading
} from 'flowbite-vue'
import { FwbButton, FwbModal } from 'flowbite-vue'
import { FwbInput } from 'flowbite-vue'

const isShowModal = ref(false)

function closeModal() {
    isShowModal.value = false
    name.value = null
    price.value = null
    selected.value = ''
}
function SavecloseModal() {
    objectarray.value.push({ name: name.value, price: price.value, id: objectarray.value.length + 1, count: 3, category: selected.value })
    closeModal()
}
function showModal() {
    isShowModal.value = true
}

const selected = ref('')
const category = [
    { value: 'unite', name: 'Unite' },
    { value: 'paper', name: 'Paper' },
]
const objectarray = ref([
    { name: 'Unit 1: Atomic Structure', price: 3000, id: 1, count: 3, category: 'theory', },
    { name: 'Unit 2: Structure and Bonding', price: 4000, id: 2, count: 3, category: 'theory', },
    { name: 'Unit 3: Chemical Calculations', price: 3000, id: 3, count: 3, category: 'theory', },
    { name: 'Unit 4: Gaseous State of Matter', price: 6000, id: 4, count: 3, category: 'theory', },
    { name: '2003, 2004, 2005', price: 3000, id: 5, count: 3, category: 'theory', },
    { name: 'Unit 5: Energetics', price: 3000, id: 6, count: 3, category: 'theory', },
    { name: 'Unit 6: Inorganic chemistry - s-block', price: 2500, id: 7, count: 3, category: 'theory', },
    { name: 'Unit 6: Inorganic chemistry - p-block', price: 7000, id: 8, count: 4, category: 'theory', },
    { name: 'Unit 6: Inorganic chemistry - d-block + lon analysis', price: 4500, id: 9, count: 3, category: 'theory', },
    { name: 'Unit 6: Question Discussion', price: 5500, id: 10, count: 3, category: 'theory', },
    { name: 'Unit 7-10: Organic chemistry - unit 7 & 8', price: 6500, id: 11, count: 6, category: 'theory', },
    { name: 'Unit 7-10: Organic chemistry - unit 9 & 10', price: 6500, id: 12, count: 3, category: 'theory', },
    { name: 'Unit 7-10: Question + Conversion Practice', price: 6500, id: 13, count: 8, category: 'theory', },
    { name: '2006, 2007, 2008', price: 3000, id: 14, count: 3, category: 'theory', },
    { name: 'Unit 11: Chemical Kinetics', price: 6000, id: 15, count: 3, category: 'theory', },
    { name: 'Unit 12: Chemical Equilibrium - Kp & Kc', price: 6500, id: 16, count: 3, category: 'theory', },
    { name: 'Unit 12: Chemical Equilibrium - Icon Equilibrium & Buffers', price: 6500, id: 17, count: 3, category: 'theory', },
    { name: 'Unit 12: Chemical Equilibrium - Ksp', price: 5500, id: 18, count: 3, category: 'theory', },
    { name: '2009, 2010, 2011', price: 3000, id: 19, count: 3, category: 'theory', },
    { name: 'Unit 12: Chemical Equilibrium - Phase Equilibrium', price: 5500, id: 20, count: 3, category: 'theory', },
    { name: '2012, 2013, 2014', price: 3000, id: 21, count: 3, category: 'theory', },
    { name: 'Unit 13: Electrochemistry', price: 1000, id: 22, count: 3, category: 'theory', },
    { name: '2015, 2016, 2017', price: 3000, id: 23, count: 3, category: 'theory', },
    { name: 'Unit 14 - Industry & polymers', price: 1000, id: 24, count: 3, category: 'theory', },
    { name: 'Unit 14 - Plant based products & environmental pollution', price: 1000, id: 25, count: 3, category: 'theory', }
]);
const name = ref(null)
const price = ref(null)
function validatenumber(event) {
    const value = event.target.value;
    // Allow only numbers
    event.target.value = value.replace(/[^\d]/g, '');
}
const query = ref('')
</script>

<template>

    <Head title="Resource Control Panel"></Head>
    <div>
        <Sidebar>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" :style="{ overflowY: 'auto', maxHeight: '95vh' }">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3">

                        <fwb-heading tag="h2">Resources</fwb-heading>
                        <br>
                        <div class="flex justify-end">
                            <fwb-button gradient="green" @click="showModal">+</fwb-button>
                        </div>
                        <fwb-input v-model="query" label="Search" placeholder="Search for resources" size="md">
                            <template #prefix>
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </template>
                        </fwb-input>
                        <fwb-table striped style="margin-top: 20px; max-width: 1200px;">
                            <fwb-table-head>
                                <fwb-table-head-cell>Resources name</fwb-table-head-cell>
                                <fwb-table-head-cell>Price</fwb-table-head-cell>
                                <fwb-table-head-cell>Video count</fwb-table-head-cell>
                                <fwb-table-head-cell>Action</fwb-table-head-cell>
                            </fwb-table-head>
                            <fwb-table-body>
                                <template v-for="(item, index) in objectarray" :key="index">
                                    <fwb-table-row>

                                        <fwb-table-cell>
                                            <span style="font-size: larger;">
                                                {{ item.name }}
                                            </span>
                                        </fwb-table-cell>
                                        <fwb-table-cell>
                                            <span style="font-size: large;">
                                                {{ item.price }}
                                            </span>
                                        </fwb-table-cell>
                                        <fwb-table-cell>
                                            <span style="font-size: large;">
                                                {{ item.count }}
                                            </span>
                                        </fwb-table-cell>
                                        <fwb-table-cell>
                                            <fwb-button gradient="cyan">Edit</fwb-button>
                                        </fwb-table-cell>
                                    </fwb-table-row>
                                </template>

                            </fwb-table-body>
                        </fwb-table>
                        <fwb-modal v-if="isShowModal" @close="closeModal" persistent>
                            <template #header>
                                <div class="flex items-center text-lg">
                                    Add New Resource
                                </div>
                            </template>
                            <template #body>
                                <fwb-input v-model="name" label="Resource Name" placeholder="Enter Resource name"
                                    size="md" />
                                <div>
                                    <fwb-input v-model="price" label="Price" placeholder="Enter Price" size="sm"
                                        type="text" @input="validatenumber" />

                                    <fwb-select v-model="selected" :options="category" label="Select a country" />
                                </div>
                            </template>
                            <template #footer>
                                <div class="flex justify-between">
                                    <fwb-button @click="closeModal" color="alternative">
                                        Close
                                    </fwb-button>
                                    <fwb-button @click="SavecloseModal" color="green"
                                        :disabled="!name || !price || !selected">
                                        Save
                                    </fwb-button>
                                </div>
                            </template>
                        </fwb-modal>

                    </div>
                </div>
            </div>
        </Sidebar>
    </div>
</template>