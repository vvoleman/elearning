<template>
    <div class="col-md-8 col-lg-6 col-xl-5 mx-auto">
        <div class="m-top-2">
            <h1 class="text-center">Nová třída</h1>
            <hr>
            <tabs class="settings mx-auto">
                <div class="tab_item tab_active mx-auto">
                    <h2 class="tab_name">Ruční přidání</h2>
                    <div>
                        <div class="form-group">
                            <label class="label">Jméno třídy</label>
                            <input class="form-control"/>
                        </div>
                    </div>
                    <div>
                        <hr>
                        <h2>Studenti</h2>
                        <div class="m-top-2" style="flex-wrap:wrap">
                            <b-btn @click="opened = 1">Přidat existující</b-btn>
                            <b-btn @click="opened = 2">Importovat z jiné třídy</b-btn>
                        </div>


                        <div>
                            <add-student v-if="opened == 1" @cancel="close" @post="add"></add-student>
                        </div>

                        <import-students></import-students>
                        <div class="m-top-2">
                            <div class="d-md-flex flex-wrap">
                                <div class="col-md-4 st" v-for="(o,i) in students">
                                    <div class="col-md-12 student_box d-flex align-items-center justify-content-between">
                                        <span>{{o.firstname}} {{o.surname}}</span>
                                        <b-dropdown variant="link" right size="lg" no-caret>
                                            <template slot="button-content">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </template>
                                            <b-dropdown-item href="#">Napsat zprávu</b-dropdown-item>
                                            <b-dropdown-item @click="removeStudent(i)">Odebrat</b-dropdown-item>
                                        </b-dropdown>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab_item mx-auto">
                    <h2 class="tab_name">Přidání ze souboru</h2>
                    ahoj
                </div>
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
        data(){
            return {
                opened:0,
                students:[],
                modal_list:[]
            }
        },
        methods:{
            close(){
                this.opened = 0;
            },
            add(data){
                this.students = this.students.concat(data);
                this.modal_list = null;
                this.close();
            },
            removeStudent(i){
                this.students.splice(i,1);
            }
        },
        watch:{
        }
    }
</script>

<style scoped>

</style>