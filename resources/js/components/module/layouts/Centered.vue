<template>
    <div class="d-md-flex justify-content-center flex-wrap">
        <component-translator class="col-md-8" v-for="(o,i) in components" :type="o.type" :key="i" :context="o.context"></component-translator>
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