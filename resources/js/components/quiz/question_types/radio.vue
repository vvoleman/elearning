<template>
    <div if="context">
        <h5>{{index}}. {{question.question}}</h5>
        <div style="padding-left:10px">
            <div class="form-check col-12" v-for="(p,j) in question.options">
                <input :value="p.id" type="radio" v-model="answer" class="form-check-input">
                <label class="form-check-label">{{p.value}}</label>
            </div>
        </div>
    </div>
</template>

<script>
    import BaseType from './BaseType.vue';
    export default {
        extends:BaseType,
        name: "radio",
        mounted(){
            this.answer = this.answer[0];
        }
    }
</script>

<style scoped>

</style>
