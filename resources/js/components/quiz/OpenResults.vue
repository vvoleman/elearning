<template>
    <div class="col-md-10 mx-auto m-top-2">
        <div>
            <h3 class="text-center">Výsledky testu</h3>
            <hr>
            <div>
                <div class="d-block"><b>Odevzdaných výsledků: </b>1/1</div>
                <div class="d-block"><b>Průměrný výsledek: </b>64%</div>
            </div>
        </div>
        <div class="m-top">
            <ResultsTable :results="results"></ResultsTable>
        </div>
        <div class="m-top-2">
            <StatsContainer :results="results" :questions="questions"></StatsContainer>
        </div>
    </div>
</template>

<script>
    import ResultsTable from "./ResultsTable";
    import StatsContainer from "./StatsContainer";
    export default {
        name: "OpenResults",
        components: {StatsContainer, ResultsTable},
        props:["res","quests"],
        data(){
            return {
                results:[],
                questions:[]
            }
        },
        mounted(){
            this.results = JSON.parse(this.res);
            this.questions = JSON.parse(this.quests);
        }
    }
</script>

<style scoped>

</style>
