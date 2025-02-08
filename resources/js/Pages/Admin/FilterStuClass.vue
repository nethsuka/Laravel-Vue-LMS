<script setup>
import Sidebar from '@/Layouts/Sidebar.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref, nextTick } from 'vue';
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
    FwbCheckbox
} from 'flowbite-vue'

//assign class names from backend 
const classes = ["2025 Paper", "2025 Theory", "2026 Paper", "2026 Theory", "2027 Paper"]

// these arrays for generate demo data
const names = [
    "Thinula", "Kasun", "Nimal", "Saman", "Amal", "Ruwan", "Dilan", "Kavindu", "Isuru", "Chathura",
    "Lakshan", "Vimukthi", "Sandeepa", "Roshan", "Gayan", "Mahesh", "Nuwan", "Tharindu", "Ashen",
    "Janith", "Chaminda", "Sameera", "Heshan", "Sandun", "Pradeep", "Dinuka", "Charitha", "Ravindu",
    "Thushara", "Pubudu"
];
// these arrays for generate demo data
const classNames = ["2025 Paper", "2025 Theory", "2026 Paper", "2026 Theory", "2027 Paper"];
const paymentStatuses = ["yes", "no"];

function getRandomElement(arr) {
    return arr[Math.floor(Math.random() * arr.length)];
}

function generateRandomNumber() {
    return "07" + Math.floor(10000000 + Math.random() * 90000000); // Generates a random 10-digit Sri Lankan phone number
}

function generateStudents(count = 50) {
    for (let i = 0; i < count; i++) {
        let name = getRandomElement(names);
        stu.value.push({
            student_name: name,
            email: `${name.toLowerCase()}@gmail.com`,
            exam_year: Math.floor(Math.random() * 3) + 2025, // Random year from 2025 to 2027
            class_name: getRandomElement(classNames),
            payment_status: getRandomElement(paymentStatuses),
            w_number: generateRandomNumber()
        });
    }
}

const stu = ref([]);
const showarray = ref([])

onMounted(() => {
    generateStudents()
    creatArray()
    seacrharray.value = showarray.value
})
function creatArray() {
    for (let raw of stu.value) {
        if (!showarray.value.some(item => item.student_name === raw.student_name)) {
            let obj = {
                student_name: raw.student_name,
                email: raw.email,
                exam_year: raw.exam_year,
                w_number: raw.w_number,
                class: [
                    { name: raw.class_name, paid: raw.payment_status }
                ]
            }
            showarray.value.push(obj)
        } else {
            let index = showarray.value.findIndex(item => item.student_name === raw.student_name)
            if (index !== -1) {
                showarray.value[index].class.push({ name: raw.class_name, paid: raw.payment_status })
            }
        }
    }
}
const seacrharray = ref([])
const query = ref("")

//filter the searcharray , called only in serchbar 
function getkey() {
    // currentPage.value = 1 
    if (query.value.length > 0) {
        seacrharray.value = showarray.value.filter(stu =>
            stu.student_name.toLowerCase().includes(query.value.toLowerCase())
        );
    } else {
        seacrharray.value = showarray.value
    }
    classfilterSearch();
}
//filter the search array , called only in getkey function
function classfilterSearch() {
    checkall.value = false
    selectedItems.value = classes.filter((_, index) => selectedClasses.value[index])
    if (selectedItems.value.length > 0) {
        seacrharray.value = seacrharray.value.filter((st) =>
            st.class.some(cls => selectedItems.value.includes(cls.name))
        )

    } else {
        checkall.value = true
    }

}

//ref array for checkboxes
const selectedClasses = ref(new Array(classes.length).fill(false))

const checkall = ref(true)

function checkAll() {
    selectedClasses.value = new Array(classes.length).fill(false)
    getkeyforclassfilter()
}


//filter the searcharray , called only in classfilter function 
function getkeyforclassfilter() {
    // currentPage.value = 1 
    if (query.value.length > 0) {
        seacrharray.value = showarray.value.filter(stu =>
            stu.student_name.toLowerCase().includes(query.value.toLowerCase())
        );
    } else {
        seacrharray.value = showarray.value
    }
}

const selectedItems = ref([])
//filter the class based on checkboxes and called only in chechboxes
function classfilter() {
    checkall.value = false
    selectedItems.value = classes.filter((_, index) => selectedClasses.value[index])
    getkeyforclassfilter();
    if (selectedItems.value.length > 0) {
        seacrharray.value = seacrharray.value.filter((st) =>
            st.class.some(cls => selectedItems.value.includes(cls.name))
        )

    } else {
        checkall.value = true
    }

}

