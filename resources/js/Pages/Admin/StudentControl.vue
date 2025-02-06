<script setup>
import Sidebar from '@/Layouts/Sidebar.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref, computed } from 'vue';
import {
    FwbA,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
    FwbSelect,
    FwbButton,
    FwbInput,
    FwbHeading,
    FwbTooltip,
    FwbAccordion,
    FwbAccordionContent,
    FwbAccordionHeader,
    FwbAccordionPanel,
    FwbBadge,
    FwbPagination,
    FwbModal,
    FwbTextarea 
} from 'flowbite-vue'

const currentPage = ref(1)
const itemsPerPage = ref(15) // Number of items per page

// Function to generate a unique email
const generateUniqueEmail = (index) => {
    return `user${index}@example.com`;
};

// Reactive arrays for extendDate and studata
const extendDate = ref([]);
const studata = ref([]);
function generatedata() {
    for (let i = 1; i <= 40; i++) {
        const email = generateUniqueEmail(i);

        // Add to extendDate
        extendDate.value.push({
            email: email,
            count: Math.floor(Math.random() * 20 + 1).toString(), // Random count between 1 and 20
        });

        // Add to studata
        studata.value.push({
            name: `User ${i}`,
            email: email,
            phoneNumber: `+1 ${Math.floor(Math.random() * 1000000000)}`, // Random phone number
            examYear: 2023 + (i % 3), // Random exam year between 2023 and 2025
            fatherNumber: `+1 ${Math.floor(Math.random() * 1000000000)}`, // Random father's phone number
            momNumber: `+1 ${Math.floor(Math.random() * 1000000000)}`, // Random mother's phone number
            nic: `${Math.floor(Math.random() * 1000000000)}V`, // Random NIC
            address: `${i} Random Street, City, Country`, // Random address
        });
    }
}
// Generate 20 unique records for extendDate and studata

onMounted(() => {
    generatedata();
    createarray()
    console.log(showarray.value)
})
const showarray = ref([])
const seacrharray = ref([])
function createarray() {
    showarray.value = studata.value.filter(student =>
        extendDate.value.some(extendItem => extendItem.email === student.email)
    ).map(student => {
        const matchedExtendData = extendDate.value.find(extendItem =>
            extendItem.email === student.email
        )
        return {
            ...student,
            ...matchedExtendData
        }
    })
    seacrharray.value = showarray.value
}

const indexof = ref(null)
function moredetails(index) {
    if (index == indexof.value) {
        indexof.value = null;
    } else {
        indexof.value = index;
    }

}

const query = ref("")
function getkey() {
    currentPage.value = 1 // Reset to first page on search
    if (query.value.length > 0) {
        seacrharray.value = showarray.value.filter(stu =>
            stu.name.toLowerCase().includes(query.value.toLowerCase())
        );
    } else {
        seacrharray.value = showarray.value
    }
}

const isextended = ref(null)
function extentedStundents() {
    currentPage.value = 1 // Reset to first page on filtering
    seacrharray.value = seacrharray.value.filter(student => student.count > 7);
    if (isextended.value == null) {
        isextended.value = true;
        return;
    }
    if (!isextended.value) {
        isextended.value = true;
    } else {
        isextended.value = false;
        getkey();
    }
}

// Computed property for paginated results
const paginatedArray = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value
    const end = start + itemsPerPage.value
    return seacrharray.value.slice(start, end)
})

// Computed property for total pages
const totalPages = computed(() => {
    return Math.ceil(seacrharray.value.length / itemsPerPage.value)
})

function validatenumber(event) {
    const value = event.target.value;
    // Allow only numbers
    event.target.value = value.replace(/[^\d]/g, '');
}
function iscountempty(item) {
    return seacrharray.value.filter(student => student.count == 0).length > 0;
}

const isShowModal = ref(false)
const stuName = ref(null)
const stuemail = ref(null)
const videoName =ref(null)
const videoLink = ref(null)
const videoexDate = ref(null)


