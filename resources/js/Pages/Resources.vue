<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { usePreventDevTools } from '@/Components/DisableDevTools';
usePreventDevTools()
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

const Arrays = defineProps({
    userResourcesInfo: Array,
    userVideoData: Array,
    paidResources: Array,
});

const { props } = usePage();


const iscaution = ref(false); 
const isShowModal = ref(false)
const showarray = ref([]);
const query = ref('');
const activebutton = ref('unit');
const total = ref(0);
const objectarray = ref(Arrays.userResourcesInfo);
const boughtArray = ref(Arrays.paidResources);
function getkey(evt) {
    showarray.value = [];
    if (query.value.length > 0) {
        for (const y of objectarray.value) {
            if (y.resource_name.toLowerCase().includes(query.value.toLowerCase())) {
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

function caution_continue(){
    iscaution.value = false;
    sessionStorage.setItem('caution', 'false');
}
function caution_back(){
    window.location.href = '/dashboard';
}

const cartarrya = ref([])

onMounted(() => {

    checkCaution();
    // Retrieve items from session storage
    const storedCart = JSON.parse(sessionStorage.getItem('cart')) || [];
    // Assign the retrieved items to cartarrya
    cartarrya.value = storedCart;
    for (let i = 0; i < cartarrya.value.length; i++) {
        total.value += parseInt(cartarrya.value[i].price)
    }
});
// checking is the value presented in session storage 
function checkCaution() {
    if (sessionStorage.getItem('caution') !== null) {
        return;
    } else {
        iscaution.value = true;
    }
}

function addtocart(item) {
    cartarrya.value.push(item)
    total.value += parseInt(item.price)
    sessionStorage.setItem('cart', JSON.stringify(cartarrya.value));

    let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
}
function removecart(item) {
    cartarrya.value = cartarrya.value.filter((x) => x !== item)
    total.value -= parseInt(item.price)
    sessionStorage.setItem('cart', JSON.stringify(cartarrya.value));
    let cart = JSON.parse(sessionStorage.getItem('cart')) || [];

}
function clearcart() {
    cartarrya.value = []
    total.value = 0
    sessionStorage.setItem('cart', JSON.stringify(cartarrya.value));
    let cart = JSON.parse(sessionStorage.getItem('cart')) || [];

}

function isitemincart(item) {
    return cartarrya.value.some(cartItem => cartItem.resource_name === item.resource_name);
}
function redirectpayement() {
    sessionStorage.setItem('buy', 'true');
    window.location.href = '/payments';

}

function isExpired(date) {
    const currentDate = new Date();
    const givenDate = new Date(date);
    if (givenDate < currentDate) {
        return true;
    } else {
        return false;
    }
}

function buyState(item) {
    if (item.buy == 1 && item.expiry_date == null) {
        return 3;
    } else if ((item.buy == 0 && item.expiry_date == null) || (item.buy == 1 && isExpired(item.expiry_date) == true)) {
        return 2;
    } else if (item.buy == 1 && isExpired(item.expiry_date) == false) {
        return 1;
    }
}

function getVideosByResourceId(resourceId) {
    // First check if any videos exist for this resourceId
    const matchingVideos = Arrays.userVideoData.filter(item => item.resource_id === resourceId && item.video_link !== null);
    // If no matching videos found, return empty array
    if (matchingVideos.length === 0) {
        return [];
    }
    // Return the matching videos
    matchingVideos.sort((a, b) => parseInt(a.video_index) - parseInt(b.video_index));
    return matchingVideos;
}

</script>

<template>

    <Head title="Resources" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Resources</h2>
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
                    <div class="flex justify-center relative items-start">
                        <div id="app" class="inline-flex rounded-md shadow-sm mt-2" role="group">
                            <button type="button" @click="activebutton = 'unit'" :class="[
                                'px-4 py-2 text-sm font-medium',
                                activebutton === 'unit' ? 'text-blue-700 bg-sky-50' : 'text-gray-900 bg-white',
                                'border border-gray-200 rounded-s-lg',
                                'hover:bg-gray-100 hover:text-blue-700',
                                'dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:text-white'
                            ]">
                                Unit Based Lessons
                            </button>
                            <button type="button" @click="activebutton = 'paper'" :class="[
                                'px-4 py-2 text-sm font-medium',
                                activebutton === 'paper' ? 'text-blue-700 bg-sky-50' : 'text-gray-900 bg-white',
                                'border-t border-b border-gray-200',
                                'hover:bg-gray-100 hover:text-blue-700',
                                'dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:text-white'
                            ]">
                                Past Papers
                            </button>
                            <button type="button" @click="activebutton = 'myresources'" :class="[
                                'px-4 py-2 text-sm font-medium',
                                activebutton === 'myresources' ? 'text-blue-700 bg-sky-50' : 'text-gray-900 bg-white',
                                'border border-gray-200 rounded-e-lg',
                                'hover:bg-gray-100 hover:text-blue-700',
                                'dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:text-white'
                            ]">
                                My Resources
                            </button>
                        </div>

                        <!-- <button type="button" @click="showModal"
                            class="mt-1.5 absolute right-0 sm:mt-0 inline-flex items-center p-2 text-md font-medium text-center text-white rounded-xl border-2 border-gray-400 hover:border-gray-500 hover:bg-gray-200 focus:ring-4 focus:outline-1 focus:ring-blue-300">
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
                        </button> -->
                        <button type="button" @click="showModal"
                            class="sm:absolute sm:right-0 mx-auto block w-fit sm:w-auto mt-4 sm:mt-1.5 items-center justify-center p-2 text-md font-medium text-center text-white rounded-xl border-2 border-gray-400 hover:border-gray-500 hover:bg-gray-200 focus:ring-4 focus:outline-1 focus:ring-blue-300">
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

                    <fwb-modal v-if="isShowModal" @close="closeModal" class="w-full max-w-md mx-auto">
                        <template #header>
                            <div class="flex items-center text-lg">
                                Cart
                            </div>
                        </template>
                        <template #body>
                            <div class="max-h-60 sm:max-h-80 overflow-y-auto">
                                <template v-if="cartarrya.length > 0">
                                    <!-- Card layout for mobile -->
                                    <div class="space-y-3 sm:hidden">
                                        <div v-for="(y, index) in cartarrya" :key="index"
                                            class="p-3 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                            <div class="flex flex-col">
                                                <div class="mb-2">
                                                    <fwb-heading class="text-md truncate" :title="y.resource_name">
                                                        {{ y.resource_name }}
                                                    </fwb-heading>
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        Rs. {{ y.price }}
                                                    </div>
                                                    <fwb-button gradient="red" size="xs" @click="removecart(y)">
                                                        Remove
                                                    </fwb-button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Table for desktop -->
                                    <div class="hidden sm:block">
                                        <fwb-table striped>
                                            <fwb-table-body>
                                                <template v-for="(y, index) in cartarrya" :key="index">
                                                    <fwb-table-row>
                                                        <fwb-table-cell class="max-w-xs" :title="y.resource_name">
                                                            <fwb-heading class="text-md truncate">{{ y.resource_name
                                                                }}
                                                            </fwb-heading>
                                                        </fwb-table-cell>
                                                        <fwb-table-cell :title="y.name">Rs. {{ y.price
                                                            }}</fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <fwb-button gradient="red" size="xs"
                                                                @click="removecart(y)">Remove Item</fwb-button>
                                                        </fwb-table-cell>
                                                    </fwb-table-row>
                                                </template>
                                            </fwb-table-body>
                                        </fwb-table>
                                    </div>
                                </template>
                                <template v-else>
                                    <fwb-alert border type="dark" class="mb-6 sm:mb-10">
                                        Cart is empty!
                                    </fwb-alert>
                                </template>
                            </div>
                        </template>
                        <template #footer>
                            <div class="flex flex-col sm:flex-row sm:justify-between space-y-3 sm:space-y-0">
                                <fwb-button @click="clearcart" color="alternative" :disabled="cartarrya.length === 0"
                                    class="w-full sm:w-auto">
                                    Clear
                                </fwb-button>
                                <div class="text-center sm:flex-1">
                                    <fwb-heading tag="h5" color="text-gray-500" v-if="total != 0"
                                        class="text-sm sm:text-base">
                                        Total: Rs. {{ total }}
                                    </fwb-heading>
                                </div>
                                <fwb-button color="green" :disabled="cartarrya.length === 0" @click="redirectpayement"
                                    class="w-full sm:w-auto inline-flex items-center justify-center">
                                    <template #prefix>
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                        </svg>
                                    </template>
                                    <span>Buy</span>
                                </fwb-button>
                            </div>
                        </template>
                    </fwb-modal>


                    <fwb-modal v-if="iscaution"  persistent size="lg">
                        <template #header>
                            <div
                                class="flex items-center text-xl font-bold text-red-600 border-b-2 border-red-500 pb-2 w-full">
                                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                IMPORTANT: Read Before Continuing
                            </div>
                        </template>
                        <template #body>
                            <div class="bg-red-50 p-4 rounded-lg border-l-4 border-red-500">
                                <p class="text-base leading-relaxed text-gray-700 mb-4 font-medium">
                                    <span class="block text-lg font-bold text-red-600 mb-2">⚠️ Caution:</span>
                                    You can <span class="underline font-bold">only</span> get the full learning
                                    experience through regular classes, not just by using these resources. Therefore, we
                                    <span class="font-bold">strongly discourage</span> relying on them without enrolling
                                    for the weekly full class.
                                </p>
                                <p class="text-base leading-relaxed text-gray-700 mb-4">
                                    These materials are made available <span class="italic">only to help you catch up on
                                        missed lessons</span> and they are not a replacement for proper guidance.
                                </p>
                                <div class="bg-yellow-100 p-3 rounded-md border border-yellow-300">
                                    <p class="text-base font-medium text-gray-800">
                                        We genuinely care about your progress and want you to learn the right way with
                                        clarity, confidence and consistency.
                                    </p>
                                </div>
                            </div>
                        </template>
                        <template #footer>
                            <div class="flex justify-between w-full">
                                <fwb-button @click="caution_back" color="alternative" class="font-medium">
                                    Back to Classes
                                </fwb-button>
                                <fwb-button @click="caution_continue" color="red" class="font-medium pulse-animation">
                                    I Understand, Continue
                                </fwb-button>
                            </div>
                        </template>
                    </fwb-modal>

                    <!-- Unit tab content -->
                    <hr class="h-px my-6 bg-gray-200 border-2 dark:bg-gray-700">
                    <div v-if="activebutton === 'unit'" class="py-3">
                        <div class="px-4 md:px-12 pb-6 md:pb-12">
                            <!-- Search input - responsive width -->
                            <fwb-input v-on:input="getkey" class="w-full max-w-sm mx-auto" v-model="query"
                                placeholder="Find unit based lessons">
                                <template #prefix>
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </template>
                            </fwb-input>

                            <!-- Responsive table design -->
                            <div class="mt-6 overflow-hidden">
                                <!-- No search results message -->
                                <fwb-alert v-if="query.length > 0 && showarray.length === 0"
                                    class="border-t-4 rounded-none" icon type="warning">
                                    There is no lesson name '{{ query }}'
                                </fwb-alert>
                                <template v-else>


                                    <!-- Card-based layout for mobile -->
                                    <div class="grid gap-4 md:hidden">
                                        <!-- With search query -->
                                        <template v-if="query.length > 0 && showarray.length > 0">
                                            <template v-for="(y, index) in showarray" :key="index">

                                                <div v-for="(y, index) in showarray" :key="index"
                                                    class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                                                    <fwb-heading class="text-base mb-2">{{ y.resource_name
                                                        }}</fwb-heading>
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-gray-700 dark:text-gray-300">Rs. {{ y.price
                                                            }}</span>
                                                        <div>
                                                            <fwb-button gradient="lime" size="xs" class="text-white"
                                                                v-if="buyState(y) == 2" @click="addtocart(y)"
                                                                :disabled="isitemincart(y)">Add To Cart</fwb-button>
                                                            <fwb-badge size="sm" class="w-auto" type="purple"
                                                                v-else-if="buyState(y) == 1">Purchased</fwb-badge>
                                                            <fwb-badge size="sm" class="w-auto"
                                                                v-else-if="buyState(y) == 3">Processing...</fwb-badge>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </template>

                                        <!-- Without search query -->
                                        <template v-else>
                                            <template v-for="(y, index) in objectarray" :key="index">
                                                <div v-if="y.category == 'theory'"
                                                    class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                                                    <fwb-heading class="text-base mb-2">{{ y.resource_name
                                                        }}</fwb-heading>
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-gray-700 dark:text-gray-300">Rs. {{ y.price
                                                            }}</span>
                                                        <div>
                                                            <fwb-button gradient="lime" size="xs" class="text-white"
                                                                v-if="buyState(y) == 2" @click="addtocart(y)"
                                                                :disabled="isitemincart(y)">Add To Cart</fwb-button>
                                                            <fwb-badge size="sm" class="w-auto" type="purple"
                                                                v-else-if="buyState(y) == 1">Purchased</fwb-badge>
                                                            <fwb-badge size="sm" class="w-auto"
                                                                v-else-if="buyState(y) == 3">Processing...</fwb-badge>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </template>
                                    </div>

                                    <!-- Regular table for larger screens -->
                                    <div class="hidden md:block">
                                        <fwb-table striped>
                                            <fwb-table-body>
                                                <!-- With search query -->
                                                <template v-if="query.length > 0 && showarray.length > 0">
                                                    <template v-for="(y, index) in showarray" :key="index">
                                                        <fwb-table-row v-if="y.category == 'theory'">
                                                            <fwb-table-cell>
                                                                <fwb-heading style="font-size: medium;">{{
                                                                    y.resource_name
                                                                    }}</fwb-heading>
                                                            </fwb-table-cell>
                                                            <fwb-table-cell>Rs. {{ y.price }}</fwb-table-cell>
                                                            <fwb-table-cell class="flex justify-center items-center">
                                                                <fwb-button gradient="lime" size="xs"
                                                                    class="mr-2 text-white" v-if="buyState(y) == 2"
                                                                    @click="addtocart(y)"
                                                                    :disabled="isitemincart(y)">Add To
                                                                    Cart</fwb-button>
                                                                <fwb-badge size="sm" class="w-15 float-end"
                                                                    type="purple"
                                                                    v-else-if="buyState(y) == 1">Purchased</fwb-badge>
                                                                <fwb-badge size="sm" class="w-15 float-end"
                                                                    v-else-if="buyState(y) == 3">Processing...</fwb-badge>
                                                            </fwb-table-cell>
                                                        </fwb-table-row>
                                                    </template>
                                                </template>

                                                <!-- Without search query -->
                                                <template v-else>
                                                    <template v-for="(y, index) in objectarray" :key="index">
                                                        <fwb-table-row v-if="y.category == 'theory'">
                                                            <fwb-table-cell>
                                                                <fwb-heading style="font-size: medium;">{{
                                                                    y.resource_name
                                                                    }}</fwb-heading>
                                                            </fwb-table-cell>
                                                            <fwb-table-cell>Rs. {{ y.price }}</fwb-table-cell>
                                                            <fwb-table-cell class="flex justify-center items-center">
                                                                <fwb-button gradient="lime" size="xs"
                                                                    class="mr-2 text-white" v-if="buyState(y) == 2"
                                                                    @click="addtocart(y)"
                                                                    :disabled="isitemincart(y)">Add To
                                                                    Cart</fwb-button>
                                                                <fwb-badge size="sm" class="w-15 float-end"
                                                                    type="purple"
                                                                    v-else-if="buyState(y) == 1">Purchased</fwb-badge>
                                                                <fwb-badge size="sm" class="w-15 float-end"
                                                                    v-else-if="buyState(y) == 3">Processing...</fwb-badge>
                                                            </fwb-table-cell>
                                                        </fwb-table-row>
                                                    </template>
                                                </template>
                                            </fwb-table-body>
                                        </fwb-table>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Paper tab content - similar responsive approach -->
                    <div v-if="activebutton === 'paper'" class="py-3">
                        <div class="px-4 md:px-12 pb-6 md:pb-12">
                            <!-- Card-based layout for mobile -->
                            <div class="grid gap-4 md:hidden">
                                <template v-for="(y, index) in objectarray" :key="index">
                                    <div v-if="y.category == 'paper'"
                                        class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                                        <fwb-heading class="text-base mb-2">{{ y.resource_name }}</fwb-heading>
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-700 dark:text-gray-300">Rs. {{ y.price }}</span>
                                            <div>
                                                <fwb-button gradient="lime" size="xs" class="text-white"
                                                    v-if="buyState(y) == 2" @click="addtocart(y)"
                                                    :disabled="isitemincart(y)">Add To Cart</fwb-button>
                                                <fwb-badge size="sm" class="w-auto" type="purple"
                                                    v-else-if="buyState(y) == 1">Purchased</fwb-badge>
                                                <fwb-badge size="sm" class="w-auto"
                                                    v-else-if="buyState(y) == 3">Processing...</fwb-badge>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- Regular table for larger screens -->
                            <div class="hidden md:block">
                                <fwb-table striped>
                                    <fwb-table-body>
                                        <template v-for="(y, index) in objectarray" :key="index">
                                            <fwb-table-row v-if="y.category == 'paper'">
                                                <fwb-table-cell>
                                                    <fwb-heading style="font-size: medium;">{{ y.resource_name
                                                    }}</fwb-heading>
                                                </fwb-table-cell>
                                                <fwb-table-cell>Rs. {{ y.price }}</fwb-table-cell>
                                                <fwb-table-cell class="flex justify-center items-center">
                                                    <fwb-button gradient="lime" size="xs" class="mr-2 text-white"
                                                        v-if="buyState(y) == 2" @click="addtocart(y)"
                                                        :disabled="isitemincart(y)">Add To Cart</fwb-button>
                                                    <fwb-badge size="sm" class="w-15 float-end" type="purple"
                                                        v-else-if="buyState(y) == 1">Purchased</fwb-badge>
                                                    <fwb-badge size="sm" class="w-15 float-end"
                                                        v-else-if="buyState(y) == 3">Processing...</fwb-badge>
                                                </fwb-table-cell>
                                            </fwb-table-row>
                                        </template>
                                    </fwb-table-body>
                                </fwb-table>
                            </div>
                        </div>
                    </div>
                    <div v-if="activebutton === 'myresources'">
                        <div class="p-4 md:p-6">
                            <fwb-accordion>
                                <template v-if="boughtArray.length > 0">
                                    <fwb-accordion-panel v-for="(y, index) in boughtArray" :key="index" class="mb-3">
                                        <fwb-accordion-header class="bg-gray-50 rounded-lg">
                                            <div class="flex flex-col space-y-2 w-full">
                                                <div class="flex justify-between items-center">
                                                    <span class="font-medium truncate max-w-xs"
                                                        :title="y.resource_name">{{ y.resource_name }}</span>
                                                    <span
                                                        class="text-sm bg-blue-100 text-blue-800 px-2 py-1 rounded-full">{{
                                                            calculateExpireDate(y.expiry_date) }} days left</span>
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    <div class="flex flex-wrap gap-x-2">
                                                        <span>
                                                            Expires: <span class="font-medium">{{ new
                                                                Date(y.expiry_date).toLocaleDateString('en-US',
                                                                    { year: 'numeric', month: '2-digit', day: '2-digit' })
                                                            }}</span>
                                                        </span>
                                                        <span>
                                                            Time: <span class="font-medium">{{ new
                                                                Date(y.expiry_date).toLocaleTimeString('en-US',
                                                                    { hour: '2-digit', minute: '2-digit', hour12: false })
                                                            }}</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </fwb-accordion-header>

                                        <fwb-accordion-content>
                                            <div v-if="getVideosByResourceId(y.resource_id).length > 0"
                                                class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-4">
                                                <template v-for="(video, index) in getVideosByResourceId(y.resource_id)"
                                                    :key="index">
                                                    <div>
                                                        <div class="p-4">
                                                            <div v-html="video.video_link"></div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                            <div v-else>
                                                <p class="pt-3 pb-7 pl-4">No vidoes available</p>
                                            </div>
                                        </fwb-accordion-content>
                                    </fwb-accordion-panel>
                                </template>
                                <template v-else>
                                    <div class="text-center p-6 bg-gray-50 rounded-lg border border-gray-200">
                                        <p class="text-gray-500">You haven't bought any resources</p>
                                    </div>
                                </template>
                            </fwb-accordion>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style scoped>
@media (min-width: 540px) {
    .cart-button-mobile {
        display: none;
    }
}

@media(max-width: 540px) {
    .large_cart {
        display: none;
    }
}

.pulse-animation {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7);
    }

    70% {
        box-shadow: 0 0 0 10px rgba(220, 38, 38, 0);
    }

    100% {
        box-shadow: 0 0 0 0 rgba(220, 38, 38, 0);
    }
}
</style>