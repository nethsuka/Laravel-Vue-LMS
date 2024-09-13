<script setup>
import Sidebar from '@/Layouts/Sidebar.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted , watch} from 'vue';
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
    FwbTab, FwbTabs
} from 'flowbite-vue'

const Arrays = defineProps({
    results: Array,
});

const activeTab = ref('first')

function creating_no_array() {
    no_array.value = Arrays.results.filter((y) => y.paid === 'no');
}

function creating_yes_array(){
    yes_array.value = Arrays.results.filter((y) => y.paid === 'yes');
}

watch(activeTab, (newTab) => {
    if (newTab === 'Second') {
        creating_yes_array();
    }
});

onMounted(() => {
  creating_no_array();
})

const no_array = ref([])
const yes_array = ref([])
const isShowModal = ref(false)
const search_name = ref('')
const showarray = ref([])
const tomodel = ref('')

function closeModal() {
    isShowModal.value = false
}

const showModal = (item) => {
    tomodel.value = item;
    isShowModal.value = true;
}

const serching = (evt) => {
    showarray.value = []
    if (search_name.value.length > 0) {
        for (let y of no_array.value) {
            if (y.student_name.toLowerCase().includes(search_name.value.toLowerCase())
                || y.user_email.toLowerCase().includes(search_name.value.toLowerCase())
            ) {
                showarray.value.push(y);
            }
        }
    }
}

const serching_yes = (evt) =>{
    showarray.value = []
    if (search_name.value.length > 0) {
        for (let y of yes_array.value) {
            if (y.student_name.toLowerCase().includes(search_name.value.toLowerCase())
            || y.user_email.toLowerCase().includes(search_name.value.toLowerCase())
            ){
                showarray.value.push(y);
            }
        }
    }
}

const form = useForm({
    slipID: '',
})

function acceptPayment(slip_ID) {
    form.slipID = slip_ID;
    form.post('/classfees');
    no_array.value = no_array.value.filter((item) => item.slip_id !== slip_ID);
    serching()
}

function undoPayment(slip_ID) {
    form.slipID = slip_ID;
    form.post('/classfees/undo-payment');
    yes_array.value = yes_array.value.filter((item) => item.slip_id !== slip_ID);
    serching()
}

function addbr(classes) {
    return classes.split(',').join('<br>');
}

function getFilePath(filePath) {
    // Construct the URL using the base path
    return `${import.meta.env.VITE_APP_BASE_URL}/storage/${filePath}`;
}

</script>

