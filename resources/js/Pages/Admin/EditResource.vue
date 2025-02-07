<script setup>
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Layouts/Sidebar.vue';
import { ref, onMounted } from 'vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import { VueDraggable } from 'vue-draggable-plus'
import 'primeicons/primeicons.css'
import {
    FwbInput,
    FwbSelect,
    FwbHeading,
    FwbTextarea,
    FwbButton,
    FwbModal,
    FwbAlert,
    FwbP
} from 'flowbite-vue';


const { props } = usePage();

const Arrays = defineProps({
    resource: Object,
    videos: Array,
});

const category = [
    { value: 'theory', name: 'Theory' },
    { value: 'paper', name: 'Paper' },
]

const form1 = useForm({
    id: '',
    name: '',
    price: '',
    category: '',
});

const form2 = useForm({
    resource_id: '',
    name: '',
    link: '',
    index: '',
});

function saveResourceChanges() {
    form1.id = Arrays.resource.id;
    form1.name = name.value;
    form1.price = price.value;
    form1.category = selected.value;
    form1.patch('/resource-controls/edit/save-changes', {
        preserveScroll: false,
    });
}

const name = ref(null)
const price = ref(null)
const selected = ref('')
const new_title = ref(null)
const new_url = ref(null)

const links = ref(Arrays.videos);

function remove(index) {
    links.value.splice(index, 1)
    onup()
}
onMounted(()=>{
    links.value.sort((a, b) => a.index - b.index);
})
function onup() {
    let i = 1;
    for (const item of links.value) {
        item.index = i;
        i++;
    }
    links.value.sort((a, b) => a.index - b.index);
}

function validatenumber(event) {
    const value = event.target.value;
    // Allow only numbers
    event.target.value = value.replace(/[^\d]/g, '');
}

const isShowModal = ref(false)

function SavecloseModal() {
    let lastindex = 1

    if(links.value.length == 0){
        console.log("thinula")
        lastindex = 1
    } else{
        lastindex = Math.max(...links.value.map(link => link.index)) + 1;
    }
    console.log('hi')
    links.value.push({
        name: new_title.value,
        link: new_url.value,
        index: lastindex ,
    })
    form2.resource_id = Arrays.resource.id;
    form2.name = new_title.value;
    form2.link = new_url.value;
    form2.index = lastindex;
    form2.post('/resource-controls/resource/add-video', {
        preserveScroll: false,
    });
    new_title.value = ''
    new_url.value = ''
    closeModal()
}

function closeModal() {
    isShowModal.value = false
}

function showModal() {
    isShowModal.value = true
}

onMounted(() => {
    name.value = Arrays.resource.name
    price.value = Arrays.resource.price
    selected.value = Arrays.resource.category
    links.value.sort((a, b) => a.index - b.index)
    console.log(links.value)
})

function isurlempty() {
    return links.value.some(link => !link.link || link.link.trim() === '')
}
</script>
<template>
    <Sidebar>

        <Head title="Resource Control Edit"></Head>
        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8" :style="{ overflowY: 'auto', maxHeight: '85vh' }">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3 mb-4">
                    <div class="p-14">
                        <div>
                            <fwb-alert v-if="$page.props.flash.successMsg" closable icon type="success"
                                class="flex justify-center fixed top-24 left-1/2 transform -translate-x-1/2 z-50">
                                <p>{{ $page.props.flash.successMsg }}</p>
                            </fwb-alert>
                            <fwb-alert v-if="$page.props.flash.errorMsg" closable icon type="danger"
                                class="flex justify-center fixed top-24 left-1/2 transform -translate-x-1/2 z-50">
                                <p>{{ $page.props.flash.errorMsg }}</p>
                            </fwb-alert>
                            <fwb-heading tag="h3" size="lg" class="mb-10">
                                Resource Edit
                            </fwb-heading>
                            <div class="space-y-4 max-w-4xl p-4"
                                style="border: 2px solid #dbdae0; border-radius: 10px;">
                                <fwb-input v-model="name" label="Resource Name" placeholder="Enter Resource name"
                                    size="sm" />
                                <fwb-input v-model="price" label="Price" placeholder="Enter Price" size="sm" type="text"
                                    @input="validatenumber" />
                                <fwb-select v-model="selected" :options="category" label="Select a country" />
                                <div class="flex justify-end mt-4">
                                    <fwb-button @click="saveResourceChanges" :disabled="!name || !price || !selected"
                                        gradient="green">Save changes</fwb-button>
                                </div>
                            </div>

                            <fwb-heading tag="h5" size="md" class="mb-4 mt-10">
                                Edite Video Links
                            </fwb-heading>
                            <div class="max-w-4xl p-3" style="border: 2px solid #dbdae0; border-radius: 10px;">
                                <div class="flex justify-end mb-5">
                                    <fwb-button gradient="cyan" @click="showModal">
                                        + Add Video
                                    </fwb-button>
                                </div>
                                <div class="flex justify-between">
                                    <VueDraggable v-model="links" :animation="150" handle=".handle" style="width: 100%;"
                                        class="flex flex-col gap-2 p-4 w-300px bg-gray-500/5 rounded"
                                        v-on:update="onup">
                                        <div v-for="(item, index) in links" :key="item.id" style="margin-top: 10px; padding-top: 10px;"
                                            class="h-50px bg-gray-500/5 px-2 rounded flex items-center justify-between">

                                            <button class="handle cursor-move">
                                                <i class="pi pi-list" style="font-size: 1.5rem"></i>
                                            </button>

                                            <fwb-input v-model="item.name" label="Video name" placeholder="
                                            Enter Video name" size="sm" />
                                            <div>

                                                <fwb-textarea v-model="item.link" label="Video embed code" style="width: 100%;" />
                                                <fwb-p v-if="!item.link || item.link.trim() === ''" style="color: red;">
                                                    Please enter a video URL
                                                </fwb-p>
                                            </div>

                                            <button class="cursor-pointer" @click="remove(index)">
                                                <i class="pi pi-times" style="font-size: 1.5rem"></i>
                                            </button>

                                        </div>
                                    </VueDraggable>
                                </div>
                                <div v-if="links.length <= 0" class="flex justify-start bg-gray-500/5 p-5">No Videos added.</div>
                                <div class="flex justify-end mt-4">
                                    <fwb-button gradient="green" :disabled="isurlempty()">Save changes</fwb-button>
                                </div>
                            </div>
                            <fwb-modal v-if="isShowModal" @close="closeModal">
                                <template #header>
                                    <div class="flex items-center text-lg">
                                        Add New Video
                                    </div>
                                </template>
                                <template #body>
                                    <div class="space-y-4">
                                        <fwb-input v-model="new_title" label="Video Title"
                                            placeholder="Enter Video Title" />
                                        <fwb-input v-model="new_url" label="Video URL" placeholder="Enter Video URL" />
                                    </div>
                                </template>
                                <template #footer>
                                    <div class="flex justify-between">
                                        <fwb-button @click="closeModal" color="alternative">
                                            Close
                                        </fwb-button>
                                        <fwb-button :disabled="!new_title || !new_url" @click="SavecloseModal"
                                            color="green">
                                            Save
                                        </fwb-button>
                                    </div>
                                </template>
                            </fwb-modal>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Sidebar>
</template>