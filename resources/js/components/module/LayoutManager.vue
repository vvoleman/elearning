<template>
    <div ref="container">

    </div>
</template>

<script>
    import Normal from "./layouts/Normal";
    import Centered from "./layouts/Centered";
    export default {
        components: {Centered, Normal},
        props:["type","components"],
        name: "LayoutManager",
        data(){
            return {
                layouts:{
                    normal: Normal,
                    centered: Centered
                }
            }

        },
        mounted(){
            var componentClass;
            console.log("běžím "+this.type);
            if(this.layouts.hasOwnProperty(this.type)){
                componentClass = Vue.extend(this.layouts[this.type]);
            }
            if(componentClass != null){
                var instance = new componentClass({
                    propsData:{
                        components:this.components
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