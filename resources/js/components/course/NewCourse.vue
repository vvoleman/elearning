<template>
    <div>
        <div class="d-md-flex justify-content-center col-md-10 mx-auto align-items-center">
            <div class="col-xl-4 col-md-6 login_form_div m-top-2">
                <div class="col-md-11 mx-auto">
                    <h3>Povinné</h3>
                    <div class="form-group">
                        <label class="label" :class="{bad:errors.first('name') != null,correct:errors.first('name') == null && name.length > 0}" :title="errors.first('name')">Název kurzu</label>
                        <input type="text" class="form-control" v-model="name" name="name" v-validate="{required:true,max:32,min:4}">
                        <input type="hidden" v-bind:value="sel_lectors" name="lectors">
                    </div>
                    <div class="form-group">
                        <label class="label" :class="{bad:sce != null && sce.length > 0,correct:slug.length > 0 && sce == null}" :title="sce">Zkratka kurzu</label>
                        <scchecker name="shortcut" :c="name" v-on:change="usedStateChange"></scchecker>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 login_form_div offset-md-1 m-top-2">
                <div class="col-md-11 mx-auto">
                    <h3>Nepovinné</h3>
                    <div class="form-group">
                        <label class="label">Popis kurzu</label>
                        <textarea class="form-control" style="resize:none" rows="4" name="desc"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="label">Další lektoři</label>
                        <emailsel @sel_users="moreLector"></emailsel>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 m-top-2 mx-auto">
            <button class="btn btn-block btn-gray" :disabled="!isValid" @submit.prevent="isValid">Vytvořit!</button>
        </div>
    </div>
</template>

<script>
    export default {
        //TODO: Ukazovat vybrané uživatele
        name: "newcourse",
        data:function(){
            return {
                name:"",
                slug:"",
                sel_lectors:"",
                data:"",
                sce:""
            }
        },
        methods:{
            usedStateChange:function(data){
                if(data.msg === false){
                    this.slug = data.shortcut;
                }
                this.sce = data.err;
            },
            moreLector(data){
                this.sel_lectors = JSON.stringify(data);
            }
        },
        mounted:function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        },
        watch:{
            name:function(){
            },
            slug_used:function(){
            },
            errors(){
                console.log(this.errors);
            }
        },
        computed:{
            isValid(){
                return (this.errors.items != null && this.errors.items.length == 0) && (this.name.length != 0 && this.slug.length != 0);
            }
        }

    }
</script>

<style scoped>
    .bad{
        background: #f64954;
    }
    .correct{
        background: #46a851;
    }
</style>