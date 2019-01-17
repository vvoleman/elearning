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
                    <span>Kapitola {{i+1}}. <h3>{{o.title}}</h3></span>
                    <div>
                        <b-btn @click="removeChapter(i)" variant="danger">-</b-btn>
                        <b-btn @click="showEditChapter(i)">Upravit</b-btn>
                        <b-btn v-b-toggle="'chapter-'+i">Zobrazit/Skrýt</b-btn>
                    </div>
                </div>
                <b-collapse :id="'chapter-'+i">
                    <chapter  v-model="module.chapters[i].rows" :key="i" :in="i"></chapter>
                </b-collapse>
            </div>
        </div>
    </div>
</template>

<script>
    import Chapter from "./createComps/Chapter";
    export default {
        name: "ModuleCreater",
        components: {Chapter},
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
                    },
                    editRow:{
                        coords:null,
                        selected:null
                    }
                },
                module: {
                    chapters:[]
                },

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
            removeChapter(i){
                this.module.chapters.splice(i,1);
            },
            showEditChapter(i){
                this.modals.editChapter.name = this.module.chapters[i].title;
                this.modals.editChapter.curr = i;
            },
            editChapter(){
                this.module.chapters[this.modals.editChapter.curr].title = this.modals.editChapter.name;
                this.modals.editChapter.name = "";
                this.modals.editChapter.curr = null;
            }
        }
    }
</script>

<style scoped>

</style>