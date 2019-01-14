<template>
    <div class="d-flex justify-content-between flex-wrap">
        <component-translator :class="[className]" v-for="(o,i) in components" :type="o.type" :key="i" :context="o.context"></component-translator>
    </div>
</template>

<script>
    import ComponentTranslator from "../ComponentTranslator";
    export default {
        components: {ComponentTranslator},
        props:["components"],
        name: "Normal",
        data(){
            return {
                className:"col-md-"
            }
        },
        mounted(){
            var temp = Math.floor(12/this.components.length);
            if(temp<=3){
                temp = 12;
            }
            this.className += temp;
        }
    }
</script>

<style scoped>

</style>