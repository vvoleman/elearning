<template>
    <div>
        <div class="col-12 d-flex justify-content-end">
            <b-btn variant="danger" @click="remove">-</b-btn>
            <b-btn>Upravit</b-btn>
        </div>

        <p></p>
    </div>
</template>

<script>
    export default {
        name: "ParagraphCreate",
        prop:["value"],
        data(){
            return {
                modal:{
                    show:false,
                    text:""
                },
                text:""
            }
        },
        mounted(){
          console.log("ParagraphCreate mounted - "+new Date().toLocaleTimeString());
        },
        methods:{
            remove(){
                console.log("ted");
              this.$emit('remove',true);
            },
            edit(){
                if(this.modal.text.length>0){
                    this.text = this.modal.text;
                    this.clear();
                }
            },
            clear(){
                this.modal.show = "";
                this.modal.show = false;
            }
        }
    }
</script>

<style scoped>

</style>