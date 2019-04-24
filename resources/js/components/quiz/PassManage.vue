<template>
    <div class="m-top-2 col-md-10 mx-auto">
        <h3>Správa přístupu</h3>
        <hr>
        <div class="d-md-flex justify-content-between">
            <span><b>Test:</b> {{quiz.name}}</span>
            <span class="d-flex align-items-center pointer" @click="create_sel = true">
                <i class="fas fa-plus"></i>
                Přidat
            </span>
        </div>
        <div class="col-md-12 mx-auto m-top-2">
            <table class="table table-striped">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Třída</th>
                    <th scope="col">Datum otevření</th>
                    <th scope="col">Datum uzavření</th>
                    <th>Zbývající čas</th>
                    <th>Další</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="(o,i) in passes">
                        <td>{{o.group.name}}</td>
                        <td>{{formateDate(o.opened_at * 1000)}}</td>
                        <td>{{formateDate(o.closing_at * 1000)}}</td>
                        <td>{{timeleft_com(o.closing_at)}}</td>
                        <td>
                            <b-dropdown variant="link" size="lg" no-caret>
                                <template slot="button-content"><i class="fas fa-ellipsis-v" style="font-size:18px"></i></template>
                                <b-dropdown-item href="#" @click="createOpen">Prodloužit</b-dropdown-item>
                                <b-dropdown-item>Smazat</b-dropdown-item>
                            </b-dropdown>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <modal v-if="create_sel" @closeModal="create_sel = null">
            <h3 slot="header">Vytvořit</h3>
            <div slot="body">
                <div class="form-group">
                    <label class="label">Třída</label>
                    <import-sel v-model="selected_groups" :quiz="quiz.uuid"></import-sel>
                </div>
                <div class="form-group">
                    <label class="label">Datum otevření</label>
                    <input type="date" v-model="create_time.start">
                </div>
                <div class="form-group">
                    <label class="label">Datum uzavření</label>
                    <input type="date" v-model="create_time.start">
                </div>
                <h5>Celková doba otevření: </h5>
            </div>
        </modal>
    </div>
</template>

<script>
    import ImportSel from "../group/importsel";
    export default {
        name: "PassManage",
        components: {ImportSel},
        props:["datas","q"],
        data(){
            return {
                passes:[],
                quiz:[],
                selected_groups:[],
                create_sel:false,
                create_time:{
                    start:null,
                    end:null,
                }
            }
        },
        mounted(){
            this.passes = JSON.parse(this.datas);
            this.quiz = JSON.parse(this.q);
        },
        methods:{
            timeLeft(seconds,only_days = false){
                var to_return = "";
                if(seconds%86400 > 0){
                    var temp = Math.floor(seconds/86400);
                    var string;
                    if(temp == 1){
                        string = "den";
                    }else if(temp >= 2 && temp<5){
                        string = "dny";
                    }else{
                        string = "dní";
                    }
                    to_return +=temp+" "+string;
                    seconds %= 86400;
                }
                if(only_days){
                    return to_return;
                }
                if(seconds%3600 > 0){
                    var temp = Math.floor(seconds/3600);
                    var string;
                    if(temp == 1){
                        string = "hodina";
                    }else if(temp >= 2 && temp<5){
                        string = "hodiny";
                    }else{
                        string = "hodin";
                    }
                    to_return +=" "+temp+" "+string;
                    seconds %= 3600;
                }
                if(seconds%60 > 0){
                    var temp = Math.floor(seconds/60);
                    var string;
                    if(temp == 1){
                        string = "minuta";
                    }else if(temp >= 2 && temp<5){
                        string = "minuty";
                    }else{
                        string = "minut";
                    }
                    to_return +=" "+temp+" "+string;
                    seconds %= 60;
                }
                if(seconds > 0){
                    var temp = seconds;
                    var string;
                    if(temp == 1){
                        string = "vteřina";
                    }else if(temp >= 2 && temp<5){
                        string = "vteřiny";
                    }else{
                        string = "vteřin";
                    }
                    to_return +=" "+temp+" "+string;
                }
                return to_return;

            },
            formateDate(timestamp){
                var date = new Date(timestamp);
                return date.toLocaleDateString()+" "+this.checkForZero(date.getHours())+":"+this.checkForZero(date.getMinutes());
            },
            checkForZero(number){
                return ((number < 10) ? '0' : '')+number;
            },
            createOpen(){
                $.post('/ajax/openQuizForGroup',{group:1,quiz:this.quiz.uuid,closing_at:1556661599,opened_at:1555840571},(data)=>{
                    console.log(data);
                });
            }
        },
        computed:{
            timeleft_com(closing_at){
                return this.timeLeft(closing_at-(Math.floor(new Date().getTime()/1000)));
            }
        }
    }
</script>

<style scoped>
    .bar-header{
        border-radius: 5px;
        background: #1b1e21;
        color:white;
    }
</style>
