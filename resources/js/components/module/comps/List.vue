<template>
    <div :class="{list_style:context.colored}">
        <ol v-if="context.ordered">
            <li v-for="item in context.items">{{item}}</li>
        </ol>
        <ul v-if="!context.ordered">
            <li v-for="item in context.items">{{item}}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        props:["context"],
        name: "List",
    }
</script>

<style scoped>

</style>