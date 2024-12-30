<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import 'primeicons/primeicons.css'
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
    FwbAlert,
    FwbModal
} from 'flowbite-vue';


const isShowModal = ref(false)
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

const boughtArray = ref([
    {
        name: 'Unit 1: Atomic Structure', expire_date: '2025/01/13', video_link: [
            `<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/1012272588?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="video1074884583"></iframe></div>`
        ]
    },
    {
        name: 'Unit 2: Structure and Bonding', expire_date: '2025/1/13', video_link: [
            `<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/1012272588?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="video1074884583"></iframe></div>`,
            `<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/1012272588?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="video1074884583"></iframe></div>`,
            `<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/1012272588?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="video1074884583"></iframe></div>`
        ]
    },
    {
        name: 'Unit 3: Chemical Calculations', expire_date: '2025/1/13', video_link: [
            `<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/1012272588?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="video1074884583"></iframe></div>`,
            `<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/1012272588?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="video1074884583"></iframe></div>`,
            `<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/1012272588?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="video1074884583"></iframe></div>`
        ]
    },
    {
        name: 'Unit 4: Gaseous State of Matter', expire_date: '2025/2/13', video_link: [
            `<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/1012272588?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="video1074884583"></iframe></div>`,
            `<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/1012272588?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="video1074884583"></iframe></div>`,

        ]
    },
    {
        name: 'Unit 5: Energetics', expire_date: '2025/3/13', video_link: [
            `<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/1012272588?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="video1074884583"></iframe></div>`,
        ]
    },
    {
        name: '2003, 2004, 2005', expire_date: '2025/4/13', video_link: [
            `<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/1012272588?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="video1074884583"></iframe></div>`,
        ]
    }
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
function calculateExpireDate(expire_date) {
    const today = new Date();
    const expireDate = new Date(expire_date);
    const timeDifference = expireDate - today;
    const daysDifference = Math.ceil(timeDifference / (1000 * 3600 * 24));
    return daysDifference;
}

function closeModal() {
    isShowModal.value = false
}
function showModal() {
    isShowModal.value = true
}

const cartarrya = ref([])

function addtocart(item) {
    cartarrya.value.push(item)
    console.log(cartarrya.value)
}

function isitemincart(item) {
    return cartarrya.value.includes(item)
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
                    <div class="flex justify-center relative">
                        <div class="inline-flex rounded-md shadow-sm mt-2" role="group">
                            <button type="button" @click="activebutton = 'unit'"
                                class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                                Unite base lessons
                            </button>
                            <button type="button" @click="activebutton = 'paper'"
                                class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                                Past papers
                            </button>
                            <button type="button" @click="activebutton = 'myresources'"
                                class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                                My Resources
                            </button>
                        </div>

                        <fwb-button color="alternative" class="absolute right-0" pill @click="showModal">
                            <!-- <i class="pi pi-cart-minus" style="font-size: 1.2rem"></i> -->

                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                            </svg>
                        </fwb-button>

                    </div>

                    <fwb-modal v-if="isShowModal" @close="closeModal">
                        <template #header>
                            <div class="flex items-center text-lg">
                                Cart
                            </div>
                        </template>
                        <template #body>
                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                With less than a month to go before the European Union enacts new consumer privacy laws
                                for its citizens, companies around the world are updating their terms of service
                                agreements to comply.
                            </p>
                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                The European Union’s General Data Protection Regulation (G.D.P.R.) goes into effect on
                                May 25 and is meant to ensure a common set of data rights in the European Union. It
                                requires organizations to notify users as soon as possible of high-risk data breaches
                                that could personally affect them.
                            </p>
                        </template>
                        <template #footer>
                            <div class="flex justify-between">
                                <fwb-button @click="closeModal" color="alternative">
                                    Decline
                                </fwb-button>
                                <fwb-button @click="closeModal" color="green">
                                    I accept
                                </fwb-button>
                            </div>
                        </template>
                    </fwb-modal>

                    <hr class="h-px my-6 bg-gray-200 border-2 dark:bg-gray-700">
                    <div v-if="activebutton === 'unit'" style="overflow-x: auto; max-height: 73vh;">

                        <fwb-input v-on:input="getkey" class="max-w-md mx-auto" v-model="query"
                            placeholder="Find unit based lessons" size="sm" style="width: 300px;">
                            <template #prefix>
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </template>
                            <template #suffix>
                            </template>
                        </fwb-input>

                        <hr class="h-px my-6 bg-gray-200 border-2 dark:bg-gray-700">
                        <fwb-table striped style="margin-top: 20px;">
                            <fwb-table-body>
                                <template v-if="query.length > 0">
                                    <template v-if="showarray.length > 0">
                                        <template v-for="(y, index) in showarray" :key="index">
                                            <fwb-table-row v-if="y.isunit">
                                                <fwb-table-cell>
                                                    <fwb-heading style="font-size: medium;">{{ y.name }} </fwb-heading>
                                                </fwb-table-cell>
                                                <fwb-table-cell>{{ y.price }}</fwb-table-cell>
                                                <fwb-table-cell><fwb-button gradient="red" shadow v-if="y.buy"
                                                    @click="addtocart(y)"
                                                    :disabled="isitemincart(y)"
                                                        style="padding: 2px 6px 2px 6px; font-size: 10px; pad">ADD TO
                                                        CART</fwb-button></fwb-table-cell>
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
                                                <fwb-heading style="font-size: medium;">{{ y.name }} </fwb-heading>
                                            </fwb-table-cell>
                                            <fwb-table-cell>{{ y.price }}</fwb-table-cell>
                                            <fwb-table-cell><fwb-button gradient="red" shadow v-if="y.buy"
                                                @click="addtocart(y)"
                                                :disabled="isitemincart(y)"
                                                    style="padding: 2px 6px 2px 6px; font-size: 10px; pad">ADD TO
                                                    CART</fwb-button></fwb-table-cell>
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
                                            <fwb-heading style="font-size: medium;">{{ y.name }} </fwb-heading>
                                        </fwb-table-cell>
                                        <fwb-table-cell>{{ y.price }}</fwb-table-cell>
                                        <fwb-table-cell><fwb-button gradient="red" shadow v-if="y.buy"
                                            @click="addtocart(y)"
                                            :disabled="isitemincart(y)"
                                                style="padding: 2px 6px 2px 6px; font-size: 10px; pad">ADD TO
                                                CART</fwb-button></fwb-table-cell>
                                    </fwb-table-row>
                                </template>
                            </fwb-table-body>
                        </fwb-table>
                    </div>
                    <div v-if="activebutton === 'myresources'">
                        <fwb-accordion>
                            <fwb-accordion-panel v-for="(y, index) in boughtArray" :key="index">
                                <fwb-accordion-header>
                                    <div style="display: flex; justify-content: space-between; width: 100%;">
                                        <span>{{ y.name }}</span>
                                        <span>Days Left: {{ calculateExpireDate(y.expire_date) }}</span>
                                        <span class="text-gray-500 dark:text-gray-400">Expire Date {{ y.expire_date
                                            }}</span>
                                    </div>
                                </fwb-accordion-header>
                                <fwb-accordion-content>
                                    <div>
                                        <div v-for="(video, index) in y.video_link" :key="index"
                                            class="grid grid-cols-3">
                                            <div v-html="video"></div>
                                        </div>
                                    </div>
                                </fwb-accordion-content>
                            </fwb-accordion-panel>

                        </fwb-accordion>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style></style>