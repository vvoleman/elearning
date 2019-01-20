<template>
    <p v-html="context.text" style="word-wrap: break-spaces">
    </p>
</template>

<script>
    export default {
        name: "paragraph",
        props:["context"],
        mounted(){
            console.log(this.context);
        }

    }
</script>

<style scoped>

</style>