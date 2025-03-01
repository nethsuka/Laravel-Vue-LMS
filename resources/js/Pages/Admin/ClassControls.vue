<script setup>
import Sidebar from '@/Layouts/Sidebar.vue';
import { onMounted, ref,watch } from 'vue'
import { VueDraggable } from 'vue-draggable-plus'
import 'primeicons/primeicons.css'
import { Head, useForm, usePage, router } from '@inertiajs/vue3';
import { FwbTab, FwbAlert, FwbTabs, FwbButton, FwbModal, FwbTextarea, FwbInput, FwbSelect, FwbFileInput, FwbHeading } from 'flowbite-vue'

const isShowModal = ref(false)
const isShowModalclass = ref(false)
const selected = ref('')
const istuteModal = ref(false)

const { props } = usePage();

const Arrays = defineProps({
    videoDetails: Array,
    classDetails: Array,
    tuteDetails: Array,
});

const activeTab = ref((Arrays.classDetails.length > 0 ? Arrays.classDetails[0].class_name : 'no data'));

const form2 = useForm({
    class_name: '',
    zoom_link: '',
    tele_link: '',
});

const form3 = useForm({
    class_name: '',
    zoom_link: '',
    tele_group: '',
});

const form4 = useForm({
    tuition_class_id: '',
    video_link: '',
    video_name: '',
    expiry_date: '',
    index: 0,
});

const form5 = useForm({
    classId : '',
    tute_name: '',
    file: null,
});

const form6 = useForm({
    tuteId : '',
});

const class_type = [
    { value: 'Paper', name: 'Paper' },
    { value: 'Theory', name: 'Theory' },
];

function validatenumber(event) {
    const value = event.target.value;
    // Allow only numbers
    event.target.value = value.replace(/[^\d]/g, '');
}

function addclassmodal() {
    isShowModalclass.value = true
}

function addtuteopen() {
    istuteModal.value = true
}

function addtute(classid) {

    console.log(classid);
    console.log(file.value);

    form5.classId = classid;
    form5.tute_name = tute_name.value;
    form5.file = file.value;
    form5.post('/class-controls/addTute', {
        preserveScroll: false,
        onSuccess: () => {
            tute_name.value = '';
            file.value = null;
            form5.reset();
        },
    });
    addtuteclose();
}

function addtuteclose() {
    istuteModal.value = false
}


function addclassmodalclose() {
    isShowModalclass.value = false
    class_year.value = ''
    zoom_link.value = ''
    tele_link.value = ''
    selected.value = ''
    exits.value = false
}

const exits = ref(false)
function addclasses() {
    const class_name = class_year.value + " " + selected.value;
    exits.value = classlist.value.some(item => item.class_name == class_name);
    if (exits.value) {
        return;
    }
    addclassmodalclose()

    console.log(class_name);
    const obj = {
        id: null,
        class_name: class_name,
        tele_group: form2.tele_link,
        zoom_link: form2.zoom_link,
    }
    classlist.value.push(obj)
    console.log(classlist.value)

    form2.class_name = class_name;

    form2.post('/class-controls/addclass', {
        preserveScroll: false,
        onSuccess: () => {
            form2.reset();
            this.activeTab = this.Arrays.classDetails.length > 0 ? this.Arrays.classDetails[0].class_name : 'no data';
        },
    });
}
function showalert(msg) {
    alert(msg)
}

const video_link = ref('')
const video_name = ref('')
const video_expiry_date = ref('');
const classvideoobj = ref([])

const tute_name = ref('')
const file = ref(null)

const class_year = ref('')
const zoom_link = ref('')
const tele_link = ref('')

function saveAndClose(classid) {
    handleAdd(classid)
    isShowModal.value = false
}

function closeModal() {
    isShowModal.value = false
}
function showModal() {
    isShowModal.value = true
}

const list = ref(Arrays.videoDetails);
const classlist = ref(Arrays.classDetails);

const listobj = ref([...list.value]);

const form1 = useForm({
    modifiedList: [],
});

const sendList = async()=> {
    try{
        form1.modifiedList = listobj.value;
        await form1.post('/class-controls/video-list-update',{
            preserveScroll: false,
            onSuccess: (page) => {
                if(page.props.videoDetails){
                    list.value = page.props.videoDetails;
                    listobj.value = [...list.value];
                    createlist()
                }
            },
        });
    }catch (error){
        console.log("error : ",error)
    }
};

