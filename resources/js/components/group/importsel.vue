<template>
    <searcher v-model="sel_users" :datalink="name_list" @datalink="loadData" @parse="parseRes" :parse="parse"></searcher>
</template>

<script>
    import StudentShow from "../StudentShow";
    import Searcher from "../Searcher";
    export default {
        name: "importsel",
        components: {Searcher, StudentShow},
        data(){
          return {
            name_list:[],
            sel_users:[],
            parse:[]
          };
        },
        mounted(){

        },
        methods:{
            parseRes(data){ //TODO: vrátit msg
                var temp = [];
                for(var i = 0; i<data.length;i++){
                    temp.push({msg:data[i].firstname+" "+data[i].surname+", "+data[i].email,obj:data[i]});
                }
                this.parse = temp;
            },
            loadData(name){
                $.get("/ajax/importStudents", {slug:name}, function (data) {
                    this.name_list = data;
                }.bind(this));
            },
        }

    }
</script>

<style scoped>

</style>