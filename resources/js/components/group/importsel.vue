<template>
    <div style="padding-left: 0px;padding-right: 0px" class="col-12 selusers">
        <div v-click-outside="closeSearch" style="z-index:11">
            <div class="d-flex  justify-content-between" v-on:keyup="keyUp">
                <input @click="looking = true" type="text" v-model="name" class="form-control" :disabled="sel_groups.length >= limit">
            </div>
            <div v-if="looking" class="results d-block col-12 position-absolute" style="padding-left:0;padding-right:0">
                <div class="d-flex align-items-center box" v-for="(o,i) in name_list" :class="{selected:i==selected}" v-on:click="selectUser(i)">{{o.name}}, žáků: {{o.students_amount}}</div>
            </div>
        </div>
        <div class="d-md-flex flex-wrap" v-if="!custom">
            <div class="col-md-6 st" v-for="(o,i) in sel_groups">
                <div class="col-md-12 student_box d-flex align-items-center justify-content-between" :title="'Počet studentů: '+o.students_amount">
                    <span>{{o.name}}</span>
                    <button class="btn btn-sm" @click="dropUser(i)" type="button"><i class="fas fa-times"></i></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import StudentShow from "../StudentShow";
    export default {
        name: "ImportSel",
        props:["value","custom","quiz","limit"],
        components: {StudentShow},
        data:function () {
            return{
                name:"",
                name_list:"",
                selected:0,
                looking:false,
                sel_groups:this.value,
                urls:["/ajax/importStudents","/ajax/getGroupsForOpen"],
                q:this.quiz
            }
        },
        mounted:function(){
            if(this.q == null){
                this.q = false;
            }else{
                console.log(this.quiz);
            }
        },
        methods:{
            isEmpty(val){
                return val == null || val.length == 0;
            },
            dropUser: function(i){
                this.sel_groups.splice(i,1);
                console.log(i);
            },
            selectUser: function(i){
                if(this.name_list == null || this.name_list.length == 0){
                    return;
                }
                if(!Array.isArray(this.sel_groups)){
                    this.sel_groups = [];
                }
                this.sel_groups.push(this.name_list[i]);
                this.selected = 0;
                this.name = "";
                this.name_list = null;
                this.closeSearch();
            },
            keyUp: function(e){
                if(this.looking && (e.keyCode == 38 || e.keyCode == 40)){
                    var temp = 1;
                    if(e.keyCode == 38){
                        temp = -1;
                    }
                    console.log((this.selected+temp+this.name_list.length)%this.name_list.length);
                    this.selected = (this.selected+temp+this.name_list.length)%this.name_list.length;
                }else if(e.keyCode == 13){
                    this.selectUser(this.selected);
                }
                return false;
            },
            startProcess: function(){
                if(this.sel_groups.length >= this.limit){
                    return;
                }
                if(this.name.length >= 4) {
                    var temp = this;
                    this.looking = true;
                    var par = {
                        name:temp.name
                    }
                    if(this.q != false){
                        par.quiz = this.q;
                    }
                    $.get((this.q == false) ? temp.urls[0] : temp.urls[1], par, function (data) {
                        var test = [];
                        temp.selected = 0;
                        data = data.data;
                        if(temp.sel_groups == null || temp.sel_groups.length == 0){
                            temp.name_list = data;
                        }else{
                            for (var i = 0; i<data.length;i++){
                                var boo = true;
                                for (var j = 0;j<temp.sel_groups.length;j++){
                                    if(data[i].id == temp.sel_groups[j].id){
                                        boo = false;
                                    }
                                }
                                if(boo){
                                    test.push(data[i]);
                                }
                            }
                            temp.name_list = test;
                        }
                    }.bind(this));
                }else if(this.name_list != null){
                    this.name_list = "";
                }
            },
            closeSearch: function(){
                if(this.looking){
                    this.looking = false;
                }
            }
        },
        watch: {
            name: _.debounce(function () {
                this.startProcess();
            }, 150),
            sel_groups: function () {
                this.$emit('input', this.sel_groups);
            },
            value(){
                this.sel_groups = this.value;
            }

        }
    }
</script>

<style scoped>

</style>
