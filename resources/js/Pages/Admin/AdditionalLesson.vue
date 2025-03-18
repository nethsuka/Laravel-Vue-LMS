<script setup>
import Sidebar from '@/Layouts/Sidebar.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import {
    FwbHeading, FwbA,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
    FwbInput,
    FwbButton,
    FwbAlert,
    FwbBadge
} from 'flowbite-vue'
import { onMounted, ref, computed, watch } from 'vue';


const Arrays = defineProps({
    extendDetails: Array
});

onMounted(() => {
    console.log(Arrays.extendDetails)
})

const keyword = ref('');
const filteredItems = computed(() => {
    const lowerKeyword = keyword.value.toLowerCase();
    return Arrays.extendDetails.filter(obj =>
        obj.st_name.toLowerCase().includes(lowerKeyword) ||
        obj.st_email.toLowerCase().includes(lowerKeyword)
    );
});

const confirmAction = (id) => {
    if (confirm('Are you sure you want to reset the extend dates?')) {
        router.delete('/aditional-lessons-controle/delete/lesson', {
            data: {id: id},
            preserveScroll: true,
        });
    }
};

function isExpired(expiryDate) {
    const currentDate = new Date();
    const expiry = new Date(expiryDate);

    // Check if the expiry date is before the current date
    return expiry < currentDate;
}

</script>
<template>
    <Head title="Extra Lessons"></Head>
    <div>
        <Sidebar>
            <div class="py-12">
                <div class="max-w-6xl mx-auto sm:px-6 lg:px-8" :style="{ overflowY: 'auto', maxHeight: '85vh' }">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3 mb-4">
                        <div class="p-12">
                            <fwb-alert v-if="$page.props.flash.successMsg" closable icon type="success"
                                class="flex justify-center fixed top-24 left-1/2 transform -translate-x-1/2 z-50 bg-green-100">
                                <p>{{ $page.props.flash.successMsg }}</p>
                            </fwb-alert>
                            <fwb-alert v-if="$page.props.flash.errorMsg" closable icon type="danger"
                                class="flex justify-center fixed top-24 left-1/2 transform -translate-x-1/2 z-50">
                                <p>{{ $page.props.flash.errorMsg }}</p>
                            </fwb-alert>
                            <fwb-heading tag="h4">Extra Lessons</fwb-heading>
                            <div  class="flex justify-center items-center mb-12 mt-10">
                                <fwb-input v-model="keyword" placeholder="Search by name or email" class="w-1/2">
                                    <template #prefix>
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" />
                                        </svg>
                                    </template>
                                </fwb-input>
                            </div>
                            <fwb-table striped>
                                <fwb-table-head>
                                    <fwb-table-head-cell>Name</fwb-table-head-cell>
                                    <fwb-table-head-cell>Email</fwb-table-head-cell>
                                    <fwb-table-head-cell>Video name</fwb-table-head-cell>
                                    <fwb-table-head-cell>Expire Date</fwb-table-head-cell>
                                    <fwb-table-head-cell>Action</fwb-table-head-cell>
                                </fwb-table-head>
                                <fwb-table-body>
                                    <template v-if="Arrays.extendDetails.length > 0">
                                        <template v-if="filteredItems.length > 0">
                                            <fwb-table-row v-for="(record, index) in filteredItems" :key="record.id">
                                                <fwb-table-cell>{{index + 1}}. {{ record.st_name }}</fwb-table-cell>
                                                <fwb-table-cell>{{ record.st_email }}</fwb-table-cell>
                                                <fwb-table-cell>{{ record.name }}</fwb-table-cell>
                                                <fwb-table-cell>
                                                    {{ record.expiry_date }}
                                                    <fwb-badge type="red" v-if="isExpired(record.expiry_date)" class="flex justify-center max-w-14">Expired</fwb-badge>
                                                </fwb-table-cell>
                                                <fwb-table-cell class="flex justify-items-center">
                                                    <fwb-button gradient="red" @click="confirmAction(record.id)">Delete</fwb-button>
                                                </fwb-table-cell>
                                            </fwb-table-row>
                                        </template>
                                        <template v-else>
                                            <fwb-table-row>
                                                <fwb-table-cell colspan="6">
                                                    <fwb-alert class="border-t-4 rounded-none" icon type="warning">
                                                        There is no name or email "{{ keyword }}"
                                                    </fwb-alert>
                                                </fwb-table-cell>
                                            </fwb-table-row>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <fwb-table-row>
                                                <fwb-table-cell colspan="6" class="float-start">
                                                        No records available.
                                                </fwb-table-cell>
                                            </fwb-table-row>
                                    </template>
                                </fwb-table-body>
                            </fwb-table>
                        </div>
                    </div>
                </div>
            </div>
        </Sidebar>
    </div>
</template>