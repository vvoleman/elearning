<template>
    <div ref="container"></div>
</template>

<script>
    import Radio from "./radio";
    export default {
        name: "TypeTranslator",
        components: {Radio},
        props:["value"],
        data(){
            return {
                components:{
                    radio:Radio
                }
            }
        },
        mounted(){
            var componentClass;
            console.log(this.value);
            if(this.components.hasOwnProperty(this.value.type)){
                componentClass = Vue.extend(this.components[this.value.type]);
                var instance = new componentClass({
                    propsData:{
                        context:{
                            context:{
                                question:this.value.type,
                            }
                        },
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
            }
        }

    }
</script>

<style scoped>

</style>
