<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import { FwbCheckbox, FwbButton, FwbAlert } from 'flowbite-vue';
import { ref, onMounted } from 'vue';

const Arrays = defineProps({
    classDetails: Array,
    paidClasses: Array,
});

const activeTab = ref('Monthly Payment');
const showAlert = ref(true);

const setActiveTab = (tab) => {
    activeTab.value = tab;
};
const { props } = usePage();
const form1 = useForm({
    name: props.auth.user.name,
    email: props.auth.user.email,
    paid_classes: [],
    note: '',
    slip: null,

});

function submit1() {
    form1.post('/payments', {
        preserveScroll: true,
        onSuccess: () => {
            total.value = 0;
            form1.reset();
            window.scrollTo(0, 0);
        },
    });
    showAlert.value = true;
}

function closeAlert() {
    showAlert.value = false;
}

function creatingshowarray() {
    console.log(Arrays.classDetails)
    for (let i of Arrays.classDetails) {
        if (!st_paid.value.includes(i.class_name)) {
            showarray.value.push(i)
        }
    }
}

// form payment calculation
const total = ref(0);

onMounted(() => {
    discount();
    creatingshowarray();
    // addClassNamesToArray();
})

const st_paid = ref(Arrays.paidClasses);
const showarray = ref([]);
const discount_class = ref([]);


function discount() {
    let paper = '';
    let theory = '';

    // Check if st_paid.value is a string or array and ensure lowercase comparison
    const st_paid_value = Array.isArray(st_paid.value) 
        ? st_paid.value.map(item => item.toLowerCase())  // If it's an array, map each element to lowercase
        : st_paid.value.toLowerCase();                   // If it's a string, convert it to lowercase

    // Get the current year and extract the last two digits
    let currentYear = new Date().getFullYear() % 100;

    // Create an array for the current year and the next two years
    let years = [currentYear-1, currentYear, currentYear + 1, currentYear + 2];

    for (let i of years) {
        paper = '20' + i + ' Paper';
        theory = '20' + i + ' Theory';

        // Convert paper and theory to lowercase
        const paper_lower = paper.toLowerCase();
        const theory_lower = theory.toLowerCase();

        // If st_paid_value is an array, use includes() to check; if it's a string, the same logic applies
        if (!(st_paid_value.includes(paper_lower) && st_paid_value.includes(theory_lower))) {
            if (st_paid_value.includes(paper_lower)) {
                discount_class.value.push(theory);
            } else if (st_paid_value.includes(theory_lower)) {
                discount_class.value.push(paper);
            }
        }
    }
}

function class_fees() {
    total.value = 0;
    let paper = '';
    let theory = '';
    for (let y of [25, 26, 27, 28, 29, 30]) {
        paper = '20' + y + ' Paper';
        theory = '20' + y + ' Theory';
        if (form1.paid_classes.includes(theory) &&
            form1.paid_classes.includes(paper)) {
            total.value = total.value + 7000;
        }
        else {
            if (form1.paid_classes.includes(theory)) {
                total.value = total.value + 5000;
            }
            else if (form1.paid_classes.includes(paper)) {
                total.value = total.value + 5000;
            }
        }
    }
}

function already_paid() {
    total.value = 0;
    let count = 0;
    for (let i of form1.paid_classes) {
        if (discount_class.value.includes(i)) {
            if (i.includes('Theory')) {
                total.value = total.value + 2000
            } else if (i.includes('Paper')) {
                total.value = total.value + 2000
            }
        }
        else {
            if (count === 0) {
                let paper = '';
                let theory = '';
                for (let y of [25, 26, 27, 28, 29, 30]) {
                    paper = '20' + y + ' Paper';
                    theory = '20' + y + ' Theory';
                    if (form1.paid_classes.includes(theory) &&
                        form1.paid_classes.includes(paper)) {
                        total.value = total.value + 7000;
                    }
                    else {
                        if (form1.paid_classes.includes(theory)) {
                            if (!discount_class.value.includes(theory)) {
                                total.value = total.value + 5000;
                            }
                        }
                        else if (form1.paid_classes.includes(paper)) {
                            if (!discount_class.value.includes(paper)) {
                                total.value = total.value + 5000;
                            }
                        }
                    }
                }
            }
            count = count + 1
        }
    }
}

