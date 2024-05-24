<script setup>
import { reactive } from 'vue'
import { router, useForm } from '@inertiajs/vue3'
import TextInput from '../components/TextInput.vue'
const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    profile_image: null,
    preview: null
})
const handleSubmit = () => {
    form.post("/register", {
        onSuccess: () => form.reset(),
        onError: () => form.reset("password", "password_confirmation")
    })
}
const handleProfileImage = (e) => {
    const { files } = e.target
    form.profile_image = files[0]
    form.preview = URL.createObjectURL(files[0])
}
console.log(form.errors);
</script>
<template>

    <Head>
        <title> | Register</title>
    </Head>
    <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                alt="Your Company" />
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">User Registration
            </h2>
        </div>
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" @submit.prevent="handleSubmit">
                <TextInput label="Full Name" placeholder="Please enter fullname" name="name" type='text'
                    v-model="form.name" :message="form.errors.name" />
                <TextInput label="Email Address" placeholder="Please enter email address" name="email" type="email"
                    v-model="form.email" :message="form.errors.email" />
                <TextInput label="Password" placeholder="Please enter password" name="password" type="password"
                    v-model="form.password" :message="form.errors.password" />
                <div class="text-sm">
                    <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                </div>
                <TextInput label="Confirm Password" placeholder="Please enter confirm password"
                    name="password_confirmation" type="password" v-model="form.password_confirmation"
                    :message="form.errors.password_confirmation" />
                <div class="grid place-items-center">
                    <div class="relative w-28 h-28 rounded-full overflow-hidden border border-slate-300">
                        <label for="profile_image" class="absolute inset-0 grid content-end cursor-pointer">
                            <span class="bg-white/70 pb-2 text-center">Avatar</span>
                        </label>
                        <input type="file" @input="handleProfileImage" id="profile_image" hidden />

                        <img class="object-cover w-28 h-28"
                            :src="form.preview ?? 'storage/profile_image/17165066209759027.png'" />
                    </div>
                    <p class="error mt-2">{{ form.errors.profile_image }}</p>
                </div>
                <!-- <div>
                    <div class="mt-1">
                        <input id="profile_image" type="file" :class="{ 'ring-red-500': message }"
                            @input="handleProfileImage"
                            class="block w-full rounded-md border-0 px-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        <small class="text-red-500" v-if="form.errors.profile_image">{{
                            form.errors.profile_image }}</small>
                    </div>
                </div> -->
                <div>
                    <button type="submit" :disabled="form.processing"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:bg-indigo-300">Register</button>
                </div>
            </form>

            <!-- <p class="mt-10 text-center text-sm text-gray-500">
                Not a member?
                {{ ' ' }}
                <a href="#" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Start a 14 day free
                    trial</a>
            </p> -->
        </div>
    </div>
</template>