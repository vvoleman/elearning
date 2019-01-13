<template>
    <div>
        <edit-component v-model="groups" :course="course" type="groups">
            <h1 slot="title">Úprava tříd v kurzu</h1>
            <import-sel slot="input" v-model="groups"></import-sel>
        </edit-component>
    </div>
</template>

<script>
    import ImportSel from "../group/importsel";
    import EditComponent from "./EditComponent";
    export default {
        components: {EditComponent, ImportSel},
        props:["datas","course"],
        name: "EditGroups",
        data(){
            return {
                groups:JSON.parse(this.datas)
            }
        }

    }
</script>

<style scoped>

</style>