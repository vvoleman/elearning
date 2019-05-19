<template>
    <div ref="container"></div>
</template>

<script>
    import Radio from "./radio";
    import Checkbox from "./checkbox";
    export default {
        name: "TypeTranslator",
        components: {Radio,Checkbox},
        props:["question","index","value"],
        data(){
            return {
                components:{
                    radio:Radio,
                    checkbox:Checkbox
                },
                instance:null
            }
        },
        mounted(){
            var componentClass;
            var temp = {
                question:this.question,
                    index:this.index,
                    value:this.value
            };
            console.log(temp);
            if(this.components.hasOwnProperty(this.question.type)){
                componentClass = Vue.extend(this.components[this.question.type]);
                var instance = new componentClass({
                    propsData:{
                        question:this.question,
                        index:this.index,
                        value:this.value
                    }
                });
                instance.$on('input',function(data){
                    this.$emit('input',data);
                }.bind(this));
                if(componentClass != null){
                    instance.$mount(); // pass nothing
                    this.$refs.container.appendChild(instance.$el);
                }
                this.instance = instance;
            }
        }
    }
</script>

<style scoped>

</style>
