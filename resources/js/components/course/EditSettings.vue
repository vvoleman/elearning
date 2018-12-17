<template>
    <div>
        <div class="d-lg-flex justify-content-between align-items-center">
            <h1>Nastavení kurzu</h1>
            <div>
                <button class="btn btn-gray" :disabled="!anyChange" @click="cancel" type="button">Zrušit změny</button>
                <button class="btn btn-gray" :disabled="!anyChange" type="submit">Uložit změny</button>
            </div>
        </div>
        <hr>
        <div>
            <div>
                <div class="form-group">
                    <label class="label" :class="{bad:errors.first('name') != null,correct:errors.first('name') == null && name.length > 0 && name != name_og}" :title="errors.first('name')">Název kurzu</label>
                    <input type="text" v-validate="{required:true,min:4,max:32}" class="form-control" name="name" v-model="name">
                </div>
                <div class="form-group">
                    <label class="label" :class="{bad:sce != null && sce.length > 0,correct:slug.length > 0 && sce == null && slug != slug_og}" :title="sce">Zkratka kurzu</label>
                    <scchecker name="slug" :c="name" :default="slug" v-on:change="usedStateChange"></scchecker>
                </div>
                <div class="form-group">
                    <label class="label" :class="{}">Popis kurzu</label>
                    <textarea name="desc" v-model="desc" class="form-control" rows="4">{{desc}}</textarea>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "EditSettings",
        props:["datas"],
        data:function(){
            return {
                name:"",
                slug:"",
                desc:"",
                sce:"",
                slug_og:"",
                name_og:"",
                desc_og:"",
            };
        },
        mounted:function(){
            var temp = JSON.parse(this.datas);
            this.name = temp.name;
            this.name_og = temp.name;
            this.slug = temp.slug;
            this.slug_og = temp.slug;
            this.desc = temp.desc;
            this.desc_og = temp.desc;
            console.log(this.slug);
        },
        methods:{
            usedStateChange(data){
                console.log(data);
                this.slug = data.shortcut;
                this.sce = data.err;
            },
            cancel(){
                this.name = this.name_og;
                this.slug = this.slug_og;
                this.desc = this.desc_og;
            },
            save(){
                /*if(this.anyChange){
                    $.post('/ajax/updateTeachers',{lectors:this.lectors,course:this.course},function(data){
                        console.log(data);
                        if(data.response == 200){
                            this.og = this.lectors;
                        }else{
                            alert(data.reponse);
                        }
                    }.bind(this));
                }*/
            },
            onsubmit(){
                return false;
            }
        },
        computed:{
            isValid(){
                return (this.errors.items != null && this.errors.items.length == 0) && (this.name.length != 0 && this.slug.length != 0)
            },
            anyChange(){
                return ((this.name != this.name_og) || (this.slug != this.slug_og) || (this.desc != this.desc_og));
            }
        }

    }
</script>

<style scoped>

</style>