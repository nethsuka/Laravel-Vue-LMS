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

const Arrays = defineProps({
    userResourcesInfo: Array,
    userVideoData: Array,
    paidResources: Array,
});

const { props } = usePage();

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

const cartarrya = ref([])

onMounted(() => {
console.log(Arrays.userResourcesInfo)
console.log(Arrays.userVideoData)
console.log(Arrays.paidResources)

    // Retrieve items from session storage
    const storedCart = JSON.parse(sessionStorage.getItem('cart')) || [];
    // Assign the retrieved items to cartarrya
    cartarrya.value = storedCart;
    for (let i = 0; i < cartarrya.value.length; i++) {
        total.value += parseInt(cartarrya.value[i].price)
    }
});

function addtocart(item) {
    cartarrya.value.push(item)
    total.value += parseInt(item.price)
    console.log(total.value)
    sessionStorage.setItem('cart', JSON.stringify(cartarrya.value));
    console.log(cartarrya.value)
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
    const matchingVideos = Arrays.userVideoData.filter(item => item.resource_id === resourceId&& item.video_link !== null);
    // If no matching videos found, return empty array
    if (matchingVideos.length === 0) {
        return [];
    }
    // Return the matching videos
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
                    <a href="/class-controls" v-if="props.auth.user.role === 'admin'">
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
                    <div class="flex justify-center relative">
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
                                                    <fwb-table-cell class="max-w-xs" :title="y.resource_name">
                                                        <fwb-heading class="text-md truncate">{{ y.resource_name }}
                                                        </fwb-heading>
                                                    </fwb-table-cell>
                                                    <fwb-table-cell :title="y.name">Rs. {{ y.price }}</fwb-table-cell>
                                                    <fwb-table-cell>
                                                        <fwb-button gradient="red" size="xs"
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
                                    <template #prefix>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                        </svg>
                                    </template>
                                    Buy
                                </fwb-button>

                            </div>
                        </template>
                    </fwb-modal>

                    <hr class="h-px my-6 bg-gray-200 border-2 dark:bg-gray-700">
                    <div v-if="activebutton === 'unit'" class="py-3">
                        <div class="px-12 pb-12">
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
                                                <fwb-table-row v-if="y.category == 'theory'">
                                                    <fwb-table-cell>
                                                        <fwb-heading style="font-size: medium;">{{ y.resource_name }}
                                                        </fwb-heading>
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
                                                    <fwb-heading style="font-size: medium;">{{ y.resource_name }}
                                                    </fwb-heading>
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
                                    </template>
                                </fwb-table-body>
                            </fwb-table>
                        </div>
                    </div>
                    <div v-if="activebutton === 'paper'" style=" overflow-x: auto; max-height: 75vh;">
                        <div class="p-12">
                            <fwb-table striped>
                                <fwb-table-body>
                                    <template v-for="(y, index) in objectarray" :key="index">
                                        <fwb-table-row v-if="y.category == 'paper'">
                                            <fwb-table-cell>
                                                <fwb-heading style="font-size: medium;">{{ y.resource_name }} </fwb-heading>
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
                    <div v-if="activebutton === 'myresources'">
                        <div class="p-12">
                            <fwb-accordion>
                                <template v-if="boughtArray.length > 0">
                                    <fwb-accordion-panel v-for="(y, index) in boughtArray" :key="index">
                                        <fwb-accordion-header>
                                            <div style="display: flex; justify-content: space-between; width: 100%">
                                                <span class="truncate max-w-xs" :title="y.resource_name">{{ y.resource_name }}</span>
                                                <span>Days Left: {{ calculateExpireDate(y.expiry_date) }}</span>
                                                <span class="text-gray-500 dark:text-gray-400">
                                                    Expire Date: <span class="font-bold">{{ new
                                                        Date(y.expiry_date).toLocaleDateString('en-US',
                                                        { year: 'numeric', month: '2-digit', day: '2-digit' }) }} |</span>
                                                    Time: <span class="font-bold">{{ new
                                                        Date(y.expiry_date).toLocaleTimeString('en-US', {
                                                            hour:
                                                        '2-digit', minute: '2-digit', hour12: false })
                                                        }}</span>
                                                </span>
                                            </div>
                                        </fwb-accordion-header>
                                        <fwb-accordion-content>
                                            <div v-if="getVideosByResourceId(y.resource_id).length>0"
                                                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4">
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
                                    <p>You haven't bought any resources</p>
                                </template>
                            </fwb-accordion>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>