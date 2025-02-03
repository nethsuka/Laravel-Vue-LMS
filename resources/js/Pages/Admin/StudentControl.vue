<script setup>
import Sidebar from '@/Layouts/Sidebar.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
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
    FwbHeading,
    FwbTooltip,
    FwbAccordion,
    FwbAccordionContent,
    FwbAccordionHeader,
    FwbAccordionPanel,
} from 'flowbite-vue'

const studata = [
    {
        name: "John Doe",
        email: "john.doe@example.com",
        phoneNumber: "+1 234 567 890",
        examYear: 2025,
        fatherNumber: "+1 345 678 901",
        momNumber: "+1 456 789 012",
        nic: "123456789V",
        address: "123 Main Street, City, Country"
    },
    {
        name: "Jane Smith",
        email: "jane.smith@example.com",
        phoneNumber: "+1 987 654 321",
        examYear: 2024,
        fatherNumber: "+1 876 543 210",
        momNumber: "+1 765 432 109",
        nic: "987654321V",
        address: "456 Elm Avenue, City, Country"
    },
    {
        name: "David Johnson",
        email: "david.johnson@example.com",
        phoneNumber: "+1 543 210 987",
        examYear: 2023,
        fatherNumber: "+1 654 321 876",
        momNumber: "+1 765 432 765",
        nic: "112233445V",
        address: "789 Oak Road, City, Country"
    }
]

</script>
<template>

    <Head title="Student Control Panel"></Head>
    <div>
        <Sidebar>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" :style="{ overflowY: 'auto', maxHeight: '95vh' }">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3">
                        <fwb-heading tag="h2" style="margin-bottom: 20px;">Students</fwb-heading>
                        <fwb-table striped style="max-width: 1200px;">
                            <fwb-table-head>
                                <fwb-table-head-cell>Name</fwb-table-head-cell>
                                <fwb-table-head-cell>Email</fwb-table-head-cell>
                                <fwb-table-head-cell>Phone Number</fwb-table-head-cell>
                                <fwb-table-head-cell>Exam Year</fwb-table-head-cell>
                                <fwb-table-head-cell>More details</fwb-table-head-cell>
                            </fwb-table-head>
                            <fwb-table-body>
                                <fwb-table-row v-for="(stu, index) in studata" :key="index">
                                    <fwb-table-cell>{{ stu.name }}</fwb-table-cell>
                                    <fwb-table-cell>{{ stu.email }}</fwb-table-cell>
                                    <fwb-table-cell>{{ stu.phoneNumber }}</fwb-table-cell>
                                    <fwb-table-cell>{{ stu.examYear }}</fwb-table-cell>
                                    <fwb-table-cell>
                                        <fwb-button gradient="teal" style="margin-right: 50%;">Teal</fwb-button>
                                    </fwb-table-cell>
                                </fwb-table-row>
                            </fwb-table-body>
                        </fwb-table>
                        <fwb-accordion always-open>
                            <fwb-accordion-panel>
                                <fwb-accordion-header>header</fwb-accordion-header>
                                <fwb-accordion-content>
                                    <div>
                                        <p class="mb-2 text-gray-500 dark:text-gray-400">
                                            Flowbite is an open-source library of interactive components built on top of
                                            Tailwind CSS including buttons, dropdowns, modals, navbars, and more.
                                        </p>
                                        <p class="text-gray-500 dark:text-gray-400">
                                            Check out this guide to learn how to <a
                                                class="text-blue-600 dark:text-blue-500 hover:underline"
                                                href="/docs/getting-started/introduction/">get started</a> and start
                                            developing websites even faster with components on top of Tailwind CSS.
                                        </p>
                                    </div>
                                </fwb-accordion-content>
                            </fwb-accordion-panel>
                            <fwb-accordion-panel>
                                <fwb-accordion-header>another header</fwb-accordion-header>
                                <fwb-accordion-content>
                                    <div>
                                        <p class="mb-2 text-gray-500 dark:text-gray-400">
                                            Flowbite is first conceptualized and designed using the Figma software so
                                            everything you see in the library has a design equivalent in our Figma file.
                                        </p>
                                        <p class="text-gray-500 dark:text-gray-400">
                                            Check out the <a class="text-blue-600 dark:text-blue-500 hover:underline"
                                                href="https://flowbite.com/figma/">Figma design system</a> based on the
                                            utility classes from Tailwind CSS and components from Flowbite.
                                        </p>
                                    </div>
                                </fwb-accordion-content>
                            </fwb-accordion-panel>
                            <fwb-accordion-panel>
                                <fwb-accordion-header>and one more header</fwb-accordion-header>
                                <fwb-accordion-content>
                                    <div>
                                        <p class="mb-2 text-gray-500 dark:text-gray-400">
                                            Flowbite is first conceptualized and designed using the Figma software so
                                            everything you see in the library has a design equivalent in our Figma file.
                                        </p>
                                        <p class="text-gray-500 dark:text-gray-400">
                                            Check out the <a class="text-blue-600 dark:text-blue-500 hover:underline"
                                                href="https://flowbite.com/figma/">Figma design system</a> based on the
                                            utility classes from Tailwind CSS and components from Flowbite.
                                        </p>
                                    </div>
                                </fwb-accordion-content>
                            </fwb-accordion-panel>
                        </fwb-accordion>
                    </div>
                </div>
            </div>


        </Sidebar>
    </div>
</template>
