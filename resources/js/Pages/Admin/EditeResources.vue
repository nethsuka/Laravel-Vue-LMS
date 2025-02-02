<script setup>
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Layouts/Sidebar.vue';
import { ref, onMounted } from 'vue';
import { VueDraggable } from 'vue-draggable-plus'
import 'primeicons/primeicons.css'
import {
    FwbInput,
    FwbSelect,
    FwbHeading,
    FwbTextarea,
    FwbButton,
    FwbModal
} from 'flowbite-vue';
const selected = ref('')
const category = [
    { value: 'unit', name: 'Unit' },
    { value: 'paper', name: 'Paper' },
]
const name = ref(null)
const price = ref(null)
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

function remove(index) {
    Resource.value.links.splice(index, 1)
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
    name.value = Resource.value.name
    price.value = Resource.value.price
    selected.value = Resource.value.category
})
</script>
<template>
    <Sidebar>

        <Head title="Resource Control Edit"></Head>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" :style="{ overflowY: 'auto', maxHeight: '95vh' }">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 py-3">
                    <fwb-heading tag="h5" size="lg" class="mb-4">
                        Resource Edit
                    </fwb-heading>
                    <div class="space-y-4">

                        <fwb-input v-model="name" label="Resource Name" placeholder="Enter Resource name" size="md" />
                        <fwb-input v-model="price" label="Price" placeholder="Enter Price" size="sm" type="text"
                            @input="validatenumber" />

                        <fwb-select v-model="selected" :options="category" label="Select a country" />

                    </div>

                    <fwb-heading tag="h5" size="md" class="mb-4" style="padding-top: 10px;">
                        Edite Video Links
                    </fwb-heading>
                    <div class="flex justify-end">
                        <fwb-button gradient="cyan" @click="showModal">
                            Add Video
                        </fwb-button>
                    </div>
                    <VueDraggable style="padding-top: 10px;" v-model="Resource.links"
                        class="flex flex-col gap-2 w-300px bg-gray-500/5 rounded" target=".sort-target" :scroll="true">
                        <TransitionGroup type="transition" tag="ul" name="fade" class="sort-target">
                            <li v-for="(item, index) in Resource.links" :key="item.id" style="padding: 0.5rem"
                                class="h-50px bg-gray-500/5 rounded flex items-center justify-between px-2">
                                <button class="handle cursor-move mr-4">
                                    <i class="pi pi-list" style="font-size: 1.5rem"></i>
                                </button>
                                <fwb-input v-model="item.title" placeholder="Enter a title" label="Video title" />
                                <fwb-textarea v-model="item.url" :rows="4" label="Video URL"
                                    placeholder="Add video link" />
                                <button class="cursor-pointer" @click="remove(index)">
                                    <i class="pi pi-times" style="font-size: 1.5rem"></i>
                                </button>
                            </li>
                        </TransitionGroup>
                    </VueDraggable>
                    <div class="flex justify-end">
                        <fwb-button gradient="green">Save</fwb-button>
                    </div>
                    <fwb-modal v-if="isShowModal" @close="closeModal">
                        <template #header>
                            <div class="flex items-center text-lg">
                                Add New Video
                            </div>
                        </template>
                        <template #body>
                            <div class="space-y-4">
                                <fwb-input v-model="new_title" label="Video Title" placeholder="Enter Video Title" />
                                <fwb-input v-model="new_url" label="Video URL" placeholder="Enter Video URL" />
                            </div>
                        </template>
                        <template #footer>
                            <div class="flex justify-between">
                                <fwb-button @click="closeModal" color="alternative">
                                    Close
                                </fwb-button>
                                <fwb-button @click="SavecloseModal"  color="green">
                                    Save
                                </fwb-button>
                            </div>
                        </template>
                    </fwb-modal>
                </div>
            </div>
        </div>
    </Sidebar>
</template>
<style>
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
</style>