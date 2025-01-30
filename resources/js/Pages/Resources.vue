<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

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
    FwbModal,
    FwbBadge,
} from 'flowbite-vue';

const { props } = usePage();

const isShowModal = ref(false)
const showarray = ref([]);
const query = ref('');
const activebutton = ref('unit');
const total = ref(0);

const objectarray = ref([
    { name: 'Unit 1: Atomic Structure', price: 3000, buy: true, isunit: true, id: 1, category: 'theory', expire_date: '2026/04/10', paid: true },
    { name: 'Unit 2: Structure and Bonding', price: 4000, buy: false, isunit: true, id: 2, category: 'theory', expire_date: null, paid: true },
    { name: 'Unit 3: Chemical Calculations', price: 3000, buy: true, isunit: true, id: 3, category: 'theory', expire_date: '2025/09/15', paid: false },
    { name: 'Unit 4: Gaseous State of Matter', price: 6000, buy: false, isunit: true, id: 4, category: 'theory', expire_date: '2025/07/20', paid: true },
    { name: '2003, 2004, 2005', price: 3000, buy: true, isunit: false, id: 5, category: 'paper', expire_date: '2022/12/30', paid: true },
    { name: 'Unit 5: Energetics', price: 3000, buy: false, isunit: true, id: 6, category: 'theory', expire_date: null, paid: false },
    { name: 'Unit 6: Inorganic chemistry - s-block', price: 2500, buy: true, isunit: true, id: 7, category: 'theory', expire_date: '2024/05/12', paid: true },
    { name: 'Unit 6: Inorganic chemistry - p-block', price: 7000, buy: true, isunit: true, id: 8, category: 'theory', expire_date: null, paid: false },
    { name: 'Unit 6: Inorganic chemistry - d-block + lon analysis', price: 4500, buy: true, isunit: true, id: 9, category: 'theory', expire_date: '2025/02/14', paid: true },
    { name: 'Unit 6: Question Discussion', price: 5500, buy: true, isunit: true, id: 10, category: 'theory', expire_date: '2023/11/05', paid: false },
    { name: 'Unit 7-10: Organic chemistry - unit 7 & 8', price: 6500, buy: true, isunit: true, id: 11, category: 'theory', expire_date: '2027/01/18', paid: true },
    { name: 'Unit 7-10: Organic chemistry - unit 9 & 10', price: 6500, buy: true, isunit: true, id: 12, category: 'theory', expire_date: null, paid: false },
    { name: 'Unit 7-10: Question + Conversion Practice', price: 6500, buy: true, isunit: true, id: 13, category: 'theory', expire_date: '2026/06/30', paid: true },
    { name: '2006, 2007, 2008', price: 3000, buy: true, isunit: false, id: 14, category: 'paper', expire_date: '2022/04/25', paid: true },
    { name: 'Unit 11: Chemical Kinetics', price: 6000, buy: true, isunit: true, id: 15, category: 'theory', expire_date: '2024/10/10', paid: false },
    { name: 'Unit 12: Chemical Equilibrium - Kp & Kc', price: 6500, buy: true, isunit: true, id: 16, category: 'theory', expire_date: null, paid: true },
    { name: 'Unit 12: Chemical Equilibrium - Icon Equilibrium & Buffers', price: 6500, buy: true, isunit: true, id: 17, category: 'theory', expire_date: '2025/08/08', paid: false },
    { name: 'Unit 12: Chemical Equilibrium - Ksp', price: 5500, buy: true, isunit: true, id: 18, category: 'theory', expire_date: '2024/12/15', paid: true },
    { name: '2009, 2010, 2011', price: 3000, buy: true, isunit: false, id: 19, category: 'paper', expire_date: '2023/03/22', paid: true },
    { name: 'Unit 12: Chemical Equilibrium - Phase Equilibrium', price: 5500, buy: true, isunit: true, id: 20, category: 'theory', expire_date: null, paid: false },
    { name: '2012, 2013, 2014', price: 3000, buy: false, isunit: false, id: 21, category: 'paper', expire_date: '2026/02/10', paid: true },
    { name: 'Unit 13: Electrochemistry', price: 1000, buy: true, isunit: true, id: 22, category: 'theory', expire_date: '2025/09/28', paid: false },
    { name: '2015, 2016, 2017', price: 3000, buy: true, isunit: false, id: 23, category: 'paper', expire_date: '2023/07/12', paid: true },
    { name: 'Unit 14 - Industry & polymers', price: 1000, buy: true, isunit: true, id: 24, category: 'theory', expire_date: '2024/11/09', paid: false },
    { name: 'Unit 14 - Plant based products & environmental pollution', price: 1000, buy: true, isunit: true, id: 25, category: 'theory', expire_date: null, paid: true }
]);


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

