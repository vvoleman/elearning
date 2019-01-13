<template>
    <modal @closeModal="$emit('closeModal',true)" @send="groupToStudents">
        <div slot="header">
            <h3>Importovat z ostatních tříd</h3>
        </div>
        <div slot="body" style="padding:0px">
            <div class="form-group">
                <label class="label">Název třídy</label>
                <importsel v-model="sel_groups"></importsel>
            </div>
            <div v-if="sent" class="loading style-2"></div>
        </div>
    </modal>
</template>

<script>
    import Importsel from "./importsel";
    export default {
        name: "importStudents",
        data(){
            return {
                sel_groups:[],
                sent:false
            };
        },
        components: {Importsel},
        methods:{
            changeData(data){
                this.sel_groups = data;
            },
            groupToStudents(){
                if(this.sel_groups.length == 0){
                    return;
                }
                var students = [];
                this.sent = true;
                $.get('/ajax/getStudentsByGroups',{groups:this.sel_groups},function(data){
                    if(data.response == null){
                        this.$emit('send',data.data);
                    }
                }.bind(this));
            }
        }
    }
</script>

<style scoped>
    .loading {
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-color: rgba(0,0,0,.5);
    }
</style>