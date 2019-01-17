<template>
    <div>
        <b-alert class="text-center" style="border-radius:0" v-if="count == null" dismissible fade :variant="type">{{msg}}</b-alert>
        <b-alert class="text-center" style="border-radius:0" v-else :show="dismissCountDown" dismissible fade :variant="type" @dismissed="dismissCountDown=0" @dismiss-count-down="countDownChanged">
            {{msg}}
        </b-alert>
    </div>
</template>

<script>
    export default {
        name:"Alert",
        props:["count","msg","type"],
        data () {
            return {
                dismissCountDown: this.count
            }
        },
        methods: {
            countDownChanged(dismissCountDown) {
                this.dismissCountDown = dismissCountDown
            }
        }
    }
</script>

<style scoped>

</style>