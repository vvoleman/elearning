<template>
    <div>
        <div class="d-md-flex flex-wrap">
            <div class="d-flex justify-content-between col-12 align-items-center">
                <div class="d-flex">
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
                <div>
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
    .toggle-part{
        background:#acacac;
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
</style>
