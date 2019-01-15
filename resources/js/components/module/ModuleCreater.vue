<template>
    <div>
        <b-btn @click="modals.newChapter.show = true">Přidat kapitolu</b-btn>
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
                <div class="col-12 d-md-flex justify-content-between align-items-center" style="background:#bbb">
                    <span>Kapitala {{i+1}}. <h3>{{o.title}}</h3></span>
                    <div>
                        <b-btn @click="removeChapter(i)" variant="danger">-</b-btn>
                        <b-btn @click="showEditChapter(i)">Upravit</b-btn>
                        <b-btn v-b-toggle="'chapter-'+i">Zobrazit/Skrýt</b-btn>
                    </div>
                </div>
                <b-collapse :id="'chapter-'+i">
                    <div style="background:#ddd">
                        <div>
                            <b-dropdown variant="success" id="ddown-buttons" text="Přidat řádek" class="m-2">
                                <b-dropdown-item>Normální</b-dropdown-item>
                                <b-dropdown-item>Zarovnat doprostřed</b-dropdown-item>
                            </b-dropdown>
                        </div>
                    </div>
                </b-collapse>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ModuleCreater",
        data() {
            return {
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
                    chapters: [],
                }
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
            }
        }
    }
</script>

<style scoped>

</style>