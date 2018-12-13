<template>
    <div class="input-group mb-3">
        <input type="text" class="form-control" v-model="custom">
        <div class="input-group-prepend">
            <button class="btn" type="button" @click="generateSlug">Vygenerovat</button>
        </div>
    </div>
</template>

<script>
    export default {
        props:["name"],
        name: "ShortcutChecker",
        data:function(){
          return {
              custom:"",
              cz_lett:"",
          }
        },
        watch:{
            name:function(){

            },
            custom:_.debounce(function(){
                if(this.custom.length > 3){
                    this.checkShortcut(this.custom);
                }else{
                    this.$emit("used",-1    );
                }
            },500)
        },
        mounted:function(){
            $.get("/js/json/cz_letters.json",function (data) {
                this.cz_lett = data;
            }.bind(this));
        },
        methods:{
            checkShortcut:function(s){
                $.get('/ajax/checkCourseSlug',{slug:s},function(data){
                    if(data.response == null && data.used != null){
                        this.$emit("used",data.used);
                    }else{
                        this.$emit("used",data.response);
                    }
                }.bind(this));
            },
            generateSlug:function(){
                var eng = this.replaceCzeshtina(this.name).toLowerCase();
                //Operační systémy 3. ročník
                var arr = eng.split(" ");
                var temp = "";
                if(arr.length > 3){
                    for (var i = 0;i<arr.length;i++){ //taking first letters
                        if(arr[i][0] != null){
                            temp+=arr[i][0];
                        }
                    }
                    if(temp.length > 8){
                        temp = temp.substr(0, 8);
                    }
                }else{
                    //TODO: Co dělat, když máme počet slov < 4
                }
                this.custom = temp; //TODO: Co když se vygenerovanej slug rovná nějakému v DB????
            },
            replaceCzeshtina:function(s){
                return s.replace(/[^a-zA-Z0-9_]/g,function(s){
                   if(this.cz_lett.hasOwnProperty(s)){
                        return this.cz_lett[s];
                   }
                   return " ";
                }.bind(this));
            }
        }
    }
</script>

<style scoped>

</style>