<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { FwbHeading, FwbButton, FwbBadge } from 'flowbite-vue'

const Arrays = defineProps({
    classDetails: Array,
    paidClassDetails: Array,
});

const showarray = ref([]);

onMounted(() => {
    CREATING_ARRAYS()
    console.log(Arrays.paidClassDetails)
})


function CREATING_ARRAYS() {
    for (let x of Arrays.classDetails) {
        if (Arrays.paidClassDetails.some(c => c.tuition_class_id === x.id)) {
            if (Arrays.paidClassDetails.some(c=> c.paid === 'yes')){
                const newobj = {
                    name: x.class_name,
                    paid: 'yes'
                }
                showarray.value.push(newobj)
            }
            else {
            const newobj = {
                name: x.class_name,
                paid: 'no'
            }
            showarray.value.push(newobj)
        }
        } else {
            const newobj = {
                name: x.class_name,
                paid: 'no'
            }
            showarray.value.push(newobj)
        }
    }
}

</script>

<template>

    <Head title="More Classes" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Classes</h2>
                <a href="/class-controls">
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
                                        <p class="mb-3 font-medium text-gray-700 dark:text-gray-400 pb-3">Price - Rs.5000/=</p>
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
                                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 pb-3">Price - Rs.5000/=</p>
                                        <a :href="route('payments')"><fwb-button gradient="purple-blue">Purchase</fwb-button></a>
                                    </div>
                                </div>
                            </template>

                        </template>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>