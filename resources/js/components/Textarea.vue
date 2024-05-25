<script setup>
const model = defineModel({
    type: null,
    required: true
});
defineProps({
    label: {
        type: String
    },
    placeholder: {
        type: String
    },
    name: {
        type: String, required: true
    },
    message: String
})
</script>
<template>
    <div>
        <label for="name" class="block text-sm font-semibold leading-4 text-gray-700">{{ label }}</label>
        <div class="mt-1">
            <textarea id="name" v-model="model" :placeholder="placeholder" :class="{ 'ring-red-500': message }"
                rows="10"
                class="block w-full rounded-md border-0 px-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
            <small class="text-red-500" v-if="message">{{ message }}</small>
        </div>
    </div>
</template>