onMounted(() => {
    // Retrieve items from session storage
    const storedCart = JSON.parse(sessionStorage.getItem('cart')) || [];
    // Assign the retrieved items to cartarrya
    cartarrya.value = storedCart;
    for (let i = 0; i < cartarrya.value.length; i++) {
        total.value += cartarrya.value[i].price
    }
    console.log(cartarrya.value)
});

function addtocart(item) {
    cartarrya.value.push(item)
    total.value += item.price
    console.log(total.value)
    sessionStorage.setItem('cart', JSON.stringify(cartarrya.value));
    console.log(cartarrya.value)
    let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
    console.log(cart);
}
function removecart(item) {
    cartarrya.value = cartarrya.value.filter((x) => x !== item)
    total.value -= item.price
    sessionStorage.setItem('cart', JSON.stringify(cartarrya.value));
    let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
    console.log(cart);
}
function clearcart() {
    cartarrya.value = []
    total.value = 0
    sessionStorage.setItem('cart', JSON.stringify(cartarrya.value));
    let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
    console.log(cart);
}

function isitemincart(item) {
    return cartarrya.value.some(cartItem => cartItem.name === item.name);
}
function redirectpayement() {
    sessionStorage.setItem('buy', 'true');
    window.location.href = '/payments';

}

function expiredatecal(item){
    if (item.expire_date == null) {
        return true;
    }
    const today = new Date();
    const expireDate = new Date(item.expire_date);
    const timeDifference = expireDate - today;
    const daysDifference = Math.ceil(timeDifference / (1000 * 3600 * 24));
    if(daysDifference > 0){
        return false;
    }
    return true;
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
                    <a href="/class-controls" v-if="props.auth.user.role === 'admin'">
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
                        <div id="app" class="inline-flex rounded-md shadow-sm mt-2" role="group">
                            <button type="button" @click="activebutton = 'unit'" :class="[
                                'px-4 py-2 text-sm font-medium',
                                activebutton === 'unit' ? 'text-blue-700 bg-gray-100' : 'text-gray-900 bg-white',
                                'border border-gray-200 rounded-s-lg',
                                'hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700',
                                'dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white'
                            ]">
                                Unite base lessons
                            </button>
                            <button type="button" @click="activebutton = 'paper'" :class="[
                                'px-4 py-2 text-sm font-medium',
                                activebutton === 'paper' ? 'text-blue-700 bg-gray-100' : 'text-gray-900 bg-white',
                                'border-t border-b border-gray-200',
                                'hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700',
                                'dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white'
                            ]">
                                Past papers
                            </button>
                            <button type="button" @click="activebutton = 'myresources'" :class="[
                                'px-4 py-2 text-sm font-medium',
                                activebutton === 'myresources' ? 'text-blue-700 bg-gray-100' : 'text-gray-900 bg-white',
                                'border border-gray-200 rounded-e-lg',
                                'hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700',
                                'dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white'
                            ]">
                                My Resources
                            </button>
                        </div>

                        <button type="button" @click="showModal"
                            class="mt-1.5 absolute right-0 inline-flex items-center p-2 text-md font-medium text-center text-white rounded-xl border-2 border-gray-400 hover:border-gray-500 hover:bg-gray-200 focus:ring-4 focus:outline-1 focus:ring-blue-300">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                            </svg>
                            <span class="sr-only">Notifications</span>
                            <div
                                class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">
                                {{ cartarrya.length }}</div>
                        </button>
                    </div>

                    <fwb-modal v-if="isShowModal" @close="closeModal">
                        <template #header>
                            <div class="flex items-center text-lg">
                                Cart
                            </div>
                        </template>
                        <template #body>
                            <div class="max-h-80 overflow-y-auto">
                                <template v-if="cartarrya.length > 0">
                                    <fwb-table striped>
                                        <fwb-table-body>
                                            <template v-for="(y, index) in cartarrya" :key="index">
                                                <fwb-table-row>
                                                    <fwb-table-cell class="max-w-xs" :title="y.name">
                                                        <fwb-heading class="text-md truncate">{{ y.name }}
                                                        </fwb-heading>
                                                    </fwb-table-cell>
                                                    <fwb-table-cell :title="y.name">Rs. {{ y.price }}</fwb-table-cell>
                                                    <fwb-table-cell>
                                                        <fwb-button gradient="red" size="xs" v-if="y.buy"
                                                            @click="removecart(y)">Remove Item</fwb-button>
                                                    </fwb-table-cell>
                                                </fwb-table-row>
                                            </template>
                                        </fwb-table-body>
                                    </fwb-table>
                                </template>
                                <template v-else>
                                    <fwb-alert border type="dark" class="mb-10">
                                        Cart is empty !
                                    </fwb-alert>
                                </template>
                            </div>
                        </template>
                        <template #footer>
                            <div class="flex justify-between">
                                <fwb-button @click="clearcart" color="alternative" :disabled="cartarrya.length === 0">
                                    Clear
                                </fwb-button>
                                <div class="flex-1 text-center">
                                    <fwb-heading tag="h5" color="text-gray-500" v-if="total != 0">Total amount : Rs. {{
                                        total }}</fwb-heading>
                                </div>

                                <fwb-button color="green" :disabled="cartarrya.length === 0" @click="redirectpayement">
                                    Buy
                                </fwb-button>

                            </div>
                        </template>
                    </fwb-modal>

                    <hr class="h-px my-6 bg-gray-200 border-2 dark:bg-gray-700">
                    <div v-if="activebutton === 'unit'" class="py-3">
                        <fwb-input v-on:input="getkey" class="max-w-sm mx-auto" v-model="query"
                            placeholder="Find unit based lessons">
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
                        <fwb-table striped style="margin-top: 20px;">
                            <fwb-table-body>
                                <template v-if="query.length > 0">
                                    <template v-if="showarray.length > 0">
                                        <template v-for="(y, index) in showarray" :key="index">
                                            <fwb-table-row v-if="y.category == 'paper'">
                                                <fwb-table-cell>
                                                    <fwb-heading style="font-size: medium;">{{ y.name }} </fwb-heading>
                                                </fwb-table-cell>
                                                <fwb-table-cell>Rs. {{ y.price }}</fwb-table-cell>
                                                <fwb-table-cell>
                                                    <fwb-button gradient="lime" size="xs" class="mr-2 text-white"
                                                        v-if="expiredatecal(y)" @click="addtocart(y)"
                                                        :disabled="isitemincart(y)">Add To Cart</fwb-button>
                                                    <fwb-badge size="sm" class="w-15 float-end" type="purple"
                                                        v-else>Purchased</fwb-badge>
                                                </fwb-table-cell>
                                            </fwb-table-row>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <fwb-alert class="border-t-4 rounded-none" icon type="warning">
                                            There is no lesson name '{{ query }}'
                                        </fwb-alert>
                                    </template>
                                </template>
                                <template v-else>
                                    <template v-for="(y, index) in objectarray" :key="index">
                                        <fwb-table-row v-if="y.category == 'theory'">
                                            <fwb-table-cell>
                                                <fwb-heading style="font-size: medium;">{{ y.name }} </fwb-heading>
                                            </fwb-table-cell>
                                            <fwb-table-cell>Rs. {{ y.price }}</fwb-table-cell>
                                            <fwb-table-cell>
                                                <fwb-button gradient="lime" size="xs" class="mr-2 text-white"
                                                v-if="expiredatecal(y)" @click="addtocart(y)" :disabled="isitemincart(y)">Add
                                                    To Cart</fwb-button>
                                                <fwb-badge size="sm" class="w-15 float-end" type="purple"
                                                    v-else>Purchased</fwb-badge>
                                            </fwb-table-cell>
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
                                        <fwb-table-cell>Rs. {{ y.price }}</fwb-table-cell>
                                        <fwb-table-cell>
                                            <fwb-button gradient="lime" size="xs" class="mr-2 text-white" v-if="y.buy"
                                                @click="addtocart(y)" :disabled="isitemincart(y)">Add To
                                                Cart</fwb-button>
                                            <fwb-badge size="sm" class="w-15 float-end" type="purple"
                                                v-else>Purchased</fwb-badge>
                                        </fwb-table-cell>
                                    </fwb-table-row>
                                </template>
                            </fwb-table-body>
                        </fwb-table>
                    </div>
                    <div v-if="activebutton === 'myresources'">
                        <fwb-accordion>
                            <fwb-accordion-panel v-for="(y, index) in boughtArray" :key="index">
                                <fwb-accordion-header>
                                    <div style="display: flex; justify-content: space-between; width: 100%">
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