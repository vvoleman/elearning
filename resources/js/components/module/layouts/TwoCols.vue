<template>
    <div class="d-flex justify-content-between">
        <component-translator v-for="item in components" :type="item.type" :key="item.type" :context="item.context"></component-translator>
    </div>
</template>

<script>
    import ComponentTranslator from "../ComponentTranslator";
    export default {
        components: {ComponentTranslator},
        props:["components"],
        name: "TwoCols"
    }
</script>

<style scoped>

</style>