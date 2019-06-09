<template>
    <div>
        <div class="d-lg-flex justify-content-between align-items-center">
            <vue-snotify></vue-snotify>
            <slot name="title"></slot>
            <!--<h1>Úprava tříd v kurzu</h1>!-->
            <div>
                <button class="btn btn-gray" :disabled="!anyChange" @click="cancel">Zrušit změny</button>
                <button class="btn btn-gray" :disabled="!anyChange" @click="save">Uložit změny</button>
            </div>
        </div>
        <div class="m-top">
            <slot name="input"></slot>
        </div>
        <!--<import-sel custom="true" v-model="items"></import-sel>!-->
    </div>
</template>

<script>
    import ImportSel from "../group/importsel";
    export default {
        components: {ImportSel},
        props:["value","course","type"],
        name: "EditComponent",
        data: function(){
            return {
                og:this.value.slice(),
                items:this.value.slice(),
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
            remove(i){
                this.items.splice(i,1);
                this.change = true;
                this.$emit('input',this.items);
            },
            cancel(){
                this.items = this.og.slice();
                this.change = false;
                this.$emit('input',this.items);
            },
            save(){
                if(this.anyChange){
                    $.post('/ajax/updateCourse',{
                        data:{
                            items:(this.items.length > 0)?this.items:null,
                            course:this.course
                        },
                        type:this.type
                    },function(data){
                        if(data.response == 200){
                            this.og = this.items.slice();
                            this.change = false;
                            this.$snotify.success('Ukládání proběhlo úspěšně!', 'Úspěch', {
                                timeout: 2000,
                                showProgressBar: true,
                                closeOnClick: true,
                                pauseOnHover: false
                            });
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
            items(){
                console.log();
                if(!_.isEqual(this.items,this.og)){
                    this.change = true;
                }
            },
            value(data){
                console.log(data);
                this.items = data;
            }
        }
    }
</script>

<style scoped>

</style>
