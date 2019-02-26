<template>
    <div ref="container"></div>
</template>

<script>
    import Radio from "./radio";
    export default {
        name: "TypeTranslator",
        components: {Radio},
        props:["question","order"],
        data(){
            return {
                components:{
                    radio:Radio
                }
            }
        },
        mounted(){
            var componentClass;
            console.log(this.question)
            if(this.components.hasOwnProperty(this.question.type)){
                componentClass = Vue.extend(this.components[this.question.type]);
                var instance = new componentClass({
                    propsData:{
                        context:{
                            context:{
                                question:this.question,
                                order:this.order
                            }
                        },
                    }
                });
                if(componentClass != null){
                    instance.$mount(); // pass nothing
                    this.$refs.container.appendChild(instance.$el);
                }
                console.log(this.question);
            }
        }

    }
</script>

<style scoped>

</style>
