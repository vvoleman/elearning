<template>
    <div>
        <searcher :existing="existing" v-model="sel_users" :datalink="name_list" @datalink="loadData" @parse="parseRes" :parse="parse"></searcher>
        <student-show v-if="!cust" v-model="sel_users"></student-show>
    </div>
</template>

<script>
    import StudentShow from "./StudentShow";
    import Searcher from "./Searcher";
    export default {
        name: "EmailSel",
        components: {Searcher, StudentShow},
        props:['replyto','value','default','custom','group','existing'],
        data:function () {
            return{
                name:"",
                name_list:"",
                selected:0,
                sel_users:this.value,
                cust:false,
                gr:"",
                parse:[]

            }
        },
        mounted:function(){
            if(!this.isEmpty(this.default) && this.isEmpty(this.value)){
                this.sel_users = JSON.parse(this.default).students;
            }
            if(this.custom != null && this.custom == "true"){
                this.cust = true;
            }
            if(!this.isEmpty(this.group)){
                this.gr = this.group;
            }
            if(this.replyto != null){
                var data = this.prepareInput(this.replyto);
                if(data){
                    this.searchForUsersById(data);
                }
                //console.log("test");
            }
        },
        methods:{
            isEmpty(val){
                return val == null || val.length == 0;
            },
            loadData(name){
                $.get("/ajax/getUsersByName", {name: name,group:this.gr}, function (data) {
                    this.name_list = data;
                }.bind(this));
            },
            prepareInput: function(data){
                var temp = data.split(",");
                for(var i=0;i<temp.length;i++){
                    if(isNaN(temp[i]) || Number(temp[i])<0 || (Number(temp[i]) %1 != 0)){
                        temp = false;
                        break;
                    }
                }
                return temp;
            },
            parseRes(data){
                var temp = [];
                for(var i = 0; i<data.length;i++){
                    temp.push({msg:data[i].firstname+" "+data[i].surname+", "+data[i].email,obj:data[i]});
                }
                this.parse = temp;
            },
            searchForUsersById: function(data){
                $.get("/ajax/getUsersByIds/",{ids:data},function(data){
                    if(typeof data != "number"){
                        this.sel_users = data;
                    }
                }.bind(this));
            }
        },
        computed:{
            looking(){
                return this.name_list.length > 0;
            }
        },
        watch:{
            name: _.debounce(function(){
                this.startProcess();
            },300),
            sel_users: function(){
                this.$emit('input',this.sel_users);
            },
            value:function(data){
                this.sel_users = data;
            }
        }
    }
</script>

<style scoped>

</style>