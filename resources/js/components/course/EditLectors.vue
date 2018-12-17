<template>
    <div>
        <div class="d-lg-flex justify-content-between align-items-center">
            <h1>Úprava lektorů kurzu</h1>
            <div>
                <button class="btn btn-gray" :disabled="!anyChange" @click="cancel">Zrušit změny</button>
                <button class="btn btn-gray" :disabled="!anyChange" @click="save">Uložit změny</button>
            </div>
        </div>
        <emailsel :default="datas" custom="true" v-model="lectors" group="teacher"></emailsel>
        <hr>
        <div class="col-12 d-lg-flex lect_lect_box" style="flex-wrap:wrap">
            <div v-for="(o,i) in lectors" class="lector_box col-12 col-lg-4 d-flex align-items-center justify-content-between">
                <div class="circle">{{o.firstname[0]+o.surname[0]}}</div>
                <span>{{o.firstname}} {{o.surname}} <span v-if="o.me" class="sm">(ty)</span></span>
                <div class="dropdown" :class="{invisible:o.me}">
                    <button class="no-bg" type="button" data-toggle="dropdown">
                        <i class="fas fa-caret-down"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item">Napsat zprávu</a>
                        <a class="dropdown-item" @click="remove(i)">Odebrat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:["datas","course"],
        name: "EditLectors",
        data: function(){
            return {
                og:JSON.parse(this.datas),
                lectors:JSON.parse(this.datas),
                change:false
            }
        },
        mounted:function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        },
        methods:{
            manageUsers(data){
                this.lectors = data;
            },
            remove(i){
                this.lectors.splice(i,1);
                this.change = true;
            },
            cancel(){
                this.lectors = this.og.slice();
                this.change = false;
            },
            save(){
                if(this.anyChange){
                    $.post('/ajax/updateTeachers',{lectors:(this.lectors.length > 0)?this.lectors:null,course:this.course},function(data){
                        console.log(data);
                        if(data.response == 200){
                            this.og = this.lectors;
                            this.change = false;
                        }else{
                            alert(data.reponse);
                        }
                    }.bind(this));
                }
            }
        },
        computed:{
            anyChange(){
                return this.change;
            }
        },
        watch:{
            lectors(){
                if(!_.isEqual(this.lectors,this.og)){
                    this.change = true;
                }
            }
        }
    }
</script>

<style scoped>

</style>