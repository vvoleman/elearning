<template>
     <div style="background:#ddd" class="container-fluid">
          <modal @closeModal="modal.selected = null" @send="editRow" v-if="modal.selected != null">
               <h1 slot="header">Úprava řádku</h1>
               <div slot="body">
                    <div class="form-group">
                         <label class="label">Typ</label>
                         <b-form-select v-model="modal.selected" :options="row_types"></b-form-select>
                    </div>
               </div>
          </modal>
          <modal v-if="false">
               <h1 slot="header">Přidání komponenty</h1>
               <div slot="body">
                    <div class="form-group">
                         <label class="label">Typ</label>
                         <b-form-select v-model="modal.selected" :options="row_types"></b-form-select>
                    </div>
               </div>
          </modal>
          <div>
               <b-dropdown variant="success" id="ddown-buttons" text="Přidat řádek" class="m-2">
                    <b-dropdown-item @click="addRow(rt.value)" v-for="(rt,c) in row_types" :key="rt.value">{{rt.text}}</b-dropdown-item>
               </b-dropdown>
          </div>
          <hr style="background-color:black">
          <div class="container-fluid">
               <h4>Řádky</h4>
               <div v-for="(p,j) in rows" class="container-fluid m-top" style="background:#ccc;padding:5px;">
                    <div class="d-flex justify-content-between align-items-center">
                         <span>Typ: {{p.type}}</span>
                         <div class="">
                              <b-btn variant="danger" @click="removeRow(j)">-</b-btn>
                              <b-btn>Přidat komponentu</b-btn>
                              <b-btn @click="showEditRow(j)">Upravit</b-btn>
                         </div>
                    </div>
                    <div>

                    </div>
               </div>
          </div>
     </div>
</template>

<script>
    export default {
        name: "Chapter",
        props: ['value','in'],
        data(){
            return {
                i: this.in,
                rows:this.value,
                modal:{
                    row:null,
                    selected:null
                },
                newComp:{

                },
                row_types:[
                    {
                        value:"normal",
                        text:"Normální"
                    },
                    {
                        value:"centered",
                        text:"Zarovnat doprostřed"
                    }
                ]
            }
        },
        methods:{
            rewrite(){
                this.i = this.in;
                this.rows = this.value;
            },
            removeRow(index){
               this.rows.splice(index,1);
            },
            addRow(type){
                var temp = {
                    type:type,
                    components:[]
                };

                this.rows.push(temp);
            },
            showEditRow(row){
                this.modal.row = row;
                this.modal.selected = this.rows[row].type;
            },
            editRow(){
                this.rows[this.modal.row].type = this.modal.selected;
                this.modal.selected = this.modal.row = null;
            }
        },
        watch:{
            rows(){
                this.$emit('input',this.rows);
            },
            value(){
              this.rewrite();
            },
            in(){
                this.i = this.in;
            }
        }
    }
</script>

<style scoped>

</style>