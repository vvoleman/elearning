<template>
    <div class="col-md-8 m-top-2 mx-auto">
        <vue-snotify></vue-snotify>
        <div>
            <h1 class="text-center">Úprava studentů</h1>
            <a :href="'/group/'+slug" class="no-a d-flex align-items-center">
                <i class="fas fa-chevron-left"></i>
                Zpět
            </a>
            <hr class="m-top-2">
                <div class="d-flex justify-content-between">
                    <div>
                        <b-btn class="btn-gray" v-on:click="sh_add = !sh_add">Přidat studenta</b-btn>
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
                            <i @click="remove(i)" class="fas fa-times pointer"></i>
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
        props:["datas","slug"],
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
            ano(toast){
                console.log("ano");
                this.zrusit(toast.id);
            },
            ne(toast){
                this.zrusit(toast.id);
            },
            zrusit(id){
                this.$snotify.remove(toast.id);
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
                            this.$snotify.success('Změny byly úspěšně uloženy!', 'Úspěch', {
                                timeout: 2000,
                                showProgressBar: true,
                                closeOnClick: true,
                                pauseOnHover: true
                            });
                        }else{
                            this.$snotify.danger('Při ukládání se vyskytla chyba!', 'Chyba', {
                                timeout: 2000,
                                showProgressBar: true,
                                closeOnClick: true,
                                pauseOnHover: true
                            });
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
