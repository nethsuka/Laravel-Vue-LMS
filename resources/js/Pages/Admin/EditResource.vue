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

const Resource = ref({
    name: 'Unit 2: Structure and Bonding',
    links: [{
        title: 'Link 1',
        url: `<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/1012272588?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="video1074884583"></iframe></div>`,
    },
    {
        title: 'Link 2',
        url: `<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/1012272588?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="video1074884583"></iframe></div>`,
    },
    {
        title: 'Link 3',
        url: `<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/1012272588?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="video1074884583"></iframe></div>`,
    },
    ],
    price: 3500,
    category: 'unit',

})

const links = ref([
    {
        title: 'Link 1',
        url: `<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/1012272588?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="video1074884583"></iframe></div>`,
    },
    {
        title: 'Link 2',
        url: `<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/1012272588?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="video1074884583"></iframe></div>`,
    },
    {
        title: 'Link 3',
        url: `<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/1012272588?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="video1074884583"></iframe></div>`,
    },
])

function remove(index) {
    links.value.splice(index, 1)
}
function onup() {
    console.log(links.value)
}
function validatenumber(event) {
    const value = event.target.value;
    // Allow only numbers
    event.target.value = value.replace(/[^\d]/g, '');
}
const isShowModal = ref(false)
function SavecloseModal() {
    Resource.value.links.push({
        title: new_title.value,
        url: new_url.value
    })
    // form2.resource_id = Arrays.resource.id;
    // form2.name = new_title.value;
    // form2.link = new_url.value;
    // form2.index = ;
    // form2.patch('/resource-controls/edit/save-changes', {
    //     preserveScroll: false,
    // });
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
})

function isurlempty() {
    return links.value.some(link => !link.url || link.url.trim() === '')
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

                                            <fwb-input v-model="item.title" label="Video name" placeholder="
                                            Enter Video name" size="sm" />
                                            <div>

                                                <fwb-textarea v-model="item.url" label="Video url" style="width: 100%;" />
                                                <fwb-p v-if="!item.url || item.url.trim() === ''" style="color: red;">
                                                    Please enter a video URL
                                                </fwb-p>
                                            </div>

                                            <button class="cursor-pointer" @click="remove(index)">
                                                <i class="pi pi-times" style="font-size: 1.5rem"></i>
                                            </button>

                                        </div>
                                    </VueDraggable>
                                </div>
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
<!-- <style scoped>
.fade-move,
.fade-enter-active,
.fade-leave-active {
    transition: all 0.5s cubic-bezier(0.55, 0, 0.1, 1);
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: scaleY(0.01) translate(30px, 0);
}

.fade-leave-active {
    position: absolute;
}

.sort-target {
    padding: 0 1rem;
}
</style> -->