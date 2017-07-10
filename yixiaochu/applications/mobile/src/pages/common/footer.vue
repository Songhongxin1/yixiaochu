<template>
    <div :class="css_wap.footer">

        <router-link to="/home" :class="[css_wap.index, isHome ? css_wap.act : '']"><i></i><span>订餐首页</span></router-link>
        <router-link to="/shopping_car" :class="[css_wap.menu, isMenu ? css_wap.act : '']"><i></i><span>我的菜单</span><em v-show="shopping_num" >{{shopping_num}}</em></router-link>
        <router-link to="/user" :class="[css_wap.user, isUsercenter ? css_wap.act : '']"><i></i><span>个人中心</span></router-link>
        <a href="javascript:;" :class="css_wap.more" @click="showMore"><i></i><span>更多</span></a>

        <ul v-show="isMore" >
            <span></span>
            <li><router-link to="/today" :class="css_wap.today"><i></i>今日菜单</router-link></li>
            <li><router-link to="/story" :class="css_wap.story"><i></i>小厨故事</router-link></li>
            <li><router-link to="/scoff" :class="css_wap.scoff"><i></i>欢乐吐槽</router-link></li>

        </ul>
    </div> 
</template>
<style>

</style>
<script>
import css_wap from '../../../static/css/wap.css';
import store from '../../store.js';
    export default{
        components:{
          css_wap
        },
        props: {
          current: {  
            default: 'home'
          }, 
          shopping_car: {
            default: () => store.fetch('shoppingCar')
          },
        },
        data(){
            return {
              isMore: false,
              css_wap: {},
            }
        },
        computed:{
          isHome(){
              if(this.current == 'home'){
                  return true;
              }
          },
          isMenu(){
              if(this.current == 'menu'){
                  return true;
              }
          },
          isUsercenter(){
              if(this.current == 'user'){
                  return true;
              }
          },
          shopping_num: function () {
            let num = 0;
            for(let single of this.shopping_car.single){
              if(single.num != 0){
                num ++
              }
            }
            for(let combo of this.shopping_car.combo){
              if(combo.num != 0){
                num ++
              }
            }
            return num;
          },
        },
        methods :{
           showMore: function(){
             this.isMore = !this.isMore;
           }
        },
        mounted(){
          this.css_wap = css_wap;
        },
    }
</script>
