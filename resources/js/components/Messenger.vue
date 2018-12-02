<template>
    <div>
        <div class="col-md-12 messenger d-md-flex">
            <div class="col-md-4 col-lg-3 shortcut_part">
                <div class="m-top boxbox">
                    <div v-if="messages.length != 0" @click="currMsg = i" v-for="(o,i) in messages" :class="{active:i==currMsg && currMsg.length != 0,new:o.seen}" class="shortcut">
                        <div class="d-flex align-items-center">
                            <div><div class="circle">{{getNameShortcut(i)}}</div></div>
                            <div class="info">
                                <h5>{{o.author.firstname}} {{o.author.surname}}</h5>
                                <span class="attr title">{{o.title}}</span>
                                <span class="attr text"><span>{{o.message.substr(0,27)}}{{(o.message.length >27)? "..." : ""}}</span></span>
                            </div>
                        </div>
                    </div>
                    <div v-if="messages.length == 0" class="d-flex align-items-center justify-content-center">
                        <span>Žádné zprávy nejsou k dispozici</span>
                    </div>
                </div>
            </div><!-- Shortcut_part !-->
            <div class="col-md-8 col-lg-9 msg_show m-top">
                <div v-if="currMsg.length != 0">
                    <div class="header">
                        <div class="box" id="box">
                            <div class="circle circle_down" id="circle">
                                <span>{{getNameShortcut(currMsg)}}</span>
                            </div>
                            <div class="offset-md-2 offset-xl-1 offset-3 col-9 col-xl-11 d-flex justify-content-between align-items-center">
                                <span class="name d-flex align-items-center" v-bind:title="cm.author.email">{{cm.author.firstname}} {{cm.author.surname}}</span> <!-- Name !-->
                                <span>{{getDate(cm.sent)}}</span> <!-- Sent !-->
                            </div>
                        </div> <!-- Header !-->
                        <div class="title">
                            <div class="offset-md-2 offset-xl-1 offset-3 col-9">
                                <span class="name">{{cm.title}}</span>
                            </div>
                        </div> <!-- Title !-->
                        <hr>
                    </div>
                    <div class="msg_panel col-12">
                        <div class="">
                            {{cm.message}}
                        </div>
                    </div><!-- Message !-->
                    <div class="col-12 d-flex justify-content-end btn_grp">
                        <button class="btn btn-gray" @click="newMsg(cm.author.email)">Odpovědět</button>
                        <button class="btn btn-gray" @click="currMsg=''">Zavřít</button>
                    </div>
                </div>
            </div><!-- Msg_show !-->
        </div><!-- Messenger !-->
        <div class="col-md-4 col-lg-3" style="border-right:1px solid #929292">
            <button @click="newMsg()" class="d-flex col-12 justify-content-center align-items-center btn"><i class="fas fa-plus-circle"></i>Nová zpráva</button>
        </div><!-- Nová zpráva !-->
        <modal v-bind:email="newMsgShow.respond_email" v-if="newMsgShow.show" @closeModal="newMsgShow.show = !newMsgShow.show">
            <h3 slot="header">Nová zpráva</h3>
            <div slot="body" class="login_form_div">
                <div class="form-group">
                    <label class="label">Email</label>
                    <emailsel></emailsel>
                </div>
                <div class="form-group">
                    <label class="label">Předmět</label>
                    <input type="text" name="title" class="form-control">
                </div>
                <div class="form-group">
                    <label class="label">Zpráva</label>
                    <textarea class="form-control"></textarea>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>

    export default {
        data: function () {
            return {
                messages:"",
                currMsg:"",
                newMsgShow:{
                    show:false,
                    respond_email:""
                }
            };
        },
        mounted: function () {
            var temp = this;
            $.get('/ajax/getMessages', function (data) {
                temp.messages = data;
                console.log(data);
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        },
        watch:{
            currMsg:function(){
                if(this.currMsg.length > 0 && this.messages[this.currMsg].seen == true){
                    this.markAsSeen(this.currMsg,true);
                }
            }
        },
        methods:{
            markAsSeen: function(msg,boo){
                $.post('/ajax/markMsgAsSeen',{id:this.messages[msg].my_id,boolean:boo,msg_id:this.messages[msg].msg_id},function(data){
                    console.log(data);
                });
            },
            getDate: function(unix){
                var d = new Date(unix*1000);
                return d.getDate()+". "+d.getMonth()+". "+d.getFullYear()+" "+d.getHours()+":"+d.getMinutes();
            },
            getNameShortcut: function(i){
                return this.messages[i].author.firstname[0]+this.messages[i].author.surname[0];
            },
            newMsg:function(email = ""){
                if(email.length == 0){
                    this.newMsgShow.respond_email = ""
                }else{
                    this.newMsgShow.respond_email = email
                }
                this.newMsgShow.show = true;
            }
        },
        computed:{
            cm: function(){
                return this.messages[this.currMsg];
            }
        }
    }
</script>

<style scoped>

</style>