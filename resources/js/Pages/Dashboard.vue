<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';
import { FwbButton, FwbAlert } from 'flowbite-vue'
import { usePreventDevTools } from '@/Components/DisableDevTools';

usePreventDevTools()
const Arrays = defineProps({

    classDetails: Array,
    extendDetails: Object,
    paidClassDetails: Array,
    videoLinks: Array,
    classTutes: Array,
});


const activeTab = ref((Arrays.classDetails.length > 0 ? Arrays.classDetails[0].class_name : 'no data'));
let changedVideoArray;

const { props } = usePage();

function setActiveTab(tab) {
    activeTab.value = tab;
}



const form2 = useForm({
    classID: '',
});



function joinOnline(cid) {
    form2.classID = cid;
    form2.post('/dashboard/zoomlink');
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
    if (currentDay >= 1 && currentDay <= Arrays.extendDetails.extend_date) {
        return true;
    } else {
        return false;
    }
}

function getVideoList(classID) {
    var videoList = [];
    for (let element of Arrays.videoLinks) {
        if (element.tuition_class_id === classID) {
            videoList.push(element);
        }
    }
    return videoList;
}

function getTutesAccordingToClass(tuteClassId) {
    return Arrays.classTutes.filter((tute) => tute.tuition_class_id === tuteClassId)
}

const downloadFile = (tute_name, tute_path) => {
    // Create a temporary <a> element to trigger the download
    const link = document.createElement('a');
    link.href = 'storage/' + tute_path;
    link.download = tute_name + '.' + tute_path.split('.').pop();
    link.click();
};

const videoWrapper = ref(null);

const preventRightClick = (e) => {
    e.preventDefault();
    e.stopPropagation();
    return false;
};
onMounted(() => {
    if (!videoWrapper.value) return;

    // Add event listener to container
    videoWrapper.value.addEventListener('contextmenu', preventRightClick);

    // Find the iframe and add protection
    const iframe = videoWrapper.value.querySelector('iframe');
    if (iframe) {
        // Prevent right click on iframe
        iframe.addEventListener('contextmenu', preventRightClick);

        // Modify iframe source to add protection parameters
        if (iframe.src.includes('player.vimeo.com')) {
            const url = new URL(iframe.src);
            url.searchParams.set('controls', '1');
            url.searchParams.set('download', '0');
            iframe.src = url.toString();
        }

        // Add security attributes
        iframe.style.pointerEvents = 'none';

        // Create overlay div
        const overlay = document.createElement('div');
        overlay.style.position = 'absolute';
        overlay.style.top = '0';
        overlay.style.left = '0';
        overlay.style.width = '100%';
        overlay.style.height = '100%';
        overlay.style.zIndex = '10';

        // Allow play/pause clicks
        overlay.addEventListener('click', () => {
            iframe.style.pointerEvents = 'auto';
            setTimeout(() => {
                iframe.style.pointerEvents = 'none';
            }, 1000);
        });

        // Prevent right click on overlay
        overlay.addEventListener('contextmenu', preventRightClick);

        // Add overlay
        iframe.parentElement.style.position = 'relative';
        iframe.parentElement.appendChild(overlay);
    }
});

onUnmounted(() => {
    videoWrapper.value?.removeEventListener('contextmenu', preventRightClick);
    const iframe = videoWrapper.value?.querySelector('iframe');
    iframe?.removeEventListener('contextmenu', preventRightClick);
});

