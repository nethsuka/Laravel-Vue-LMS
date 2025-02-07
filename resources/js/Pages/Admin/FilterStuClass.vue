<script setup>
import Sidebar from '@/Layouts/Sidebar.vue';
import { Head } from '@inertiajs/vue3';
import {
    FwbA,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
    FwbHeading
} from 'flowbite-vue'

const classes = ["2025 Paper","2025 Theory","2026 Paper","2026 Paper"]
const stu=
[
    {
        student_name: "thinula",
        email: "th@gmail.com",
        exam_year: 2025,
        class_name: "2025 Paper",
        payment_status: "yes",
        w_number: "0712345678"
    },
    {
        student_name: "thinula",
        email: "th@gmail.com",
        exam_year: 2025,
        class_name: "2025 Theory",
        payment_status: "no",
        w_number: "0712345678"
    },
    {
        student_name: "thinula",
        email: "th@gmail.com",
        exam_year: 2026,
        class_name: "2026 Paper",
        payment_status: "yes",
        w_number: "0712345678"
    },
    {
        student_name: "thinula",
        email: "th@gmail.com",
        exam_year: 2026,
        class_name: "2026 Theory",
        payment_status: "no",
        w_number: "0712345678"
    },
    {
        student_name: "kasun",
        email: "ks@gmail.com",
        exam_year: 2025,
        class_name: "2025 Paper",
        payment_status: "yes",
        w_number: "0723456789"
    },
    {
        student_name: "kasun",
        email: "ks@gmail.com",
        exam_year: 2025,
        class_name: "2025 Theory",
        payment_status: "no",
        w_number: "0723456789"
    },
    {
        student_name: "kasun",
        email: "ks@gmail.com",
        exam_year: 2026,
        class_name: "2026 Paper",
        payment_status: "yes",
        w_number: "0723456789"
    },
    {
        student_name: "kasun",
        email: "ks@gmail.com",
        exam_year: 2026,
        class_name: "2026 Theory",
        payment_status: "no",
        w_number: "0723456789"
    },
    {
        student_name: "nimal",
        email: "nm@gmail.com",
        exam_year: 2025,
        class_name: "2025 Paper",
        payment_status: "yes",
        w_number: "0734567890"
    },
    {
        student_name: "nimal",
        email: "nm@gmail.com",
        exam_year: 2026,
        class_name: "2026 Paper",
        payment_status: "no",
        w_number: "0734567890"
    },
    {
        student_name: "saman",
        email: "sm@gmail.com",
        exam_year: 2025,
        class_name: "2025 Theory",
        payment_status: "yes",
        w_number: "0745678901"
    },
    {
        student_name: "saman",
        email: "sm@gmail.com",
        exam_year: 2026,
        class_name: "2026 Theory",
        payment_status: "no",
        w_number: "0745678901"
    }
]



</script>
<template>

    <Head title="Student's Classes"></Head>
    <div>
        <Sidebar>
            <div class="py-12">
                <div class="max-w-6xl mx-auto sm:px-6 lg:px-8" :style="{ overflowY: 'auto', maxHeight: '85vh' }">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3 mb-4">
                        <fwb-heading tag="h2" style="margin-bottom: 20px;">Students' Classes</fwb-heading>
                        <fwb-table striped>
                            <fwb-table-head>
                                <fwb-table-head-cell>Name</fwb-table-head-cell>
                                <fwb-table-head-cell>Email</fwb-table-head-cell>
                                <fwb-table-head-cell>Phone Number</fwb-table-head-cell>
                                <fwb-table-head-cell>Exam Year</fwb-table-head-cell>
                                <fwb-table-head-cell>Classes</fwb-table-head-cell>

                                <fwb-table-head-cell>
                                    <span class="sr-only">Edit</span>
                                </fwb-table-head-cell>
                            </fwb-table-head>
                            <fwb-table-body>
                                <fwb-table-row v-for="(st,index) in stu" :key="index">
                                    <fwb-table-cell>{{ st.student_name }}</fwb-table-cell>
                                    <fwb-table-cell>{{ st.email }}</fwb-table-cell>
                                    <fwb-table-cell>{{ st.w_number }}</fwb-table-cell>
                                    <fwb-table-cell>{{ st.exam_year }}</fwb-table-cell>
                                    
                                    <fwb-table-cell>
                                        <fwb-a href="#">
                                            Edit
                                        </fwb-a>
                                    </fwb-table-cell>
                                </fwb-table-row>
                                
                            </fwb-table-body>
                        </fwb-table>
                    </div>
                </div>
            </div>
        </Sidebar>
    </div>
</template>