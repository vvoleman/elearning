<template>
    <div class="infobar col-12 d-md-flex align-items-center justify-content-between">
        <div class="countdown d-flex align-items-center">
            <div class="timebar">
                <div class="time" :style="{width: (100/(time_limit*60)*timeLeft)+'%'}"></div>
            </div>
            <div style="margin-left:15px;color:white">
                <span>{{formateSecs(timeLeft)}}</span>
                <timer :start-date="start_date" :time="time_limit" @countDown="setCountDown" @end="end(false)"></timer>
            </div>
        </div>
        <div class="d-flex align-items-center to_submit ">
            <i @click="move(false)" :class="{unmarked:!curr_question.canLeft}" class="fas fa-chevron-left"></i>
            <span class="q_left">{{curr_question.index+1}}. otázka z {{curr_question.length}}</span>
            <i @click="changeBookmark" class="fas fa-bookmark" :class="{unmarked:!curr_question.hasBookmark}" title="Označit si otázku"></i>
            <i @click="move(true)" :class="{unmarked:!curr_question.canRight}" class="fas fa-chevron-right"></i>
        </div>
        <div class="d-flex align-items-center to_submit">
            <span>{{missing}}</span>
            <button @click="end(true)" type="button" class="btn btn-secondary">Odeslat</button>
        </div>
    </div>
</template>

<script>
    import Timer from "./Timer";
    export default {
        components: {Timer},
        props:{
            time_limit:{
                type:Number,
                required:true
            },
            curr_question:{
                type:Object,
                required:false
            },
            start_date:{
                type:Date,
                required:true
            },
            questions_left:{
                type:Number
            }
        },
        name: "InfoBar",
        data(){
            return {
                timeLeft:null
            }
        },
        methods:{
            move(dir){
                var em;
                if(dir === true && this.curr_question.canRight){
                    em = true
                }else if(dir === false && this.curr_question.canLeft){
                    em = false
                }
                if(em != null){
                    this.$emit("move",em);
                }
            },
            setCountDown(time){
                this.timeLeft = time;
            },
            end(boo){ //true - button click, false - timeout
                this.$emit("end",boo);
            },
            formateSecs(time){
                var ret = Math.floor(time/60);
                time = time%60;
                ret+= ":"+((time<10) ? "0" : "")+time;
                return ret;
            },
            changeBookmark(){
                this.$emit("changeBookmark",true);
            }
        },
        computed:{
            missing(){
                console.log("tu");
                if(this.questions_left > 0){
                    var string = "Chybí "+this.questions_left+" ";
                    if(this.questions_left == 1){
                        string+="otázka";
                    }else if(this.questions_left > 1 && this.questions_left < 5){
                        string+="otázky";
                    }else{
                        string+="otázek";
                    }
                    return string;
                }else{
                    return "Hotovo!";
                }

            }
        }
    }
</script>

<style scoped>
    .time{
        transition:width 100ms ease-in-out, height 100ms ease-in-out;
    }
</style>
