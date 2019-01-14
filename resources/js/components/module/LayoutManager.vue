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
        mounted(){
            var componentClass;
            switch (this.type) {
                case "normal":
                    componentClass = Vue.extend(Normal);
                    break;
                case "center":
                    componentClass = Vue.extend(Centered);
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