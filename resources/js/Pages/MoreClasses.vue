<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
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
                        class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-4 py-1.5 text-center">Admin
                        Panel</button>
                </a>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3" style="text-align: center;">
                    <!-- main content -->
                    <h3 class="text-2xl mt-2 font-bold dark:text-white text-center">More Classes</h3>
                    <hr style="margin: 20px auto 20px auto;">
                    <template v-if="showarray.length !== 0">
                        <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-6 pb-3">
                            <template v-for="x in showarray" :key="x.name">
                                <template v-if="x.paid == 'yes'">
                                    <div class="overflow-hidden max-w-sm bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 hover:bg-slate-50 hover:border-sky-400 hover:shadow-slate-400 shadow-md">
                                        <div class="p-3 bg-slate-300 text-center">
                                            <h5
                                                class="mb-2 text-2xl font-bold tracking-tight dark:text-white text-gray-600">
                                                {{ x.name }}
                                            </h5>
                                        </div>
                                        <div class="p-6">
                                            <p class="mb-3 font-medium text-gray-700 dark:text-gray-400 pb-3">Price - Rs.{{x.price}}/=</p>
                                            <span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Purchased</span>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="overflow-hidden max-w-sm bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700 hover:bg-slate-50 hover:border-sky-400 hover:shadow-slate-400 shadow-md">
                                        <div class="p-3 bg-slate-300 text-center">
                                            <h5
                                                class="mb-2 text-2xl font-bold tracking-tight dark:text-white text-gray-600">
                                                {{ x.name }}
                                            </h5>
                                        </div>
                                        <div class="p-6">
                                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 pb-3">Price - Rs.{{x.price}}/=</p>
                                            <fwb-button @click="redirectPayment(x)" gradient="purple-blue">Purchase</fwb-button>
                                        </div>
                                    </div>
                                </template>
                            </template> 
                        </div>
                    </template>
                    <template v-else>
                        <p class="pt-1 pb-3 pl-4 float-start">No class available yet.</p>
                    </template>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>