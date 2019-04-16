<template>
    <div class="m-top-2 col-md-10 mx-auto">
        <div class="">
            <h3>Správa přístupu</h3>
            <hr>
            <span><b>Test:</b> {{quiz.name}}</span>
        </div>
        <div class="bar-header col-md-8 mx-auto">
            ff
        </div>
    </div>
</template>

<script>
    export default {
        name: "PassManage",
        props:["datas","quiz"],
        data(){
            return {
                passes:[],
                quiz:[]
            }
        },
        mounted(){
            this.passes = JSON.parse(this.datas);
            this.quiz = JSON.parse(this.quiz);
        }
    }
</script>

<style scoped>
    .bar-header{
        border-radius: 5px;
        background: #1b1e21;
        color:white;
    }
</style>
