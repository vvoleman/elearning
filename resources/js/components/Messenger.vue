<template>
    <div class="messenger_megadiv">
        <div class="col-md-12 messenger d-md-flex">
            <div class="col-md-4 col-lg-3 shortcut_part">
                <div class="m-top boxbox">
                    <div v-if="messages.length != 0 && messagesVis" @click="currMsg = i" v-for="(o,i) in messages" :class="{active:i==currMsg && currMsg.length != 0,new:!o.seen}" class="shortcut">
                        <div class="d-flex align-items-center">
                            <div><div class="circle">{{getNameShortcut(i)}}</div></div>
                            <div class="info">
                                <h5 style="margin:2px;">{{o.author.firstname}} {{o.author.surname}}</h5>
                                <span class="attr title">{{o.title}} </span>
                                <span class="attr text"><span>{{o.message.substr(0,27)}}{{(o.message.length >27)? "..." : ""}}</span></span>
                                <span class="attr" style="font-size:14px">({{getDate(o.sent)}})</span>
                            </div>

                        </div>
                    </div>
                    <div v-if="messages.length == 0" class="d-flex align-items-center justify-content-center">
                        Žádná zpráva nebyla nalezena
                    </div>
                    <div v-if="messages.length > 0 && !messagesVis" class="d-flex justify-content-center">
                        <i class="fas fa-sync-alt fa-spin"></i>
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
                        <button class="btn btn-gray" @click="newMsg(cm.author.id)">Odpovědět</button>
                        <button class="btn btn-gray" @click="currMsg=''">Zavřít</button>
                    </div>
                </div>
            </div><!-- Msg_show !-->
        </div><!-- Messenger !-->
        <div class="col-md-4 col-lg-3 d-flex" style="border-right:1px solid #929292;padding-right: 0px;padding-left: 0;">
            <button @click="newMsg()" class="d-flex col-9 justify-content-center align-items-center btn"><i class="fas fa-plus-circle"></i>Nová zpráva</button>
            <button @click="getMsgs()" title="Zprávy lze načíst jen jednou za 15 vteřin" :disabled="!ready" class="btn no_p col-3"><i class="fas fa-sync-alt"></i></button>
        </div><!-- Nová zpráva !-->
        <modal v-if="newMsgShow.show" @closeModal="newMsgShow.show = !newMsgShow.show" @send="checkMail">
            <h3 slot="header">Nová zpráva</h3>
            <div slot="body">
                <div class="form-group">
                    <label class="label" title="" :class="{bad:newMsgShow.errors.user.length>0,correct:newMsgShow.errors.user==-1}" :title="newMsgShow.errors.user">Adresát</label>
                    <emailsel v-bind:replyto="reply" @sel_users="setResponses"></emailsel>
                </div>
                <div class="form-group">
                    <label class="label" :class="{bad:newMsgShow.errors.title.length>0,correct:newMsgShow.errors.title==-1}" :title="newMsgShow.errors.title">Předmět</label>
                    <input type="text" name="title" class="form-control" v-model="newMsgShow.inputs.title">
                </div>
                <div class="form-group">
                    <label class="label" :class="{bad:newMsgShow.errors.message.length>0,correct:newMsgShow.errors.message==-1}" :title="newMsgShow.errors.message">Zpráva</label>
                    <textarea class="form-control" v-model="newMsgShow.inputs.message"></textarea>
                </div>
            </div>
        </modal>
    </div>
