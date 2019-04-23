<template>
    <div class="m-top-2 col-md-10 mx-auto">
        <h3>Správa přístupu</h3>
        <hr>
        <div class="d-md-flex justify-content-between">
            <span><b>Test:</b> {{quiz.name}}</span>
            <span class="d-flex align-items-center">
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
                    <th>Zbývá dní</th>
                    <th>Další</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="(o,i) in passes">
                        <td>{{o.group.name}}</td>
                        <td>{{formateDate(o.opened_at * 1000)}}</td>
                        <td>{{formateDate(o.closing_at * 1000)}}</td>
                        <td>{{Math.floor(((o.closing_at*1000)-new Date().getTime())/86400000)}}</td>
                        <td><button class="btn btn-sm btn-primary" @click="createOpen">Prodloužit</button><button class="btn btn-sm btn-danger">Smazat</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <modal>
            <h3 slot="header">Vytvořit</h3>
            <div slot="body">
                <div class="form-group">
                    <label class="label">Třída</label>
                    <import-sel v-model="selected_groups" :quiz="quiz.uuid"></import-sel>
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
                selected_groups:[]
            }
        },
        mounted(){
            this.passes = JSON.parse(this.datas);
            this.quiz = JSON.parse(this.q);
        },
        methods:{
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
