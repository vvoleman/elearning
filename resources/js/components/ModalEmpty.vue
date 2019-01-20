<template>
    <div class="modal-mask" >
        <div class="modal-wrapper col-12">
            <div class="modal-container col-md-10 col-lg-8">
                <div class="modal-header">
                    <slot name="header"><h1>Okno</h1></slot>
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
                    </slot>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "ModalEmpty",
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
        top:0;
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
        height:auto;
        overflow:auto;
        margin: 0px auto;
        padding: 20px 30px;
        color:black;
        border-radius: 2px;
        background-color: #ddd;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
    }
    .modal-header{
        border-bottom:1px solid #bcbcbc;
        height:10%;
    }
    .modal-footer{
        border-top:1px solid #bcbcbc;
        height:10%;
    }
    .modal-body {
        position:relative;
        display:block;
        overflow:auto;
        max-height:500px;
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