<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Logo from "../../../assets/Logo.svg"
import LoginBG from "../../../assets/LoginBG.svg"
import DumyGuestLayout from '@/Layouts/DumyGuestLayout.vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <DumyGuestLayout>
        <Head title="Login" />
    <div class="min-h-screen flex flex-col items-center justify-center bg-cover bg-center bg-no-repeat" :style="{ backgroundImage: `url(${LoginBG})` }">
        <!-- Wave Decoration -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
                <defs>
                    <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" style="stop-color:#066C92; stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#25BECF; stop-opacity:1" />
                    </linearGradient>
                </defs>
                <path fill="url(#gradient)" fill-opacity="0.2" d="M0,224L80,213.3C160,203,320,181,480,181.3C640,181,800,203,960,197.3C1120,192,1280,160,1360,144L1440,128L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                <path fill="url(#gradient)" fill-opacity="1" d="M0,224L80,213.3C160,203,320,181,480,181.3C640,181,800,203,960,197.3C1120,192,1280,160,1360,144L1440,128L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z" transform="translate(0, 20)"></path>
                <!-- Apply the gradient to the path -->
            </svg>
        </div>
        <!-- Main Content -->
        <div class="relative z-10 w-full max-w-md px-6">
            <!-- Logo -->
            <div class="text-center mb-4"> <!-- Reduced the margin-bottom here -->
            <img :src=Logo alt="MHCHEM" class="h-12 mx-auto mb-6" />
            <h1 class="text-3xl font-bold text-gray-800">Student Login</h1>
        </div>

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit" class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-lg">
                <div>
                    <InputLabel for="email" value="Email" class="text-gray-700" />
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-6">
                    <InputLabel for="password" value="Password" class="text-gray-700" />
                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                        v-model="form.password"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="flex items-center justify-between mt-6">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" class="rounded border-gray-300 text-teal-500 shadow-sm focus:border-teal-500 focus:ring-teal-500" />
                        <span class="ms-2 text-sm text-gray-600">Remember Me</span>
                    </label>
                    
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="text-sm text-teal-600 hover:text-teal-800 transition-colors"
                    >
                        Forgot Your Password?
                    </Link>
                </div>

                <PrimaryButton
                    class="w-full mt-6 bg-gradient-to-r from-teal-400 to-teal-600 hover:from-teal-500 hover:to-teal-700 text-white py-3 rounded-xl transition-all duration-200 flex justify-center items-center"
                    :class="{ 'opacity-75 cursor-not-allowed': form.processing }"
                    :disabled="form.processing"
                >
                    Login
                </PrimaryButton>

                <div class="mt-6 text-center">
                    <span class="text-gray-600">Don't have an account? </span>
                    <Link
                        v-if="canResetPassword"
                        :href="route('register')"
                        class="text-teal-600 hover:text-teal-800 font-medium transition-colors"
                    >
                        Sign Up
                    </Link>
                </div>
            </form>
        </div>
    </div>
    </DumyGuestLayout>
</template>

<style scoped>
.bg-gradient-wave {
    background: linear-gradient(45deg, #0BC5EA 0%, #00B5D8 100%);
}
</style>