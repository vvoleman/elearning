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
                            <b-btn>Přidat existující</b-btn>
                            <b-btn>Importovat z jiné třídy</b-btn>
                        </div>


                        <div>
                            <modal v-if="opened == 0" v-on:send="addToGroup" v-on:closeModal="sh_add=false">
                                <div slot="header">
                                    <h3>Přidání</h3>
                                </div>
                                <div slot="body" style="padding:0px">
                                    <div class="form-group">
                                        <label class="label">Přidat</label>
                                        <emailsel :existing="datas" v-model="modal_list" group="user"></emailsel>
                                    </div>
                                </div>
                            </modal>
                        </div>


                        <div class="m-top-2">
                            <div class="d-md-flex flex-wrap">
                                <div class="col-md-4 st">
                                    <div class="col-md-12 student_box d-flex align-items-center justify-content-between">
                                        <span>Jméno příjmeni</span>
                                        <b-dropdown variant="link" right size="lg" no-caret>
                                            <template slot="button-content">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </template>
                                            <b-dropdown-item href="#">Napsat zprávu</b-dropdown-item>
                                            <b-dropdown-item href="#">Odebrat</b-dropdown-item>
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
    export default {
        name: "newGroup",
        data(){
            return {
                opened:0,
                students:[],
                modal_list:[]
            }
        },
        methods:{
            addStudents(){
                stude
            }
        }
    }
</script>

<style scoped>

</style>