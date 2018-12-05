<template>
    <div class="col-md-6 mx-auto course_short">
        <div class="d-flex justify-content-between header align-items-center m-top">
            <h4><slot name="head-text"></slot></h4>
            <i class="fas fa-caret-down" @click="show = !show"></i>
        </div>
        <transition name="slide-fade">
            <div class="body" v-if="show">
                <slot name="body"></slot>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        props: ["def_show"],
        name: "Hideable",
        data: function(){
            return {
                show: this.def_show
            }
        }
    }
</script>

<style scoped>

</style>