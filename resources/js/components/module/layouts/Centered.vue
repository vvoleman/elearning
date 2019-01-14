<template>
    <div class="d-flex justify-content-center flex-wrap">
        <component-translator v-for="(o,i) in components" :type="o.type" :key="i" :context="o.context"></component-translator>
    </div>
</template>

<script>
    import ComponentTranslator from "../ComponentTranslator";
    export default {
        components: {ComponentTranslator},
        props:["components"],
        name: "Centered"
    }
</script>

<style scoped>

</style>