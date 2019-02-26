<template>
    <div>
        <div class="m-top-2 login_form_div col-md-6 mx-auto" v-if="!start">
            <h1>{{name}}</h1>
            <ul>
                <li>Časový limit: <b>{{minutesAvailable}} minut</b></li>
                <li>Počet otázek: <b>{{questions.length}}</b></li>
                <li>Kurz: <a class="no-a dotted" :href="course.url">{{course.name}}</a></li>
                <li v-if="course.module.name != null">Test pro modul: <a class="dotted" :href="course.module.url">{{course.module.name}}</a></li>
            </ul>
            <div>
                <button @click="startQuiz">Spustit test</button>
            </div>
        </div>
        <div class="m-top sticky-top login_form_div col-12 d-flex justify-content-between" v-if="start">
            <div>čas</div>
            <div><button>Ukončit</button></div>
        </div>

        <div v-if="start" class="col-md-6 mx-auto">
            <quiz-frame :questions="questions">

            </quiz-frame>
        </div>
    </div>
</template>

<script>
    import QuizFrame from "./QuizFrame";
    export default {
        name: "Quiz",
        components: {QuizFrame},
        props:["datas"],
        data(){
            return {
                start:false,
                name:"",
                course:{
                    url:"",
                    name:"",
                    module:{
                        name:"",
                        url:""
                    }
                },
                minutesAvailable:"",
                randomOrder:"",
                questions:[]
            }
        },
        mounted(){
            var json = JSON.parse(this.datas);
            this.name = json.name;
            this.minutesAvailable = json.minutesAvailable;
            this.randomOrder = json.randomOrder;
            this.questions = json.questions;
            this.course = json.course;
        },
        methods:{
            startQuiz(){
                if(confirm("Spustit test? Máš na to "+this.minutesAvailable+" minut!")){
                    this.start = true;
                }
            }
        }
    }
</script>

<style scoped>
    .dotted{
        border-bottom: solid 1px #333;
        color:#333;
        font-weight: bold;
        text-decoration: none;
    }
</style>
