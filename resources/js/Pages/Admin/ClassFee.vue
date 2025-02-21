<script setup>
import Sidebar from '@/Layouts/Sidebar.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import {
    FwbA,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
    FwbButton,
    FwbModal,
    FwbInput,
    FwbAlert,
    FwbTab, 
    FwbTabs,
    FwbHeading
} from 'flowbite-vue';

const activeTab = ref('first');

const Arrays = defineProps({
    results: Array,
});

function addbr(classes){
    if(classes == null){
        return "No Classes";
    }else{
        return classes.split(',').join('<br>');
    }
}

function getFilePath(filePath) {
  // Construct the URL using the base path
  return `${import.meta.env.VITE_APP_BASE_URL}/storage/${filePath}`;
}

const keyword1 = ref('');
const no_filteredItems = computed(() => {
    const lowerKeyword = keyword1.value.toLowerCase();
    return Arrays.results.filter(obj =>
        obj.student_name.toLowerCase().includes(lowerKeyword) ||
        obj.user_email.toLowerCase().includes(lowerKeyword)
    );
});

const keyword2 = ref('');
const yes_filteredItems = computed(() => {
    const lowerKeyword = keyword2.value.toLowerCase();
    return Arrays.results.filter(obj =>
        obj.student_name.toLowerCase().includes(lowerKeyword) ||
        obj.user_email.toLowerCase().includes(lowerKeyword)
    );
});

function unpaidCount() {
    return Arrays.results.filter(item => item.paid === 'no').length;
}

function paidCount() {
    return Arrays.results.filter(item => item.paid === 'yes').length;
}

function deleteSlipData() {
    const choice = confirm('Are you sure you want to proceed with the deletion ?');
    if (choice) {
        router.visit('/classfees/delete/slips', { method: 'delete' });
    }
}


// modal view controles
const isShowModal = ref(false)
const tomodel = ref('')

function closeModal() {
    isShowModal.value = false
}

const showModal = (item) => {
    tomodel.value = item;
    isShowModal.value = true;
}

const form1 = useForm({
    slipID: ''
})

function confirmDelete(id) {
    const confirmed = confirm('Are you sure you want to delete this slip?');
    if (confirmed) {
        form1.slipID = id;
        form1.delete('/classfees/delete-slip', {
        preserveScroll: false,
    });
    }
}

</script>

