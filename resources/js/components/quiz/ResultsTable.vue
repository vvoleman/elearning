<template>
    <div class="m-top-2">
        <div class="d-md-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <label class="switch">
                    <input type="checkbox" v-model="submitToggle">
                    <span class="slider round"></span>
                </label>
                <label style="margin-left:5px">Zobrazit neodevzdané</label>
            </div>
            <div>
                <button class="btn btn-success" v-b-modal="'edit-grades'">Upravit známky</button>
                <b-modal id="edit-grades" title="Upravit známky">
                    <div class="d-md-flex flex-wrap">
                        <div class="form-group col-md-6">
                            <label class="label">1</label>
                            <input type="number" min="1" max="100" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="label">2</label>
                            <input type="number" min="1" max="100" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="label">3</label>
                            <input type="number" min="1" max="100" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="label">4</label>
                            <input type="number" min="1" max="100" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="label">5</label>
                            <input type="number" min="1" max="100" class="form-control">
                        </div>
                    </div>
                </b-modal>
            </div>
        </div>
        <table class="table table-striped m-top">
            <thead class="thead-dark">
                <th>#</th>
                <th>Příjmení</th>
                <th>Jméno</th>
                <th>Čas</th>
                <th>Úspěšnost</th>
            </thead>
            <tbody>
                <tr v-for="(o,i) in filtered" :class="{not_submit:o.time==null}">
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
    background:#ff7979 !important;
}
.form-group input[type=number]{
    border:1px solid #333;
}
</style>
