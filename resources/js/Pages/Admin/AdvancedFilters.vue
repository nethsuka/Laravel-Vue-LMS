<script setup>
import Sidebar from '@/Layouts/Sidebar.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref, computed, watch } from 'vue';
import {
    FwbA,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
    FwbP,
    FwbHeading,
    FwbBadge,
    FwbButton,
    FwbInput,
    FwbCheckbox,
    FwbPagination
} from 'flowbite-vue'

const Arrays = defineProps({
    studentAndPaymentDetails: Array,
    classDetails: Array,
});

const classes = Arrays.classDetails

const stu = ref(Arrays.studentAndPaymentDetails);
const showarray = ref([]);
const seacrharray = ref([]);
const query = ref("");
const selectedClasses = ref(new Array(classes.length).fill(false));
const checkall = ref(true);
const paymentFilter = ref('all');

function creatArray() {
    const tempArray = [];
    for (let raw of stu.value) {
        const existingStudent = tempArray.find(item => item.student_name === raw.student_name);
        if (!existingStudent) {
            tempArray.push({
                student_name: raw.student_name,
                email: raw.email,
                exam_year: raw.exam_year,
                w_number: raw.w_number,
                class: [
                    { name: raw.class_name, paid: raw.payment_status }
                ]
            });
        } else {
            existingStudent.class.push({ name: raw.class_name, paid: raw.payment_status });
        }
    }
    showarray.value = tempArray;
    seacrharray.value = tempArray;
}

// Computed property for selected class items
const selectedItems = computed(() =>
    classes.filter((_, index) => selectedClasses.value[index])
);

// Step 1: Filter by search query
const searchFiltered = computed(() => {
    if (!query.value || typeof query.value !== 'string') return showarray.value;

    const searchTerm = query.value.toLowerCase();
    return showarray.value.filter(student =>
        student.student_name.toLowerCase().includes(searchTerm)
    );
});

// Step 2: Filter by selected classes
const classFiltered = computed(() => {
    if (selectedItems.value.length === 0) return searchFiltered.value;

    return searchFiltered.value.filter((student) =>
        selectedItems.value.every(selectedClass =>
            student.class.some(cls => cls.name === selectedClass)
        )
    );
});

// Step 3: Filter by payment status
const finalFiltered = computed(() => {
    if (paymentFilter.value === 'all') return classFiltered.value;

    if (selectedItems.value.length === 0) {
        return classFiltered.value.filter(student =>
            student.class.every(cl =>
                cl.paid === (paymentFilter.value === 'paid' ? 'yes' : 'no')
            )
        );
    }

    return classFiltered.value.filter((student) =>
        selectedItems.value.every(selectedClass =>
            student.class.some(cls =>
                cls.name === selectedClass &&
                cls.paid === (paymentFilter.value === 'paid' ? 'yes' : 'no')
            )
        )
    );
});

// Update seacrharray whenever finalFiltered changes
watch(finalFiltered, (newValue) => {
    seacrharray.value = newValue;
});

// Handler functions
function updateSearch(event) {
    currentPage.value = 1
    query.value = typeof event === 'object' ? event.target.value : event;
}

function handleClassFilter(index) {
    currentPage.value = 1
    // Create a new array with the updated value
    const newSelectedClasses = [...selectedClasses.value];
    newSelectedClasses[index] = !newSelectedClasses[index];

    // If any class is being checked, uncheck "All class"
    if (newSelectedClasses[index]) {
        checkall.value = false;
    } else {
        // If no classes are selected, check "All class"
        const noClassesSelected = newSelectedClasses.every(value => !value);
        if (noClassesSelected) {
            checkall.value = true;
        }
    }
    selectedClasses.value = newSelectedClasses;
}
function handleCheckAll() {
    currentPage.value = 1
    selectedClasses.value = new Array(classes.length).fill(false);
    checkall.value = true;
}
function handlePaymentFilter(value) {
    currentPage.value = 1
    if (value === 'all') {
        paymentFilter.value = 'all';
    } else {
        // If clicking paid or nonpaid, uncheck 'all'
        if (value === paymentFilter.value) {
            // If clicking the same checkbox, switch to 'all'
            paymentFilter.value = 'all';
        } else {
            // If clicking a different checkbox, switch to that value
            paymentFilter.value = value;
        }
    }
}
// Initialize with all classes unchecked and "All class" checked
onMounted(() => {
    creatArray();
    // Initialize with default states
    selectedClasses.value = new Array(classes.length).fill(false);
    checkall.value = true;
    paymentFilter.value = 'all';
});



