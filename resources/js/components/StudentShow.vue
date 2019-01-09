<template>
    <div>
        <div v-for="(o,i) in students" class="send_to d-flex align-items-center justify-content-between col-md-12">
            <div class="circle">{{o.firstname[0]+o.surname[0]}}</div>
            <span>{{o.firstname}} {{o.surname}}</span>
            <button class="btn btn-sm" @click="dropUser(i)"><i class="fas fa-times"></i></button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "StudentShow",
        props:["value"],
        data(){
            return {
                students: this.value
            }
        },
        mounted(){
          console.log("StudentShow is on");
        },
        methods:{
            dropUser(i){
                this.students.splice(i,1);
                this.$emit('input',this.students);
            }
        },
        watch:{
            value(){
                this.students = this.value;
            }
        }
    }
</script>

<style scoped>

</style>