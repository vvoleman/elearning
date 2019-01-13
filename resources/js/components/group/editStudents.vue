<template>
    <div class="col-md-8 m-top-2 mx-auto">
        <div>
            <h1 class="text-center">Úprava studentů</h1>
            <hr class="m-top-2">
                <div class="d-flex justify-content-between">
                    <div>
                        <b-btn variant="success" v-on:click="sh_add = !sh_add">Přidat studenta</b-btn>
                    </div>
                    <div>
                        <button class="btn btn-gray" :disabled="!changed" @click="cancel">Zrušit změny</button>
                        <button class="btn btn-gray" :disabled="!changed" @click="sync">Uložit změny</button>
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
                            <label class="label">Přidat</label>
                            <emailsel :existing="g.students" v-model="modal_list" group="user"></emailsel>
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
            }else{
                this.backup = this.g.students.slice();
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
                    this.changed= true;
                    this.sh_add = false;
                    this.modal_list = null;
                }
            },
            remove(i){
                this.g.students.splice(i,1);
            },
            sync(){
                if(this.changed === true){
                    $.post('/ajax/syncStudentsInGroup',{data:this.g.students,id:this.g.id_g},function(data){
                        if(data.response == 200){
                            this.backup = this.g.students.slice();
                            this.changed = false;

                        }
                    }.bind(this));
                }
            },
            cancel(){
                if(this.changed) {
                    this.g.students = this.backup.slice();
                }
            },
        },
        computed:{
          students(){
              return this.g.students;
          }
        },
        watch:{
            students(){
                this.changed = !_.isEqual(this.g.students,this.backup);
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