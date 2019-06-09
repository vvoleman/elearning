<template>
    <div>
        <radio v-if="value.type == 'radio'" v-model="value" @answers="emitAnswers" @input="emitInput"></radio>
        <checkbox v-if="value.type == 'checkbox'" v-model="value" @answers="emitAnswers" @input="emitInput"></checkbox>
    </div>
</template>

<script>
    import Radio from "./radio";
    import Checkbox from "./checkbox";
    export default {
        name: "TypeTranslator",
        components: {Checkbox, Radio},
        props:["value"],
        data(){
            return {

            }
        },
        mounted(){

        },
        methods:{
            emitInput(data){
                this.$emit('input',data);
            },
            emitAnswers(data){
                this.$emit('answers',data);
            }
        }

    }
</script>

<style scoped>

</style>
