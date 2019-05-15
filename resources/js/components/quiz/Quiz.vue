<template>
    <form method="post" :action="submitTo" id="form">
        <input type="hidden" name="_token" :value="csrf">
        <input type="hidden" name="data" :value="JSON.stringify(toSubmit)"/>
        <div>
            <QuestionList :questions="questions" :curr_question="selected" @question_selected="setSelected"></QuestionList>
            <InfoBar :time_limit="timeLeft" @end="end" @move="move" :curr_question="q_data" @changeBookmark="changeBookmark" :questions_left=""></InfoBar>
            <QuestionBoard :question="" @value_changed="" ></QuestionBoard>
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
                minutesAvailable:"",
                randomOrder:"",
                questions:[],
                startDateTime:null,
                timeLeft:0,
                answers:[],
                submitTo:"",
                csrf:"",
                selected:0,
                bookmarks:[]
            }
        },
        mounted(){
            var json = JSON.parse(this.datas);
            this.minutesAvailable = json.minutesAvailable;
            this.randomOrder = json.randomOrder;
            this.questions = json.questions;
            this.startDateTime = new Date();
            this.submitTo = json.submitTo;
            this.csrf = json.csrf;
        },
        methods: {
            end(){
                //document.getElementById("form").submit();
                //alert('Vaše výsledky se nyní zpracují!');
            },
            move(dir){
                if(typeof dir != "boolean"){return;}//verifying value

                var val;
                if(dir){
                    val = (this.selected > 0) ? this.selected-1 : 0; 
                }else{
                    val = (this.selected < this.questions.length-1) ? this.selected+1 : this.questions.length-1;
                }
                this.selected = val;
            },
            setSelected(index){
                if(!(index >= 0 && index < this.questions.length)){return;} //verifying value

                this.selected = index;

            }
        },
        computed:{
            toSubmit(){
                return {
                    answers:this.answers,
                    startdatetime:this.startDateTime.getTime()
                }
            },
            q_data(){
                return {
                    index:this.selected,
                    hasBookmark:(this.bookmarks.find(this.selected) == true) ? true : false,
                    canLeft:(this.selected > 0),
                    canRight:(this.selected < this.questions.length-1)
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
