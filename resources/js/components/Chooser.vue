<template>
    <div class="d-md-flex justify-content-between">
        <div class="d-flex col-md-4">
            <select v-model="currSelect" class="form-control">
                <option value="0">Vyberte kurz</option>
                <option v-for="(o,i) in courses" :value="i+1">{{o.label}}</option>
            </select>
            <i class="fas fa-plus pointer" :class="{disabledbutton:currSelect==0}" @click="addFilter()"></i>
        </div>
        <div class="d-flex">
            <div v-for="(o,i) in active_filter">
                <div class="filter">{{o.label}} <span class="close">&times</span></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Chooser",
        data(){
            return {
                currSelect:0,
                courses:[
                    {
                        label:"Český jazyk",
                        id:1
                    },
                    {
                        label:"Matematika",
                        id:2
                    },
                    {
                        label:"Fyzika",
                        id:3
                    },
                    {
                        label:"Matematika",
                        id:2
                    },
                    {
                        label:"Fyzika",
                        id:3
                    },
                    {
                        label:"Matematika",
                        id:2
                    },
                    {
                        label:"Fyzika",
                        id:3
                    },
                    {
                        label:"Matematika",
                        id:2
                    },
                    {
                        label:"Fyzika",
                        id:3
                    }
                ],
                active_filter:[]
            }
        },
        methods:{
            addFilter(){
                var i = this.currSelect-1;
                if(i==-1 || this.courses[i] == null){
                    return;
                }
                this.active_filter.push(this.courses[i]);
                this.courses.splice(i,1);
                if(this.courses[i] == null){
                    this.currSelect = i;
                }
            }
        }
    }
</script>

<style scoped>
    .fa-plus{
        margin-left:10px;
    }
    .close{
        font-size:20px;
        margin-left:5px;
        color:white;
    }
    .filter{
        padding:10px;
        color:white;
        margin:0px 10px;
        background:#2a9055;
        box-shadow: 0px 0px 12px -2px rgba(0,0,0,0.45);
    }
</style>
