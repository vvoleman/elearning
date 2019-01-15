<template>
    <div>
        <b-btn @click="modals.newChapter.show = true">Přidat kapitolu</b-btn>
        <b-btn @click="show = !show">Zobrat výsledek</b-btn>
        <modal @closeModal="modals.newChapter.show = false" @send="newChapter" v-if="modals.newChapter.show">
            <h1 slot="header">Kapitola</h1>
            <div slot="body">
                <div class="form-group">
                    <label class="label">Název kapitoly</label>
                    <input class="form-control" v-model="modals.newChapter.name">
                </div>
            </div>
        </modal>
        <modal @closeModal="modals.editChapter.curr = null" @send="editChapter" v-if="modals.editChapter.curr != null">
            <h1 slot="header">Úprava kapitoly</h1>
            <div slot="body">
                <div class="form-group">
                    <label class="label">Název kapitoly</label>
                    <input class="form-control" v-model="modals.editChapter.name">
                </div>
            </div>
        </modal>
        <hr>
        <div>
            <div v-for="(o,i) in module.chapters" class="col-12" style="padding-left:0;padding-right:0">
                <div class="col-12 d-md-flex justify-content-between align-items-center m-top" style="background:#bbb">
                    <span>Kapitala {{i+1}}. <h3>{{o.title}}</h3></span>
                    <div>
                        <b-btn @click="removeChapter(i)" variant="danger">-</b-btn>
                        <b-btn @click="showEditChapter(i)">Upravit</b-btn>
                        <b-btn v-b-toggle="'chapter-'+i">Zobrazit/Skrýt</b-btn>
                    </div>
                </div>
                <b-collapse :id="'chapter-'+i">
                    <div style="background:#ddd" class="container-fluid">
                        <div>
                            <b-dropdown variant="success" id="ddown-buttons" text="Přidat řádek" class="m-2">
                                <b-dropdown-item @click="addRow(rt.type,i)" v-for="(rt,c) in row_types" :key="rt.type">{{rt.text}}</b-dropdown-item>
                            </b-dropdown>
                        </div>
                        <hr style="background-color:black">
                        <div class="container-fluid">
                            <h4>Řádky</h4>
                            <div v-for="(p,j) in o.rows" class="container-fluid m-top" style="background:#ccc;padding:5px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Typ: {{p.type}}</span>
                                    <div class="">
                                        <b-btn variant="danger">-</b-btn>
                                        <b-btn>Přidat komponentu</b-btn>
                                        <b-btn>Upravit</b-btn>
                                    </div>
                                </div>
                                <div>

                                </div>
                            </div>
                        </div>
                    </div>
                </b-collapse>

                <moduleview v-if="show" :datas="{data:module}">

                </moduleview>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ModuleCreater",
        data() {
            return {
                show:false,
                modals:{
                    newChapter:{
                        show:false,
                        name:""
                    },
                    editChapter:{
                        curr:null,
                        name:""
                    }
                },
                module: {
                    "chapters":[
                        {
                            "title":"Seznámení",
                            "rows":[
                                {
                                    "type":"normal",
                                    "components":[
                                        {
                                            "type":"paragraph",
                                            "context":"Lorem ipsum dolor sit amet, <b>consectetur</b> adipisicing elit, <u title='Prostě podtrženej text, sestim smiř'>sed do eiusmod tempor incididunt</u> ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, <b>consectetur</b> adipisicing elit, <u title='Prostě podtrženej text, sestim smiř'>sed do eiusmod tempor incididunt</u> ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                                        },
                                        {
                                            "type":"img",
                                            "context":{
                                                "src":"https://static.ffx.io/images/$zoom_0.193%2C$multiply_1%2C$ratio_1.776846%2C$width_1059%2C$x_0%2C$y_97/t_crop_custom/w_768/t_sharpen%2Cq_auto%2Cf_auto%2Cdpr_auto/08b24b2389c24ff14ea66df016db5e664a791d01",
                                                "desc":"jenom trochu"
                                            }
                                        }
                                    ]
                                },
                                {
                                    "type":"normal",
                                    "components":[
                                        {
                                            "type":"paragraph",
                                            "context":"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                                        }
                                    ]
                                }
                            ]
                        }]
                },
                row_types:[
                    {
                        type:"normal",
                        text:"Normální"
                    },
                    {
                        type:"centered",
                        text:"Zarovnat doprostřed"
                    }
                ]
            }
        },
        methods:{
            newChapter(data){
                if(this.modals.newChapter.name.length > 0){
                    var temp = {
                        title:this.modals.newChapter.name,
                        rows:[]
                    }
                    this.module.chapters.push(temp);
                    this.modals.newChapter.show = false;
                    this.modals.newChapter.name = "";
                }
            },
            showEditChapter(i){
                var temp = this.module.chapters[i];
                this.modals.editChapter.name = temp.title;
                this.modals.editChapter.curr = i;
            },
            editChapter(){
                this.module.chapters[this.modals.editChapter.curr].title = this.modals.editChapter.name;
                this.modals.editChapter.name = "";
                this.modals.editChapter.curr = null;
            },
            removeChapter(i){
                this.module.chapters.splice(i,1);
            },
            addRow(type,i){
                var temp = {
                    type:type,
                    components:[]
                };

                this.module.chapters[i].rows.push(temp);
            }
        }
    }
</script>

<style scoped>

</style>