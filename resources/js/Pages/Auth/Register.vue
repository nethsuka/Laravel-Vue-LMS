<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayoutRegister from '@/Layouts/GuestLayoutRegister.vue';

const form = useForm({
    name: '',
    NIC: '',
    exam_year: '',
    school: '',
    getToKnow: '',
    address : '',
    f_number: '',
    m_number: '',
    whatsapp_number: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayoutRegister>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name*" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="First Name & Last Name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="nic" value="Student NIC Number*" />

                <TextInput
                    id="nic"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.NIC"
                    required
                    autofocus
                    autocomplete="nic"
                />

                <InputError class="mt-2" :message="form.errors.NIC" />
            </div>

            <div class="mt-4">
                <InputLabel for="year" value="Exam Year*" />

                <TextInput
                    id="year"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.exam_year"
                    required
                    autofocus
                    autocomplete="year"
                />

                <InputError class="mt-2" :message="form.errors.exam_year" />
            </div>

            <div class="mt-4">
                <InputLabel for="school" value="School" />

                <TextInput
                    id="school"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.school"
                    autofocus
                    autocomplete="school"
                />

                <InputError class="mt-2" :message="form.errors.school" />
            </div>

            <div class="mt-4">
                <label for="know" class="block font-medium text-sm text-gray-700">How did you get to know about the teacher ?*</label>
                <textarea 
                    id="know" 
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" 
                    name="w3review" rows="3"
                    v-model="form.getToKnow"
                    required
                    autofocus
                ></textarea>

                <InputError class="mt-2" :message="form.errors.getToKnow" />
            </div>

            <div class="mt-4">
                <label for="address" class="block font-medium text-sm text-gray-700">Address (With Town)*</label>
                <textarea 
                    id="address" 
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" 
                    rows="2"
                    v-model="form.address"
                    required
                    autofocus
                ></textarea>

                <InputError class="mt-2" :message="form.errors.address" />
            </div>

            <div class="mt-4">
                <InputLabel for="fnum" value="Father's Number" />

                <TextInput
                    id="fnum"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.f_number"
                    autofocus
                    autocomplete="Father's Number"
                />

                <InputError class="mt-2" :message="form.errors.f_number" />
            </div>

            <div class="mt-4">
                <InputLabel for="mnum" value="Mother's Number" />

                <TextInput
                    id="mnum"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.m_number"
                    autofocus
                    autocomplete="Mother's Number"
                />

                <InputError class="mt-2" :message="form.errors.m_number" />
            </div>

            <div class="mt-4">
                <InputLabel for="wnum" value="Whatsapp Number*" />

                <TextInput
                    id="wnum"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.whatsapp_number"
                    autofocus
                    required
                    autocomplete="whatsapp_number"
                />

                <InputError class="mt-2" :message="form.errors.whatsapp_number" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email*" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Already registered?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayoutRegister>
</template>
