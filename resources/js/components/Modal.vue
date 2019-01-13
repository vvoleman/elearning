<template>
    <div class="modal-mask" >
        <div class="modal-wrapper col-12">
            <div class="modal-container col-xl-4 col-md-6">

                <div class="modal-header">
                    <slot name="header">
                    </slot>
                </div>
                <div class="modal-body">
                    <slot name="body">
                    </slot>
                </div>
                <div class="modal-footer">
                    <slot name="footer">
                        <button type="button" class="btn btn-danger" @click="closeModal">
                            Zavřít
                        </button>
                        <button type="button" class="btn btn-success" @click="sendModal">
                            Odeslat
                        </button>
                    </slot>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data(){
            return {
              sent:false,
            };
        },
        methods:{
            closeModal:function(){
                this.$emit('closeModal', 'true');
            },
            sendModal(){
                this.$emit('send',true);
                this.sent = true;
            }
        },
        mounted:function () {
            window.addEventListener('keyup', e => {
                if(e.keyCode == 27){
                    this.closeModal();
                }
            })
        }
    }
</script>

<style scoped>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #ddd;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
    }
    .modal-header{
        border-bottom:1px solid #bcbcbc;
    }
    .modal-footer{
        border-top:1px solid #bcbcbc;
    }
    .modal-body {
        margin: 20px 0;
    }
    .modal-container hr{
        background:#bcbcbc;
    }

    .modal-default-button {
        float: right;
    }
    @media only screen and (max-width:600px){
        .modal-container{
            height: 95%;
            overflow:auto;
        }
    }

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>