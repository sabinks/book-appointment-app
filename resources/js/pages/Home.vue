<template>

    <Head>
        <title> | {{ $page.component }}</title>
        <meta head-key="description" name="description" content="This is home description">
    </Head>
    <div>
        Home
    </div>
</template>
<script setup>
defineProps({
    name: String
})
</script>