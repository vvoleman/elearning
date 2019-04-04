<template>

</template>

<script>
    export default {
        name: "Timer",
        props:["startDate","time"],
        data(){
            return {
                endDate:new Date(this.startDate.getTime()+(this.time*60*1000)),
                start:false
            }
        },
        mounted(){
            this.startTimer();
        },
        methods:{
            startTimer(){
                this.start = true;
                this.countDown();
            },
            stopTimer(){
                this.start = false;
            },
            countDown(){
                if(this.start){
                    var timeLeft = Math.floor((this.endDate.getTime()-new Date().getTime())/1000);
                    if(timeLeft >= 0){
                        this.$emit('countDown',timeLeft);
                        setTimeout(()=>{
                            this.countDown();
                        },300);
                    }else{
                        this.$emit('end',true);
                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>