function closeModal() {
    stuName.value = null
    stuemail.value = null
    videoName.value = null
    videoLink.value = null
    videoexDate.value = null
    isShowModal.value = false
}
function showModal(item) {
    stuName.value = item.name
    stuemail.value = item.email
    isShowModal.value = true
}
</script>
<template>

    <Head title="Student Control Panel"></Head>
    <div>
        <Sidebar>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" :style="{ overflowY: 'auto', maxHeight: '95vh' }">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3">
                        <fwb-heading tag="h2" style="margin-bottom: 20px;">Students</fwb-heading>
                        <fwb-input v-on:input="getkey" class="max-w-sm mx-auto" v-model="query"
                            placeholder="Find student by name">
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
                        <div class="flex justify-end mb-4">
                            <fwb-button gradient="green-blue" @click="extentedStundents" class="flex justify-end mb-4">View
                                <span v-if="!isextended" >
                                    Extended
                                </span>
                                <span v-if="isextended">
                                    All
                                </span>
                                Stundents</fwb-button>
                        </div>
                        <fwb-table striped style="max-width: 1200px; margin: 20px 0 20px 0 ;">
                            <fwb-table-head>
                                <fwb-table-head-cell>Name</fwb-table-head-cell>
                                <fwb-table-head-cell>Email</fwb-table-head-cell>
                                <fwb-table-head-cell>Phone Number</fwb-table-head-cell>
                                <fwb-table-head-cell>Exam Year</fwb-table-head-cell>
                                <fwb-table-head-cell>More details</fwb-table-head-cell>
                                <fwb-table-head-cell>Delete student</fwb-table-head-cell>
                            </fwb-table-head>
                            <fwb-table-body>
                                <template v-for="(stu, index) in paginatedArray" :key="index">
                                    <fwb-table-row>
                                        <fwb-table-cell>{{ stu.name }}
                                            <fwb-badge href="#" size="sm" v-if="parseInt(stu.count) > 7"
                                                style="max-width: 60%; margin-top: 5px;">
                                                Extended
                                            </fwb-badge>
                                        </fwb-table-cell>
                                        <fwb-table-cell>{{ stu.email }}</fwb-table-cell>
                                        <fwb-table-cell>{{ stu.phoneNumber }}</fwb-table-cell>
                                        <fwb-table-cell>{{ stu.examYear }}</fwb-table-cell>
                                        <fwb-table-cell>
                                            <fwb-button @click="moredetails(index)" gradient="teal"
                                                style="margin-right: 50%; ">View</fwb-button>
                                        </fwb-table-cell>
                                        <fwb-table-cell>
                                            <fwb-button @click="remove(index)" gradient="red"
                                                style="margin-right : 50%; ">
                                                Delete
                                            </fwb-button>
                                        </fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row v-if="indexof == index">
                                        <fwb-table-cell :colspan="6">
                                            <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="space-y-2">
                                                        <div class="flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 mr-2 text-blue-500" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            <span class="font-semibold text-gray-700">NIC:</span>
                                                            <span class="ml-2 text-gray-600">{{ stu.nic }}</span>
                                                        </div>

                                                        <div class="flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 mr-2 text-green-500" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            </svg>
                                                            <span class="font-semibold text-gray-700">Address:</span>
                                                            <p class="ml-2 text-gray-600">{{ stu.address }}</p>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 mr-2 text-yellow-500" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M4 6h11a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z" />
                                                            </svg>
                                                            <fwb-button color="yellow" pill @click="showModal(stu)">Add
                                                                extra
                                                                lessons</fwb-button>
                                                        </div>
                                                    </div>

                                                    <div class="space-y-2">
                                                        <div class="flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 mr-2 text-purple-500" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                            </svg>
                                                            <span class="font-semibold text-gray-700">Father's
                                                                Number:</span>
                                                            <span class="ml-2 text-gray-600">{{ stu.fatherNumber
                                                                }}</span>
                                                        </div>

                                                        <div class="flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 mr-2 text-pink-500" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                            </svg>
                                                            <span class="font-semibold text-gray-700">Mother's
                                                                Number:</span>
                                                            <span class="ml-2 text-gray-600">{{ stu.momNumber }}</span>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 mr-2 text-blue-500" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            <span class="font-semibold text-gray-700">Date
                                                                Count: &nbsp;&nbsp;</span>
                                                            <fwb-input v-model="stu.count" @input="validatenumber"
                                                                placeholder="Enter count" size="sm" />
                                                            <fwb-button style="margin-left: 10px;" gradient="green"
                                                                :disabled="!stu.count > 0" pill>Save
                                                                Changes</fwb-button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fwb-table-cell>
                                    </fwb-table-row>
                                </template>
                            </fwb-table-body>
                        </fwb-table>
                        <div class="flex justify-center mt-4">
                            <fwb-pagination v-model="currentPage" :total-pages="totalPages" show-icons></fwb-pagination>
                        </div>
                    </div>
                </div>
            </div>
            <fwb-modal v-if="isShowModal" @close="closeModal">
                <template #header>
                    <div class="flex items-center text-lg">
                        Add Extra Lessons
                    </div>
                </template>
                <template #body>
                    <fwb-heading tag="h6">Student name : {{ stuName }}</fwb-heading>
                    <fwb-heading tag="h6" class="mb-2">Stundent Email : {{ stuemail }}</fwb-heading>
                    <hr>
                    <fwb-input v-model="videoName" label="Video name" placeholder="enter your name" size="sm" class="mb-2 mt-2" />
                    
                    <fwb-textarea v-model="videoLink" :rows="4" label="URL"
                        placeholder="Paste URL" class="mb-2" />
                                        
                    <label for="email"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white mt-1">Expiry date</label>
                                        
                    <input type="date"
                        class="border bg-gray-50 border-gray-300 rounded-lg p-1 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        v-model="videoexDate">
                </template>
                <template #footer>
                    <div class="flex justify-between">
                        <fwb-button @click="closeModal" color="alternative" >
                            Close
                        </fwb-button>
                        <fwb-button @click="closeModal" color="green" :disabled ="!videoLink || !videoexDate">
                            Save
                        </fwb-button>
                    </div>
                </template>
            </fwb-modal>
        </Sidebar>
    </div>
</template>
<style scoped></style>