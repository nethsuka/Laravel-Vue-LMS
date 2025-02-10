<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import { FwbCheckbox, FwbButton, FwbAlert } from 'flowbite-vue';
import { ref, onMounted, computed } from 'vue';

const Arrays = defineProps({
    classDetails: Array,
    paidClasses: Array,
});

const activeTab = ref('Monthly Payment');
const showAlert = ref(true);

const setActiveTab = (tab) => {
    activeTab.value = tab;
};

let cart = ref([]);

onMounted(() => {
    discount();
    creatingshowarray();
    // addClassNamesToArray();
    if(sessionStorage.getItem('buy')=='true'){
        activeTab.value = 'Resources Payment';
        sessionStorage.removeItem('buy');
    }

    // cart array taken from the session storage
    const storedCart = sessionStorage.getItem("cart");
    if (storedCart) {
        cart.value = JSON.parse(storedCart);
    }

    // Selected item taken from the session storage , saved by in more classes page
    redirectedFromMoreclass();
    console.log(cart.value);
})

const { props } = usePage();
const form1 = useForm({
    name: props.auth.user.name,
    email: props.auth.user.email,
    paid_classes: [],
    note: '',
    slip: null,
});

const form2 = useForm({
    name: props.auth.user.name,
    email: props.auth.user.email,
    selected_resources: [],
    note: '',
    slip: null,
});


function redirectedFromMoreclass(){
    const selectedClass = sessionStorage.getItem('class')
    sessionStorage.removeItem('class');
    if (selectedClass){
        if(selectedClass.length > 13){
            const year = selectedClass.substring(0,4);
            const class1 = year +' Paper';
            const class2 = year +' Theory';
            handleCheckboxChange(class1);
            handleCheckboxChange(class2);
        }else{
            // fromsession.value.push(selectedClass);
            handleCheckboxChange(selectedClass);
        }
    }
}

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

