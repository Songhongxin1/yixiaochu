<template>
<div class="{{css_public.mymenu}} {{show_menus ? css_public.act : ''}}" >
    <a href="javasctipt:;" :class="css_public.my_menu" v-on:click="show_menu"><i></i>我<br>的<br>菜<br>单</a>
    <div :class="css_public.menu_cont" >
        <div :class="css_public.top">
            <label><input type="checkbox" v-bind:checked="allcheck" v-on:click="check_all">全选</label>
            <a href="javascript:;" class="del"></a>
        </div>
        <ul v-if="menus" >
            <li v-for="(k,v) of menus">
               <input type="checkbox" value="{{v.id}}" v-bind:checked="allcheck" v-model="ids">
               <p v-if="v.combo_name"><img :src="v.cover_img">{{v.combo_name}}</p>
               <p v-else="v.foods_name"><img :src="v.cover_img">{{v.foods_name}}</p>
            </li>
        </ul>
        <a href="/order" :class="css_public.settle" v-on:click="settle">立即结算<i></i></a>
    </div>
</div>
</template>
<script>
    import css_public from '../../../static/css/public.css';
    import store from '../../store.js';
    export default{
        components:{
            css_public
        },
        props:['menus', 'show_menus'],
        data(){
            return {
                ids:[],
                allcheck:false,
                css_public
            }
        },
        ready(){
            this.css_public = css_public;
            this.$set('menus',store.fetch('menus'));
        },
        methods:{
            //显示/隐藏购物车
            show_menu(){
                this.$parent.show_menus = !this.$parent.show_menus;
            },
            //结算
            settle(){
                console.log(this.ids);
            },
            //选择所有
            check_all(){
                this.allcheck = !this.allcheck;
            }
        }
    }
</script>