<template>

    <Head title="Admin Panel" />

    <Sidebar>
        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8" :style="{ overflowY: 'auto', maxHeight: '85vh' }">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3">
                    <fwb-tabs v-model="activeTab" class="p-5" variant="underline">
                        <fwb-tab name="first" title="Accept Payments" >
                            <!--main  content -->
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 bg-slate-200 pt-8">
                                <div
                                    class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
                                    <div>
                                        <h2 class="text-xl font-bold pb-4">Payments to be Accepted</h2>
                                    </div>
                                    <div class="relative">
                                        <fwb-input v-model="search_name" placeholder="Search for records"
                                            v-on:input="serching">
                                            <template #prefix>
                                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" />
                                                </svg>
                                            </template>
                                        </fwb-input>
                                    </div>
                                </div>
                                <fwb-table hoverable>
                                    <fwb-table-head>
                                        <fwb-table-head-cell>Student Name</fwb-table-head-cell>
                                        <fwb-table-head-cell>Email</fwb-table-head-cell>
                                        <fwb-table-head-cell>Joined Classes</fwb-table-head-cell>
                                        <fwb-table-head-cell>Paid Classes</fwb-table-head-cell>
                                        <fwb-table-head-cell>Slip Data</fwb-table-head-cell>
                                        <fwb-table-head-cell>Action</fwb-table-head-cell>
                                    </fwb-table-head>
                                    <fwb-table-body>
                                        <template v-if="search_name.length > 0">
                                            <template v-if="showarray.length > 0">
                                                <template v-for="(i, index) in showarray" :key="index">
                                                    <fwb-table-row v-if="i.paid == 'no'">
                                                        <!-- <template v-if="element.paid == 'no'"></template> -->
                                                        <fwb-table-cell>{{ i.student_name }}</fwb-table-cell>
                                                        <fwb-table-cell>{{ i.user_email }}</fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <div v-html="addbr(i.joined_classes)"></div>
                                                        </fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <div v-html="addbr(i.paid_classes)"></div>
                                                        </fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <fwb-button color="default" class="whitespace-nowrap px-3 py-1" @click="showModal(i)" outline>Slip Details</fwb-button>
                                                        </fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <button type="button" @click="acceptPayment(i.slip_id)" class="text-gray-900 bg-gradient-to-r from-lime-200 via-lime-400 to-lime-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-lime-300 dark:focus:ring-lime-800 font-medium rounded-lg text-sm px-4 py-1.5 text-center">Accept</button>
                                                        </fwb-table-cell>
                                                    </fwb-table-row>
                                                </template>
                                            </template>
                                            <template v-else>
                                                <fwb-table-row>
                                                    <fwb-table-cell colspan="6">
                                                        <fwb-alert class="border-t-4 rounded-none" icon type="warning">
                                                            There is no item '{{ search_name }}'
                                                        </fwb-alert>
                                                    </fwb-table-cell>
                                                </fwb-table-row>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <template v-if="no_array.length > 0">
                                                <template v-for="(i, index) in Arrays.results" :key="index">
                                                    <fwb-table-row v-if="i.paid == 'no'">
                                                        <fwb-table-cell>{{ i.student_name }}</fwb-table-cell>
                                                        <fwb-table-cell>{{ i.user_email }}</fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <div v-html="addbr(i.joined_classes)"></div>
                                                        </fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <div v-html="addbr(i.paid_classes)"></div>
                                                        </fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <fwb-button color="default" class="whitespace-nowrap px-3 py-1" @click="showModal(i)" outline>Slip Details</fwb-button>
                                                        </fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <button type="button" @click="acceptPayment(i.slip_id)" class="text-gray-900 bg-gradient-to-r from-lime-200 via-lime-400 to-lime-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-lime-300 dark:focus:ring-lime-800 font-medium rounded-lg text-sm px-4 py-1.5 text-center">Accept</button>
                                                        </fwb-table-cell>
                                                    </fwb-table-row>
                                                </template>
                                            </template>
                                            <template v-else>
                                                <fwb-table-row>
                                                    <fwb-table-cell colspan="6">
                                                        <fwb-alert type="dark" class="text-left hover:bg-gray-100">
                                                            No Records found
                                                        </fwb-alert>
                                                    </fwb-table-cell>
                                                </fwb-table-row>
                                            </template>
                                        </template>

                                    </fwb-table-body>
                                </fwb-table>
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
                                            <fwb-button @click="closeModal" color="alternative">
                                                Decline
                                            </fwb-button>
                                            <fwb-button @click="closeModal" color="green">
                                                I accept
                                            </fwb-button>
                                        </div>
                                    </template>
                                </fwb-modal>
                            </div>
                        </fwb-tab>
                        <fwb-tab name="Second" title="Undo Payments" >
                            <!--main  content -->
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 bg-slate-200 py-8">
                                <div
                                    class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
                                    <div>
                                        <h2 class="text-xl font-bold pb-4">Accepted Payments</h2> 
                                    </div>
                                    <div class="relative">
                                        <fwb-input v-model="search_name" placeholder="Search for records"
                                            v-on:input="serching_yes">
                                            <template #prefix>
                                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" />
                                                </svg>
                                            </template>
                                        </fwb-input>
                                    </div>
                                </div>
                                <fwb-table hoverable>
                                    <fwb-table-head>
                                        <fwb-table-head-cell>Student Name</fwb-table-head-cell>
                                        <fwb-table-head-cell>Email</fwb-table-head-cell>
                                        <fwb-table-head-cell>Joined Classes</fwb-table-head-cell>
                                        <fwb-table-head-cell>Paid Classes</fwb-table-head-cell>
                                        <fwb-table-head-cell>Slip Data</fwb-table-head-cell>
                                        <fwb-table-head-cell>Action</fwb-table-head-cell>
                                    </fwb-table-head>
                                    <fwb-table-body>
                                        <template v-if="search_name.length > 0">
                                            <template v-if="showarray.length > 0">
                                                <template v-for="(i, index) in showarray" :key="index">
                                                    <fwb-table-row v-if="i.paid == 'yes'">
                                                        <!-- <template v-if="element.paid == 'no'"></template> -->
                                                        <fwb-table-cell>{{ i.student_name }}</fwb-table-cell>
                                                        <fwb-table-cell>{{ i.user_email }}</fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <div v-html="addbr(i.joined_classes)"></div>
                                                        </fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <div v-html="addbr(i.paid_classes)"></div>
                                                        </fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <fwb-button color="default" class="whitespace-nowrap px-3 py-1" @click="showModal(i)" outline>Slip Details</fwb-button>
                                                        </fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <button type="button" @click="undoPayment(i.slip_id)" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-4 py-1.5 text-center">Undo</button>
                                                        </fwb-table-cell>
                                                    </fwb-table-row>
                                                </template>
                                            </template>
                                            <template v-else>
                                                <fwb-table-row>
                                                    <fwb-table-cell colspan="6">
                                                        <fwb-alert class="border-t-4 rounded-none" icon type="warning">
                                                            There is no item '{{ search_name }}'
                                                        </fwb-alert>
                                                    </fwb-table-cell>
                                                </fwb-table-row>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <template v-if="yes_array.length > 0">
                                                <template v-for="(i, index) in Arrays.results" :key="index">
                                                    <fwb-table-row v-if="i.paid == 'yes'">
                                                        <fwb-table-cell>{{ i.student_name }}</fwb-table-cell>
                                                        <fwb-table-cell>{{ i.user_email }}</fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <div v-html="addbr(i.joined_classes)"></div>
                                                        </fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <div v-html="addbr(i.paid_classes)"></div>
                                                        </fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <fwb-button color="default" class="whitespace-nowrap px-3 py-1" @click="showModal(i)" outline>Slip Details</fwb-button>
                                                        </fwb-table-cell>
                                                        <fwb-table-cell>
                                                            <button type="button" @click="undoPayment(i.slip_id)" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-4 py-1.5 text-center">Undo</button>
                                                        </fwb-table-cell>
                                                    </fwb-table-row>
                                                </template>
                                            </template>
                                            <template v-else>
                                                <fwb-table-row>
                                                    <fwb-table-cell colspan="6">
                                                        <fwb-alert type="dark" class="text-left">
                                                            No Records found
                                                        </fwb-alert>
                                                    </fwb-table-cell>
                                                </fwb-table-row>
                                            </template>
                                        </template>

                                    </fwb-table-body>
                                </fwb-table>
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
                                            Slip uploaded data and time - {{
                                                tomodel.payment_date
                                            }}
                                        </p>
                                        <iframe allowfullscreen :src="getFilePath(tomodel.slip_url)" class="w-full h-80"
                                            frameborder="0"></iframe>
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
                            </div>
                        </fwb-tab>
                    </fwb-tabs>
                </div>
            </div>
        </div>
    </Sidebar>
</template>