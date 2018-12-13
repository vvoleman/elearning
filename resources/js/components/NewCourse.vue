<template>
    <div>
        <div class="d-md-flex justify-content-center col-md-10 mx-auto align-items-center">
            <div class="col-xl-4 col-md-6 login_form_div m-top-2">
                <div class="col-md-11 mx-auto">
                    <div class="form-group">
                        <label class="label" :class="{bad:(errors.name.length > 0),correct:errors.name.length==0 && name.length > 3}">Název kurzu</label>
                        <input type="text" class="form-control" v-model="name">
                    </div>
                    <div class="form-group">
                        <label class="label" :class="{bad:((slug_used || slug_used.length == 0) && slug_used != ''),correct:(!slug_used && slug_used.length != '')}">Zkratka kurzu</label>
                        <scchecker :name="name" v-on:used="usedStateChange"></scchecker>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 login_form_div offset-md-1 m-top-2">
                <div class="col-md-11 mx-auto">
                    <div class="form-group">
                        <label class="label">Popis kurzu</label>
                        <textarea class="form-control" style="resize:none" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="label">Další lektoři</label>
                        <emailsel></emailsel>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 m-top-2 mx-auto">
            <button class="btn btn-block btn-gray">Vytvořit!</button>
        </div>
    </div>
</template>

<script>
    export default {
        //TODO: Ukazovat vybrané uživatele
        name: "newaccount",
        data:function(){
            return {
                name:"",
                slug_used:"",
                errors:{
                    name:""
                }
            }
        },
        methods:{
            usedStateChange:function(data){
                this.slug_used = data;
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
                if(this.name.length < 4){
                    this.errors.name = "Jméno je příliš krátké!";
                }else if(this.errors.name.length != 0 && this.name.length >= 4){
                    this.errors.name = "";
                }
            }
        }

    }
</script>

<style scoped>

</style>