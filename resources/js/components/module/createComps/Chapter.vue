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
          </modal> <!-- edit row !-->
          <div class="container-fluid" style="padding:5px">
               <div class="d-md-flex justify-content-between align-items-center">
                    <h4 >Řádky</h4>
                    <div>
                         <b-dropdown right id="ddown-buttons" text="Přidat řádek" class="m-2">
                              <b-dropdown-item @click="addRow(rt.value)" v-for="(rt,c) in row_types" :key="rt.value">{{rt.text}}</b-dropdown-item>
                         </b-dropdown>
                    </div> <!-- addRow dropdown !-->
               </div>
               <hr>
               <div v-for="(p,j) in rows" class="container-fluid m-top" style="background:#ccc;padding:5px">
                    <div class="d-md-flex justify-content-between align-items-center">
                         <span>Typ: <b>{{p.type}}</b></span>
                         <div>
                              <b-btn variant="danger" @click="removeRow(j)">-</b-btn>
                              <b-dropdown text="Přidat komponentu">
                                   <b-dropdown-item @click="addComponent(j,item.type)" v-for="(item,key) in components" :key="key">{{item.value}}</b-dropdown-item>
                              </b-dropdown>
                              <b-btn @click="showEditRow(j)">Upravit</b-btn>
                              <b-btn v-b-toggle="'row-'+i+'-'+j">Skrýt/Zobrazit</b-btn>
                         </div>
                    </div>
                    <b-collapse :id="'row-'+i+'-'+j">
                         <div class="d-md-flex flex-wrap col-12">
                              <div v-for="(q,k) in p.components" :key="k+new Date().getTime()" class="col-md-4">
                                   <component-translator class="col-md-12 component" @update="(data) => { updateComponent(data,j,k); }" @remove="removeComponent(j,k)" :type="q.type+'create'" :context="q.context"></component-translator>
                              </div>
                         </div>
                    </b-collapse>
               </div>
          </div>
     </div>
</template>

<script>
    import ComponentTranslator from "../ComponentTranslator";
    export default {
        name: "Chapter",
        components: {ComponentTranslator},
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
                ],
                components:[
                    {
                        type:"paragraph",
                        value:"Odstavec"
                    },
                    {
                        type:"img",
                        value:"Obrázek"
                    },
                    {
                        type:"list",
                        value:"Seznam"
                    },
                ]
            }
        },
        methods:{
            updateComponent(data,row,comp){
               this.rows[row].components[comp].context = data;
            },
            removeComponent(row,comp){
                var temp = this.rows[row].components.slice(0,comp).concat(this.rows[row].components.slice(comp+1));
                this.rows[row].components = temp;
            },
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
                console.log(row);
                this.modal.row = row;
                this.modal.selected = this.rows[row].type;
            },
            editRow(){
                this.rows[this.modal.row].type = this.modal.selected;
                this.modal.selected = this.modal.row = null;
            },
            addComponent(row,comp){
                var temp = {
                    type:comp,
                    context:{
                    }
                };
                this.rows[row].components.push(temp);
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