// In the script setup section:
const paymentFilter = ref('all') // Default value is 'all'
//filter the class base on paid statment and called in checkboxes
function handlePaymentFilter(value) {
    // Only update if the checkbox is being checked
    if (value === paymentFilter.value) {
        paymentFilter.value = 'all'
        classfilter()
    } else {
        paymentFilter.value = value
    }
    // Apply payment filter
    if (paymentFilter.value === 'paid') {
        if (selectedItems.value == 0) {
            seacrharray.value = seacrharray.value.filter(student =>
                student.class.every(cl => cl.paid === 'yes')
            )
        } else {
            // seacrharray.value = seacrharray.value.filter((student, index) => selectedItems.value.includes(student.class[0].name) && student.class.some(cl => cl.paid === 'yes'))
            seacrharray.value = seacrharray.value.filter((student) =>
                selectedItems.value.every(selectedClass =>
                    student.class.some(cls =>
                        cls.name === selectedClass && cls.paid === 'yes'
                    )
                )
            );

        }
    } else if (paymentFilter.value === 'nonpaid') {
        if (selectedItems.value.length == 0) {
            seacrharray.value = seacrharray.value.filter(student =>
                student.class.every(cl => cl.paid === 'no')
            )
        } else {
            // seacrharray.value = seacrharray.value.filter((student, index) => selectedItems.value.includes(student.class[0].name) && student.class.some(cl => cl.paid === 'no'))
            seacrharray.value = seacrharray.value.filter((student) =>
                selectedItems.value.every(selectedClass =>
                    student.class.some(cls =>
                        cls.name === selectedClass && cls.paid === 'no'
                    )
                )
            );
        }
    }
}



</script>
<template>

    <Head title="Student's Classes"></Head>
    <div>
        <Sidebar>
            <div class="py-12">
                <div class="max-w-6xl mx-auto sm:px-6 lg:px-8" :style="{ overflowY: 'auto', maxHeight: '85vh' }">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3 mb-4">
                        <fwb-heading tag="h2" style="margin-bottom: 20px;">Students' Classes</fwb-heading>
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
                        <template v-for="(cl, index) in classes" :key="index">
                            <fwb-checkbox v-model="selectedClasses[index]" @change="classfilter" :label="cl" />
                        </template>
                        <fwb-checkbox v-model="checkall" label="All class" @change="checkAll" />
                        <div class="flex gap-4">
                            <fwb-checkbox :model-value="paymentFilter === 'paid'"
                                @update:model-value="handlePaymentFilter('paid')" label="Paid students" />
                            <fwb-checkbox :model-value="paymentFilter === 'nonpaid'"
                                @update:model-value="handlePaymentFilter('nonpaid')" label="Non paid students" />
                            <fwb-checkbox :model-value="paymentFilter === 'all'"
                                @update:model-value="handlePaymentFilter('all')" label="Paid or Non paid students" />
                        </div>
                        <fwb-table striped>
                            <fwb-table-head>
                                <fwb-table-head-cell>Name</fwb-table-head-cell>
                                <fwb-table-head-cell>Email</fwb-table-head-cell>
                                <fwb-table-head-cell>Phone Number</fwb-table-head-cell>
                                <fwb-table-head-cell>Exam Year</fwb-table-head-cell>
                                <fwb-table-head-cell>Classes</fwb-table-head-cell>
                            </fwb-table-head>
                            <fwb-table-body v-if="seacrharray.length != 0">
                                <fwb-table-row v-for="(st, index) in seacrharray" :key="index" style="width: 100%;">
                                    <fwb-table-cell>{{ st.student_name }}</fwb-table-cell>
                                    <fwb-table-cell>{{ st.email }}</fwb-table-cell>
                                    <fwb-table-cell>{{ st.w_number }}</fwb-table-cell>
                                    <fwb-table-cell>{{ st.exam_year }}</fwb-table-cell>

                                    <fwb-table-cell style="margin-right: 50%;">
                                        <template v-for="(cl, index) in st.class" :key="index">
                                            <fwb-p class="flex items-center gap-2 text-xs">
                                                {{ cl.name }}:
                                                <fwb-badge type="red" v-if="cl.paid == 'no'">Not paid</fwb-badge>
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
                    </div>
                </div>
            </div>
        </Sidebar>
    </div>
</template>