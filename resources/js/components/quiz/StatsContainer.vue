<template>
    <div class="m-top-2">
        <div class="d-flex align-items-center">
            <label class="switch">
                <input type="checkbox" v-model="user_toggle">
                <span class="slider round"></span>
            </label>
            <label style="margin-left:5px">Zobrazit studenta</label>
            <select v-if="user_toggle" v-model="selected_user" class="form-control col-2" style="margin-left:5px">
                <option v-for="(o,i) in results" :value="o.user_id">{{o.surname}} {{o.firstname}}</option>
            </select>
        </div>
        <div class="m-top-2 col-md-3">
            <div v-for="(o,i) in questions">
                <question-stat :question="o" :key="i" :results="results"></question-stat>
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
                user_toggle:true,
                selected_user:0
            }
        },
        mounted(){
            this.filtered;
        },
        computed:{
            filtered(){
                //udělat filtrování studentů


            }
        }
    }
</script>

<style scoped>

</style>
