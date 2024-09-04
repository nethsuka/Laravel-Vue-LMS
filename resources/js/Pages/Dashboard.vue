<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const Arrays = defineProps({
  stclassRecords: Array,
  classDetails: Array,
  extendDetails: Object,
  paidClassDetails: Array,
  videoLinks: Array,
});

// const activeTab = ref('profile');
// const activeTab = ref('2023AL');
// const activeTab = ref(Arrays.classDetails[0].class_name);
const activeTab = ref((Arrays.classDetails.length > 0 ? Arrays.classDetails[0].class_name : 'no data'));


function setActiveTab(tab) {
  activeTab.value = tab;
}

const form = useForm({
    className: '',
});

const form2 = useForm({
    classID: '',
});

function submit(value) {
    form.className = value;
    Arrays.stclassRecords.push({ tuition_class_id: value });
    form.post('/dashboard');
}

function joinOnline(cid) {
    form2.classID = cid;
    form2.post('/dashboard/zoomlink');
}

function collectTuitionClassIds() {
    var tuitionClassIds = Arrays.stclassRecords.map(record => record.tuition_class_id);
    console.log(tuitionClassIds);
    return tuitionClassIds;
}

function checkPaidOrNot(classID) {
    for (var item of Arrays.paidClassDetails) {
        if (item.tuition_class_id === classID && item.paid === 'yes') {
            return true;
        }
    }
    return false;
}

function checkDateRange() {
    const currentDate = new Date();
    const currentDay = currentDate.getDate();
    if( currentDay >= 1 && currentDay <= Arrays.extendDetails.extend_date){
        return true;
    }else{
        return false;
    }
}

function getVideoList(classID){
    var videoList = [];
    for(let element of Arrays.videoLinks) {
        if(element.tuition_class_id == classID){
            videoList.push(element);
        }
    }
    return videoList;
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
                <a href="/admin">
                    <button type="button" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-4 py-1.5 text-center">Admin Panel</button>
                </a>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3">
                    <!-- <div class="p-6 text-gray-900">You're logged in!</div> -->
                    <!-- <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p> -->

                    <div class="md:flex">
                        <template v-if="Arrays.classDetails.length > 0">
                            <ul class="flex-column space-y space-y-4 text-sm font-medium text-gray-500 dark:text-gray-400 md:me-4 mb-4 md:mb-0">
                            <li v-for="record in classDetails" :key="record.id">
                                <a
                                href="#"
                                class="inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-40 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white"
                                :class="{ 'back-color': activeTab == record.class_name }"
                                @click.prevent="setActiveTab(record.class_name)"
                                >
                                {{ record.class_name }}
                                </a>
                            </li>
                            </ul>

                            <div class="p-6 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full">

                            <template v-for="record in classDetails" :key="record.id">
                                <div v-if="activeTab === record.class_name">
                                    <div v-if="!collectTuitionClassIds().includes(record.id)" class="container flex justify-center items-center py-20">
                                        <button @click="submit(record.id)" type="submit" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-white">Join Class</button>
                                    </div>
                                    <div v-else-if="checkPaidOrNot(record.id) || checkDateRange()">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ record.class_name }} Class</h3>
                                        <!-- <p class="mb-2">This is some placeholder content for the Profile tab's associated content. Clicking another tab will toggle the visibility of this one.</p>
                                        <p>The tab JavaScript swaps classes to control the content visibility and styling.</p> -->
                                        <div class="mt-5 mb-10 flex">
                                        <a href="#" @click="joinOnline(record.id)" class="text-white bg-gradient-to-r from-pink-400 via-pink-500 to-pink-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-pink-300 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                            Join Online Class
                                        </a>
                                        <a :href="record.tele_group" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                            Telegram Channel
                                        </a>
                                        </div>

                                        <div class="pb-9">
                                        <h6 class="pb-1"><b>Tutes</b></h6>
                                        <hr class="pb-3">
                                        <a href="#" class="block max-w-sm p-3 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                        <!-- <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5> -->
                                        <p class="flex font-normal text-gray-700 dark:text-gray-400">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7ZM8 16a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1-5a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
                                            </svg>
                                            &nbsp;&nbsp;My_file.pdf
                                        </p>
                                        </a>
                                        </div>

                                        <h6 class="pb-1"><b>Recordings</b></h6>
                                        <hr class="pb-3">
                                        <div v-if="getVideoList(record.id).length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5">
                                            <template v-for="video in getVideoList(record.id)">
                                                <div>
                                                    <div class="py-2 pl-4">{{ video.video_name }}</div>
                                                    <div v-html="video.video_link"></div>
                                                </div>
                                            </template>
                                            
                                            <!-- <div v-html="record.video_link"></div>
                                            <div v-html="record.video_link"></div> -->
                                            <!-- Add more video links as needed -->
                                        </div>
                                        <div v-else>
                                            <p class="pt-3 pb-7 pl-4">No recordings available.</p>
                                        </div>
                                    </div>
                                    <div v-else class="container flex justify-center items-center py-20">
                                        <a href="/payments">
                                        <button type="button" class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Pay For Access</button>
                                        </a>
                                    </div>
                                </div>
                            </template>


                            <!-- <template v-if="activeTab === 'dashboard'">
                                <div class="container flex justify-center items-center">
                                    <button @click="submit('1')" type="submit" class="my-8 focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-400 dark:hover:bg-green-700 dark:focus:ring-green-800">Join Class</button>
                                </div>
                            </template>
                            <template v-if="activeTab === 'settings'">
                                <div class="container flex justify-center items-center">
                                    <button @click="submit('2')" class="my-8 focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-400 dark:hover:bg-green-700 dark:focus:ring-green-800">Join Class</button>
                                </div>
                            </template>
                            <template v-if="activeTab === 'contact'">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Contact Tab</h3>
                                <p class="mb-2">This is some placeholder content for the Contact tab's associated content.</p>
                            </template> -->
                            </div>
                        </template>
                        <template v-else>
                            <p>There is no Class to show</p>
                        </template>
                    </div>
                                        

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.back-color { 
    background-color: #2f7dd1; 
    color: white;
}
@media only screen and (min-width: 300px) {
.back-color  {
    width: 100%;
  }
}
</style>
