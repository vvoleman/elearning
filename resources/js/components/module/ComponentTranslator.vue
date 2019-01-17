<template>
    <div ref="container" class="m-top"></div>
</template>

<script>
    import Paragraph from "./comps/Final/Paragraph";
    import Img from "./comps/Final/Img";
    import List from "./comps/Final/List";
    import ParagraphCreate from "./comps/Creating/Paragraph";
    export default {
        components: {ParagraphCreate, List, Img, Paragraph},
        props:["type","context","value"],
        name: "ComponentTranslator",
        data(){
            return{
                components: {
                    paragraph:Paragraph,
                    img:Img,
                    list:List,
                    paragraphcreate:ParagraphCreate
                }
            }
        },
        mounted(){
            var componentClass;
            if(this.components.hasOwnProperty(this.type)){
                componentClass = Vue.extend(this.components[this.type]);
                var instance = new componentClass({
                    propsData:{
                        context:this.context,
                        value:this.value
                    }
                });
            }
            instance.$on('remove',function(data){
                this.$emit('remove',data);
            });
            instance.$on('input',function(data){
                this.$emit('input',data);
            }.bind(this));
            if(componentClass != null){

                instance.$mount(); // pass nothing
                this.$refs.container.appendChild(instance.$el);
            }
        },
        methods:{
        },
        watch:{
            value(){
                console.log(this.value);
            }
        }

    }
</script>

<style scoped>

</style>