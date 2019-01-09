 <template>
        <div style="padding-left: 0px;padding-right: 0px" class="col-12 selusers" v-on:keyup="keyUp">
            <div v-click-outside="closeSearch" style="z-index:11">
                <div class="d-flex  justify-content-between" >
                    <input @click="looking = true" type="text" v-model="name" class="form-control">
                </div>
                <div v-if="looking" class="results d-block col-12 position-absolute" style="padding-left:0;padding-right:0">
                    <div class="d-flex align-items-center box" v-for="(o,i) in name_list" :class="{selected:i==selected}" v-on:click="selectUser">{{o.msg}}</div>
                </div>
            </div>
        </div>
 </template>

 <script>
     import StudentShow from "./StudentShow";
     export default {
         name: "Searcher",
         components: {
             StudentShow
         },
         props: ['value','existing','cust','datalink','parse'],
         data: function() {
             return {
                 name: "",
                 name_list: "",
                 selected: 0,
                 looking: false,
                 sel_users: this.value,
                 exist: []

             }
         },
         mounted: function() {
             if (!this.isEmpty(this.existing)) {
                 this.exist = JSON.parse(this.existing).students;
             }
         },
         methods: {
             isEmpty(val) {
                 return val == null || val.length == 0;
             },
             askForData(){
                this.$emit('datalink',this.name);
             },
             dropUser: function(i) {
                 this.sel_users.splice(i, 1);
                 console.log(i);
             },
             selectUser: function() {
                 if (this.name_list == null || this.name_list.length == 0) {
                     return;
                 }
                 if (!Array.isArray(this.sel_users)) {
                     console.log(this.sel_users);
                     this.sel_users = [];
                 }
                 this.sel_users.push(this.name_list[this.selected].obj);
                 console.log(this.sel_users);
                 this.selected = 0;
                 this.name = "";
                 this.closeSearch();
                 if (this.cust) {
                     this.$emit("users_sel", this.sel_users);
                 }
             },
             startProcess: function() {
                 if (this.name.length >= 4) {
                     var temp = this;
                     this.looking = true;
                     this.askForData();
                 } else if (this.name_list.length > 0) {
                     this.name_list = "";
                 }
             },
             continueProcess: function(data){
                 var test = [];
                 if ((this.sel_users == null || this.sel_users.length == 0) && this.exist.length == 0) {
                     test = data;
                     console.log("tu");
                 } else {
                     for (var i = 0; i < data.length; i++) {
                         var boo = true;
                         for (var j = 0; j < this.sel_users.length; j++) {
                             if (data[i].id == this.sel_users[j].id || (this.exist.length > 0 && data[i].id == this.exist[j].id)) {
                                 boo = false;
                             }
                         }
                         if (this.exist.length > 0) {
                             for (var j = 0; j < this.exist.length; j++) {
                                 if (data[i].id == this.exist[j].id) {
                                     boo = false;
                                 }
                             }
                         }
                         if (boo) {
                             test.push(data[i]);
                         }
                     }
                 }
                 this.$emit('parse',test);
             },
             keyUp: function(e) {
                 if (this.looking && (e.keyCode == 38 || e.keyCode == 40)) {
                     var temp = 1;
                     if (e.keyCode == 38) {
                         temp = -1;
                     }
                     this.selected = (this.selected + temp + this.name_list.length) % this.name_list.length;
                     console.log(this.selected);
                 } else if (e.keyCode == 13) {
                     this.selectUser();
                 }
             },
             closeSearch: function() {
                 if (this.looking) {
                     this.looking = false;
                 }
             },
             prepareInput: function(data) {
                 var temp = data.split(",");
                 for (var i = 0; i < temp.length; i++) {
                     if (isNaN(temp[i]) || Number(temp[i]) < 0 || (Number(temp[i]) % 1 != 0)) {
                         temp = false;
                         break;
                     }
                 }
                 return temp;
             }

         },
         watch: {
             name: _.debounce(function() {
                 this.startProcess();
             }, 300),
             sel_users: function() {
                 this.$emit('input', this.sel_users);
             },
             value: function(data) {
                 this.sel_users = data;
             },
             datalink(){
                 this.continueProcess(this.datalink);
             },
             parse(data){
                 this.name_list = data;
             }
         }
     }
 </script>

 <style scoped>

    </style>