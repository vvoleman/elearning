<template>
    <div if="context">
        <h5>{{index}}. {{question.question}} ({{corr_amount}} odpovědi)</h5>
        <div style="padding-left:10px">
            <div class="form-check col-12" v-for="(p,j) in question.options">
                <input name="otazka" :value="p.id" type="checkbox" v-model="answer" class="form-check-input">
                <label class="form-check-label">{{p.value}}</label>
            </div>
        </div>
    </div>
</template>

<script>
    import BaseType from './BaseType.vue';
    export default {
        extends:BaseType,
        name: "checkbox",
        mounted(){
        },
        watch:{
            answer(){
            }
        }
    }
</script>

<style scoped>

</style>
