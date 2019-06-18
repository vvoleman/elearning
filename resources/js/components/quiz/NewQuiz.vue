<template>
    <div class="container m-top-2">
        <input type="hidden" name="json" :value="JSON.stringify(dataJSON)">
        <div>
            <div class="d-md-flex justify-content-between align-items-center">
                <h3>Nový test</h3>
                <button type="submit" class="btn btn-gray" :disabled="!readyToSubmit">Vytvořit</button>
            </div>
            <hr>
            <div class="d-md-flex">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="label">Název</label>
                        <input type="text" class="form-control" v-model="inputs.name" name="name">
                    </div>
                    <div class="form-group">
                        <label class="label">Časový limit (minuty)</label>
                        <input type="number" class="form-control" min="1" v-model="inputs.minutesAvailable">
                    </div>
                    <div class="form-group disabledbutton" title="Již brzy!">
                        <label class="label">Odkazuje se na modul</label>
                        <input type="number" class="form-control" min="1">
                    </div>
                </div>
                <div class="col-md-6">
                </div>
            </div>
        </div>
        <div class="m-top-2">
            <div class="d-md-flex justify-content-between">
                <h3>Otázky</h3>
                <i id="content" class="fas fa-plus clickable" @click="modals.newQuestion = true"></i>
                <modal v-if="modals.newQuestion" @closeModal="modals.newQuestion = false" @send="newQuestion">
                    <h3 slot="header">Nová otázka</h3>
                    <div slot="body">
                        <div class="form-group">
                            <label class="label">Otázka</label>
                            <input type="text" v-model="inputs.modals.new.question" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="label">Typ</label>
                            <select class="form-control" v-model="inputs.modals.new.type">
                                <option v-for="(o,i) in q_types" :value="i">{{o.title}}</option>
                            </select>
                        </div>
                    </div>
                </modal>
            </div>
            <hr>
            <div>
                <div v-for="(o,i) in questions" class="q_box m-top">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <div>
                            <h4>{{i+1}} <span style="font-size:15px">{{o.type}}</span></h4>
                            <h6>{{o.question}}</h6>
                        </div>
                        <div class="">
                            <i class="fas fa-pen clickable" @click="editQuestion_start(i)"></i>
                            <i class="fas fa-times clickable" @click="deleteQuestion(i)"></i>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <TypeTranslator @answers="(data)=>{o.answers=data}" v-model="questions[i]"></TypeTranslator>
                    </div>
                </div>
                <modal v-if="modals.edit_question" @closeModal="modals.edit_question = false" @send="editQuestion">
                    <h3 slot="header">Upravit otázku</h3>
                    <div slot="body">
                        <div class="form-group">
                            <label class="label">Znění otázky</label>
                            <input type="text" class="form-control" v-model="inputs.modals.edit.question">
                        </div>
                        <div class="form-group">
                            <label class="label">Typ</label>
                            <select class="form-control" v-model="inputs.modals.edit.type">
                                <option v-for="(o,i) in q_types" :value="i">{{o.title}}</option>
                            </select>
                        </div>
                    </div>
                </modal>
            </div>
        </div>
        <transition name="fade">
            <button type="button" class="up_link fas fa-arrow-up" v-if="show_up" @click="goUp">

            </button>
        </transition>

    </div>
</template>

<script>
    import TypeTranslator from "./edit/TypeTranslator";
    export default {
        name: "NewQuiz",
        components: {TypeTranslator},
        props:["course_id"],
        data(){
            return{
                show_up:false,
                inputs:{
                    name:"",
                    minutesAvailable:20,
                    isPrivate:false,
                    random:false,
                    modals:{
                        new:{
                            question:"",
                            type:0
                        },
                        edit:{
                            editedQuestion:0,
                            question:"",
                            type:0
                        }
                    }
                },
                loadedModules:[],
                modals:{
                    newQuestion:false,
                    new_error:null,
                    edit_question:false,
                    add_option:false
                },
                q_types:[
                    {
                        title:"Jedna odpověď",
                        name:"radio",
                        answers:1
                    },
                    {
                        title:"Více odpovědí",
                        name:"checkbox",
                        answers:-1
                    }
                ],
                questions:[]
            }
        },
        created () {
            window.addEventListener('scroll', this.handleScroll);
        },
        destroyed () {
            window.removeEventListener('scroll', this.handleScroll);
        },
        methods:{
            newQuestion(){
                if(this.inputs.modals.new.question.length < 1){
                    return false;
                }
                this.questions.push({
                    type:this.q_types[this.inputs.modals.new.type].name,
                    question:this.inputs.modals.new.question,
                    options:[]
                });

                this.modals.newQuestion = false;
                this.inputs.modals.new.question = "";
                this.inputs.modals.new.type=1;
            },
            handleScroll(e){
                this.show_up = (document.getElementById("content").getBoundingClientRect().y < 0);
            },
            goUp(){
                window.scrollBy(0,document.getElementById("content").getBoundingClientRect().top);
            },
            getIndexType(type){
                for(var i = 0; i<this.q_types.length; i++){
                    if(this.q_types[i].name == type){
                        return i;
                    }
                }
                return false;
            },
            editQuestion_start(i){
                this.inputs.modals.edit.type = this.getIndexType(this.questions[i].type);
                this.inputs.modals.edit.question = this.questions[i].question;
                this.inputs.modals.edit.editedQuestion = i;
                this.modals.edit_question = true;
            },
            deleteQuestion(i){
                if(confirm('Opravdu chcete otázku smazat?')){
                    this.questions.splice(i,1);
                }
            },
            editQuestion(){
                var i = this.inputs.modals.edit;
                console.log(i);
                if(this.questions[i.editedQuestion].type == "checkbox" && this.q_types[i.type].name == "radio"){
                    for(var j=0;j<this.questions[i.editedQuestion].options.length;j++){
                        this.questions[i.editedQuestion].options[j].isAnswer = false;
                    }
                }
                console.log(this.q_types[i.type].name+" - "+this.questions[i.editedQuestion].type);
                this.questions[i.editedQuestion].type = this.q_types[i.type].name;
                this.questions[i.editedQuestion].question = i.question;
                this.modals.edit_question = false;
            },
            controlQuestions(){
                var cond = false;
                for(var i = 0; i<this.questions.length;i++){
                    if(this.typeExists(this.questions[i].type) && (this.questions[i].question.length > 0)){
                        cond = true;
                    }
                }
                return cond;
            },
            typeExists(type){
                for(var i = 0; i<this.q_types.length;i++){
                    if(this.q_types[i].name == type){
                        return true;
                    }
                }
                return false;
            }
        },
        computed:{
            readyToSubmit(){
                return this.controlQuestions() && (this.inputs.name.length > 0) && this.inputs.minutesAvailable > 0 && this.questions.length > 0;
            },
            dataJSON(){
                return {
                    questions:this.questions,
                    name:this.inputs.name,
                    minutesAvailable: this.inputs.minutesAvailable,
                    isPrivate: this.inputs.isPrivate,
                    random: this.inputs.random
                }
            }
        }
    }
</script>

<style scoped>
    .q_box{
        padding:15px;
        background:#d8d8d8;
    }
    .fas{
        font-size: 20px;
    }
    .clickable:hover{
    }
    .up_link{
        position: fixed;
        display:flex;
        justify-content: center;
        align-items: center;
        top:90%;
        right:1%;
        width: 50px;
        height:50px;
        background: #242424;
        padding:10px;
        color:white;
        z-index:15;
        border-radius: 30px;
    }

</style>