function submit2() {
    form2.selected_resources = cart;
    form2.post('/payments/resource-payment', {
        preserveScroll: true,
        onSuccess: () => {
            // total.value = 0;
            form2.reset();
            sessionStorage.removeItem('cart');
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
const st_paid = ref(Arrays.paidClasses);
const showarray = ref([]);
const discount_class = ref([]);


function discount() {
    let paper = '';
    let theory = '';

    const st_paid_value = Array.isArray(st_paid.value) 
        ? st_paid.value.map(item => item.toLowerCase())
        : st_paid.value.toLowerCase();

    let currentYear = new Date().getFullYear() % 100;
    let years = [currentYear-1, currentYear, currentYear + 1, currentYear + 2];

    for (let i of years) {
        paper = '20' + i + ' Paper';
        theory = '20' + i + ' Theory';

        const paper_lower = paper.toLowerCase();
        const theory_lower = theory.toLowerCase();

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
        
        if (form1.paid_classes.includes(theory) && form1.paid_classes.includes(paper)) {
            if (y >= 26) {
                total.value = total.value + 7500;  // New combined price for 2026 onwards
            } else {
                total.value = total.value + 7000;  // Original combined price for 2025
            }
        } else {
            if (form1.paid_classes.includes(theory) || form1.paid_classes.includes(paper)) {
                total.value = total.value + 5000;  // Single class price remains same
            }
        }
    }
}

function already_paid() {
    total.value = 0;
    let count = 0;
    
    for (let i of form1.paid_classes) {
        if (discount_class.value.includes(i)) {
            const year = parseInt(i.substring(2, 4));  // Extract year from class name
            if (year >= 26) {
                total.value = total.value + 2500;  // Discount price for 2026 onwards
            } else {
                total.value = total.value + 2000;  // Original discount price for 2025
            }
        } else {
            if (count === 0) {
                let paper = '';
                let theory = '';
                
                for (let y of [25, 26, 27, 28, 29, 30]) {
                    paper = '20' + y + ' Paper';
                    theory = '20' + y + ' Theory';
                    
                    if (form1.paid_classes.includes(theory) && form1.paid_classes.includes(paper)) {
                        if (y >= 26) {
                            total.value = total.value + 7500;  // New combined price for 2026 onwards
                        } else {
                            total.value = total.value + 7000;  // Original combined price for 2025
                        }
                    } else {
                        if (form1.paid_classes.includes(theory)) {
                            if (!discount_class.value.includes(theory)) {
                                total.value = total.value + 5000;
                            }
                        } else if (form1.paid_classes.includes(paper)) {
                            if (!discount_class.value.includes(paper)) {
                                total.value = total.value + 5000;
                            }
                        }
                    }
                }
            }
            count = count + 1;
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
function removeitem(name){
    console.log(name);
    cart.value = cart.value.filter(item => item.resource_name !== name);
    sessionStorage.setItem("cart", JSON.stringify(cart.value));
}

const totalResourcePrice = computed(() => {
  return cart.value.reduce((total, item) => total + (parseInt(item.price) || 0), 0);
});

</script>

<template>

    <Head title="Payments" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Payments</h2>
                <div>
                    <Link href="/purchaceclass">
                    <!-- <fwb-button gradient="cyan" shadow>Purchace Class</fwb-button> -->
                    </Link>
                    <a href="/class-controls"  v-if="props.auth.user.role === 'admin'">
                        <button type="button"
                        class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg hover:shadow-purple-500/100 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-md px-4 py-1.5 text-center ml-3">
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

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3">

                    <ul
                        class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
                        <li class="me-2">
                            <a href="#" @click.prevent="setActiveTab('Monthly Payment')"
                                :class="{ 'text-blue-600 bg-sky-50 active dark:bg-gray-800 dark:text-blue-500': activeTab === 'Monthly Payment' }"
                                class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Monthly
                                Payment</a>
                        </li>
                        <li class="me-2">
                            <a href="#" @click.prevent="setActiveTab('Resources Payment')"
                                :class="{ 'text-blue-600 bg-sky-50 active dark:bg-gray-800 dark:text-blue-500': activeTab === 'Resources Payment' }"
                                class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Resources Payment</a>
                        </li>
                    </ul>

                    <div
                        class="p-6 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full">
                        <template v-if="activeTab === 'Monthly Payment'">
                            <h3 class="mb-5 text-lg font-bold text-gray-900 dark:text-white pb-2">Monthly Payment</h3>
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
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white pt-2">Note</label>
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
                        <template v-if="activeTab === 'Resources Payment'">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 pb-5">Resources Payment</h3>
                            
                            <form class="max-w-sm mx-auto" @submit.prevent="submit2">
                                <div class="mb-5">
                                    <label for="name1"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                    <input type="text" id="name1" v-model="form2.name" disabled
                                        class="cursor-not-allowed bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required />
                                </div>
                                <div class="mb-5">
                                    <label for="email2"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                    <input type="email" id="email2" v-model="form2.email" disabled
                                        class="cursor-not-allowed bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required />
                                </div>
                                <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selected resources :</label>

                                <div class="mb-6">
                                    <template v-if="cart.length > 0">
                                        <div v-for="item in cart" :key="item.id" class="badge-container flex flex-wrap gap-1 mb-1.5">
                                            <span class="inline-flex items-center px-2 py-1 text-sm font-medium text-indigo-800 bg-indigo-100 rounded-full dark:bg-indigo-900 dark:text-indigo-300 max-w-xs truncate relative">
                                                <span class="truncate pr-5" :title="item.name">{{ item.resource_name }}</span>
                                                <button @click="removeitem(item.resource_name)" type="button" class="mr-2 inline-flex items-center p-1 ms-2 text-md text-indigo-400 bg-transparent rounded-xs hover:bg-indigo-200 hover:text-indigo-900 dark:hover:bg-indigo-800 dark:hover:text-indigo-300 absolute right-0" aria-label="Remove" >
                                                    <svg class="w-2 h-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                    </svg>
                                                    <span class="sr-only">Remove badge</span>
                                                </button>
                                            </span>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <p class="text-sm pl-4 mb-2">You can pick Resources from the<a href="/resources">
                                            HERE
                                        </a>
                                        </p>
                                    </template>
                                </div>
                                <InputError class="mt-2 pb-2" :message="form2.errors.selected_resources" />

                                <label for="message2"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Note</label>
                                <textarea id="message2" v-model="form2.note" rows="4"
                                    class="mb-4 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Any note regarding your payment..."></textarea>

                                <template v-if="totalResourcePrice > 0">
                                    <blockquote
                                        class="text-lg italic font-semibold my-3 border-l-4 border-s-slate-400 bg-slate-100 text-gray-900 dark:text-white text-center py-4">
                                        <p>Total Payment: Rs {{ totalResourcePrice }}.00</p>
                                    </blockquote>
                                </template>

                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="file_input2">Upload
                                    Slip</label>
                                <input @input="form2.slip = $event.target.files[0]" accept=".pdf,.png,.jpg,.jpeg"
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                    aria-describedby="file_input_help" id="file_input2" type="file">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">
                                    PNG, JPG or PDF (MAX 2MB).</p>
                                <InputError class="mt-2" :message="form2.errors.slip" />

                                <button type="submit"
                                    class="mt-6 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                            </form>

                        </template>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>