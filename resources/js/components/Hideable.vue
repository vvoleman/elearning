<template>
    <div class="col-md-8 mx-auto course_short m-top">
        <div>
            <div class="d-flex justify-content-between header align-items-center" >
                <h4><slot name="head-text"></slot></h4>
                <div>
                    <slot name="control"></slot>
                    <i class="fas noselect " :class="{'fa-caret-down':!show,'fa-caret-up':show}" @click="show = !show"></i>
                </div>
            </div>
            <div class="body" v-if="show">
                <slot name="body"></slot>
            </div>
        </div>
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