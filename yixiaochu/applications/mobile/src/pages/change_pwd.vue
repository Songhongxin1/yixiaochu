<template>
<div>
    <headpart title="个人中心"></headpart>
    
    <div :class="css_wap.mainfix">
        <ul :class="[css_user.user_list, css_user.info_cont]" >
            <li><p>头像</p><img :src="user_info.head_img_url"></li>
            <li><p>昵称</p><p>{{user_info.nickname}}</p></li>
            <li><p>姓名</p><p>{{user_info.user_name}}</p></li>
            <li><p>电话</p><p>{{user_info.user_phone}}</p></li>
            <li><p>性别</p><p>{{user_info.sex==1?'男':'女'}}</p></li>
            <!--li><p>生日</p><p>1990年08月08日</p></li-->
         </ul>
         <a href="javascript:;" :class="css_user.submit" @click="trigger_edit">修改资料</a>
    </div>

    <footpart current = "user" ></footpart>
</div>
</template>

<style>
.fileupload-button{
  background-color: #ffffff;
  border-color: #ffffff;
  border: solid 1px #ccc;
  text-align: center;
  line-height: 1.8rem;
  color: #f56c65;
  font-size: 0.68rem;
  float: left;
  width: 1.8rem;
  height: 1.8rem;
  border-radius: 0.2rem;
  margin: 0.3rem 0;
}
.fileupload-button input[type=file]{
  color:
}
</style>

<script>
import css_wap from '../../static/css/wap.css';
import css_user from '../../static/css/user.css';
import headpart from './common/header';
import footpart from './common/footer';
import store from '../store.js';
import VueFileUpload from 'vue-file-upload';

export default {
    components:{
      css_wap,
      css_user,
      headpart,
      footpart,
      VueFileUpload,
      
    },
    created(){
    },
    data(){
      return {
        css_wap: {},
        css_user: {},
        single_foods: {},
        combo_foods: {},
        shopping_car:{
          single: [],
          combo: [],
        },
        //用户信息
        user_info:[],
        is_edit: false,
        files:[],
        //文件过滤器，只能上传图片
        filters:[
          {
            name:"imageFilter",
            fn(file){
                var type = '|' + file.type.slice(file.type.lastIndexOf('/') + 1) + '|';
                return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
            }
          }
        ],
        //回调函数绑定
        cbEvents:{
          onCompleteUpload:(file,response,status,header)=>{
            this.$set('user_info.head_img_url', response.full_url);
            this.isuploadSuccess = true;
            alert('上傳成功');
            
          }
        },
        //xhr请求附带参数
        reqopts:{
          formData:{
            tokens:'tttttttttttttt'
          },
          responseType:'json',
          withCredentials:false
        },
        
      }
    },
    computed: {
      
    },
    ready(){
       this.css_wap = css_wap;
       this.css_user = css_user;
    },
    methods:{
      trigger_edit: function(){
        this.is_edit = !this.is_edit;
      },
      save: function(){
        this.$http.post('user/save_info', {
          user: store.fetch('user'),
          head_img: this.user_info.head_img_url,
          nickname: this.user_info.nickname,
          user_name: this.user_info.user_name,
          sex: this.user_info.sex,
        })
        .then((response) => {
          if(response.body.status == 0){
            alert(response.body.msg);
            this.trigger_edit();
          }else{
            alert(response.body.msg);
          }
        })
        .catch(function(error) {
          alert('网络异常，请稍后再试！');
        });
        
      },

    },
    watch:{
      'files': function(files) {
        if(this.files.length != 0){
          files[0].upload();
          this.files.pop();
        }
      }
    },
    route:{
      data: function(){
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
      }
    },
}

</script>
