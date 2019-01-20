<template>
    <div>
        <input type="hidden" name="json" :value="JSON.stringify(module)">
        <modal-empty v-if="show" @closeModal="show = false">
            <h1 slot="header">Ukázka</h1>
            <div slot="body">
                <moduleview :datas="module" :name="m_name" :desc="m_desc"></moduleview>
            </div>
        </modal-empty>

        <!-- //////////////// !-->
        <div class="col-md-10 mx-auto m-top-2">
            <div class="d-flex justify-content-between">
                <div>
                    <b-btn @click="modals.newChapter.show = true">Přidat kapitolu</b-btn>
                    <b-btn @click="show = true" :disabled="module.chapters.length == 0">Zobrazit výsledek</b-btn>
                </div>
                <div>
                    <b-btn type="submit" :disabled="!readyToGo">Uložit</b-btn>
                </div>
            </div>
            <modal @closeModal="modals.newChapter.show = false" @send="newChapter" v-if="modals.newChapter.show">
                <h1 slot="header">Kapitola</h1>
                <div slot="body">
                    <div class="form-group">
                        <label class="label">Název kapitoly</label>
                        <input class="form-control" v-model="modals.newChapter.name">
                    </div>
                </div>
            </modal> <!-- new chapter !-->
            <modal v-if="modals.editChapter.curr != null" @closeModal="modals.editChapter.curr = null" @send="editChapter">
                <h1 slot="header">Úprava názvu kapitoly</h1>
                <div slot="body">
                    <div class="form-group">
                        <label class="label">Název</label>
                        <input class="form-control" type="text" v-model="modals.editChapter.name">
                    </div>
                </div>
            </modal>
            <div>
                <hr>
                <div class="">
                    <div>
                        <div class="form-group">
                            <h2>Název modulu</h2>
                            <input v-validate="{required:true,min:4,max:32}" type="text" v-model="m_name" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label><h3>Popisek modulu</h3></label>
                            <textarea class="form-control" name="desc" v-model="m_desc"></textarea>
                        </div>
                    </div>
                </div>
            </div> <!-- name !-->
            <hr>
            <div>
                <div v-for="(o,i) in module.chapters" class="col-12" style="padding-left:0;padding-right:0">
                    <div class="col-12 d-md-flex justify-content-between align-items-center m-top" style="background:#bbb">
                        <span>Kapitola {{i+1}}. <h3>{{o.title}}</h3></span>
                        <div>
                            <b-btn @click="removeChapter(i)" variant="danger">&times</b-btn>
                            <b-btn @click="showEditChapter(i)">Upravit</b-btn>
                            <b-btn v-b-toggle="'chapter-'+i">Zobrazit/Skrýt</b-btn>
                        </div>
                    </div>
                    <b-collapse :id="'chapter-'+i">
                        <chapter  v-model="module.chapters[i].rows" :key="i" :in="i"></chapter>
                    </b-collapse>
                </div>
            </div> <!-- chapters !-->
        </div>
    </div>
</template>

<script>
    import Chapter from "./createComps/Chapter";
    import ModalEmpty from "../ModalEmpty";
    export default {
        name: "ModuleCreater",
        components: {ModalEmpty, Chapter},
        props:["datas","name","desc"],
        data() {
            return {
                change:false,
                m_name:this.name,
                m_desc:this.desc,
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
                og:{}

            }
        },
        mounted(){
            if(this.datas != null) {
                var temp = JSON.parse(this.datas).context;
                this.module = temp.data;
                this.og = temp.data.chapters.slice();
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
        },
        computed:{
            readyToGo(){
                return this.m_name != null && this.m_name.length > 0 && this.errors.items != null && this.errors.items.length == 0 && this.module.chapters.length > 0;
            },
            anyChange(){
                return (this.change);
            },
            chapters(){
                return this.module.chapters;
            }
        },
        watch:{
            chapters(){
                if(!_.isEqual(this.module.chapters,this.og) ){
                    this.change = true;
                }else{
                    this.change = false;
                }
            }
        }
    }
</script>

<style scoped>

</style>