function createlist() {
    listobj.value.sort((a, b) => a.index - b.index);
}
onMounted(() => {
    createlist();
    console.log(listobj.value)
})

function remove(index) {
    listobj.value.splice(index, 1)
}
function onup(classid) {
    let i = 1;
    for (const item of listobj.value) {
        if (item.tuition_class_id == classid) {
            item.index = i
            i++;
        }
    }
    createlist()
    console.log(listobj.value)
}


const handleAdd= async(classid) => {
    try{
        const lastindex = listobj.value
            .filter(item => item.tuition_class_id === classid)
            .reduce((max, item) => Math.max(max, item.index), 0);
        console.log(lastindex)

        form4.tuition_class_id = classid;
        form4.video_link = video_link.value;
        form4.video_name = video_name.value;
        form4.expiry_date = video_expiry_date.value;
        form4.index = lastindex + 1;

        
        await form4.post('/class-controls/addnewvideo', {
            preserveScroll: true,
            onSuccess: (page) => {
                video_link.value = '';
                video_name.value = '';
                video_expiry_date.value = '';
                
                if(page.props.videoDetails){
                    list.value = page.props.videoDetails;
                    listobj.value =[...list.value];
                    createlist();
                }
            },
        });
    }catch(error){
        console.log("handle error : ",error)
    }
};

watch(listobj,()=>{
    createlist();   
},{deep:true})

function saveclasslist(classid) {
    const classobj = classlist.value.find(i => i.id === classid)
    // console.log(classobj)
    form3.class_name = classobj.class_name;
    form3.zoom_link = classobj.zoom_link;
    form3.tele_group = classobj.tele_group;
    form3.patch('/class-controls/updateclass', {
        preserveScroll: false,
    });
}
function disabledsavechanges() {
    const nullvalues = listobj.value.filter(i => i.video_link === null || i.video_link.trim() === '' || i.expiry_date === null || i.expiry_date.trim() === '')
    if (nullvalues.length > 0) {
        return true
    } else {
        return false
    }
}

const handleDrop = (event) => {
  event.preventDefault()
  const droppedFiles = event.dataTransfer.files
  if (droppedFiles.length > 0) {
    file.value = droppedFiles[0] // Save the first file dropped
  }
}

const handleFileChange = (event) => {
  const selectedFile = event.target.files[0]
  if (selectedFile) {
    file.value = selectedFile // Save the selected file
  }
}


function getTutesAccordingToClass(tuteClassId) {
  return Arrays.tuteDetails.filter((tute) => tute.tuition_class_id === tuteClassId)
}

function getFilePath(filePath) {
  // Construct the URL using the base path
  return `${import.meta.env.VITE_APP_BASE_URL}/storage/${filePath}`;
}

function removeTute(tuteId) {
    form6.tuteId = tuteId;
    const choice = confirm('Are you sure you want to delete this file ?');
    if (choice) {
        form6.delete('/class-controls/deleteTute', {
            preserveScroll: false,
            onSuccess: () => {
                form6.reset();
            },
        });
    }
}

const form7 = useForm({
    classId: '',
})

function deleteClass(classId) {
    form7.classId = classId;
    const choice = confirm('Are you sure you want to permanently delete this class ?');
    if (choice) {
        form7.delete('/class-controls/deleteClass', {
            preserveScroll: false,
            onSuccess: () => {
                form7.reset();
                this.activeTab = this.Arrays.classDetails.length > 0 ? this.Arrays.classDetails[0].class_name : 'no data';
            },
        });
    }
}

function isExpired(expiryDate) {
  if (!expiryDate) return false; // if expiry date is null, consider it not expired
  const currentDate = new Date();
  const expiry = new Date(expiryDate);
  return expiry < currentDate; // return true if the expiry date is in the past
}

