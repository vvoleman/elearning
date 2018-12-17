<template>
    <div class="input-group mb-3">
        <input :disabled="look" v-validate="{required:true,regex:/^[a-zA-Z0-9_]*$/,min:4,max:8}" :name="name" type="text" class="form-control" v-model="custom">
        <div class="input-group-prepend">
            <button class="btn" type="button" @click="generateSlug" :disabled="c.length == 0 || look">Vygenerovat <i style="font-size:15px" class="fas fa-sync-alt fa-spin" v-if="look"></i></button>
        </div>
    </div>
</template>

<script>
    export default {
        props:["c","name","default"],
        name: "ShortcutChecker",
        data:function(){
          return {
              custom:"",
              og:"",
              cz_lett:"",
              look:false
          }
        },
        watch:{
            custom:_.debounce(function(){
                    if(this.custom.length < 4 || this.custom.length > 8){
                        this.sendChange(this.custom);
                        return;
                    }
                    this.checkShortcut(this.custom).then(function(data){
                        var t = true;
                        if(this.isSlugOk(data) === false){
                            t = false;
                        }
                        this.sendChange(t);
                    }.bind(this),function(){});
            },100),
            default(){
                this.custom = this.default;
                if(this.og.length == 0){
                    this.og = this.default;
                }
            }
        },
        mounted:function(){
            console.log(this.default);
            if(this.default != null && this.default.length > 0){
                this.custom = this.default;
                this.og = this.custom;
                console.log(this.og);
            }else{
                console.log("proč to nejdeeeee");
            }
            $.get("/js/json/cz_letters.json",function (data) {
                this.cz_lett = data;
            }.bind(this));
        },
        methods:{
            checkShortcut:function(s){
                return $.get('/ajax/checkCourseSlug',{slug:s});
            },
            generateSlug:function(){
                var temp = Math.random().toString(36).substr(2,8);
                this.look = true;
                this.checkShortcut(temp).then(function(data){
                    var t = true;
                    if(this.isSlugOk(data) !== false){
                        this.generateSlug();
                    }
                    this.look = false;
                    this.custom = temp;
                }.bind(this),function(idk){
                    this.look = false;
                    return null;
                });
            }, //OPRAVIT
            replaceCzeshtina:function(s){
                return s.replace(/[^a-zA-Z0-9_]/g,function(s){
                   if(this.cz_lett.hasOwnProperty(s)){
                        return this.cz_lett[s];
                   }
                   return " ";
                }.bind(this));
            },
            sendChange(msg){
                this.$emit('change',{msg: msg,shortcut:this.custom,err:(this.errors.first(this.name) == null && msg && (this.og != this.custom)) ? "Zkratka je již zabraná!" : this.errors.first(this.name)});
                console.log("posláno");
            },
            isSlugOk(data){
                if(data.response == null && data.used != null){
                    return data.used;
                }else{
                    return data.response;
                }
            }
        }
    }
</script>

<style scoped>

</style>