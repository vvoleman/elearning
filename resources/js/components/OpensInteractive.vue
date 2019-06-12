<template>
    <div>
        <div class="d-md-flex flex-wrap">
            <div class="col-12">
                <div class="col-12">
                    <chooser :c="courses" @filterChange="filterChange"></chooser>
                </div>
            </div>
        </div>
        <hr>
        <div class="d-flex flex-wrap">
            <div v-for="(o,i) in filtered" class="col-md-4 st">
                <a :href="o.result" class="no-a">
                    <div class="col-md-12 student_box d-flex align-items-center justify-content-between " :class="{act:o.active,stop:!o.active}">
                        <span>{{o.quiz_name}}</span>
                        <div>
                            <span class="small">{{(o.active) ? "Aktivní" : "Uzavřeno"}}</span>
                        <i v-b-popover.hover="'Kurz: '+o.course.name+'\n'+'Od: '+o.opened_at+'\n'+'Do: '+o.closing_at" title="Informace" class="fas fa-info-circle"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import Chooser from "./Chooser";
    export default {
        name: "OpensInteractive",
        components: {Chooser},
        props:["o"],
        data(){
            return {
                filter:[],
                opens:[],
                courses:[]
            }
        },
        mounted(){
          this.opens = JSON.parse(this.o);
          for(var i = 0; i < this.opens.length; i++){
              if(this.courses.filter((c)=>{return c.id == this.opens[i].course.id;}).length == 0){
                  this.courses.push(this.opens[i].course);
              }
          }
        },
        methods:{
            filterChange(data){
                this.filter = data;
            }
        },
        computed:{
            filtered(){
                if(this.filter.length == 0){
                    return this.opens;
                }
                var temp = this.opens.filter((o)=>{
                    for(var i = 0; i<this.filter.length; i++){
                        if(this.filter[i].id == o.course.id){
                            return true;
                        }
                    }
                });
                return temp;
            }
        }

    }
</script>

<style scoped>
    .col-12,.col-4{
        padding-left:0;
        padding-right:0;
    }
    .toggle-part{
        display:flex;
        align-items: center;
        padding:5px;
        margin:5px;
        cursor:pointer;

    }
    .toggle-part label{
        margin-bottom:0;
    }
    .l{
        margin-left:5px;
        font-weight:bold;
        color:#242424;
        user-select: none;
    }
    .slider{
        background:#acacac;
    }
    .act{
        background:#def9cf;
    }
    .stop{
        background: #f9dbe3;
    }
</style>
