<template>
    <div class="img_box col-md-4">
        <div>
            <img :src="context.src" style="width:100%">
        </div>
        <div class="desc">
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