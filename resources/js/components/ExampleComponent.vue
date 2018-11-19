<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Example Component</div>

                    <div class="card-body" v-on:click="test">
                        {{datapack}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data:function(){
            return{
                datapack:"ahoj"
            }
        },
        methods:{
            test: function(){
                console.log("test");
            }
        }
    }
</script>