</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Dashboard</h2>
                <div>
                    <a href="/more-classes">
                        <template v-if="classDetails.length > 0">
                            <button type="button"
                                class="text-white bg-gradient-to-r from-sky-500 to-sky-700 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-4 py-1.5 text-center shadow-lg shadow-sky-500/50 dark:shadow-lg dark:shadow-cyan-800/80 ml-3">
                                Add More Classes
                            </button>
                        </template>
                        <template v-else>
                            <button type="button"
                                class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-4 py-1.5 text-center shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80">
                                Add Classes
                            </button>
                        </template>
                    </a>
                    <a href="/class-controls" v-if="props.auth.user.role === 'admin'">
                        <button type="button"
                            class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-sm px-4 py-1.5 text-center me-2 mb-2 ml-2">
                            Admin Panel
                        </button>
                    </a>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3">
                    <!-- <div class="p-6 text-gray-900">You're logged in!</div> -->
                    <!-- <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p> -->


                    <h3 class="text-3xl font-extrabold text-center text-gray-800 dark:text-white mt-1 mb-6">
                        My Classes
                    </h3>
                    <hr class="h-px my-6 bg-gray-200 border-0 dark:bg-gray-900">

                    <div class="md:flex">
                        <template v-if="Arrays.classDetails.length > 0">
                            <ul
                                class="flex-column space-y space-y-4 text-sm font-medium text-gray-500 dark:text-gray-400 md:me-4 mb-4 md:mb-0">
                                <li v-for="record in classDetails" :key="record.id">
                                    <a href="#"
                                        class="whitespace-nowrap inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white"
                                        :class="{ 'back-color': activeTab == record.class_name }"
                                        @click.prevent="setActiveTab(record.class_name)">
                                        {{ record.class_name }}
                                    </a>
                                </li>
                            </ul>

                            <div
                                class="p-6 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full">

                                <template v-for="record in classDetails" :key="record.id">
                                    <div v-if="activeTab === record.class_name">
                                        <div v-if="checkPaidOrNot(record.id) || checkDateRange()">
                                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{
                                                record.class_name }} Class</h3>
                                            <fwb-alert v-if="!checkPaidOrNot(record.id)" border type="warning" icon
                                                closable class="flex justify-between items-center max-w-xl mt-7">
                                                <p>This class is available only until the <b>{{
                                                        Arrays.extendDetails.extend_date }}th</b> of this month. If
                                                    payment is not settled by this date, you will no longer have access
                                                    to the class.</p>
                                            </fwb-alert>
                                            <div class="mt-5 mb-10">
                                                <!-- <a href="#" @click="joinOnline(record.id)"
                                                    class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-xl text-sm px-6 py-3 text-center flex items-center justify-center me-2 mb-2 space-x-2">
                                                    <span>Join Zoom Class</span>
                                                </a> -->
                                                <fwb-button gradient="teal" class="mr-2.5 mb-1"
                                                    @click="joinOnline(record.id)">
                                                    <template #prefix>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            viewBox="0 0 50 50" style="fill:#FFFFFF;">
                                                            <path
                                                                d="M33.619,4H16.381C9.554,4,4,9.554,4,16.381v17.238C4,40.446,9.554,46,16.381,46h17.238C40.446,46,46,40.446,46,33.619V16.381C46,9.554,40.446,4,33.619,4z M30,30.386C30,31.278,29.278,32,28.386,32H15.005C12.793,32,11,30.207,11,27.995v-9.382C11,17.722,11.722,17,12.614,17h13.382C28.207,17,30,18.793,30,21.005V30.386z M39,30.196c0,0.785-0.864,1.264-1.53,0.848l-5-3.125C32.178,27.736,32,27.416,32,27.071v-5.141c0-0.345,0.178-0.665,0.47-0.848l5-3.125C38.136,17.54,39,18.019,39,18.804V30.196z">
                                                            </path>
                                                        </svg>
                                                    </template>
                                                    Join Zoom Class
                                                </fwb-button>
                                                <a :href="record.tele_group">
                                                    <fwb-button gradient="teal">
                                                        <template #prefix>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" viewBox="0 0 24 24" fill="currentColor"
                                                                class="mr-2">
                                                                <path
                                                                    d="M9.45 14.72l-.38 5.36c.54 0 .78-.23 1.07-.5l2.56-2.46 5.3 3.87c.97.53 1.66.25 1.91-.89l3.45-16.23.01-.02c.31-1.46-.53-2.04-1.46-1.71L1.29 9.81c-1.41.55-1.39 1.35-.24 1.71l5.04 1.56 11.67-7.36c.55-.33 1.06-.15.64.21" />
                                                            </svg>
                                                        </template>
                                                        Telegram Channel
                                                    </fwb-button>
                                                </a>
                                            </div>

                                            <div class="pb-9">
                                                <h6 class="pb-1 text-lg"><b>Tutes</b></h6>
                                                <hr class="pb-3">
                                                <template v-if="getTutesAccordingToClass(record.id).length !== 0">
                                                    <template v-for="tute in getTutesAccordingToClass(record.id)"
                                                        :key="tute.id">
                                                        <button @click="downloadFile(tute.tute_name, tute.tute_path)"
                                                            class="mb-3 flex justify-between items-center w-1/3 p-3 bg-white border border-gray-200 rounded-lg shadow hover:bg-cyan-50 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                                            <p
                                                                class="flex font-normal text-gray-700 dark:text-gray-400 truncate">
                                                                <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                                    aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" fill="currentColor" viewBox="0 0 24 24">
                                                                    <path fill-rule="evenodd"
                                                                        d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7ZM8 16a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1-5a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                                &nbsp;&nbsp;{{ tute.tute_name + '.' +
                                                                tute.tute_path.split('.').pop() }}
                                                            </p>
                                                            <svg class="mr-3 ml-2 w-6 h-6 text-gray-800 dark:text-white"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                width="24" height="24" fill="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path fill-rule="evenodd"
                                                                    d="M13 11.15V4a1 1 0 1 0-2 0v7.15L8.78 8.374a1 1 0 1 0-1.56 1.25l4 5a1 1 0 0 0 1.56 0l4-5a1 1 0 1 0-1.56-1.25L13 11.15Z"
                                                                    clip-rule="evenodd" />
                                                                <path fill-rule="evenodd"
                                                                    d="M9.657 15.874 7.358 13H5a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-2.358l-2.3 2.874a3 3 0 0 1-4.685 0ZM17 16a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H17Z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </template>
                                                </template>
                                                <template v-else>
                                                    <p>No tutes available.</p>
                                                </template>
                                            </div>

                                            <h6 class="pb-1 text-lg"><b>Recordings</b></h6>
                                            <hr class="pb-3">
                                            <div v-if="getVideoList(record.id).length > 0"
                                                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5">
                                                <template v-for="(video, index) in getVideoList(record.id)"
                                                    :key="index">
                                                    <div
                                                        class="bg-white shadow-md rounded-lg mb-4 p-4 hover:bg-gray-100 transition-colors duration-300">
                                                        <div class="flex justify-end">
                                                            <div
                                                                class="inline-block bg-gray-300 text-gray-800 text-sm py-1 px-3 rounded-full">
                                                                Expires on <span class="font-bold">{{ video.expiry_date
                                                                }} | Time : 23:59</span>
                                                            </div>
                                                        </div>
                                                        <div class="mt-2 text-sm text-gray-600 video-wrapper"
                                                            @contextmenu.prevent>
                                                            <div v-html="video.video_link"
                                                                class="cursor-pointer video-container relative select-none"
                                                                ref="videoWrapper" @contextmenu.prevent>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                                <!-- <div v-html="record.video_link"></div>
                                                <div v-html="record.video_link"></div> -->
                                                <!-- Add more video links as needed -->
                                            </div>
                                            <div v-else>
                                                <p>No recordings available.</p>
                                            </div>
                                        </div>
                                        <div v-else class="container flex justify-center items-center py-20">
                                            <a href="/payments">
                                                <fwb-button color="dark" class="rounded-full">Payment
                                                    Required</fwb-button>
                                            </a>
                                        </div>
                                    </div>
                                </template>

                            </div>
                        </template>
                        <template v-else>
                            <div class="flex justify-center items-center w-full p-10">
                                <div class="max-w-md text-center">
                                    <p class="text-gray-600 mb-4">You haven't bought any classes</p>
                                    <a href="/more-classes">
                                        <fwb-button gradient="cyan-blue">Add Classes</fwb-button>
                                    </a>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>
/* .back-color {
    background-color: #2279e3;
    color: white;
} */
.back-color {
    background: linear-gradient(to right, #84cc16, #65a30d, #4d7c0f);
    /* from-lime-500 via-lime-600 to-lime-700 */
    color: white;
}

.back-color:hover {
    background: linear-gradient(to right, #65a30d, #4d7c0f, #3b6210);
    /* Hover gradient */
}

@media only screen and (min-width: 300px) {
    .back-color {
        width: 100%;
    }
}

.video-wrapper {
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
}

.video-container {
    position: relative;
}

.video-container iframe {
    pointer-events: none;
}

/* Disable text selection for all elements inside video container */
.video-container * {
    user-select: none !important;
    -webkit-user-select: none !important;
    -moz-user-select: none !important;
    -ms-user-select: none !important;
}
</style>
