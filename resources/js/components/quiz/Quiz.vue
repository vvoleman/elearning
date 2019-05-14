<template>
    <form method="post" :action="submitTo" id="form">
        <input type="hidden" name="_token" :value="csrf">
        <input type="hidden" name="data" :value="JSON.stringify(toSubmit)"/>
        <div v-if="start">
            <div class="sticky-top login_form_div col-12 d-flex justify-content-between">
                <div>čas: {{timeLeft}}
                    <!--<Timer :startDate="startDateTime" :time="minutesAvailable" @end="end" @countDown="countDown"></Timer>!-->
                </div>
                <div><button type="button" @click="end">Odeslat</button></div>
            </div>
            <div class="col-md-6 mx-auto">
                <quiz-frame :questions="questions" v-model="answers">

                </quiz-frame>
            </div>
        </div>
    </form>
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
                start:false,
                minutesAvailable:"",
                randomOrder:"",
                questions:[],
                startDateTime:null,
                timeLeft:0,
                answers:[],
                submitTo:"",
                csrf:"",
                output:""
            }
        },
        mounted(){
            var json = JSON.parse(this.datas);
            this.minutesAvailable = json.minutesAvailable;
            this.randomOrder = json.randomOrder;
            this.questions = json.questions;
            console.log(this.questions);
            this.startDateTime = new Date();
            this.submitTo = json.submitTo;
            this.csrf = json.csrf;
            this.start = true;
        },
        methods: {
            countDown(time){
                this.timeLeft = this.toMinutes(time);
            },
            toMinutes(s){
                var temp = s%60;
                return (~~(s/60))+":"+((temp<10)? '0' : '')+temp;
                //~~ = Math.floor()
            },
            end(){
                //document.getElementById("form").submit();
                //alert('Vaše výsledky se nyní zpracují!');
            }
        },
        computed:{
            toSubmit(){
                return {
                    answers:this.answers,
                    startdatetime:this.startDateTime.getTime()
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
