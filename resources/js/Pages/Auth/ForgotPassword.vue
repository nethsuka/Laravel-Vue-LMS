<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Logo from "../../../assets/Logo.svg"
import LoginBG from "../../../assets/LoginBG.svg"

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
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
            <div class="text-center mb-8">
                <img :src=Logo alt="MHCHEM" class="h-12 mx-auto mb-4" />
                <h1 class="text-3xl font-bold text-gray-800">Reset Your Password</h1>
            </div>

            <div class="text-center mb-8 text-gray-600">
                Please enter your username or email address.<br />
                You will receive a link to create a new password via email.
            </div>

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600 text-center">
                {{ status }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-gray-900 placeholder-gray-500"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="username or email"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div>
                    <PrimaryButton
                        class="w-full bg-gradient-to-r from-teal-400 to-teal-600 hover:from-teal-500 hover:to-teal-700 text-white py-3 px-6 rounded-xl transition-all duration-200 flex justify-center items-center text-base font-medium"
                        :class="{ 'opacity-75 cursor-not-allowed': form.processing }"
                        :disabled="form.processing"
                    >
                        Reset Password
                    </PrimaryButton>
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

@media (max-width: 640px) {
    .text-3xl {
        font-size: 1.875rem;
    }
}
</style>