<template>
    <Head title="Monthly Payments" />

        <Sidebar>
        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8" :style="{ overflowY: 'auto', maxHeight: '85vh' }">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3 mb-4">
                    <div class="grid grid-cols-4 gap-4">
                        <div class="text-sm py-2 px-7 col-span-3">
                            Please proceed with caution as this will permanently remove all slip data from the database
                            from which there is no way to retrieve it.
                        </div>
                        <div class="py-2 px-7">
                            <fwb-button color="red" class="ml-12" @click="deleteSlipData">Delete All Slips</fwb-button>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3">
                    <fwb-heading tag="h4" size="lg" class="pl-4 pt-4 pb-6">
                        Monthly Payments
                    </fwb-heading>
                    <!--main  content -->
                    <fwb-tabs v-model="activeTab" class="p-4" variant="underline">
                        <fwb-tab name="first" title="Accept Payments">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 bg-slate-200 pt-8">
                                <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
                                    <div>
                                        <h2 class="text-xl font-bold pb-4">Payments to be Accepted</h2>
                                    </div>
                                    <label for="table-search" class="sr-only">Search</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        <input type="text"  v-model="keyword1" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search from name or email">
                                    </div>
                                </div>
                                <fwb-table hoverable>
                                    <fwb-table-head>
                                        <fwb-table-head-cell>Name
                                            &nbsp;
                                        <span
                                            class="inline-flex items-center justify-center w-5 h-5 me-2 text-sm font-semibold text-white bg-gray-500 rounded-full dark:bg-gray-700 dark:text-gray-300">
                                            {{ unpaidCount() }}
                                        </span>
                                        </fwb-table-head-cell>
                                        <fwb-table-head-cell>Email</fwb-table-head-cell>
                                        <fwb-table-head-cell>Joined Classes</fwb-table-head-cell>
                                        <fwb-table-head-cell>Paid Classes</fwb-table-head-cell>
                                        <fwb-table-head-cell>Slip Data</fwb-table-head-cell>
                                        <fwb-table-head-cell>Action</fwb-table-head-cell>
                                    </fwb-table-head>
                                    <fwb-table-body>
                                        <template v-if="unpaidCount() > 0">
                                            <template v-if="no_filteredItems.length > 0">
                                                <fwb-table-row v-for="element in no_filteredItems" :key="element.slip_id">
                                                    <template v-if="element.paid == 'no'">
                                                        <fwb-table-cell>{{ element.student_name }}</fwb-table-cell>
                                                        <fwb-table-cell>{{ element.user_email }}</fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <div v-html="addbr(element.joined_classes)"></div>
                                                        </fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <div v-html="addbr(element.paid_classes)"></div>
                                                        </fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <fwb-button color="default" @click="showModal(element)" class="whitespace-nowrap px-3 py-1" outline>Slip Details</fwb-button>
                                                        </fwb-table-cell>
                                                        <fwb-table-cell class="flex justify-center">
                                                            <Link href="/classfees" method="patch" :data="{ slipID: element.slip_id, paidClasses: element.paid_classes, stID: element.stID }" as="button" type="button" class="text-gray-900 bg-gradient-to-r from-lime-200 via-lime-400 to-lime-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-lime-300 dark:focus:ring-lime-800 font-medium rounded-lg text-sm px-4 py-1.5 text-center">
                                                                Accept
                                                            </Link>
                                                            <Link href="" @click="confirmDelete(element.slip_id)" as="button" type="button" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-2.5 text-center ml-1.5">
                                                                <svg class="w-4 h-4 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                                </svg>
                                                            </Link>
                                                        </fwb-table-cell>
                                                    </template>
                                                </fwb-table-row>
                                            </template>
                                            <template v-else>
                                                <fwb-table-row>
                                                    <fwb-table-cell colspan="6">
                                                        <fwb-alert class="border-t-4 rounded-none" icon type="warning">
                                                            There is no name or email '{{ keyword1 }}'
                                                        </fwb-alert>
                                                    </fwb-table-cell>
                                                </fwb-table-row>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <fwb-table-row>
                                                <fwb-table-cell colspan="6">
                                                    <fwb-alert type="dark" class="text-left hover:bg-gray-100">
                                                        No Records available
                                                    </fwb-alert>
                                                </fwb-table-cell>
                                            </fwb-table-row>
                                        </template>
                                    </fwb-table-body>
                                </fwb-table>
                            </div>
                        </fwb-tab>
                        <fwb-tab name="Second" title="Undo Payments">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 bg-slate-200 pt-8">
                                <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
                                    <div>
                                        <h2 class="text-xl font-bold pb-4">Accepted Payments</h2>
                                    </div>
                                    <label for="table-search" class="sr-only">Search</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        <input type="text"  v-model="keyword2" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search from name or email">
                                    </div>
                                </div>
                                <fwb-table hoverable>
                                    <fwb-table-head>
                                        <fwb-table-head-cell>Name
                                            &nbsp;
                                        <span
                                            class="inline-flex items-center justify-center w-5 h-5 me-2 text-sm font-semibold text-white bg-gray-500 rounded-full dark:bg-gray-700 dark:text-gray-300">
                                            {{ paidCount() }}
                                        </span>
                                        </fwb-table-head-cell>
                                        <fwb-table-head-cell>Email</fwb-table-head-cell>
                                        <fwb-table-head-cell>Joined Classes</fwb-table-head-cell>
                                        <fwb-table-head-cell>Paid Classes</fwb-table-head-cell>
                                        <fwb-table-head-cell>Slip Data</fwb-table-head-cell>
                                        <fwb-table-head-cell>Action</fwb-table-head-cell>
                                    </fwb-table-head>
                                    <fwb-table-body>
                                        <template v-if="paidCount() > 0">
                                            <template v-if="yes_filteredItems.length > 0">
                                                <fwb-table-row v-for="element in yes_filteredItems" :key="element.slip_id">
                                                    <template v-if="element.paid == 'yes'">
                                                        <fwb-table-cell>{{ element.student_name }}</fwb-table-cell>
                                                        <fwb-table-cell>{{ element.user_email }}</fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <div v-html="addbr(element.joined_classes)"></div>
                                                        </fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <div v-html="addbr(element.paid_classes)"></div>
                                                        </fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <fwb-button color="default" class="whitespace-nowrap px-3 py-1" @click="showModal(element)" outline>Slip Details</fwb-button>
                                                        </fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <Link href="/classfees/undo-payment" method="patch" :data="{ slipID: element.slip_id, paidClasses: element.paid_classes, stID: element.stID }" as="button" type="button" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-4 py-1.5 text-center">
                                                                Undo
                                                            </Link>
                                                        </fwb-table-cell>
                                                    </template>
                                                </fwb-table-row>
                                            </template>
                                            <template v-else>
                                                <fwb-table-row>
                                                    <fwb-table-cell colspan="6">
                                                        <fwb-alert class="border-t-4 rounded-none" icon type="warning">
                                                            There is no name or email '{{ keyword2 }}'
                                                        </fwb-alert>
                                                    </fwb-table-cell>
                                                </fwb-table-row>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <fwb-table-row>
                                                <fwb-table-cell colspan="6">
                                                    <fwb-alert type="dark" class="text-left hover:bg-gray-100">
                                                        No Records available
                                                    </fwb-alert>
                                                </fwb-table-cell>
                                            </fwb-table-row>
                                        </template>
                                    </fwb-table-body>
                                </fwb-table>
                            </div>
                        </fwb-tab>
                    </fwb-tabs>
                    <!-- conetent ends -->


                    <fwb-modal v-if="isShowModal" @close="closeModal" size="4xl">
                        <template #header>
                            <div class="flex items-center text-lg">
                                Slip details
                            </div>
                        </template>
                        <template #body>
                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                Student email - {{ tomodel.user_email }} | Name - {{
                                    tomodel.student_name }}
                            </p>
                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                Note - {{ tomodel.slip_note }}
                            </p>
                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                Slip upload data and time - {{
                                    tomodel.payment_date
                                }}
                            </p>
                            <iframe allowfullscreen :src="getFilePath(tomodel.slip_url)" class="w-full h-80"
                                frameborder="0"></iframe>
                        </template>
                        <template #footer>
                            <div class="flex justify-between">
                                <a :href="getFilePath(tomodel.slip_url)" target="_blanck">
                                    <fwb-button color="alternative">
                                        View full screen
                                    </fwb-button>
                                </a>
                                <fwb-button @click="closeModal" color="green">
                                    Close
                                </fwb-button>
                            </div>
                        </template>
                    </fwb-modal>

                </div>
            </div>
        </div>
        </Sidebar>
</template>