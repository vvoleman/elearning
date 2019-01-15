<template>
    <div ref="container" class="m-top"></div>
</template>

<script>
    import Paragraph from "./comps/Paragraph";
    import Img from "./comps/Img";
    import List from "./comps/List";
    export default {
        components: {List, Img, Paragraph},
        props:["type","context"],
        name: "ComponentTranslator",
        mounted(){
            var componentClass;
            switch (this.type) {
                case "paragraph":
                    componentClass = Vue.extend(Paragraph);
                    break;
                case "img":
                    componentClass = Vue.extend(Img);
                    break;
                case "list":
                    componentClass = Vue.extend(List);
                    break;
            }
            if(componentClass != null){
                var instance = new componentClass({
                    propsData:{
                        context:this.context
                    }
                });
                instance.$mount(); // pass nothing
                this.$refs.container.appendChild(instance.$el);
            }
        }

    }
</script>

<style scoped>

</style>