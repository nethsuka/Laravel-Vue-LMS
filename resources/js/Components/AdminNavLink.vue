<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'items-center text-sm font-medium leading-5 text-white hover:bg-slate-500 transition duration-150 ease-in-out bg-slate-600 flex p-3'
        : 'items-center border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out flex p-3'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
