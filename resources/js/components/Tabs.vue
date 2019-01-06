<template>
    <div class="tabs_div">
        <div class="col-md-12 mx-auto" style="margin:0">
            <ul class="nav nav-pills nav-justified">
                <li v-for="(e,i) in elements" v-on:click="swapEl(i,this)" class="nav-item nav-link" v-bind:class="{active: selEl == i}" style="cursor:pointer">
                    {{e.title}}
                </li>
            </ul>
        </div>
        <slot>no input</slot>

    </div>
</template>

<script>
    export default {
        data: function(){
            return{
                elements: "",
                selEl:""
            }
        },
        methods: {
            bootstrap: function(){
                var test = this.$el.querySelectorAll(".tab_item");
                var temp = [];
                for(var i = 0;i<test.length;i++){
                    temp[i]= {
                        "title": test[i].querySelector(".tab_name").innerText,
                        "element":test[i]
                    };
                    if(!temp[i].element.className.match(/\btab_active\b/)){
                        temp[i].element.style.display = "none";
                    }

                }
                this.selEl = 0;
                this.elements = temp;


            },
            swapEl: function(i,el){
                if(i != this.selEl) {
                    this.elements[this.selEl].element.style.display = "none";
                    this.elements[i].element.style.display = "block";

                    this.selEl = i;
                }
            }
        },
        mounted: function(){
            this.$nextTick(function(){
                this.bootstrap();
            });
        }
    }
</script>

<style scoped>
    .nav{
        overflow: auto;
    }
    *{
        padding-left:0px;
        padding-right:0px;
    }
</style>