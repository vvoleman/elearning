<template>
    <div>
        <div class="m-top-2 login_form_div col-md-6 mx-auto" v-if="start == false">
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
            <div>čas <Timer :end="timeOut" v-on:countDown="timeChange" :start-date="startDateTime" :time="minutesAvailable"></Timer>{{toMinutes(timeLeft)}}</div>
            <div><button @click="timeOut">Odeslat</button></div>
        </div>

        <div v-if="start == true" class="col-md-6 mx-auto">
            <quiz-frame :questions="questions" v-model="answers">

            </quiz-frame>
        </div>
        <div v-if="load">
            Načítám...
        </div>
    </div>
</template>

<script>
    import QuizFrame from "./QuizFrame";
    import Timer from "./Timer";
    export default {
        name: "Quiz",
        components: {QuizFrame,Timer},
        props:["datas"],
        data(){
            return {
                load:false,
                start:false,
                name:"",
                uuid:"",
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
                questions:[],
                startDateTime:null,
                timeLeft:0,
                answers:[]
            }
        },
        mounted(){
            var json = JSON.parse(this.datas);
            this.name = json.name;
            this.minutesAvailable = json.minutesAvailable;
            this.randomOrder = json.randomOrder;
            this.questions = json.questions;
            this.course = json.course;
            this.uuid = json.uuid;
            this.startDateTime = new Date();
        },
        methods: {
            startQuiz() {
                if (confirm("Spustit test? Máš na to " + this.minutesAvailable + " minut!")) {
                    this.start = true;

                }
            },
            timeChange(data) {
                this.timeLeft = data;
            },
            toMinutes(t) {
                return "" + (Math.floor(t / 60)) + ":" + ((t % 60 < 10) ? "0" : "") + (t % 60);
            },
            timeOut(){
                this.submitQuiz();
            },
            submitQuiz(){
                console.log(this.answers);
                this.load = true;
                this.start = null;
                $.post('/quiz/'+this.uuid,{data:{answers:this.answers,startDateTime:Math.floor(this.startDateTime.getTime()/1000)}},function (data){
                    console.log(data);
                    this.load = false;
                }.bind(this));
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
