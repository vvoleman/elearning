<template>
    <div class="m-top col-md-8 mx-auto">
        <div class="form-group" v-bind:class="{}">
            <label data-toggle="tooltip" data-placement="right" class="label" v-bind:class="{meh: email_valid==0,correct:email_valid==1,bad:email_valid==2}" >Nový email</label>
            <input type="email" class="form-control" v-bind:name="em_name" v-model="email">
        </div>
        <div class="form-group">
            <label class="label">Heslo pro potvrzení</label>
            <input type="password" class="form-control" name="password" v-model="password">
        </div>
        <button :disabled="!formReady" class="btn btn-gray btn-block">Změnit</button>
    </div>
</template>

<script>
    export default {
        props:["em_name","em_addr"],
        data: function(){
            return{
                email:this.em_addr,
                email_old:this.em_addr,
                email_valid:-1,
                password:""
            }
        },
        watch:{
            email: _.debounce(function(){
                this.startingProcess(this.email)
            },400),
            email_valid:function(){
                console.log(this.email_valid);
            }
        },
        methods:{
            startingProcess: function(email){
                if(!this.checkIfValid(email)){
                    this.email_valid = 2;
                    return;
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var temp = this;
                $.post("/ajax/checkEmailExists",{"email":email},function(data){
                    if(data.unique){
                        temp.email_valid = 1;
                    }else{
                        if(data.email == temp.email_old){
                            temp.email_valid = 0;
                        }else{
                            temp.email_valid = 2;
                        }
                    }
                });
            },
            checkIfValid(email){
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }
        },
        computed:{
            formReady: function(){
                return ((this.password.length > 0) && (this.email_valid == 1));
            }
        }

    }
</script>
