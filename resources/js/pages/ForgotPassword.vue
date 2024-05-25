<template>
    <div class='min-h-screen flex'>
        <div class='flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24'>
            <div class='mx-auto w-full max-w-sm lg:w-96'>
                <div class="">
                    <a href="/">
                        <div class="flex flex-col gap-x-4 items-start">
                            <Image class="h-36 w-auto" src="/assets/logo_small.png" alt="Logo" width="100"
                                height="100" />
                            <h2 class="`text-4xl tracking-wider font-extrabold text-secondary ${montserrat.className}`">
                                Booking Appointment
                            </h2>
                        </div>
                    </a>

                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                        Forgot Password
                    </h2>
                </div>

                <div class='mt-8'>
                    <div class='mt-6'>
                        <form class='space-y-6' @submit.prevent="handleSubmit">
                            <TextInput label="Email Address" placeholder="Please enter email address" name="email"
                                type="email" v-model="form.email" :message="form.errors.email" />
                            <div class="space-y-2">
                                <button type="submit" :disabled="form.processing"
                                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:bg-indigo-300">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden lg:block relative w-0 flex-1 contrast-50">
            <img class="absolute inset-0 h-full w-full object-cover"
                src="http://localhost:8000/storage/book_appointment1.jpg" alt="Main" />
        </div>
    </div>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3';
import Demo from '../layouts/Demo.vue'
import TextInput from '../components/TextInput.vue'
defineOptions({ layout: Demo })
import { useRouter } from 'vue-router';
const router = useRouter()
const form = useForm({
    email: 'member5@mail.com',
})
const handleSubmit = () => {
    form.post("/forgot-password", {
        onSuccess: () => {
            form.reset()
            router.push('/')
        },
        // onError: () => form.reset('')
    })
}
</script>