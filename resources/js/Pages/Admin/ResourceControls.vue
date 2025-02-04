<script setup>
import Sidebar from '@/Layouts/Sidebar.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import {
    FwbA,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
    FwbSelect,
    FwbHeading,
    FwbAlert,
    FwbButton,
    FwbModal
} from 'flowbite-vue'
import { useForm, usePage, router } from '@inertiajs/vue3';
import { FwbInput } from 'flowbite-vue'


const Arrays = defineProps({
    resourcesWithVideoCount: Array,
});

const { props } = usePage();

const form1 = useForm({
    name: '',
    price: '',
    category: '',
});

const form2 = useForm({
    resource_id: ''
});

const isShowModal = ref(false)

function closeModal() {
    isShowModal.value = false
    name.value = null
    price.value = null
    selected.value = ''
}

function showModal() {
    isShowModal.value = true
}

const selected = ref('')

const category = [
    { value: 'theory', name: 'Theory' },
    { value: 'paper', name: 'Paper' },
]

function SavecloseModal() {
    form1.name = name.value;
    form1.price = price.value;
    form1.category = selected.value;
    form1.post('/resource-controls/add-resource', {
        preserveScroll: false,
    });
    closeModal();
}

const objectarray = ref(Arrays.resourcesWithVideoCount);

const name = ref(null)
const price = ref(null)

const query = ref('')
const filteredarray = computed(() => {
    const lowerKeyword = query.value.toLowerCase();
    return Arrays.resourcesWithVideoCount.filter(obj =>
        obj.name.toLowerCase().includes(lowerKeyword)
    );
});

function validatenumber(event) {
    const value = event.target.value;
    // Allow only numbers
    event.target.value = value.replace(/[^\d]/g, '');
}

function redirectEdite(resourceId) {
    window.location.href = `/resource-controls/edit/${resourceId}`;
}

function deleteResource(resourceId) {
    form2.resource_id = resourceId;
    const choice = confirm('Are you sure you want to permanently delete this class ?');
    if (choice) {
        form2.delete('/resource-controls/delete-resource', {
            preserveScroll: false,
        });
    }
}

</script>

<template>

    <Head title="Resource Control Panel"></Head>
    <div>
        <Sidebar>
            <div class="py-12">
                <div class="max-w-6xl mx-auto sm:px-6 lg:px-8" :style="{ overflowY: 'auto', maxHeight: '85vh' }">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3 mb-4">
                        <div class="p-12">
                            <fwb-alert v-if="$page.props.flash.successMsg" closable icon type="success"
                                class="flex justify-center fixed top-24 left-1/2 transform -translate-x-1/2 z-50">
                                <p>{{ $page.props.flash.successMsg }}</p>
                            </fwb-alert>
                            <fwb-alert v-if="$page.props.flash.errorMsg" closable icon type="danger"
                                class="flex justify-center fixed top-24 left-1/2 transform -translate-x-1/2 z-50">
                                <p>{{ $page.props.flash.errorMsg }}</p>
                            </fwb-alert>
                            <fwb-heading tag="h3">Resources</fwb-heading>
                            <br>
                            <div class="flex justify-end mb-4">
                                <fwb-button gradient="green" @click="showModal">+ Add Resource</fwb-button>
                            </div>
                            <fwb-input v-on:input="getkey" v-model="query" placeholder="Search for resources"
                                size="md">
                                <template #prefix>
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" />
                                    </svg>
                                </template>
                            </fwb-input>
                            <fwb-table striped class="mt-11" >
                                <fwb-table-head>
                                    <fwb-table-head-cell>Resources name</fwb-table-head-cell>
                                    <fwb-table-head-cell>Price</fwb-table-head-cell>
                                    <fwb-table-head-cell>Video count</fwb-table-head-cell>
                                    <fwb-table-head-cell>Action</fwb-table-head-cell>
                                </fwb-table-head>
                                <template v-if="filteredarray.length == 0">
                                    <fwb-table-body>
                                        <fwb-table-row>
                                            <fwb-table-cell :colspan="4" class="text-center">
                                                <div class="flex items-center justify-center py-4">
                                                    <span class="text-lg text-gray-500">
                                                        No data found
                                                    </span>
                                                </div>
                                            </fwb-table-cell>
                                        </fwb-table-row>
                                    </fwb-table-body>
                                </template>
                                <fwb-table-body>
                                    <template v-for="(item, index) in filteredarray" :key="index">
                                        <fwb-table-row>

                                            <fwb-table-cell>
                                                <span  class="text-base">
                                                    {{ item.name }}
                                                </span>
                                            </fwb-table-cell>
                                            <fwb-table-cell>
                                                <span  class="text-base">
                                                    {{ item.price }}
                                                </span>
                                            </fwb-table-cell>
                                            <fwb-table-cell>
                                                <span  class="text-base flex justify-center">
                                                    {{ item.videos_count }}
                                                </span>
                                            </fwb-table-cell>
                                            <fwb-table-cell class="flex justify-center">
                                                <fwb-button @click="redirectEdite(item.id)" gradient="cyan">Edit</fwb-button>
                                                <fwb-button gradient="red" @click="deleteResource(item.id)" class="ml-2">Delete</fwb-button>
                                            </fwb-table-cell>
                                        </fwb-table-row>
                                    </template>
                                </fwb-table-body>
                            </fwb-table>
                            <fwb-modal v-if="isShowModal" @close="closeModal" persistent>
                                <template #header>
                                    <div class="flex items-center text-lg">
                                        Add New Resource
                                    </div>
                                </template>
                                <template #body>
                                    <fwb-input v-model="name" label="Resource Name" placeholder="Enter Resource name"
                                        size="md" />
                                    <div>
                                        <fwb-input v-model="price" label="Price" placeholder="Enter Price" size="sm"
                                            type="text" @input="validatenumber" />

                                        <fwb-select v-model="selected" :options="category" label="Select a country" />
                                    </div>
                                </template>
                                <template #footer>
                                    <div class="flex justify-between">
                                        <fwb-button @click="closeModal" color="alternative">
                                            Close
                                        </fwb-button>
                                        <fwb-button @click="SavecloseModal" color="green"
                                            :disabled="!name || !price || !selected">
                                            Save
                                        </fwb-button>
                                    </div>
                                </template>
                            </fwb-modal>
                        </div>
                    </div>
                </div>
            </div>
        </Sidebar>
    </div>
</template>