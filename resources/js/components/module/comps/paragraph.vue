<template>
    <p v-html="context">
    </p>
</template>

<script>
    export default {
        name: "paragraph",
        props:["context"],

    }
</script>

<style scoped>

</style>