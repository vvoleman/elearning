<template>
    <div class="m-top-2">
        <div v-for="(o,i) in questions">
            <TypeTranslator :question="o" :order="i+1"></TypeTranslator>
        </div>
    </div>
</template>

<script>
    import TypeTranslator from "./question_types/TypeTranslator";
    export default {
        name: "QuizFrame",
        components: {TypeTranslator},
        props:["questions"]
    }
</script>

<style scoped>
    input{
        box-shadow:none;
    }
</style>
