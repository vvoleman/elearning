<template>
    <div if="context">
        <h5>{{(context!=null)?context.context.order:""}}. {{question.question}}</h5>
        <div style="padding-left:10px">
            <div class="form-check col-12" v-for="(p,j) in question.options">
                <input :value="p.id" type="checkbox" :name="'q_'+context.context.order" v-model="answer" class="form-check-input">
                <label class="form-check-label">{{p.value}}</label>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "checkbox",
        props:["context","value"],
        data(){
            return {
                answer:this.value
            }
        },
        mounted(){
            console.log(this.context);
        },
        computed:{
            question(){
                return this.context.context.question;
            }
        },
        watch:{
            answer(){
                console.log(this.answer);
                this.$emit('input',{id:this.question.id,answer:[this.answer]});
            }
        }
    }
</script>

<style scoped>

</style>
