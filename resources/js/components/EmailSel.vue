<template>
    <div style="padding-left: 0px;padding-right: 0px" class="col-12 selusers" v-on:keyup="keyUp">
        <div v-click-outside="closeSearch" style="z-index:11">
            <div class="d-flex  justify-content-between">
                <input keydown.enter.prevent='true' v-b-tooltip.hover @click="looking = true" type="text" v-model="name" class="form-control" :disabled="extendsLimit" :title="(extendsLimit) ? 'Je možné vybrat pouze '+limit+' uživatele' : ''">
            </div>
            <div v-if="looking" class="results d-block col-12 position-absolute" style="padding-left:0;padding-right:0">
                <div class="d-flex align-items-center box" v-for="(o,i) in name_list" :class="{selected:i==selected}" v-on:click="selectUser">{{o.firstname}} {{o.surname}} <span class="sm offset-0"> &nbsp{{o.email}}</span></div>
            </div>
        </div>
        <student-show v-if="!cust"  v-model="sel_users"></student-show>
    </div>
</template>

<script>
    import StudentShow from "./StudentShow";
    export default {
        name: "EmailSel",
        components: {StudentShow},
        props:['replyto','value','default','custom','group','existing','limit'],
        data:function () {
            return{
                name:"",
                name_list:"",
                selected:0,
                looking:false,
                sel_users:this.value,
                cust:false,
                gr:"",
                exist:[]

            }
        },
        mounted:function(){
            if(!this.isEmpty(this.existing)){
                this.exist = (typeof this.existing == "string") ? JSON.parse(this.existing).students : this.existing;
            }
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
            dropUser: function(i){
                this.sel_users.splice(i,1);
                console.log(i);
            },
            selectUser: function(){
                if(this.name_list == null || this.name_list.length == 0){
                    return;
                }
                if(!Array.isArray(this.sel_users)){
                    console.log(this.sel_users);
                    this.sel_users = [];
                }
                this.sel_users.push(this.name_list[this.selected]);
                this.selected = 0;
                this.name = "";
                this.name_list = null;
                this.closeSearch();
                if(this.cust){
                    this.$emit("users_sel",this.sel_users);
                }
            },
            keyUp: function(e){
                if(this.looking && (e.keyCode == 38 || e.keyCode == 40)){
                    var temp = 1;
                    if(e.keyCode == 38){
                        temp = -1;
                    }
                    this.selected = (this.selected+temp+this.name_list.length)%this.name_list.length;
                    console.log(this.selected);
                }else if(e.keyCode == 13){
                    this.selectUser();
                }
            },
            startProcess: function(){
                if(this.name.length >= 4) {
                    var temp = this;
                    this.looking = true;
                    $.get("/ajax/getUsersByName", {name: temp.name,group:temp.gr}, function (data) {
                        var test = [];
                        if((temp.sel_users == null || temp.sel_users.length == 0) && temp.exist.length == 0){
                            temp.name_list = data;
                        }else{
                            for (var i = 0; i<data.length;i++){
                                var boo = true;
                                for (var j = 0;j<temp.sel_users.length;j++){
                                    if(data[i].id == temp.sel_users[j].id || (temp.exist.length > 0 && data[i].id == temp.exist[j].id)){
                                        boo = false;
                                    }
                                }
                                if(temp.exist.length > 0){
                                    for(var j = 0;j<temp.exist.length;j++){
                                        if(data[i].id == temp.exist[j].id){
                                            boo = false;
                                        }
                                    }
                                }
                                if(boo){
                                    test.push(data[i]);
                                }
                            }
                            temp.name_list = test;
                        }
                    });
                }else if(this.name_list != null && this.name_list.length > 0){
                    this.name_list = "";
                }
            },
            closeSearch: function(){
                if(this.looking){
                    this.looking = false;
                }
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
            searchForUsersById: function(data){
                $.get("/ajax/getUsersByIds/",{ids:data},function(data){
                    if(typeof data != "number"){
                        this.sel_users = data;
                    }
                }.bind(this));
            }
        },
        watch:{
            name: _.debounce(function(){
                if(this.extendsLimit){
                    return;
                }
                this.startProcess();
            },150),
            sel_users: function(){
                this.$emit('input',this.sel_users);
            },
            value:function(data){
                this.sel_users = data;
            }
        },
        computed:{
            extendsLimit(){
                return this.sel_users >= this.limit && !this.isEmpty(this.limit);
            }
        }
    }

</script>

<style scoped>

</style>