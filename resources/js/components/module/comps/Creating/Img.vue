<template>
    <div class="col-12">
        <modal v-if="modal.show" @closeModal="clear" @send="edit">
            <h1 slot="header">Úprava obrázku</h1>
            <div slot="body">
                <div class="form-group">
                    <label class="label">Odkaz</label>
                    <input class="form-control" type="text" v-model="modal.src"/>
                </div>
                <div class="form-group">
                    <label class="label">Popisek</label>
                    <input class="form-control" type="text" v-model="modal.desc">
                </div>
            </div>
        </modal>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span>Typ: <b>Obrázek</b></span>
            </div>
            <div>
                <b-btn variant="danger" @click="remove">&times</b-btn>
                <b-btn @click="open">Upravit</b-btn>
            </div>
        </div>
        <hr>
        <div v-if="ctx.src.length>0 && ctx.desc.length > 0">
            <img :src="ctx.src" class="col-md-12" @error="imageLoadError">
            <span>{{ctx.desc}}</span>
        </div>
        <h5 v-else class="text-center">Doplňte data</h5>
    </div>
</template>

<script>
    export default {
        name: "ImgCreate",
        props:["context"],
        data(){
            return {
                modal:{
                    show:false,
                    src:"",
                    desc:""
                },
                ctx:{
                    src:"",
                    desc:""
                }
            }
        },
        mounted(){
            if(this.context != null && this.context.src != null){
                this.ctx = this.context;
            }
            console.log("ParagraphCreate mounted - "+new Date().toLocaleTimeString());
        },
        methods:{
            open(){
                this.modal.src = this.ctx.src;
                this.modal.desc = this.ctx.desc;
                this.modal.show = true;
            },
            close(){
                this.clear();
            },
            remove(){
                this.$emit('remove',true);
            },
            update(){
            },
            edit(){
                if(this.modal.src.length>0 && this.modal.desc.length > 0){
                    this.ctx.src = this.modal.src;
                    this.ctx.desc = this.modal.desc;
                    this.$emit('update',this.ctx);
                    this.clear();
                }
            },
            clear(){
                this.modal.src = "";
                this.modal.desc = "";
                this.modal.show = false;
            },
            imageLoadError(){
                alert('Toto není funkční obrázek');
                this.ctx.src = "";
            }
        },
        watch:{
            context(){
                console.log(this.context);
            }
        }
    }
</script>

<style scoped>

</style>