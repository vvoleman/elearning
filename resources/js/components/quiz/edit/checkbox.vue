<template>
    <div>
        <div class="col-12">
            <div v-for="(p,j) in question.options" class="option d-md-flex justify-content-between">
                <span><b>{{j+1}}.</b> <small v-if="p.text.length == 0"><i>Odpověď nevyplněna</i></small><span v-else>{{p.text}}</span></span>
                <div>
                    <i class="fas fa-pen clickable" @click="editOption(j)"></i>
                    <i class="fas fa-times clickable" @click="deleteOption(j)"></i>
                    <span @click="setAsCorrect(j)"><i class="fas fa-check-circle not_active" :class="{c_active:(p.isAnswer)}" disabled></i></span>
                </div>
            </div>
        </div>
        <modal v-if="edit_modal.show" @send="editOptionSave" @closeModal="edit_modal.show = false;">
            <h3 slot="header">Upravit odpověď</h3>
            <div slot="body">
                <div class="form-group">
                    <label class="label">Odpověď</label>
                    <input type="text" class="form-control" v-model="edit_modal.option"/>
                </div>
            </div>
        </modal>
        <div class="col-12 d-md-flex justify-content-end align-items-center">
            <div class="d-flex align-items-center clickable" @click="addOption()">
                <i class="fas fa-plus"></i>
                Přidat možnost
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['value'],
        name: "checkbox",
        data(){
            return{
                question:this.value,
                edit_modal:{
                    option:"",
                    show:false,
                    selected:null,
                }
            }
        },
        methods:{
            deleteOption(j){
                if(confirm('Opravdu chcete možnost smazat?')){
                    this.question.options.splice(j,1);
                    //this.questions[i].splice(i,1);
                }
            },
            addOption(){
                this.question.options.push({
                    text:"",
                    isAnswer:false
                });
            },
            editOption(j){
                this.edit_modal.selected = j;
                this.edit_modal.option = this.question.options[j].text;
                this.edit_modal.show = true;
            },
            editOptionSave(){
                this.question.options[this.edit_modal.selected].text = this.edit_modal.option;
                this.edit_modal.selected = null;
                this.edit_modal.show = false;
            },
            setAsCorrect(j){
                if(this.question.options[j].isAnswer){
                    this.question.options[j].isAnswer = false;
                    return;
                }

                var counter = 0;
                for(var i = 0;i<this.question.options.length;i++){
                    if(this.question.options[i].isAnswer){
                        counter++;
                    }
                }
                    this.question.options[j].isAnswer = true;
            }
        },
        watch:{
            options(){
                this.$emit('input',this.question.options);
            },
            answers(){
                this.$emit('answers',this.question.answers);
            }
        }
    }
</script>

<style scoped>
    .c_active {
        color: #46a851 !important;
    }
</style>
