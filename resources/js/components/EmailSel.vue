<template>
    <div style="padding-left: 0px;padding-right: 0px" class="col-12 selusers" v-on:keyup="keyUp">
        <div v-click-outside="closeSearch" style="z-index:11">
            <div class="d-flex  justify-content-between" >
                <input @click="looking = true" type="text" v-model="name" class="form-control">
            </div>
            <div v-if="looking" class="results d-block col-12 position-absolute">
                <div class="d-flex justify-content-between align-items-center" v-for="(o,i) in name_list" :class="{selected:i==selected}" v-on:click="selectUser">{{o.firstname}} {{o.surname}} <span class="sm">{{o.email}}</span></div>
            </div>
        </div>
        <div class="d-flex justify-content-between" style="flex-wrap:wrap">
            <div v-for="(o,i) in sel_users" class="send_to d-flex align-items-center justify-content-between col-md-6">
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
        data:function () {
            return{
                name:"",
                name_list:"",
                selected:0,
                looking:false,
                sel_users:""
            }
        },
        mounted:function(){
        },
        methods:{
            dropUser:function(i){
                this.sel_users.splice(i,1);
            },
            selectUser:function(){
                if(!Array.isArray(this.sel_users)){
                    this.sel_users = [];
                    console.log("ti");
                }
                this.sel_users.push(this.name_list[this.selected]);
                this.selected = 0;
                this.closeSearch();
            },
            keyUp:function(e){
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
                    $.get("ajax/getUsersByName", {name: temp.name}, function (data) {
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
                this.$emit('sel_users',this.sel_users);
            }
        }
    }
</script>

<style scoped>

</style>