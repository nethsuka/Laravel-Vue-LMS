<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayoutRegister from '@/Layouts/GuestLayoutRegister.vue';
import Logo from "../../../assets/Logo.svg"

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
        preserveScroll: true,
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
function validatenumber(event) {
    const value = event.target.value;
    // Allow only numbers
    event.target.value = value.replace(/[^\d]/g, '');
}


</script>

<template>
    <GuestLayoutRegister>
        <Head title="Register" />

        <div class="text-center pt-2 pb-6">
            <h1 class="text-3xl font-bold text-gray-800">Student Registration</h1>
        </div>

        <form @submit.prevent="submit" enctype="multipart/form-data">
            <div>
                <InputLabel class="text-gray-600 text-sm" for="first_name">1. Name</InputLabel>

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="John Doe"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel class="text-gray-600 text-sm" for="nic">2. Student NIC Number</InputLabel>
                <TextInput
                @input="validatenumber" 
                    id="nic"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.NIC"
                    required
                    autocomplete="nic"
                    placeholder="200xxxxxxxxx"
                />

                <InputError class="mt-2" :message="form.errors.NIC" />
            </div>

            <div class="mt-4">
                <InputLabel class="text-gray-600 text-sm" for="exam_year">3. Exam Year</InputLabel>
                <TextInput
                @input="validatenumber" 
                    id="year"
                    class="mt-1 block w-full no-spinner"
                    type="text"
                    v-model="form.exam_year"
                    required
                    autocomplete="year"
                    placeholder="20XX"
                />

                <InputError class="mt-2" :message="form.errors.exam_year" />
            </div>

            <div class="mt-4">
                <InputLabel class="text-gray-600 text-sm" for="school">4. School</InputLabel>

                <TextInput
                    id="school"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.school"
                    autocomplete="school"
                />

                <InputError class="mt-2" :message="form.errors.school" />
            </div>

            <div class="mt-4">
                <InputLabel class="text-gray-600 text-sm" for="getToKnow">5. How did you get to know about the teacher</InputLabel>
                <textarea 
                    id="know" 
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" 
                    name="w3review" rows="3"
                    v-model="form.getToKnow"
                    required
                ></textarea>

                <InputError class="mt-2" :message="form.errors.getToKnow" />
            </div>

            <div class="mt-4">
                <InputLabel class="text-gray-600 text-sm" for="address">6. Address (With Town)</InputLabel>
                <textarea 
                    id="address" 
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" 
                    rows="2"
                    v-model="form.address"
                    required
                ></textarea>

                <InputError class="mt-2" :message="form.errors.address" />
            </div>

            <div class="mt-4">
                <InputLabel class="text-gray-600 text-sm" for="f_number">7. Father's Contact Number</InputLabel>

                <TextInput
                @input="validatenumber"
                
                    id="fnum"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.f_number"
                    autocomplete="Father's Number"
                    placeholder="07xxxxxxxx"
                    />
                    
                    <InputError class="mt-2" :message="form.errors.f_number" />
                </div>
                
                <div class="mt-4">
                    <InputLabel class="text-gray-600 text-sm" for="m_number">8. Mother's Contact Number</InputLabel>
                    
                    <TextInput
                    id="mnum"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.m_number"
                    autocomplete="Mother's Number"
                    placeholder="07xxxxxxxx"
                    @input="validatenumber"
                    />
                    
                    <InputError class="mt-2" :message="form.errors.m_number" />
                </div>
                
                <div class="mt-4">
                    <InputLabel class="text-gray-600 text-sm" for="whatsapp">9. Whatsapp Number</InputLabel>
                    
                    <TextInput
                    id="wnum"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.whatsapp_number"
                    required
                    autocomplete="whatsapp_number"
                    placeholder="07xxxxxxxx"
                    @input="validatenumber"
                />

                <InputError class="mt-2" :message="form.errors.whatsapp_number" />
            </div>

            <div class="mt-4">
                <InputLabel class="text-gray-600 text-sm" for="email">10. Email</InputLabel>

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
                <InputLabel class="text-gray-600 text-sm" for="password">11. Password</InputLabel>

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel class="text-gray-600 text-sm" for="password_confirmation">12. Confirm Password</InputLabel>

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
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

                <PrimaryButton class="ms-4 text-white bg-gradient-to-r from-[#25BECF] to-[#076F94] hover:from-[#076F94] hover:to-[#25BECF]" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
                <!-- Footer -->
            </div>
        </form>
    </GuestLayoutRegister>
    <div class="bg-gradient-to-r from-[#066C92] to-[#25BECF] text-white py-8 px-6">
        <div class="max-w-2xl mx-auto space-y-2">
            <p><b>*Conditions applied when registering for classes</b></p>
            <div class="ml-12">
                <p>1. Only English medium students who follow the G.C.E Advanced Level Chemistry syllabus may register.</p>
                <p>2. Access to classes will be denied if the registration is suspicious</p>
                <p>3. Privacy of all the details provided at the registration will be protected.</p>
                <p>4. To continue the classes for one month period, the class fee should be settled on or before 7th of the respective month.</p>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* For Chrome, Safari, Edge */
.no-spinner::-webkit-inner-spin-button,
.no-spinner::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* For Firefox */
.no-spinner {
    -moz-appearance: textfield;
}

input, textarea, select {
    @apply border-gray-300 focus:border-[#076F94] focus:ring-[#076F94] rounded-md;
}

</style>