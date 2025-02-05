<script setup>
import { Link } from '@inertiajs/vue3';
import Logo from "../../assets/Logo.svg"
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center py-10 bg-gray-100">
        <div>
            <Link href="/">
                <img :src=Logo class="w-40 h-20 fill-current text-gray-500" />
            </Link>
        </div>

        <div
            class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
