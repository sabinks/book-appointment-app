<script setup>
import { onMounted, reactive, ref } from 'vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import TextInput from '../components/TextInput.vue'
import Textarea from '../components/Textarea.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import { usePage } from '@inertiajs/vue3'
import { format } from 'date-fns';

const page = usePage()
const time_range = ref(['09:00:00', '09:30:00', '10:00:00', '10:30:00', '11:00:00', '11:30:00', '12:00:00', '12:30:00', '13:00:00', '13:30:00', '14:00:00', '14:30:00', '15:00:00', '15:30:00', '16:00:00', '16:30:00', '17:00:00', '17:30:00'])
const booking_date_time = ref([])
const selectedDateTime = ref([])
const selectedTimeRange = ref([])
const form = useForm({
    name: 'member five',
    email: 'member5@mail.com',
    phone: '1231231231',
    dob: '2000-01-01 00:00:00',
    booking_date: '',
    booking_time: '',
    description: 'booking description'
})
onMounted(() => {
    const appointments = page.props.appointments.map((appointment) => {
        const data = appointment.split(" ")
        return {
            date: data[0], time: data[1]
        }
    })
    booking_date_time.value = appointments
})
const handleSubmit = () => {
    form.post("/book-appointment", {
        onSuccess: () => form.reset(),
        onError: () => form.reset('booking_time')
    })
}
const handleDOBChange = (value) => {
    form.dob = format(value, 'yyyy-MM-dd')
}
const handleDateChange = (value) => {
    form.booking_date = format(value, 'yyyy-MM-dd')
    form.booking_time = ''
    selectedDateTime.value = booking_date_time.value.filter(booking => booking.date == form.booking_date)
}
const handleTimePicker = (e) => {
    form.booking_time = e.target.value
}
</script>
<template>

    <Head>
        <title> | Book Appointment</title>
    </Head>
    <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                alt="Your Company" />
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Book Appointment
            </h2>
        </div>
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" @submit.prevent="handleSubmit">
                <TextInput label="Full Name" placeholder="Please enter fullname" name="name" type="text"
                    v-model="form.name" :message="form.errors.name" />
                <TextInput label="Email Address" placeholder="Please enter email address" name="email" type="email"
                    v-model="form.email" :message="form.errors.email" />
                <TextInput label="Phone Number" placeholder="Please enter phone number" name="phone" type="text"
                    v-model="form.phone" :message="form.errors.phone" />
                <div class="">
                    <label for="dob" class="block text-sm font-semibold leading-4 text-gray-700 mb-1">Select Date of
                        Birth</label>
                    <VueDatePicker :model-value="form.dob" @update:model-value="handleDOBChange" format="yyyy-MM-dd">
                    </VueDatePicker>
                    <small class="text-red-500" v-if="form.errors.dob">{{ form.errors.dob }}</small>

                </div>
                <div class="">
                    <label for="booking_date" class="block text-sm font-semibold leading-4 text-gray-700 mb-1">Select
                        Appointment
                        Date</label>
                    <VueDatePicker :model-value="form.booking_date" @update:model-value="handleDateChange"
                        @update:closed="console.log('123')" format="yyyy-MM-dd"></VueDatePicker>
                    <small class="text-red-500" v-if="form.errors.booking_date">{{ form.errors.booking_date }}</small>

                </div>
                <div class="" v-if="form.booking_date">
                    <label for="booking_time" class="block text-sm font-semibold leading-4 text-gray-700 mb-1">Select
                        Appointment
                        Time</label>
                    <p class="text-xs mb-2 font-semibold">Available Time Slot</p>
                    <div class="grid grid-cols-4 gap-2">

                        <div class="border rounded-md text-sm font-semibold text-center hover:cursor-pointer hover:shadow-md hover:bg-green-300 transi duration-300"
                            v-for="time in time_range" :key="index" :class="[
                                { 'hidden': selectedDateTime?.some(booking => booking.time == time) },
                                { 'bg-green-300': time == form.booking_time }]">
                            <!-- <span :model-value="form.booking_time" @update:model-value="handleTimePicker">
                                {{ time }}
                            </span> -->
                            <button :value="time" @click.prevent="handleTimePicker">{{
                                format(new Date(`${form.booking_date}:${time}`), 'hh:mm aa ') }}</button>
                        </div>
                    </div>
                    <small class="text-red-500" v-if="form.errors.booking_time">{{ form.errors.booking_time }}</small>

                </div>
                <Textarea label="Description" placeholder="Please enter description" name="password" type="textarea"
                    v-model="form.description" :message="form.errors.description" />

                <div class="space-y-2">
                    <button type="submit" :disabled="form.processing"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:bg-indigo-300">Book</button>
                </div>
            </form>
        </div>
    </div>
</template>