<template>
    <div class="m-top-2">
        <div class="d-flex align-items-center">
            <label style="margin-left:5px">Zobrazit studenta</label>
            <select v-model="selected_user" class="form-control col-2" style="margin-left:5px">
                <option value="0">Všichni</option>
                <option v-for="(o,i) in results" :value="o.user_id">{{o.surname}} {{o.firstname}}</option>
            </select>
        </div>
        <div v-if="findStudentNull" class="m-top-2">
            <h3>Student tento test neodevzdal!</h3>
        </div>
        <div class="m-top-2 d-md-flex flex-wrap" v-if="!findStudentNull">
            <div v-for="(o,i) in questions" class="col-md-4 qs_box">
                <question-stat :index="i+1" class="" :question="o" :key="i" :results="filtered"></question-stat>
            </div>

        </div>
    </div>
</template>

<script>
    import QuestionStat from "./QuestionStat";
    export default {
        name: "StatsContainer",
        components: {QuestionStat},
        props:{
            results:{
                type:Array
            },
            questions:{
                type:Array
            }
        },
        data(){
            return {
                selected_user:0
            }
        },
        computed:{
            findStudentNull(){
                if(this.filtered.length > 1 || this.selected_user == 0){
                    return false;
                }
                return this.filtered[0].percentage == null;
            },
            filtered(){
                if(this.selected_user == 0){
                    return this.results;
                }
                return this.results.filter((r)=>{
                    return r.user_id == this.selected_user;
                });
            }
        }
    }
</script>

<style scoped>
    .qs_box:nth-child(even){
        background:#d3d3d3;

    }
    .qs_box{
        padding:25px;
        margin-top:10px;
    }
</style>
