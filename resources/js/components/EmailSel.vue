<template>
    <div style="padding-left: 0px;padding-right: 0px" class="col-12 selusers" v-on:keyup="keyUp">
        <div v-click-outside="closeSearch" style="z-index:11">
            <div class="d-flex  justify-content-between" >
                <input @click="looking = true" type="text" v-model="name" class="form-control">
            </div>
            <div v-if="looking" class="results d-block col-12 position-absolute" style="padding-left:0;padding-right:0">
                <div class="d-flex align-items-center box" v-for="(o,i) in name_list" :class="{selected:i==selected}" v-on:click="selectUser">{{o.firstname}} {{o.surname}} <span class="sm offset-0"> &nbsp{{o.email}}</span></div>
            </div>
        </div>
        <div class="d-flex justify-content-between" v-if="!cust" style="flex-wrap:wrap">
            <div v-for="(o,i) in sel_users" class="send_to d-flex align-items-center justify-content-between col-md-12">
                <div class="circle">{{o.firstname[0]+o.surname[0]}}</div>
                <span>{{o.firstname}} {{o.surname}}</span>
                <button class="btn btn-sm" @click="dropUser(i)"><i class="fas fa-times"></i></button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "EmailSel",
        props:['replyto','value','default','custom','group'],
        data:function () {
            return{
                name:"",
                name_list:"",
                selected:0,
                looking:false,
                sel_users:"",
                cust:false,
                gr:""
            }
        },
        mounted:function(){
            if(this.default != null && this.default.length > 0){
                this.sel_users = JSON.parse(this.default);
            }
            if(this.custom == "true"){
                this.cust = true;
            }
            if(this.group != null && this.group.length > 0){
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
            dropUser: function(i){
                this.sel_users.splice(i,1);
            },
            selectUser: function(){
                if(!Array.isArray(this.sel_users)){
                    this.sel_users = [];
                }
                this.sel_users.push(this.name_list[this.selected]);
                this.selected = 0;
                this.name = "";
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
                        if(temp.sel_users.length == 0){
                            temp.name_list = data;
                        }else{
                            for (var i = 0; i<data.length;i++){
                                var boo = true;
                                for (var j = 0;j<temp.sel_users.length;j++){
                                    if(data[i].id == temp.sel_users[j].id){
                                        boo = false;
                                    }
                                }
                                if(boo){
                                    test.push(data[i]);
                                }
                            }
                            temp.name_list = test;
                        }
                    });
                }else if(this.name_list.length > 0){
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
                this.startProcess();
            },300),
            looking:function(){
                console.log("Looking = "+this.looking)
            },
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