function forpamentfilter(item){
    if(item === paymentFilter.value){
        return true;
    }
    return false;
}
const currentPage = ref(1)
const itemsPerPage = ref(15)
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
</script>

<template>

    <Head title="Student's Classes"></Head>
    <div>
        <Sidebar>
            <div class="py-12">
                <div class="max-w-6xl mx-auto sm:px-6 lg:px-8" :style="{ overflowY: 'auto', maxHeight: '85vh' }">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3 mb-4">
                        <fwb-heading tag="h2" style="margin-bottom: 20px;">Students' Classes</fwb-heading>
                        <fwb-input v-model="query" @input="updateSearch" class="max-w-sm mx-auto"
                            placeholder="Find student by name">
                            <template #prefix>
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </template>
                        </fwb-input>

                        <div class="mt-4 space-x-4">
                            <fwb-heading tag="h6">According to classes</fwb-heading>
                            <div class="flex flex-wrap gap-4 mt-2">
                                <template v-for="(cl, index) in classes" :key="index">
                                    <fwb-checkbox :modelValue="selectedClasses[index]"
                                        @change="handleClassFilter(index)" :label="cl" />
                                </template>
                                <fwb-checkbox v-model="checkall" @change.prevent="handleCheckAll" label="All class" />
                            </div>
                        </div>

                        <div class="mt-4 space-x-4">
                            <fwb-heading tag="h6">According to payment status</fwb-heading>
                            <div class="flex flex-wrap gap-4 mt-2">
                                <fwb-checkbox :modelValue="forpamentfilter('paid')"
                                    @change="handlePaymentFilter('paid')" label="Paid students" />
                                <fwb-checkbox :modelValue="forpamentfilter('nonpaid')"
                                    @change="handlePaymentFilter('nonpaid')" label="Non paid students" />
                                <fwb-checkbox :modelValue="forpamentfilter('all')" @change="handlePaymentFilter('all')"
                                    label="Paid or Non paid students" />

                            </div>
                        </div>


                        <fwb-table striped class="mt-4">
                            <fwb-table-head>
                                <fwb-table-head-cell>
                                    Name &nbsp;
                                    <span
                                        class="inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">
                                        {{ seacrharray.length }}<span class="sr-only">Icon description</span>
                                    </span>
                                </fwb-table-head-cell>
                                <fwb-table-head-cell>Email</fwb-table-head-cell>
                                <fwb-table-head-cell>Phone Number</fwb-table-head-cell>
                                <fwb-table-head-cell>Exam Year</fwb-table-head-cell>
                                <fwb-table-head-cell>Classes</fwb-table-head-cell>
                            </fwb-table-head>
                            <fwb-table-body v-if="paginatedArray.length > 0">
                                <fwb-table-row v-for="(st, index) in paginatedArray" :key="index">
                                    <fwb-table-cell>{{ index + 1 }}. &nbsp; {{ st.student_name }}</fwb-table-cell>
                                    <fwb-table-cell>{{ st.email }}</fwb-table-cell>
                                    <fwb-table-cell>{{ st.w_number }}</fwb-table-cell>
                                    <fwb-table-cell>{{ st.exam_year }}</fwb-table-cell>
                                    <fwb-table-cell>
                                        <template v-for="(cl, index) in st.class" :key="index">
                                            <fwb-p class="flex items-center gap-2 text-xs">
                                                {{ cl.name }}:
                                                <fwb-badge type="red" v-if="cl.paid === 'no'">Not paid</fwb-badge>
                                                <fwb-badge v-else>Paid</fwb-badge>
                                            </fwb-p>
                                        </template>
                                    </fwb-table-cell>
                                </fwb-table-row>
                            </fwb-table-body>
                            <fwb-table-body v-else>
                                <fwb-table-row>
                                    <fwb-table-cell colspan="5">No data found</fwb-table-cell>
                                </fwb-table-row>
                            </fwb-table-body>
                        </fwb-table>
                        <div class="flex justify-center mt-4">
                            <fwb-pagination v-model="currentPage" :total-pages="totalPages" show-icons></fwb-pagination>
                        </div>
                    </div>
                </div>
            </div>
        </Sidebar>
    </div>
</template>