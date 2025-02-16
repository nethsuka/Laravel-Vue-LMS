<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';
import { FwbHeading, FwbButton, FwbBadge } from 'flowbite-vue'

const Arrays = defineProps({
    classDetails: Array,
    paidClassDetails: Array,
});

const { props } = usePage();

const showarray = ref([]);

onMounted(() => {
    CREATING_ARRAYS()
    creatingbudle()
    showarray.value.sort((a, b) => a.name.substring(0,4).localeCompare(b.name.substring(0,4)))
    // console.log(showarray.value)
    // console.log(Arrays.paidClassDetails)
})


function CREATING_ARRAYS() {
    for (let x of Arrays.classDetails) {
        if (Arrays.paidClassDetails.some(c => c.tuition_class_id === x.id)) {
            if (Arrays.paidClassDetails.some(c=> c.paid === 'yes')){
                const newobj = {
                    name: x.class_name,
                    paid: 'yes',
                    price: 5000
                }
                showarray.value.push(newobj)
            }
            else {
            const newobj = {
                name: x.class_name,
                paid: 'no',
                price: 5000
            }
            showarray.value.push(newobj)
        }
        } else {
            const newobj = {
                name: x.class_name,
                paid: 'no',
                price: 5000

            }
            showarray.value.push(newobj)
        }
    }
}

// function that creating bundle of classes , ---- need to add class years accordingly 
function creatingbudle(){
    const yearsarray = [2025,2026,2027,2028,2029,2030]
    // const count = ref(0)
    for (let x of yearsarray){
        const buddlearray = showarray.value.filter(item => item.name.includes(x.toString()))
        const count = buddlearray.length;
        
        if (count == 2 ){
            const newbudle = ref(null)
            if(buddlearray[0].paid == 'yes' && buddlearray[1].paid == 'yes'){
                newbudle.value = {
                    name: x.toString() + ' Paper + ' + x.toString() + ' Theory',
                    paid: 'yes',
                    price: 7000
                }
            }
            else {
                newbudle.value = {
                    name: x.toString() + ' Paper + ' + x.toString() + ' Theory',
                    paid: 'no',
                    price: 7000
                }
            }
            if(parseInt(newbudle.value.name.substring(0,4)) >= 2026 ){
                newbudle.value.price = 7500
            }
            showarray.value.push(newbudle.value)
        }
    }
}

function redirectPayment(item){
    sessionStorage.setItem('class', item.name)
    window.location.href = '/payments'
}


</script>

<template>

    <Head title="More Classes" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Classes</h2>
                <a href="/class-controls" v-if="props.auth.user.role === 'admin'">
                    <button type="button"
                    class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-sm px-4 py-1.5 text-center me-2 mb-2 ml-2">
                        Admin Panel
                    </button>
                </a>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3" style="text-align: center;">
                    <!-- main content -->
                    <h3 class="text-3xl mt-2 font-bold dark:text-white text-center text-slate-800">Available Classes</h3>
                    <hr style="margin: 20px auto 20px auto;">
                    <template v-if="showarray.length !== 0">
                        <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-6 pb-3">
                            <template v-for="x in showarray" :key="x.name">
                                <template v-if="x.paid == 'yes'">
                                    <div class="overflow-hidden max-w-sm bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 shadow-md">
                                        <div class="p-3 bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-t-lg">
                                            <h5
                                                class="mb-2 text-2xl font-bold tracking-tight dark:text-white text-white">
                                                {{ x.name }}
                                            </h5>
                                        </div>
                                        <div class="p-6">
                                            <p class="mb-3 font-bold text-md text-gray-700 dark:text-gray-400 pb-3">Price - Rs. {{x.price}}/=</p>
                                            <div class="flex justify-center items-center">
                                                <fwb-badge size="sm" type="purple" class="bg-purple-200">Purchased</fwb-badge>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="overflow-hidden max-w-sm bg-white border border-gray-200 rounded-lg dark:bg-[#076F94] hover:bg-slate-50 hover:border-sky-400 hover:shadow-slate-400 shadow-md">
                                        <div class="p-3 bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-t-lg">
                                            <h5
                                                class="mb-2 text-2xl font-bold tracking-tight text-white">
                                                {{ x.name }}
                                            </h5>
                                        </div>
                                        <div class="p-6">
                                            <p class="mb-3 font-bold text-md text-gray-700 dark:text-gray-400 pb-3">Price - Rs.{{x.price}}/=</p>
                                            <!-- <fwb-button @click="redirectPayment(x)" class="font-bold text-lg bg-gradient-to-r from-teal-400 to-teal-600 hover:from-teal-500 hover:to-teal-700 text-white">Buy Now</fwb-button> -->
                                            <fwb-button gradient="lime" class="px-4 py-1.5 text-white" @click="redirectPayment(x)">Buy Now</fwb-button>
                                        </div>
                                    </div>
                                </template>
                            </template> 
                        </div>
                    </template>
                    <template v-else>
                        <p class="pt-2 pb-4 px-4 text-gray-600 bg-gray-100 rounded-md shadow-sm text-base font-medium leading-relaxed">
                            No classes are available yet. <span class="text-blue-600 font-semibold">Stay tuned</span> while we add new classes!
                        </p>
                    </template>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>