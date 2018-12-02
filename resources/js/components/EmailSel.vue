<template>
    <div>
        <input type="text" v-model="name" class="form-control">
        <div v-if="name_list.length > 0">
            <div v-for="(o,i) in name_list">{{o.firstname}}</div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "EmailSel",
        data:function () {
            return{
                name:"",
                name_list:"",
                looking:false,
            }
        },
        methods:{
            startProcess: function(){
                if(this.name.length >= 4) {
                    var temp = this;
                    $.get("ajax/getUsersByName", {name: temp.name}, function (data) {
                        temp.name_list = data;
                    });
                }else if(this.name_list.length > 0){
                    this.name_list = "";
                }
            }
        },
        watch:{
            name: _.debounce(function(){
                this.startProcess();
            },500)
        }
    }
</script>

<style scoped>

</style>