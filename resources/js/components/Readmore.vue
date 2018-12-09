<template>
    <div>

    </div>
</template>

<script>
    export default {
        name: "readmore",
        data: function(){
          return {
              temp_text:"",
              full_text:"",
          }
        },
        mounted:function(){
            var temp = this.$slots.default[0].text;
            if(temp != ""){
                this.full_text = temp;
            }
        }
    }
</script>

<style scoped>

</style>