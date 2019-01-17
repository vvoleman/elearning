<template>
    <p v-html="context.text">
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