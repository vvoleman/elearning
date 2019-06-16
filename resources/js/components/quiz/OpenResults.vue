<template>
    <div class="col-md-10 mx-auto m-top-2">
        <div>
            <h3 class="text-center">Výsledky testu "{{quiz}}" </h3>
            <div class="text-center col-12"><b><span :class="{'text-success':act,'text-danger':!act}">{{(act) ? "Test je stále otevřen!" : "Test uzavřen!"}}</span></b></div>
            <hr>
            <div>
                <div class="d-block"><b>Odevzdaných výsledků: </b>{{filledQuizesAmount().length}}/{{results.length}}</div>
                <div class="d-block"><b>Průměrný výsledek: </b>{{averageResult()}}{{averageResult() != null ? "%" : "-"}}</div>
            </div>
        </div>
        <div class="m-top">
            <ResultsTable :results="results"></ResultsTable>
        </div>
        <hr>
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
        props:["res","quests","quiz","act"],
        data(){
            return {
                results:[],
                questions:[]
            }
        },
        mounted(){
            this.results = JSON.parse(this.res);
            this.questions = JSON.parse(this.quests);
        },
        methods:{
            filledQuizesAmount(){
                return this.results.filter((r)=>{
                    return r.time != null;
                });
            },
            averageResult(){
                var filled = this.filledQuizesAmount();
                if(filled.length == 0){
                    return null;
                }
                console.log(filled);
                var sum = 0;
                for(var i=0;i<filled.length;i++){
                    sum+=parseFloat(filled[i].percentage);
                }
                return Math.floor(sum/filled.length*10)/10;
            }
        }
    }
</script>

<style scoped>

</style>
