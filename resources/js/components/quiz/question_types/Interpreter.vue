<template>
    <div>
        <checkbox v-if="question.type=='checkbox'" :corr_amount="corr_amount"  :ans="answer" :question="question" :index="index" @answers="sendAnswers"></checkbox>
        <radio v-if="question.type=='radio'" :ans="answer" :question="question" :index="index" @answers="sendAnswers"></radio>
    </div>
</template>

<script>
    import Checkbox from "../question_types/checkbox";
    import Radio from "../question_types/radio";
    export default {
        components: {Radio, Checkbox},
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
                type:Array,
                default:()=>[]
            },
            corr_amount:{
                type:Number
            }
        },
        name: "Interpreter",
        methods:{
            sendAnswers(data){
                this.$emit("answers",data);
            }
        }
    }
</script>

<style scoped>

</style>
