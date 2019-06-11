<template>
    <div>
        <div class="d-flex">
            <select v-model="currSelect" class="form-control">
                <option value="0">Vyberte kurz</option>
                <option v-for="(o,i) in courses" :value="i+1">{{o.label}}</option>
            </select>
            <i class="fas fa-plus pointer" :class="{disabledbutton:currSelect==0}"></i>
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
                    }
                ],
                active_filter:[]
            }
        }
    }
</script>

<style scoped>
    .fa-plus{
        margin-left:10px;
    }
</style>
