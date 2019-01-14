<template>
    <div ref="container">

    </div>
</template>

<script>
    import TwoCols from "./layouts/TwoCols";
    export default {
        components: {TwoCols},
        props:["type","components"],
        name: "LayoutManager",
        mounted(){
            var componentClass;
            switch (this.type) {
                case "twocols":
                    componentClass = Vue.extend(TwoCols);
                    break;
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