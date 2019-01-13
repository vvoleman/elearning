<template>
    <div class="col-md-8 col-lg-6 col-xl-5 mx-auto">
        <div class="m-top-2">
            <h1 class="text-center">Nová třída</h1>
            <hr>
            <tabs class="settings mx-auto">
                <div class="tab_item tab_active mx-auto">
                    <h2 class="tab_name">Ruční přidání</h2>
                    <input type="hidden" name="users" v-bind:value="JSON.stringify(students)">
                    <input type="hidden" name="teacher" v-bind:value="JSON.stringify(teacher)">
                    <div>
                        <div class="form-group">
                            <label v-b-tooltip.hover class="label" :class="{bad:errors.first('name') != null || inputs.name.length == 1 ,correct:errors.first('name') == null && inputs.name.length > 1}" :title="errors.first('name')">Jméno třídy</label>
                            <input class="form-control" v-validate="{required:true,max:32,min:8}" name="name" v-model="inputs.name"/>
                        </div>
                        <div class="form-group" v-if="selective == true">
                            <label v-b-tooltip.hover class="label" :class="{correct:teacher.length > 0,bad:teacher !== '' && teacher.length == 0}" :title="(teacher !== '' && teacher.length == 0) ? 'Správce třídy musí být vybrán!' : ''">Správce třídy</label>
                            <emailsel group="teacher" v-model="teacher" limit="1"></emailsel>
                        </div>
                    </div>
                    <div>
                        <hr>
                        <h2>Studenti</h2>
                        <div style="flex-wrap:wrap">
                            <b-btn @click="opened = 1" class="m-top btn-gray">Přidat existující</b-btn>
                            <b-btn @click="opened = 2" class="m-top btn-gray">Importovat z jiné třídy</b-btn>
                        </div>


                        <div>
                            <add-student :existing="students" v-if="opened == 1" @cancel="close" @post="add"></add-student>
                        </div>
                        <div>
                            <import-students v-if="opened==2" @send="addMore" @closeModal="opened=0"></import-students>
                        </div>
                        <div class="m-top-2">
                            <div class="d-md-flex flex-wrap" v-if="students.length > 0">
                                <div class="col-lg-6 st" v-for="(o,i) in students">
                                    <div class="col-md-12 student_box d-flex align-items-center justify-content-between">
                                        <span>{{o.firstname}} {{o.surname}}</span>
                                        <button type="button" class="btn btn-sm" @click="removeStudent(i)"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center" v-else style="padding:25px;">
                                <span class="d-block" style="font-size:25px;color:#666;user-select: none">Žádní studenti</span>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <b-btn type="submit" class="btn-gray btn-block" :disabled="!isManualReady">Vytvořit</b-btn>
                        </div>
                    </div>
                </div>
                <!--<div class="tab_item mx-auto">
                    <h2 class="tab_name" disabled>Přidání ze souboru</h2>
                    ahoj
                </div>!-->
            </tabs>

        </div>
    </div>
</template>

<script>
    import AddStudent from "./addStudent";
    import ImportStudents from "./importStudents";
    export default {
        name: "newGroup",
        components: {ImportStudents, AddStudent},
        props:["selective"],
        data(){
            return {
                opened:0,
                students:[],
                teacher:"",
                modal_list:[],
                inputs:{
                    name:""
                }
            }
        },
        methods:{
            close(){
                this.modal_list = null;
                this.opened = 0;
            },
            add(data){
                this.students = this.students.concat(data);
                this.close();
            },
            addMore(data){
                this.students = _.uniqBy(this.students.concat(data),"id");
                this.close();
            },
            removeStudent(i){
                this.students.splice(i,1);
            }
        },
        watch:{
        },
        computed:{
            isManualReady(){
                return (this.errors.first('name') == null && this.inputs.name.length > 0 && this.students.length > 0 && ((this.selective) ? this.teacher.length > 0 : true));
            }
        }
    }
</script>

<style scoped>

</style>