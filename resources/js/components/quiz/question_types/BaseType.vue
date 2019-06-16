<template>

</template>

<script>
    export default {
        props:{
            ans:{
                type:Array,
                default:()=>[]
            },
            question:{
                type:Object,
                required:true
            },
            index:{
                type:Number,
                required:true
            },
            corr_amount:{
                type:Number
            }

        },
        name: "BaseType",
        data(){
            return {
                answer:this.ans
            }
        },
        watch: {
            answer() {
                var temp;
                if(typeof this.answer != "array" && this.answer != null && this.answer.length == null){
                    temp = [this.answer];
                }
                this.$emit('answers', (temp == null) ? this.answer : temp);
            }
        }
    }
</script>

<style scoped>

</style>
