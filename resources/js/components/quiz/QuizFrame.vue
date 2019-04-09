<template>
    <div class="m-top-2 quiz">
        <div v-for="(o,i) in questions" class="m-top-2">
            <TypeTranslator v-model="answers[i]" :question="o" :order="i+1"></TypeTranslator>
        </div>
    </div>
</template>

<script>
    import TypeTranslator from "./question_types/TypeTranslator";
    export default {
        name: "QuizFrame",
        components: {TypeTranslator},
        props:["questions","value"],
        data(){
            return {
                answers:[]
            };
        },
        mounted(){
            console.log("!!!");
            console.log(this.questions);
        },
        watch:{
            answers(){
                console.log("teď");
                this.$emit('input',this.answers);
            }
        }
    }
</script>

<style scoped>
    input{
        box-shadow:none;
    }
</style>
