<template>
    <form method="post" :action="submitTo" id="form">
        <input type="hidden" name="_token" :value="csrf">
        <input v-if="startDateTime != null" type="hidden" name="data" :value="JSON.stringify(toSubmit)"/>
        <div>
            <question-list :setFilter="onlyBookmarks" :bookmarks="bookmarks" :questions="questions" :curr_question="selected" @question_selected="setSelected"></question-list>
            <div class="body col-md-10 offset-md-2" style="padding-left:0;padding-right: 0" v-if="startDateTime != null">
                <info-bar :time_limit="secondsAvailable" @end="end" @move="move" :start_date="startDateTime" :curr_question="q_data" :questions_left="missing.length" @changeBookmark="changeBookmark"></info-bar>
                <question-board :corr_amount="ca[selected]" :question="questions[selected]" :answer="getAnswersFor(answers[selected])" :index="selected+1" @changeAnswers="setAnswer"></question-board>
            </div>
        </div>
    </form>
</template>

<script>
    import QuestionList from "./QuestionList";
    import InfoBar from "./InfoBar";
    import QuestionBoard from "./QuestionBoard";
    export default {
        name: "Quiz",
        components: {QuestionBoard, InfoBar, QuestionList},
        props:["datas","corr_amount"],
        data(){
            return {
                secondsAvailable:"",
                randomOrder:"",
                questions:[],
                startDateTime:null,
                answers:[],
                submitTo:"f",
                csrf:"",
                selected:0,
                bookmarks:[],
                missing:0,
                onlyBookmarks:false,
                ca:[]
            }
        },
        mounted(){
            var json = JSON.parse(this.datas);
            console.log(json);
            this.secondsAvailable = json.minutesAvailable;
            this.randomOrder = json.randomOrder;
            this.questions = json.questions;
            this.startDateTime = new Date();
            this.submitTo = json.submitTo;
            this.csrf = json.csrf;
            this.ca = JSON.parse(this.corr_amount);

            this.missing = this.findMissingQuestions(this.answers);
            console.log(this.startDateTime,new Date());



        },
        methods: {
            getAnswersFor(obj){
                return (obj == null) ? [] : obj.answers;
            },
            changeBookmark(){
                var i = this.bookmarks.indexOf(this.selected);
                if(i == -1){
                    this.bookmarks.push(this.selected);
                }else{
                    this.bookmarks.splice(i,1);
                }
            },
            end(boo){
                if(boo){
                    if(this.missing.length > 0){
                        if(confirm('Nebyly vyplněny všechny otázky, chcete se k nim vrátit?')){
                            return;
                        }
                    }
                    if(this.bookmarks.length > 0){
                        if(confirm('Máte ještě označeny některé otázky, chcete se k nim vrátit?')){
                            this.onlyBookmarks = true;
                            return;
                        }
                    }
                    if(!confirm('Opravdu si přejete ukončit test?')) {
                        return;
                    }
                }
                alert('Vaše výsledky se nyní zpracují!');
                document.getElementById("form").submit();
            },
            move(dir){
                if(typeof dir != "boolean"){return;}//verifying value
                var val;
                if(!dir){
                    val = (this.selected > 0) ? this.selected-1 : 0;
                }else{
                    val = (this.selected < this.questions.length-1) ? this.selected+1 : this.questions.length-1;
                }
                this.selected = val;
            },
            setSelected(index){
                if(!(index >= 0 && index < this.questions.length)){return;} //verifying value

                this.selected = index;

            },
            setAnswer(data){
                if(data == null || data.length == 0){
                    this.answers[this.selected] = null;
                }else{
                    this.answers[this.selected] = {answers:data,id:this.questions[this.selected].id};
                }
                this.missing = this.findMissingQuestions(this.answers);

            },
            findMissingQuestions(answers){
                var missing = [];
                for(var i = 0; i<this.questions.length;i++){
                    if(answers[i] == null){
                        missing.push(i);
                    }
                }
                return missing;
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
                    hasBookmark:(this.bookmarks.indexOf(this.selected) != -1) ? true : false,
                    canLeft:(this.selected > 0),
                    canRight:(this.selected < this.questions.length-1),
                    length:this.questions.length
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
