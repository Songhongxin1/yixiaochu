<template>
    <headpart show_item="user"></headpart>
    <!-- main start -->
    <div :class="css_public.container">
        <div :class="css_user.page_main">
            <userhead user_item="info"></userhead>
            <div :class="css_user.info_cont">
                <div :class="css_user.left_cont">
                    <ul :class="css_user.info_list">
                        <li>
                            <label>当前头像：</label>
                            <img v-if="user_info.head_img_url" :class="css_user.up_img_url" :src="user_info.head_img_url"/>
                            <a href="javascript:;" :class="css_user.up_img"></a>
                        </li>
                        <li>
                            <label>昵      称：</label>
                            <input type="text" placeholder="请输入昵称" v-model="user_info.nickname">
                        </li>
                        <li>
                            <label>真实姓名：</label>
                            <input type="text" placeholder="请输入真实姓名" v-model="user_info.user_name">
                        </li>
                        <li>
                            <label>电话号码：</label>
                            <input type="text" readOnly="true"  v-model="user_info.user_phone">
                        </li>
                        <li>
                            <label>性      别：</label>
                            <label><input  type="radio" value="1" v-model="user_info.sex">男</label>
                            <label><input  type="radio" value="0" v-model="user_info.sex">女</label>
                        </li>
                        <!-- <li>
                            <label>生      日：</label>
                            <input type="text" placeholder="请选择生日" v-model="user_info.birthday">
                        </li> -->
                    </ul>
                </div>
                <div :class="css_user.right_cont">
                    <ul :class="css_user.edit_cont">
                        <li>
                            <p>送餐地址一：</p>
                            <select>
                                <option>贵阳</option>
                            </select>
                            <select>
                                <option>观山湖区</option>
                            </select>
                        </li>
                        <li><textarea placeholder="请输入详细地址"></textarea></li>
                    </ul>
                    <a href="javascript:;" :class="css_user.add_adres">添加新地址﹀</a>
                    <ul :class="css_user.edit_cont">
                        <li>
                            <p>送餐地址二：</p>
                            <select>
                                <option>贵阳</option>
                            </select>
                            <select>
                                <option>观山湖区</option>
                            </select>
                        </li>
                        <li><textarea></textarea></li>
                    </ul>
                </div>
                <a href="javascript:;" @click="save" :class="css_user.but">保存</a>
            </div>          

        </div>
    </div>
    <!-- menu start -->
    <mymenu v-bind:menus.sync="menus" v-bind:show_menus.sync="show_menus"></mymenu>
    <!-- backtop start -->
    <div class="gotop"></div>
    <!-- foot start -->
    <footpart></footpart>
</template>
<script>
    import css_user from '../../static/css/user.css';
    import css_public from '../../static/css/public.css';
    import store from '../store.js';
    //其他公共组件
    import headpart from './common/header';
    import footpart from './common/footer';
    import mymenu from './common/mymenu';
    import userhead from './common/userhead';
    //时间空间
    import calendar from './common/calendar';
    export default{
        components:{
            css_public,
            css_user,
            store,
            headpart,
            footpart,
            mymenu,
            userhead,
            calendar
        },
        data(){
            return {
                //我的菜单数据
                menus:[],
                //是否显示我的菜单
                show_menus:false,
                //用户信息
                user_info:[],
                //地址信息
                user_addr:[],
                css_user:{},
                css_public:{},
            }
        },
        route:{
            data(){
                var user = store.fetch('user');
                this.$http.post('user/info', {user:user}).then((response) => {
                    this.user_info = response.body.data;
                    this.user_addr = []; //this.user_info.user_addr
                })
            }
        },
        ready(){
            this.css_user = css_user;
            this.css_public = css_public;
            //如果未登录跳转
            if(store.fetch('user').length == 0){
                this.$route.router.go('login');
            }
        },
        methods:{
            save(){
              this.$http.post('user/save_info', {
                user: store.fetch('user'),
                nickname: this.user_info.nickname,
                user_name: this.user_info.user_name,
                user_phone: this.user_info.user_phone,
                sex: this.user_info.sex,
                /*address:{
                  id,
                  addr_name,
                  addr_phone,
                },*/
              })
              .then((response) => {
                console.log(response);return
                  if(response.body.status == 0){
                      this.message.serviceReturn = response.body.msg;
                      this.isErr = false;
                  }else{
                      this.message.serviceReturn = response.body.msg;
                      this.isErr = true;
                  }
              })
              .catch(function(error) {
                  this.message.serviceReturn = '网络异常，请稍后再试！';
                  this.isErr = true;
              })
            }

        }
    }
</script>