// Handle the checkbox selection
const handleCheckboxChange = (value) => {
    if (st_paid.length === 0) {
        if (form1.paid_classes.includes(value)) {
            form1.paid_classes = form1.paid_classes.filter(item => item !== value);
        } else {
            form1.paid_classes.push(value);
        }
        class_fees()
    } else {
        if (!st_paid.value.includes(value)) {
            if (form1.paid_classes.includes(value)) {
                form1.paid_classes = form1.paid_classes.filter(item => item !== value);
            } else {
                form1.paid_classes.push(value);
            }
            already_paid()
        }
    }

};

</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Payments</h2>
                <div>
                    <Link href="/purchaceclass">
                    <!-- <fwb-button gradient="cyan" shadow>Purchace Class</fwb-button> -->
                    </Link>
                    <a href="/class-controls">
                        <button type="button"
                            class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-4 py-1.5 text-center">
                            Admin Panel</button>
                    </a>
                </div>
            </div>
        </template>

        <div class="pt-5" v-if="$page.props.flash.successMsg && showAlert">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <!-- <div v-if="$page.props.flash.successMsg && showAlert">                             -->
                <div id="alert-border-3"
                    class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800"
                    role="alert">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path fill="currentColor"
                            d="m18.774 8.245-.892-.893a1.5 1.5 0 0 1-.437-1.052V5.036a2.484 2.484 0 0 0-2.48-2.48H13.7a1.5 1.5 0 0 1-1.052-.438l-.893-.892a2.484 2.484 0 0 0-3.51 0l-.893.892a1.5 1.5 0 0 1-1.052.437H5.036a2.484 2.484 0 0 0-2.48 2.481V6.3a1.5 1.5 0 0 1-.438 1.052l-.892.893a2.484 2.484 0 0 0 0 3.51l.892.893a1.5 1.5 0 0 1 .437 1.052v1.264a2.484 2.484 0 0 0 2.481 2.481H6.3a1.5 1.5 0 0 1 1.052.437l.893.892a2.484 2.484 0 0 0 3.51 0l.893-.892a1.5 1.5 0 0 1 1.052-.437h1.264a2.484 2.484 0 0 0 2.481-2.48V13.7a1.5 1.5 0 0 1 .437-1.052l.892-.893a2.484 2.484 0 0 0 0-3.51Z" />
                        <path fill="#fff"
                            d="M8 13a1 1 0 0 1-.707-.293l-2-2a1 1 0 1 1 1.414-1.414l1.42 1.42 5.318-3.545a1 1 0 0 1 1.11 1.664l-6 4A1 1 0 0 1 8 13Z" />
                    </svg>
                    <div class="ms-3 text-sm font-medium">
                        {{ $page.props.flash.successMsg }}
                    </div>
                    <button type="button"
                        class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                        @click="closeAlert" aria-label="Close">
                        <span class="sr-only">Dismiss</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <!-- </div> -->
            </div>
        </div>

        <div class="pb-12 pt-7">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3">

                    <ul
                        class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
                        <li class="me-2">
                            <a href="#" @click.prevent="setActiveTab('Monthly Payment')"
                                :class="{ 'text-blue-600 bg-gray-100 active dark:bg-gray-800 dark:text-blue-500': activeTab === 'Monthly Payment' }"
                                class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Monthly
                                Payment</a>
                        </li>
                        <li class="me-2">
                            <a href="#" @click.prevent="setActiveTab('dashboard')"
                                :class="{ 'text-blue-600 bg-gray-100 active dark:bg-gray-800 dark:text-blue-500': activeTab === 'dashboard' }"
                                class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Dashboard</a>
                        </li>
                        <li class="me-2">
                            <a href="#" @click.prevent="setActiveTab('settings')"
                                :class="{ 'text-blue-600 bg-gray-100 active dark:bg-gray-800 dark:text-blue-500': activeTab === 'settings' }"
                                class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Settings</a>
                        </li>
                        <li class="me-2">
                            <a href="#" @click.prevent="setActiveTab('contacts')"
                                :class="{ 'text-blue-600 bg-gray-100 active dark:bg-gray-800 dark:text-blue-500': activeTab === 'contacts' }"
                                class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Contacts</a>
                        </li>
                        <li>
                            <a
                                class="inline-block p-4 text-gray-400 rounded-t-lg cursor-not-allowed dark:text-gray-500">Disabled</a>
                        </li>
                    </ul>

                    <div
                        class="p-6 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full">
                        <template v-if="activeTab === 'Monthly Payment'">
                            <h3 class="mb-5 text-lg font-bold text-gray-900 dark:text-white">Monthly Payment</h3>
                            <!-- <p class="mb-4">This is some placeholder content for the Profile tab's associated content.</p> -->

                            <form class="max-w-sm mx-auto" @submit.prevent="submit1">
                                <template v-if="st_paid.length > 0">
                                    <div class="mb-5">
                                        <fwb-alert icon type="info" class="p-4 w-full bg-blue-100">
                                            <div class="flex flex-col">
                                                <p>Already paid for - 
                                                    <span v-for="(paidClass, index) in st_paid" :key="index">
                                                        {{ paidClass }}{{ index < st_paid.length - 1 ? ', ' : '' }}
                                                    </span>
                                                </p>
                                            </div>
                                        </fwb-alert>
                                    </div>
                                </template>
                                <div class="mb-5">
                                    <label for="name"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                    <input type="text" id="name" v-model="form1.name" disabled
                                        class="cursor-not-allowed bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required />
                                </div>
                                <div class="mb-5">
                                    <label for="email"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                    <input type="email" id="email" v-model="form1.email" disabled
                                        class="cursor-not-allowed bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required />
                                </div>
                                <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Classes you can pay</label>
                                <template v-if="showarray.length > 0">
                                    <div v-for="name in showarray" class="flex items-center mb-2" :key="name.name">

                                        <FwbCheckbox :modelValue="form1.paid_classes.includes(name.class_name)"
                                            @update:modelValue="() => handleCheckboxChange(name.class_name)"
                                            :label="name.class_name">
                                        </FwbCheckbox>

                                    </div>
                                </template>
                                <template v-else>
                                    <p class="text-xs pl-4 mb-2">Not available</p>
                                </template>

                                <InputError class="mt-2" :message="form1.errors.paid_classes" />


                                <label for="message"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Note</label>
                                <textarea id="message" v-model="form1.note" rows="4"
                                    class="mb-4 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Any note regarding your payment..."></textarea>

                                <template v-if="total > 0">
                                    <blockquote
                                        class="text-lg italic font-semibold my-3 border-l-4 border-s-slate-400 bg-slate-100 text-gray-900 dark:text-white text-center py-4">
                                        <p>Total Class Fees: Rs {{ total }}.00</p>
                                    </blockquote>
                                </template>

                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="file_input">Upload
                                    Slip</label>
                                <input @input="form1.slip = $event.target.files[0]" accept=".pdf,.png,.jpg,.jpeg"
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                    aria-describedby="file_input_help" id="file_input" type="file">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">
                                    PNG, JPG or PDF (MAX 2MB).</p>
                                <InputError class="mt-2" :message="form1.errors.slip" />

                                <button type="submit"
                                    class="mt-6 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                            </form>

                        </template>
                        <template v-if="activeTab === 'dashboard'">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Dashboard Tab</h3>
                            <p>This is some placeholder content for the Dashboard tab's associated content.</p>
                        </template>
                        <template v-if="activeTab === 'settings'">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Settings Tab</h3>
                            <p>This is some placeholder content for the Settings tab's associated content.</p>
                        </template>
                        <template v-if="activeTab === 'contacts'">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Contacts Tab</h3>
                            <p>This is some placeholder content for the Contacts tab's associated content.</p>
                        </template>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>