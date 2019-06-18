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
                <button class="btn btn-success" @click="clickEdit">Upravit hranice známek</button>
                <b-modal v-model="modalShow" ref="edit-grades" title="Upravit hranice známky" @ok="changeGrades" @hide="checkHide" @cancel="close" @close="close">
                    <div class="d-md-flex flex-wrap">
                        <div class="form-group col-md-6">
                            <label class="label">2</label>
                            <input type="number" min="1" max="100" class="form-control" v-model="modal[0]">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="label">3</label>
                            <input type="number" min="1" max="100" class="form-control" v-model="modal[1]">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="label">4</label>
                            <input type="number" min="1" max="100" class="form-control" v-model="modal[2]">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="label">5</label>
                            <input type="number" min="1" max="100" class="form-control" v-model="modal[3]">
                        </div>
                    </div>
                    <hr v-if="!rangeOk || !gradesOk">
                    <div v-if="!rangeOk" class="alert-danger col-12">
                        Pozor! Hranice mohou být pouze v rozsahu 0-100 (ne včetně)
                    </div>
                    <div v-if="!gradesOk" class="alert-danger col-12">
                        Pozor! Špatné pořadí hranic známek!
                    </div>
                    <div slot="modal-cancel">Zrušit</div>
                    <div slot="modal-ok">Použít</div>
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
                <th>Známka</th>
            </thead>
            <tbody>
                <tr v-for="(o,i) in filtered" :class="{not_submit:o.time==null}">
                    <td>{{i+1}}</td>
                    <td>{{o.surname}}</td>
                    <td>{{o.firstname}}</td>
                    <td>{{(o.percentage != null) ? formateDate(o.time) : "-"}}</td>
                    <td>{{o.percentage}}{{(o.percentage != null) ? "%" : "-"}}</td>
                    <td>{{findGrade(o.percentage)}}</td>
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
                orderBy:"surname",
                grades:[87,73,58,43],
                modal:[],
                modalShow:false,
                gradesOk:true,
                rangeOk:true
            }
        },
        methods:{
            formateDate(seconds){
                return ((Math.floor(seconds/60) < 10) ? "0" : "")+Math.floor(seconds/60)+":"+((Math.floor(seconds%60) < 10) ? "0" : "")+Math.floor(seconds%60);
            },
            compare(a,b){
                if ( a[this.orderBy] < b[this.orderBy] ){
                    return -1;
                }
                if ( a[this.orderBy]> b[this.orderBy] ){
                    return 1;
                }
                return 0;
            },
            findGrade(perc){
                for (var i = 0; i<5;i++){
                    if(perc > this.grades[i]){
                        return i+1;
                    }
                }
                return 5;
            },
            clickEdit(){
                this.modal = this.grades.slice();
                this.modalShow = true;
            },
            changeGrades(){
                this.grades = this.modal.slice();
            },
            close(){
                console.log("ahoj");
                this.modalShow = false;
            },
            checkHide(evt){
                if(evt.trigger == "backdrop"){
                    evt.preventDefault();
                }
            }
        },
        watch:{
            modal(){
                var corr = true;
                var limit = true;
                for(var i = 0;i<this.modal.length;i++){
                    if(this.modal[i]>=100 || this.modal[i]<=0){
                        limit = false;
                        break;
                    }
                    if(this.modal[i+1] != null && this.modal[i] <= this.modal[i+1]){
                        corr = false;
                        break;
                    }
                }
                this.gradesOk = corr;
                this.rangeOk = limit;
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
