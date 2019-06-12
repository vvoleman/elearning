<template>
    <div>
        <div class="d-md-flex flex-wrap">
            <div class="col-12">
                <div class="d-flex col-12">
                    <div class="toggle-part" @click="active = !active">
                        <label class="switch">
                            <input type="checkbox" v-model="active">
                            <span class="slider round"></span>
                        </label>
                        <span class="l">Aktivní</span>
                    </div>
                    <div class="toggle-part" @click="nonactive = !nonactive">
                        <label class="switch">
                            <input type="checkbox" v-model="nonactive">
                            <span class="slider round"></span>
                        </label>
                        <span class="l">Ukončené</span>
                    </div>
                </div>
                <div class="col-12">
                    <chooser></chooser>
                </div>
            </div>
        </div>
        <hr>
    </div>
</template>

<script>
    import Chooser from "./Chooser";
    export default {
        name: "OpensInteractive",
        components: {Chooser},
        data(){
            return {
                active:true,
                nonactive:true
            }
        }
    }
</script>

<style scoped>
    .col-12,.col-4{
        padding-left:0;
        padding-right:0;
    }
    .toggle-part{
        display:flex;
        align-items: center;
        padding:5px;
        margin:5px;
        cursor:pointer;

    }
    .toggle-part label{
        margin-bottom:0;
    }
    .l{
        margin-left:5px;
        font-weight:bold;
        color:#242424;
        user-select: none;
    }
    .slider{
        background:#acacac;
    }
</style>
