<template>
    <div class="m-top-2">
        <div class="d-flex align-items-center">
            <label class="switch">
                <input type="checkbox" v-model="submitToggle">
                <span class="slider round"></span>
            </label>
            <label style="margin-left:5px">Zobrazit neodevzdané</label>
        </div>
        <table class="table table-striped">
            <thead class="thead-dark">
                <th>#</th>
                <th>Příjmení</th>
                <th>Jméno</th>
                <th>Čas</th>
                <th>Úspěšnost</th>
            </thead>
            <tbody>
                <tr v-for="(o,i) in filtered" :class="{not_submit:o.percentage==null}">
                    <td>{{i+1}}</td>
                    <td>{{o.surname}}</td>
                    <td>{{o.firstname}}</td>
                    <td>{{(o.percentage != null) ? formateDate(o.time) : "-"}}</td>
                    <td>{{o.percentage}}{{(o.percentage != null) ? "%" : "-"}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "ResultsTable",
        props:{
            results:{
                type:Array
            }
        },
        data(){
            return{
                submitToggle:true,
                orderBy:"surname"
            }
        },
        methods:{
            formateDate(seconds){
                return Math.floor(seconds/60)+":"+Math.floor(seconds%60);
            },
            compare(a,b){
                if ( a[this.orderBy] < b[this.orderBy] ){
                    return -1;
                }
                if ( a[this.orderBy]> b[this.orderBy] ){
                    return 1;
                }
                return 0;
            }
        },
        computed:{
            filtered(){
                return this.results.filter((r)=>{return (this.submitToggle) ? true : r.percentage != null}).sort(this.compare);
            }
        }
    }
</script>

<style scoped>
    .not_submit{
        background:#ff7979;
    }
</style>
