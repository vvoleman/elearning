<template>
    <div class="question col-12">
        <interpreter :question="question" :index="index" @answers="handleAnswers" :answer="answer" :corr_amount="corr_amount"></interpreter>
    </div>
</template>

<script>
    import Checkbox from "./question_types/checkbox";
    import TypeTranslator from "./question_types/TypeTranslator";
    import Interpreter from "./question_types/Interpreter";
    export default {
        components: {Interpreter, TypeTranslator, Checkbox},
        props:{
            question:{
                type:Object,
                required:true
            },
            index:{
                type:Number,
                required:true
            },
            answer:{
                type:Array
            },
            corr_amount:{
                type:Number
            }
        },
        name: "QuestionBoard",
        methods:{
            handleAnswers(data){
                this.$emit("changeAnswers",data);
            }
        }
    }
</script>

<style scoped>

</style>
