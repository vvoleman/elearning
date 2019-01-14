<template>
    <div v-if="datas != null">
        <div class="mv-toolbar col-12 sticky-top" style="padding-left:0;padding-right:0">
            <b-collapse id="toolbar" visible>
                <div class="d-md-flex justify-content-between">
                    <div class="d-md-flex align-items-center">
                        <div class="bar-item">
                            < Předchozí modul
                        </div>
                    </div>
                    <div class="d-md-flex align-items-center">
                        <div class="bar-item">
                            <b-select v-model="selected" :options="options"></b-select>
                        </div>
                    </div>
                    <div class="d-md-flex align-items-center">
                        <div class="bar-item">
                            Následující modul >
                        </div>
                    </div>
                </div>
            </b-collapse>
        </div>
        <div class="col-md-10 mx-auto m-top-2" v-if="module.data != null">
            <div v-for="(o,i) in module.data.chapters" :id="'chapter-'+i" class="container">
                <h1>{{o.title}}</h1>
                <div class="container">
                    <div v-for="(p,j) in o.rows">
                        <layout-manager :type="p.type" :components="p.components"></layout-manager>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LayoutManager from "./LayoutManager";
    export default {
        name: "ModuleViewer",
        props:["datas"],
        components: {LayoutManager},
        data(){
            return {
                selected:0,
                data:JSON.parse(this.datas),
                module:[],
                options:[],
                resources:[]
            }
        },
        mounted(){
            this.convertToObject();
        },
        methods:{
            convertToObject(){
                this.module = this.data.context;
                this.resources = this.data.resources;
                var temp =  this.module.data.chapters;
                for(var i = 0; i<temp.length; i++){
                    var temp2 = {
                        value:i,
                        text:(i+1)+". "+temp[i].title
                    };
                    this.options.push(temp2);
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