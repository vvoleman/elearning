<template>
    <div ref="container" class="m-top"></div>
</template>

<script>
    import Paragraph from "./comps/Final/Paragraph";
    import Img from "./comps/Final/Img";
    import List from "./comps/Final/List";
    import ParagraphCreate from "./comps/Creating/Paragraph";
    import ImgCreate from "./comps/Creating/Img";
    import ListCreate from "./comps/Creating/List";
    export default {
        components: {ListCreate, ParagraphCreate, ImgCreate, List, Img, Paragraph},
        props:["type","context","value"],
        name: "ComponentTranslator",
        data(){
            return{
                components: {
                    paragraph:Paragraph,
                    img:Img,
                    list:List,
                    paragraphcreate:ParagraphCreate,
                    imgcreate:ImgCreate,
                    listcreate:ListCreate
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
                    }
                });
                instance.$on('remove',function(data){
                    this.$emit('remove',data);
                }.bind(this));
                instance.$on('update',function(data){
                    this.$emit('update',data);
                }.bind(this));
            }
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