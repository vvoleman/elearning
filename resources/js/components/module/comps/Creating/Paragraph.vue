<template>
    <div class="col-12" v-if="ctx != null">
        <modal v-if="modal.show" @closeModal="clear" @send="edit">
            <h1 slot="header">Úprava odstavce</h1>
            <div slot="body">
                <div class="form-group">
                    <label class="label">Text</label>
                    <textarea style="height:300px;" class="form-control" v-model="modal.text"></textarea>
                </div>
            </div>
        </modal>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span>Typ: <b>Odstavec</b></span>
            </div>
            <div>
                <b-btn variant="danger" @click="remove">&times</b-btn>
                <b-btn @click="open">Upravit</b-btn>
            </div>
        </div>
        <hr>
        <p v-if="ctx.text.length >0" v-html="limited_text">
        </p>
        <h5 v-else class="text-center">Žádný text</h5>
    </div>
</template>

<script>
    export default {
        name: "ParagraphCreate",
        props:["context"],
        data(){
            return {
                modal:{
                    show:false,
                    text:""
                },
                ctx:{
                    text:""
                }
            }
        },
        mounted(){
            if(this.context != null && this.context.text != null){
                this.ctx = this.context;
            }
            console.log("ParagraphCreate mounted - "+new Date().toLocaleTimeString());
        },
        methods:{
            open(){
              this.modal.text = this.ctx.text;
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
                if(this.modal.text.length>0){
                    this.ctx.text = this.modal.text;
                    this.$emit('update',this.ctx);
                    this.clear();
                }
            },
            clear(){
                this.modal.text = "";
                this.modal.show = false;
            }
        },
        watch:{
            context(){
                console.log(this.context);
            }
        },
        computed:{
            limited_text(){
                return (this.ctx.text.length > 300) ? this.ctx.text.substring(0,300)+"..." : this.ctx.text;
            }
        }
    }
</script>

<style scoped>

</style>