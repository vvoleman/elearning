<template>
    <div class="m-top-2 col-md-10 mx-auto">
        <vue-snotify></vue-snotify>
        <h3>Správa přístupu</h3>
        <hr>
        <div class="d-md-flex justify-content-between">
            <span><b>Test:</b> {{quiz.name}}</span>
            <span class="d-flex align-items-center pointer" @click="addClick">
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
                        <td>{{timeLeft(Math.floor((o.closing_at-o.opened_at)),true)}}</td>
                        <td>
                            <b-dropdown variant="link" size="lg" no-caret>
                                <template slot="button-content"><i class="fas fa-ellipsis-v" style="font-size:18px"></i></template>
                                <b-dropdown-item @click="extendClick(i)">Upravit čas</b-dropdown-item>
                                <b-dropdown-item @click="remove(i)">Smazat</b-dropdown-item>
                            </b-dropdown>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <modal v-if="create_sel" @closeModal="addClose" @send="createOpen">
            <h3 slot="header">Vytvořit</h3>
            <div slot="body">
                <div class="form-group">
                    <label class="label">Třída</label>
                    <import-sel limit="1" v-model="selected_groups" :quiz="quiz.uuid"></import-sel>
                </div>
                <div class="form-group">
                    <label class="label">Datum otevření</label>
                    <datetime type="datetime" v-model="create_time.start"></datetime>
                </div>
                <div class="form-group">
                    <label class="label">Datum uzavření</label>
                    <datetime type="datetime" v-model="create_time.end"></datetime>
                </div>
                <h5>Celková doba otevření:</h5>
                <span>{{timespan}}</span>
            </div>
        </modal>
        <modal v-if="extend_sel != null" @closeModal="extendClose" @send="sendExtend">
            <h3 slot="header">Upravit čas</h3>
            <div slot="body">
                <div class="">
                    <div class="form-group">
                        <label class="label">Datum otevření</label>
                        <datetime type="datetime" v-model="extend_time.start"></datetime>
                    </div>
                    <div class="form-group">
                        <label class="label">Datum uzavření</label>
                        <datetime type="datetime" v-model="extend_time.end"></datetime>
                    </div>
                    <h5>Celková doba otevření:</h5>
                    <span>{{timespan_ext}}</span>
                </div>
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
                extend_sel:null,
                extend_time:{
                    start:null,
                    end:null
                },
                create_time:{
                    start:null,
                    end:null
                },
                date:null,
                alert:{
                    show:false,
                    text:"",

                }
            }
        },
        mounted(){
            this.passes = JSON.parse(this.datas);
            this.quiz = JSON.parse(this.q);
        },
        methods:{
            addClick(){
                this.create_sel = true;
                this.create_time.start = this.getTimestamp(new Date().getTime());
            },
            extendClick(i){
                this.extend_sel = i;
                this.extend_time.start = this.getTimestamp(this.passes[i].opened_at*1000);
                this.extend_time.end = this.getTimestamp(this.passes[i].closing_at*1000);
            },
            addClose(){
                this.create_sel = false;
                this.selected_groups = [];
                this.create_time.start = null;
                this.create_time.end = null;
            },
            extendClose(){
                this.extend_sel = null;
                this.extend_time.start = null;
                this.extend_time.end = null;
            },
            sendExtend(){
                if(this.extend_sel != null && this.extend_time.start != null && this.extend_time.end != null && this.timespan_ext != ""){
                    $.post('/ajax/updateOpenTime',{id:this.passes[this.extend_sel].id,opened_at:Math.floor(new Date(this.extend_time.start).getTime()/1000),closing_at:Math.floor(new Date(this.extend_time.end).getTime()/1000)},(data)=>{
                        if(data.response == 200){
                            this.loadData();
                            this.extendClose();
                            this.$snotify.success('Položka byla úspěšně upravena!', 'Úspěch', {
                                timeout: 2000,
                                showProgressBar: true,
                                closeOnClick: true,
                                pauseOnHover: false
                            });
                        }
                    });
                }
            },
            createOpen(){
                if(this.selected_groups.length > 0 && this.create_time.start != null && this.create_time.end != null){
                    $.post('/ajax/openQuizForGroup',{group:this.selected_groups[0].id,quiz:this.quiz.uuid,closing_at:this.end.getTime()/1000,opened_at:this.start.getTime()/1000},(data)=>{
                        if(data.response == 200){
                            this.loadData();
                            this.addClose();
                            this.$snotify.success('Položka byla úspěšně přidána!', 'Úspěch', {
                                timeout: 2000,
                                showProgressBar: true,
                                closeOnClick: true,
                                pauseOnHover: false
                            });
                        }
                    });
                }else{
                    alert("tu");
                }
            },
            remove(i){
                if(this.passes[i] != null){
                    $.post('/ajax/removeQuizOpen',{id:this.passes[i].id},(data)=>{
                        if(data.response == 200){
                            this.loadData();
                            this.$snotify.success('Položka byla úspěšně smazána!', 'Úspěch', {
                                timeout: 2000,
                                showProgressBar: true,
                                closeOnClick: true,
                                pauseOnHover: false
                            });
                        }else{
                            this.$snotify.danger('Při mazání položky se vyskytla chyba!', 'Chyba', {
                                timeout: 2000,
                                showProgressBar: true,
                                closeOnClick: true,
                                pauseOnHover: false
                            });
                        }
                    });
                }
            },
            loadData(){
                $.get('/ajax/getQuizOpenings',{quiz:this.quiz.uuid},(data)=>{
                    if(data.data != null){
                        this.passes = data.data;
                    }else{
                        this.$snotify.danger('Při načítání se vyskytla chyba!', 'Chyba', {
                            timeout: 2000,
                            showProgressBar: true,
                            closeOnClick: true,
                            pauseOnHover: true
                        });
                    }
                });
            },
            timeLeft(seconds,only_days = false){
                var to_return = "";
                if(seconds/86400 >= 0){
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
                if(seconds/3600 >= 0){
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
                if(only_days){
                    return to_return;
                }
                if(seconds/60 >= 0){
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
                    var temp = Math.floor(seconds);
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
            getTimestamp(unix){
                return new Date(unix).toISOString().slice(0,16)+":00.000Z"
            }
        },
        computed:{
            timespan(){
                if(this.create_time.start != null && this.create_time.end != null){
                    return this.timeLeft((this.end.getTime()-this.start.getTime())/1000);
                }
            },
            timespan_ext(){
                if(this.extend_time.start != null && this.extend_time.end != null){
                    return this.timeLeft((new Date(this.extend_time.end).getTime()-new Date(this.extend_time.start).getTime())/1000);
                }
            },
            start(){
                return new Date(this.create_time.start);
            },
            end(){
                return new Date(this.create_time.end);
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
