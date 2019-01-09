<template>
    <modal @closeModal="cancel" @send="post">
        <div slot="header">
            <slot name="title"></slot>
        </div>
        <div slot="body" style="padding:0px">
            <slot name="content"></slot>
            <div class="form-group">
                <label class="label">Přidat</label>
                <emailsel v-model="modal_list" group="user"></emailsel>
            </div>
        </div>
    </modal>
</template>

<script>
    export default {
        name: "studentManager"
    }
</script>

<style scoped>

</style>