</script>
<template>
    <Head title="Class Controls"></Head>
    <Sidebar>
        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8" :style="{ overflowY: 'auto', maxHeight: '85vh' }">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3 mb-4">
                    <!-- content -->
                    <div class="p-12">
                        <fwb-alert v-if="$page.props.flash.successMsg" closable icon type="success"
                            class="flex justify-center fixed top-24 left-1/2 transform -translate-x-1/2 z-50 bg-green-100">
                            <p>{{ $page.props.flash.successMsg }}</p>
                        </fwb-alert>
                        <fwb-alert v-if="$page.props.flash.errorMsg" closable icon type="danger"
                            class="flex justify-center fixed top-24 left-1/2 transform -translate-x-1/2 z-50">
                            <p>{{ $page.props.flash.errorMsg }}</p>
                        </fwb-alert>
                        <fwb-alert v-if="form5.errors.file" closable icon type="danger"
                            class="flex justify-center fixed top-24 left-1/2 transform -translate-x-1/2 z-50">
                            <p>{{ form5.errors.file }}</p>
                        </fwb-alert>
                        <fwb-heading tag="h4" size="lg" class="mb-5">
                            Class Controls
                        </fwb-heading>
                        <fwb-button type="button" @click="addclassmodal"
                            class="float-end focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                            Add Class</fwb-button><br><br>
                        <fwb-tabs v-model="activeTab" class="p-5">
                            <template v-if="Arrays.classDetails.length > 0">
                                <template v-for="tuteClass in Arrays.classDetails" :key="tuteClass.id">
                                    <fwb-tab :name="tuteClass.class_name" :title="tuteClass.class_name">
                                        <form class="max-w-2xl mx-auto mt-6 border-2 pt-5 py-2 px-14 rounded-md bg-slate-50">
                                            <div class="mb-5 flex items-center">
                                                <label for="l1"
                                                    class="text-sm font-medium text-gray-900 dark:text-white mr-3 whitespace-nowrap">Class
                                                    Name</label>
                                                <input type="text" id="l1" aria-label="disabled input"
                                                    class="cursor-not-allowed bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 flex-grow"
                                                    placeholder="class name" disabled :value="tuteClass.class_name"
                                                    required />
                                            </div>
                                            <div class="mb-5 flex items-center">
                                                <label for="l2"
                                                    class="text-sm  font-medium text-gray-900 dark:text-white mr-3 whitespace-nowrap">Zoom
                                                    Link</label>
                                                <textarea id="l2" rows="3"
                                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-200 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="Enter your content here..." :value="tuteClass.zoom_link"
                                                    @input="tuteClass.zoom_link = $event.target.value"></textarea>
                                            </div>
                                            <div class="mb-5 flex items-center">
                                                <label for="l3"
                                                    class="text-sm font-medium text-gray-900 dark:text-white mr-3 whitespace-nowrap">Telegram
                                                    Link</label>
                                                <textarea id="l3" rows="3"
                                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-200 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="Enter your content here..." :value="tuteClass.tele_group"
                                                    @input="tuteClass.tele_group = $event.target.value"></textarea>
                                            </div>
                                            <fwb-button type="button" size="sm" class="float-end"
                                                @click="saveclasslist(tuteClass.id)">Save Changes</fwb-button>
                                            <br><br>
                                        </form>

                                        <br><br>
                                        <div class="mb-5 flex w-1/2">
                                            <label for="l3" class="text-sm font-medium text-gray-900 dark:text-white mr-8 whitespace-nowrap">Tutes:</label>
                                            <div class="flex flex-col w-full">
                                                <button @click="addtuteopen" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
                                                    </svg>
                                                    <span>&nbsp;Add Tute</span>
                                                </button>
                                                <div class="flex flex-col gap-2 p-4 w-full bg-gray-500/5 rounded-b-md">
                                                    <template v-for="tute in getTutesAccordingToClass(tuteClass.id)" :key="tute.id">
                                                        <div class="h-auto bg-gray-500/5 px-4 py-2 rounded flex items-center justify-between">
                                                            <div class="flex flex-row w-full gap-4">
                                                                <div class="flex flex-col flex-1">
                                                                    <a :href="'storage/'+tute.tute_path" :download="tute.tute_name" class="flex justify-between items-center max-w-sm p-3 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                                                        <p class="flex font-normal text-gray-700 dark:text-gray-400">
                                                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                                                <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7ZM8 16a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1-5a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
                                                                            </svg>
                                                                            &nbsp;&nbsp;{{tute.tute_name + '.' + tute.tute_path.split('.').pop()}}
                                                                        </p>
                                                                        <svg class="mr-3 w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                                            <path fill-rule="evenodd" d="M13 11.15V4a1 1 0 1 0-2 0v7.15L8.78 8.374a1 1 0 1 0-1.56 1.25l4 5a1 1 0 0 0 1.56 0l4-5a1 1 0 1 0-1.56-1.25L13 11.15Z" clip-rule="evenodd"/>
                                                                            <path fill-rule="evenodd" d="M9.657 15.874 7.358 13H5a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-2.358l-2.3 2.874a3 3 0 0 1-4.685 0ZM17 16a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H17Z" clip-rule="evenodd"/>
                                                                        </svg>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                            <!-- Remove Button -->
                                                            <button class="cursor-pointer ml-4" @click="removeTute(tute.id)">
                                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                                    <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-5 flex w-full">
                                            <label for="l3"
                                                class="text-sm font-medium text-gray-900 dark:text-white mr-8 whitespace-nowrap">Video
                                                : </label>
                                            <div class="flex flex-col w-full">
                                                <button @click="showModal"
                                                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
                                                    </svg>
                                                    <span>&nbsp;Add Video</span>
                                                </button>
                                                <VueDraggable v-model="listobj" :animation="150" handle=".handle"
                                                        class="flex flex-col gap-2 p-4 w-300px bg-gray-500/5 rounded"
                                                        v-on:update="onup(tuteClass.id)">
                                                    <template v-for="(item, index) in listobj" :key="item.id || index">
                                                        <div v-show="item.tuition_class_id === tuteClass.id"
                                                            class="h-50px bg-gray-500/5 px-2 rounded flex items-center justify-between relative">
                                                            
                                                            <!-- Expired Label (conditionally rendered) -->
                                                            <span  v-if="isExpired(item.expiry_date)" class="absolute top-0 right-0 bg-red-500 text-white text-xs py-1 px-2 rounded-bl-lg">
                                                                Expired
                                                            </span>

                                                            <button class="handle cursor-move mr-4">
                                                                <i class="pi pi-list" style="font-size: 1.5rem"></i>
                                                            </button>
                                                            <div class="flex flex-row">
                                                                <div class="flex flex-col mb-4 mt-4 mr-4">
                                                                    <label for="small-input"
                                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Video name</label>
                                                                    <input type="text" v-model="item.video_name"
                                                                        id="small-input"
                                                                        class="mr-3 block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                    <!-- <fwb-alert type="warning"
                                                                        v-if="item.video_name === null || item.video_name.trim() === ''">
                                                                        Video name is required
                                                                    </fwb-alert> -->
                                                                </div>
                                                                <div class="flex flex-col mb-4">
                                                                    <label for="message"
                                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Video link</label>
                                                                    <textarea id="message" rows="4"
                                                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                        placeholder="Write your thoughts here..."
                                                                        v-model="item.video_link"></textarea>
                                                                    <fwb-alert type="warning"
                                                                        v-if="item.video_link === null || item.video_link.trim() === ''">
                                                                        Video link is required
                                                                    </fwb-alert>
                                                                </div>

                                                                <div class="flex flex-col mb-4 ml-5">
                                                                    <label for="email"
                                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white mt-3">Expiry date</label>
                                                                    <input type="date"
                                                                        class="border bg-gray-50 border-gray-300 rounded-lg p-1 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                                        v-model="item.expiry_date">
                                                                    <fwb-alert type="warning"
                                                                        v-if="item.expiry_date === null || item.expiry_date.trim() === ''">
                                                                        Expiry date is required
                                                                    </fwb-alert>
                                                                </div>
                                                            </div>

                                                            <button class="cursor-pointer" @click="remove(index)">
                                                                <i class="pi pi-times" style="font-size: 1.5rem"></i>
                                                            </button>
                                                        </div>
                                                    </template>
                                                </VueDraggable>
                                            </div>
                                        </div>
                                        <fwb-button @click="sendList()" size="sm" color="green" class="float-end"
                                            :disabled="disabledsavechanges()">Save
                                            Changes</fwb-button>

                                        <br>
                                        <br>
                                        <br>
                                        <div id="alert-additional-content-2"
                                            class="p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                                            role="alert">
                                            <div class="flex items-center">
                                                <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                                </svg>
                                                <!-- <span class="sr-only">Info</span> Outer Overflow bug comes due to this tag-->
                                                <h3 class="text-lg font-medium">Warning!</h3>
                                            </div>
                                            <div class="mt-2 mb-4 text-sm">
                                                Deleting this class will permanently erase all associated data and it cannot be recovered.</div>
                                            <div class="flex">
                                                <button type="button" @click="deleteClass(tuteClass.id)"
                                                    class="text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-1.5 me-2 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                                    Delete
                                                </button>
                                            </div>
                                        </div>

                                        <fwb-modal v-if="istuteModal" @close="addtuteclose">
                                            <template #header>
                                                <div class="flex items-center text-lg">
                                                    Add Tute for : {{ tuteClass.class_name }}
                                                </div>
                                            </template>
                                            <template #body>
                                                <fwb-input v-model="tute_name" placeholder="Enter Tute Name"
                                                    label="File name" />
                                                <br>
                                                <div class="flex items-center justify-center w-full" 
                                                    id="dropzone" 
                                                    @dragover.prevent 
                                                    @drop="handleDrop">
                                                    <label for="dropzone-file" 
                                                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                                            </svg>
                                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG or PDF</p>
                                                            <p v-if="file" class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ file.name }}</p>
                                                        </div>
                                                        <input id="dropzone-file" 
                                                            @input="form5.file = $event.target.files[0]"
                                                            accept=".pdf,.png,.jpg,.jpeg,.doc,.xlsx,.txt" 
                                                            type="file" 
                                                            class="hidden" 
                                                            aria-describedby="file_input_help" />
                                                    </label>
                                                </div>
                                            </template>
                                            <template #footer>
                                                <div class="flex justify-between">
                                                    <fwb-button @click="addtuteclose" color="alternative">
                                                        Close
                                                    </fwb-button>
                                                    <fwb-button @click="addtute(tuteClass.id)" color="green"
                                                        :disabled="!file">
                                                        Save
                                                    </fwb-button>
                                                </div>
                                            </template>
                                        </fwb-modal>
                                        <fwb-modal v-if="isShowModal" @close="closeModal">
                                            <template #header>
                                                <div class="flex items-center text-lg">
                                                    Add video for : {{ tuteClass.class_name }}
                                                </div>
                                            </template>
                                            <template #body>
                                                <fwb-input class="mb-4" v-model="video_name" label="Video Name"
                                                    placeholder="Enter Class Name" size="md" />
                                                <fwb-textarea v-model="video_link" :rows="4" label="Class Link"
                                                    placeholder="Enter link..." />
                                                <label for="email"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white mt-3">Expiry
                                                    date</label>
                                                <input type="date" v-model="video_expiry_date"
                                                    class="border bg-gray-50 border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            </template>
                                            <template #footer>
                                                <div class="flex justify-between">
                                                    <fwb-button @click="closeModal" color="alternative">
                                                        Close
                                                    </fwb-button>
                                                    <fwb-button @click="saveAndClose(tuteClass.id)" color="green"
                                                        :disabled="!video_link || !video_expiry_date">
                                                        Save
                                                    </fwb-button>
                                                </div>
                                            </template>
                                        </fwb-modal>
                                    </fwb-tab>
                                </template>
                            </template>
                            <template v-else>
                                <p class="pt-1 pb-3 pl-4">No class records available.</p>
                            </template>

                            <!-- <fwb-tab name="2025 Paper" title="2025 Paper">
                                Lorem ipsum dolor... 2
                            </fwb-tab>
                            <fwb-tab name="2026 Theory" title="2026 Theory">
                                Lorem ipsum dolor... 3
                            </fwb-tab>
                            <fwb-tab name="fourth" title="Fourth" disabled>
                                Lorem ipsum dolor... 4 -->
                            <!-- </fwb-tab> -->
                        </fwb-tabs>
                    </div>
                </div>

                <!-- Add class modal -->
                <fwb-modal v-if="isShowModalclass" @close="addclassmodalclose">
                    <template #header>
                        <div class="flex items-center text-lg">
                            Add class
                        </div>
                    </template>
                    <template #body>
                        <div class="grid gap-6 mb-6 md:grid-cols-2 w-full">
                            <fwb-input v-model="class_year" label="Class Year" placeholder="Enter class Year"
                                type="text" @input="validatenumber" />
                            <fwb-select v-model="selected" :options="class_type" label="Class type" />
                        </div>

                        <fwb-textarea v-model="form2.zoom_link" :rows="4" label="Zoom link"
                            placeholder="Enter Zoom link..." />
                        <br>
                        <fwb-input v-model="form2.tele_link" label="Telegram link" placeholder="Enter Telegram link" />
                        <br>
                        <fwb-alert v-if="exits" type="danger">
                            Already have {{ class_year }} {{ selected }}
                        </fwb-alert>

                    </template>
                    <template #footer>
                        <div class="flex justify-between">
                            <fwb-button @click="addclassmodalclose" color="alternative">
                                Close
                            </fwb-button>
                            <fwb-button type="submit" @click="addclasses" color="green"
                                :disabled="!class_year || !selected">
                                Save
                            </fwb-button>
                        </div>
                    </template>
                </fwb-modal>
            </div>
        </div>
    </Sidebar>
</template>