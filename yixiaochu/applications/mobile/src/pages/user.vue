<template>
<div>
    <headpart title="个人中心"></headpart>
    
    <div :class="css_wap.mainfix">
        <div :class="css_user.user_top">
            <img :src="user_info.head_img_url">
            <p>{{user_info.nickname}}<i></i></p>
        </div>
        <div :class="css_user.user_cont">
            <div :class="css_user.point"><i></i><p>积分  {{user_info.score}}<br><a href="javascript:;">如何获取积分？</a></p></div>
            <div :class="css_user.point"><i></i><p><a href="javascript:;">查看积分</a><br><a href="javascript:;">获取记录</a></p></div>
        </div>
        <ul :class="css_user.user_nav">
            <li><a href="javascript:;"><i></i>我的订单<span></span></a></li>
            <li><router-link to="userinfo"><i></i>个人资料<span></span></router-link></li>
            <li><a href="javascript:;"><i></i>我的菜单<span></span></a></li>
            <li><a href="javascript:;"><i></i>修改密码<span></span></a></li>
            <li><a href="/address"><i></i>收货地址<span></span></a></li>
        </ul>
    </div>

    <footpart current = "user" ></footpart>
</div>
</template>

<style>
.staggered-transition {
  transition: all .7s ease;
  overflow: hidden;
  margin: 0;

}
.staggered-enter, .staggered-leave {
  opacity: 0;
}

.swiper-pagination{
  bottom: 10px; 
  left: 0; 
  width: 100%; 
  position: absolute;
  text-align: right;
  z-index: 10;
}

.swiper-pagination-bullet {
  margin: 0 5px; 
  width: 10px;
  height: 10px;
  display: inline-block;
  border-radius: 50%;
  background: #fff;
}
.swiper-pagination-bullet-active { opacity: 1; background: #dc1a00; }


.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}
.modal-enter, .modal-leave {
  opacity: 0;
}
.modal-enter .modal-container,
.modal-leave .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>

<script>
import css_wap from '../../static/css/wap.css';
import css_user from '../../static/css/user.css';
import headpart from './common/header';
import footpart from './common/footer';
import store from '../store.js';

export default {
    components:{
      css_wap,
      css_user,
      headpart,
      footpart,
    },
     
    data(){
      return {
        css_wap: {},
        css_user: {},
        //用户信息
        user_info:[],
      }
    },
    computed: {
      
    },
    mounted(){      
       this.css_wap = css_wap;
       this.css_user = css_user;
    },
    methods:{

    },
    watch:{

    },
    created: function(){
  
        if(store.fetch('user').length != 0){
          
          let user = store.fetch('user');
          this.$http.post('user/info', {
            user: user,
          })
          .then((response) => {
            if(response.body.status == 0){
              this.user_info = response.body.data;
            }else{
              //alert( response.body.msg);
            }
          })
          .catch(function(error) {
            alert('网络异常，请稍后再试！');
          });

        }else{
            this.$route.router.go('login');
            return;
        }
     
    },
}

</script>
