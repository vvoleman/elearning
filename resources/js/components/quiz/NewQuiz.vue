<template>
    <div class="container m-top-2">
        <div>
            <h3>Nový test</h3>
            <hr>
            <div class="d-md-flex">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="label">Název</label>
                        <input type="text" class="form-control" v-model="inputs.name">
                    </div>

                    <div class="form-group">
                        <label class="label">Časový limit (minuty)</label>
                        <input type="number" class="form-control" min="1" v-model="inputs.minutesAvailable">
                    </div>
                    <div class="form-group">
                        <label class="label">Odkazuje se na modul</label>
                        <input type="number" class="form-control" min="1">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group d-flex align-items-center justify-content-between">
                        <label class="label" style="margin-top:0">Nutné otevření</label>

                        <label class="switch m-top">
                            <input type="checkbox" v-model="inputs.isPrivate">
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between">
                        <label class="label" style="margin-top:0">Náhodné řazení otázek</label>

                        <label class="switch m-top">
                            <input type="checkbox" v-model="inputs.random">
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-top-2">
            <div class="d-md-flex justify-content-between">
                <h3>Otázky</h3>
                <i class="fas fa-plus clickable" @click="modals.newQuestion = true"></i>
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
                        <TypeTranslator :question="o.type" @answers="(data)=>{o.answers=data}" v-model="questions[i]"></TypeTranslator>
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
    </div>
</template>

<script>
    import TypeTranslator from "./edit/TypeTranslator";
    export default {
        name: "NewQuiz",
        components: {TypeTranslator},
        data(){
            return{
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
                    },
                    {
                        title:"Textové pole",
                        name:"string",
                        answers:-1
                    }
                ],
                questions:[
                    {
                        type:"radio",
                        question:"Máš hlad?",
                        options:[],
                        answers:[]
                    }
                ],
            }
        },
        mounted(){
          //alert('Udělej to přes ten translator, jinak tu budeš mít bordel');
        },
        methods:{
            newQuestion(){
                if(this.inputs.modals.new.question.length < 1){
                    return false;
                }
                this.questions.push({
                    type:this.q_types[this.inputs.modals.new.type].name,
                    question:this.inputs.modals.new.question,
                    options:[],
                    answers:[]
                });

                this.modals.newQuestion = false;
                this.inputs.modals.new.question = "";
                this.inputs.modals.new.type=1;
            },
            getIndexType(type){
                console.log(type);
                for(var i = 0; i<this.q_types.length; i++){
                    if(this.q_types[i].name == type){
                        return i;
                    }
                }
                return false;
            },
            editQuestion_start(i){
                console.log(this.getIndexType(this.questions[i].type));
                this.inputs.modals.edit.type = this.getIndexType(this.questions[i].type);
                this.inputs.modals.edit.question = this.questions[i].question;
                this.editedQuestion = i;
                this.modals.edit_question = true;
            },
            deleteQuestion(i){
                if(confirm('Opravdu chcete možnost smazat?')){
                    this.questions.splice(i,1);
                }
            },
            editQuestion(){
                var i = this.inputs.modals.edit;
                this.questions[i.editedQuestion].type = this.q_types[i.type];
                this.questions[i.editedQuestion].question = i.question;
                this.modals.edit_question = false;
            },
            addOption(i){
                this.questions[i].options.push({
                    text:""
                });
            },
            checkIfOptionAnswer(i,j){
                return this.questions[i].answers.indexOf(j);
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
</style>
