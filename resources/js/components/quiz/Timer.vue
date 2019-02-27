<template>

</template>

<script>
    export default {
        name: "Timer",
        props:["time"],
        data(){
            return {
                dateStart:new Date(),
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
                    var timeLeft = (this.dateStart.getTime()-new Date().getTime())*1000;
                    if(timeLeft > 0){
                        this.$emit('countDown',timeLeft);
                        setTimeout(()=>{
                            this.countDown();
                        },1000);
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
