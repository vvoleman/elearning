<template>
    <div class="col-md-8 m-top mx-auto">
        <div>
            <h3 class="text-center">Úprava studentů</h3>
            <hr>
                <div class="d-flex justify-content-between">
                    <div>
                        <b-btn variant="success" v-on:click="sh_add = !sh_add">Přidat studenta</b-btn>
                    </div>
                    <div>
                        <button class="btn btn-gray" :disabled="!changed" @click="cancel">Zrušit</button>
                        <button class="btn btn-gray" :disabled="!changed" @click="sync">Uložit</button>
                    </div>
                </div>
            <hr>
            <div>
                <modal v-if="sh_add" v-on:send="addToGroup" v-on:closeModal="sh_add=false">
                    <div slot="header">
                    <h3>Přidání</h3>
                    </div>
                    <div slot="body" style="padding:0px">
                        <div class="form-group">
                            <label class="label">Přidat manuálně</label>
                            <emailsel :existing="datas" v-model="modal_list" group="user"></emailsel>
                        </div>
                        <hr>
                        <h5>Již brzy</h5>
                        <div class="form-group m-top disabledbutton">
                            <label class="label">Přidat studenty pomocí CSV</label>
                            <input type="file" class="col-12">
                        </div>
                    </div>
                </modal>
            </div>
            <div>

                <div class="d-md-flex flex-wrap">
                    <div class="col-md-4 st" v-for="(s,i) in g.students">
                        <div class="col-md-12 student_box d-flex align-items-center justify-content-between">
                            <span>{{s.firstname}} {{s.surname}}</span>
                            <b-dropdown variant="link" right size="lg" no-caret>
                                <template slot="button-content">
                                    <i class="fas fa-ellipsis-v"></i>
                                </template>
                                <b-dropdown-item href="#">Napsat zprávu</b-dropdown-item>
                                <b-dropdown-item href="#"@click="remove(i)">Odebrat</b-dropdown-item>
                            </b-dropdown>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "editStudents",
        props:["datas"],
        data(){
            return {
                test:"",
                g:"",
                backup:"",
                modal_list:[],
                sh_add:false,
                temps:{
                    add_block:null
                },
                changed:false
            }
        },
        mounted(){
            this.g = JSON.parse(this.datas);
            if(this.g.students.length == 0){
                this.g.students = [];
            }
        },
        methods:{
            testing(temp){
                console.log(temp);
            },
            addToGroup(){
                if(this.modal_list.length > 0){
                    var a = [];
                    var b = [2,3,4];
                    this.g.students = this.g.students.concat(this.modal_list);
                    this.changing(true);
                    this.sh_add = false;
                }
            },
            remove(i){
                this.g.students.splice(i,1);
                this.changing(true);
            },
            sync(){
                if(this.changed === true){
                    $.post('/ajax/syncStudentsInGroup',{data:this.g.students,id:this.g.id_g},function(data){
                        if(data.response == 200){
                            this.changing(false);
                        }
                    }.bind(this));
                }
            },
            cancel(){
                if(this.changed) {
                    this.g.students = this.backup.splice();
                    this.changing(false);
                }
            },
            changing(boo){
                this.changed = boo;
                if(boo){
                    this.backup = this.g.students.splice();
                }else{
                    this.backup = null;
                }

            }
        }

    }
</script>

<style scoped>
    .disabledbutton {
        pointer-events: none;
        opacity: 0.4;
    }
</style>