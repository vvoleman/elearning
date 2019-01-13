<template>
    <div>
        <div class="d-md-flex flex-wrap">
            <div class="col-md-6 st" v-for="(o,i) in students">
                <div class="col-md-12 student_box d-flex align-items-center justify-content-between">
                    <span>{{o.firstname}} {{o.surname}}</span>
                    <button type="button" class="btn btn-sm" @click="dropUser(i)"><i class="fas fa-times"></i></button>
                </div>
            </div>
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