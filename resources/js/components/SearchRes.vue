<template>
    <div>
        <div v-if="looking" class="results d-block col-12 position-absolute">
            <div class="d-flex justify-content-between align-items-center" v-for="(o,i) in name_list" :class="{selected:i==selected}" v-on:click="selectUser">{{o.firstname}} {{o.surname}} <span class="sm">{{o.email}}</span></div>
        </div>
    </div>
</template>

<script>
    export default {
        props:[],
        name: "searchres",
        data:function () {
            return {
                selected:0,
            }
        },
        methods:{
            selectUser:function(){

            }
        }
    }
</script>

<style scoped>

</style>