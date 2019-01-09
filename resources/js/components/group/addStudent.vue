<template>
    <modal @closeModal="cancel" @send="post">
        <div slot="header">
            <h3>Přidání</h3>
        </div>
        <div slot="body" style="padding:0px">
            <div class="form-group">
                <label class="label">Přidat</label>
                <emailsel v-model="modal_list" group="user"></emailsel>
            </div>
        </div>
    </modal>
</template>

<script>
    export default {
        name: "addStudent",
        data(){
            return {
                modal_list:[]
            }
        },
        methods:{
            cancel(){
                this.$emit('cancel',null);
            },
            post(){
                this.$emit('post',this.modal_list);
            }
        }
    }
</script>

<style scoped>

</style>