</template>
<script>
    export default {
        props:["replyto"],
        data: function () {
            return {
                messages:"",
                messagesVis:true,
                currMsg:"",
                newMsgShow:{
                    errors: {
                        user:"",
                        title:"",
                        message:""
                    },
                    inputs:{
                      title:"",
                      message:""
                    },
                    show:false,
                    respond_emails:""
                },
                ready:true,
                reply:this.replyTo
            };
        },
        mounted: function () {
            this.getMsgs();
            if(this.replyto != null){
                this.newMsg();
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        },
        watch:{
            currMsg:function(){
                if((typeof this.currMsg == "number") && this.messages[this.currMsg].seen == false){
                    this.markAsSeen(this.currMsg,true);
                }
            },
            title:function(){
                var s = this.newMsgShow.inputs.title;
                if(s.length == 0){
                    this.newMsgShow.errors.title = "Předmět musí být vyplněn!";
                }else if(s.length > 32){
                    this.newMsgShow.errors.title = "Předmět může mít max. 32 znaků!";
                }else{
                    this.newMsgShow.errors.title = -1;
                }

            },
            message:function(){
                var s = this.newMsgShow.inputs.message;
                if(s.length == 0) {
                    this.newMsgShow.errors.message = "Zpráva nemůže být prázdná!";
                }else{
                    this.newMsgShow.errors.message = -1;
                }
            },
            receivers:function(){
                if(this.newMsgShow.respond_emails.length > 0){
                    this.newMsgShow.errors.user = -1;
                }else{
                    this.newMsgShow.errors.user = "Vyberte prosím, komu máme zprávu zaslat!";
                }
            }
        },
        methods:{
            checkMail:function(){
                if(this.rwegucci){
                    this.sendMail({
                        title:this.title,
                        receivers:this.receivers,
                        message:this.message
                    });
                }else{
                    alert("Nelze odeslat zprávu!");
                    console.log(this.newMsgShow);
                }
            },
            clearInputs:function(){
                this.newMsgShow.inputs.message = "";
                this.newMsgShow.inputs.title = "";
            },
            sendMail:function(d){
                var temp = this;
                $.post('/ajax/postMessage',{data:d},function(data){
                   if(data.response != null && data.response == 200){
                       temp.clearInputs();
                       alert('Zpráva byla úspěšně odeslána!');
                       temp.newMsgShow.show = false;
                   }
                });
            },
            markAsSeen:function(msg,boo){
                var temp = this;
                $.post('/ajax/markMsgAsSeen',{id:this.messages[msg].my_id,boolean:boo,msg_id:this.messages[msg].msg_id},function(data){
                    if(data.response != null && data.response == 200){
                        temp.messages[msg].seen = true;
                    }
                });
            },
            getDate:function(unix){
                var d = new Date(unix*1000);
                return d.getDate()+". "+d.getMonth()+". "+d.getFullYear()+" "+d.getHours()+":"+d.getMinutes();
            },
            getNameShortcut:function(i){
                return this.messages[i].author.firstname[0]+this.messages[i].author.surname[0];
            },
            newMsg:function(id = null){
                if(id != null && (typeof id == "number") && (id%1==0)){
                    this.reply = ""+id;
                }else if(typeof id == "array"){
                    for(var i = 0;i<id.length-1;i++){
                        this.reply+=id[i]+",";
                    }
                    this.reply += id[id.length-1];
                }
                this.newMsgShow.show = true;
            },
            setResponses:function(value){
                this.newMsgShow.respond_emails = value;
                console.log(value);
            },
            getMsgs:function(){
                this.messagesVis = false;
                if(this.ready){
                    this.ready = false;
                    setTimeout(function(){
                        this.ready = true;
                    }.bind(this),1000);
                    $.get('/ajax/getMessages', function (data) {
                        this.messages = data;
                        this.messagesVis = true;
                        console.log(data);
                    }.bind(this));
                }

            }
        },
        computed:{
            cm: function(){
                return this.messages[this.currMsg];
            },
            title: function() {
                return this.newMsgShow.inputs.title;
            },
            message: function(){
                return this.newMsgShow.inputs.message;
            },
            receivers: function(){
                return this.newMsgShow.respond_emails;
            },
            rwegucci: function(){
                return (this.newMsgShow.errors.message == -1 && this.newMsgShow.errors.title == -1 && this.newMsgShow.respond_emails.length > 0);
            }
        }
    }
</script>

<style scoped>

</style>