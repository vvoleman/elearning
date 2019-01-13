<template>
    <div>
        <edit-component v-model="lectors" :course="course" type="lectors">
            <h1 slot="title">Úprava lektorů kurzu</h1>
            <emailsel slot="input" v-model="lectors" group="teacher"></emailsel>
        </edit-component>
    </div>
</template>

<script>
    import EditComponent from "./EditComponent";
    export default {
        components: {EditComponent},
        props:["datas","course"],
        name: "EditLectors",
        data: function(){
            return {
                lectors:JSON.parse(this.datas),
            }
        }
    }
</script>

<style scoped>

</style>