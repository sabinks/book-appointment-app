<script setup>
import { reactive } from 'vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import TextInput from '../components/TextInput.vue'
const form = useForm({
    email: '',
    password: '',
    remember: false
})
const handleSubmit = () => {
    form.post("/login", {
        onSuccess: () => form.reset(),
        onError: () => form.reset("password")
    })

}
</script>
<template>

    <Head>
        <title> | Login</title>
    </Head>
    <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                alt="Your Company" />
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">User Login
            </h2>
        </div>
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" @submit.prevent="handleSubmit">
                <TextInput label="Email Address" placeholder="Please enter email address" name="email" type="email"
                    v-model="form.email" :message="form.errors.email" />
                <TextInput label="Password" placeholder="Please enter password" name="password" type="password"
                    v-model="form.password" :message="form.errors.password" />
                <div class="text-sm flex justify-between">
                    <div class="">

                        <div class="flex space-x-2">
                            <input id="remember" type="checkbox" v-model="form.remember"
                                class="block rounded-md border-0 px-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                            <label for="remember" class="block text-sm font-medium leading-4 text-gray-700">Remember
                                Me</label>
                        </div>
                    </div>
                    <a href="/forgot-password" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot
                        password?</a>
                </div>
                <div class="space-y-2">
                    <button type="submit" :disabled="form.processing"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:bg-indigo-300">Login</button>
                    <Link href="/register"
                        class="flex w-full justify-center rounded-md bg-slate-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-slate-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600 disabled:bg-slate-300">
                    Need
                    Account?</Link>
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