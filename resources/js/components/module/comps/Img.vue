<template>
    <div class="img_box">
        <div>
            <img :src="context.src" style="width:100%">
        </div>
        <div class="desc" v-if="context.desc != null">
            <span>{{context.desc}}</span>
        </div>
    </div>
</template>

<script>
    export default {
        props:["context"],
        name: "Img"
    }
</script>

<style scoped>

</style>