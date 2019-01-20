<template>
    <div>

        <div v-if="data != null && module_name != null">
            <div class="mv-toolbar col-12 sticky-top" style="padding-left:0;padding-right:0;z-index:15" v-if="typeof datas == 'string'">
                <modal-empty v-if="info" @closeModal="info = false">
                    <h1 slot="header">Informace</h1>
                    <div slot="body">
                        <div class="container-fluid">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Název</th>
                                    <td>{{module_name}}</td>
                                </tr>
                                <tr>
                                    <th>Vytvořeno/Editováno</th>
                                    <td>{{new Date(module.created_at*1000).toLocaleString()}}</td>
                                </tr>
                                <tr>
                                    <th>Popisek</th>
                                    <td>{{(module_desc != null) ? module_desc : '-'}}</td>
                                </tr>
                                <tr>
                                    <th>Počet kapitol</th>
                                    <td>{{chapters.length}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </modal-empty>
                <b-collapse id="toolbar" visible>
                    <div class="d-md-flex justify-content-between">
                        <div class="d-md-flex align-items-center">
                            <div class="bar-item">

                            </div>
                        </div>
                        <div class="d-md-flex align-items-center">
                            <div class="bar-item">
                                <b-select v-model="selected" :options="options"></b-select>
                            </div>
                            <div class="bar-item"><i @click="info=true" class="fas fa-info-circle"></i></div>
                        </div>
                        <div class="d-md-flex align-items-center">
                            <div class="bar-item">

                            </div>
                        </div>
                    </div>
                </b-collapse>
            </div>
            <div class="col-md-10 mx-auto m-top-2" v-if="chapters != null">
                <div v-for="(o,i) in chapters" :id="'chapter-'+i" class="container">
                    <h1>{{o.title}}</h1>
                    <div class="container">
                        <div v-for="(p,j) in o.rows" class="col-12">
                            <layout-manager :type="p.type" :components="p.components"></layout-manager>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="d-flex justify-content-center align-items-center">
            <h3>Při načítání se vyskytla chyba.</h3>
        </div>
    </div>
</template>

<script>
    import LayoutManager from "./LayoutManager";
    import ModalEmpty from "../ModalEmpty";
    export default {
        name: "ModuleViewer",
        props:["datas","name","desc"],
        components: {ModalEmpty, LayoutManager},
        data(){
            return {
                info:false,
                module_name:this.name,
                module_desc:this.desc,
                selected:0,
                data: (typeof this.datas == "string") ? JSON.parse(this.datas) : this.datas,
                module:[],
                chapters:[],
                options:[],
                resources:[]
            }
        },
        mounted(){
            if(this.data != null){
                this.convertToObject();
            }
        },
        methods:{
            convertToObject(){
                if(this.data.context != null){
                    this.module = this.data.context;
                    this.resources = this.data.resources;
                    this.chapters = this.module.data.chapters;
                    var temp =  this.chapters;
                    for(var i = 0; i<temp.length; i++){
                        var temp2 = {
                            value:i,
                            text:(i+1)+". "+temp[i].title
                        };
                        this.options.push(temp2);
                    }
                }else{
                    this.chapters = this.data.chapters;
                }
            }
        },
        watch:{
            selected(){
                var el = document.getElementById('chapter-' + this.selected);
                window.scrollTo(0,el.offsetTop);
            }
        }
    }
</script>

<style scoped>
    .bar-item{
        padding:15px;
    }
</style>