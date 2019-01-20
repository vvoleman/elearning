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
                <span>Typ: <b>Seznam</b></span>
            </div>
            <div>
                <b-btn variant="danger" @click="remove">&times</b-btn>
                <b-btn @click="open">Upravit</b-btn>
            </div>
        </div>
        <hr>
        <h5 v-if="ctx.text.length >0">Položek: {{ctx.items.length}}</h5>
        <h5 v-else class="text-center">Prázdný seznam</h5>
    </div>
</template>

<script>
    export default {
        name: "ListCreate",
        props:["context"],
        data(){
            return {
                modal:{
                    show:false,
                    text:""
                },
                ctx:{
                    items:[]
                }
            }
        },
    }
</script>

<style scoped>

</style>