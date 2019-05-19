<template>
    <div class="col-md-2 sidebar">

        <h4 class="text-center">Otázky</h4>
        <div class="d-flex justify-content-center">
        <div class="form-check-inline form-check no-sel" @click="changeClick" :class="{unmarked:bookmarks.length == 0}">
            <input :disabled="bookmarks.length == 0" type="checkbox" v-model="onlyBookmarks" class="form-check-input">
            <label class="form-check-label">Pouze označené</label>
        </div>
        </div>
        <hr>
        <ul>
            <li v-if="(onlyBookmarks) ? (bookmarks.indexOf(i) != -1) : true" v-for="(o,i) in questions" @click="q_click(i)" class="q_item d-flex justify-content-between align-items-center" :class="{sel:i==curr_question}"><span>{{i+1}}. otázka</span><i v-if="bookmarks.indexOf(i) != -1" class="fas fa-bookmark"></i></li>
            <!-- Dodělat filter !-->
        </ul>
    </div>
</template>

<script>
    export default {
        props:{
            questions:{
                type:Array,
                required:true
            },
            curr_question:{
                type:Number,
                required:true
            },
            bookmarks:{
                type:Array,
                default:[]
            },
            setFilter:{
                type:Boolean,
                default: false
            }

        },
        name: "QuestionList",
        data(){
            return{
                onlyBookmarks:false
            }
        },
        methods:{
            q_click(i){
                this.$emit("question_selected",i);
            },
            changeClick(){
                if(this.bookmarks.length > 0){
                    this.onlyBookmarks = !this.onlyBookmarks
                }
            }
        },
        watch:{
            bookmarks(){
                console.log(this.bookmarks.length == 0 && this.onlyBookmarks);
                if(this.bookmarks.length == 0 && this.onlyBookmarks){
                    this.onlyBookmarks = false;
                }
            },
            setFilter(){
                this.onlyBookmarks = this.setFilter;
            }
        }
    }
</script>

<style scoped>
    .sel{
        color:orange;
    }
    .sel:hover{
        background:none;
    }
    .q_item .fas{
        font-size:18px;
        padding:0;
        color:white;
    }
    .no-sel{
        user-select: none;
    }
</style>
