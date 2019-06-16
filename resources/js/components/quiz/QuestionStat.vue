<template>
    <div>
        <div>
            <h4>{{index}}. {{question.text}}</h4>
            <span v-if="results.length == 1">Bodů: {{results[0].points[index-1]}}</span>
            <span v-if="results.length > 1" class="small">Úspěšnost: {{getSuccessPercentage()}}%</span>
            <hr>
            <div class="offset">
                <div class="d-flex ans align-items-center justify-content-between" v-for="(o,i) in question.options" :class="{'bg-success':getOptionById(o.option_id) != null && getOptionById(o.option_id).correct}">
                    <span :class="{corr:getOptionById(o.option_id)!=null && getOptionById(o.option_id).students.length > 0}">{{o.text}}</span>
                    <div v-if="results.length > 1 && getOptionById(o.option_id)!=null && getOptionById(o.option_id).students.length > 0" style="margin-left:15px" class="smaller d-flex align-items-center">
                        <b v-b-popover.hover="returnAsString(getOptionById(o.option_id).students)" title="Tuto možnost vybrali:">{{(getOptionById(o.option_id).students.length+"x")}}</b>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "QuestionStat",
        props:{
            question:{
                type:Object
            },
            results:{
                required:true
            },
            index:{
                type:Number
            }
        },
        data(){
            return{
                stats:[

                ]
            };
        },
        mounted(){
            this.runStats();
        },
        methods:{
            runStats(){
                this.stats = [];
                for(var i = 0; i<this.question.options.length;i++){
                    this.stats.push({
                        option_id:this.question.options[i].option_id,
                        students:this.getSelectedCount(this.question.question_id,this.question.options[i].option_id),
                        correct:this.isOptionCorrect(this.question.options[i].option_id)
                    });
                }
            },
            getSelectedCount(q_id,o_id){
                var arr = [];
                for(var i = 0;i<this.results.length;i++){
                    var temp = this.results[i].answers.filter((q)=>{
                       return q.question_id == q_id;
                    })[0];
                    if(temp != null){
                        temp = temp.selected_options.filter((o)=>{
                            return o == o_id;
                        });
                        if(temp.length > 0){
                            arr.push({
                                "user_id":this.results[i].user_id,
                                "firstname":this.results[i].firstname,
                                "surname":this.results[i].surname,
                            });
                        }
                    }
                }
                return arr;
            },
            returnAsString(students){
                var toReturn = "";
                for(var i = 0;i<students.length;i++){
                    toReturn +=students[i].surname+" "+students[i].firstname+"\n";
                }
                return toReturn;
            },
            getSuccessPercentage(){
                var sum = 0;
                var filtered = this.results.filter((r)=>{return r.time != null});
                for(var i=0;i<filtered.length;i++){
                    sum+=filtered[i].points[this.index-1];
                }
                console.log(sum+"/"+"("+filtered.length+"*"+this.question.correct_opts.length+")");
                return (sum/(filtered.length*this.question.correct_opts.length))*100;
            },
            isOptionCorrect(option_id){
                return this.question.correct_opts.filter((o)=>{
                    return o == option_id;
                }).length > 0;
            },
            getOptionById(option_id){
                var temp = this.stats.filter((o)=>{
                    return o.option_id == option_id;
                });
                if(temp.length > 0){
                    return temp[0];
                }
                return null;

            }
        },
        watch:{
            results(){
                this.runStats();
            }
        }
    }
</script>

<style scoped>
    .offset{
        margin-left:30px;
    }
    .ans{
        padding:5px;
        border-radius:5px;
        margin-bottom:3px;
    }
    .smaller{
        font-size:16px;
    }
    .corr{
        font-weight: bold;
    }
</style>
