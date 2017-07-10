<style  scoped>
.fileupload-button{
    background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAH4AAAB+CAYAAADiI6WIAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QjgzRTRDNjc2RTVEMTFFNkI1Q0FDOUE1Mzg2NDY4RUYiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QjgzRTRDNjg2RTVEMTFFNkI1Q0FDOUE1Mzg2NDY4RUYiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpCODNFNEM2NTZFNUQxMUU2QjVDQUM5QTUzODY0NjhFRiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpCODNFNEM2NjZFNUQxMUU2QjVDQUM5QTUzODY0NjhFRiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PlkhsnIAAAEqSURBVHja7NyxDcIwEEBRgzwRUyB5GTqK1BR0zOH+1vBMUUCMgLF070mpk9zXpbJy6r1fSymXQiajHtFbaw+zyCMitrMx5CS88AiP8AiP8AiP8AiP8AiP8AiP8AiP8AiP8AiP8AiP8AiP8MIjPMIjPMIjPMIjPMIjPMIjPMLPdr99LuERHuERHuERHuERHuERHuERHuERHuERHuERHuERHuERnre69NPNOP78y3s8XzYeG7/Gxnw3feGttPEIj/AIj/AIj/AIj/DCIzzCIzzCIzzCIzzCIzzCIzzCM1NN++ZJj1XbeJ96hEd4hEd4hEd4hEd4hEd4hEd4hEd4hEd4hEd4hEd4hEd4hBce4REe4REe4REe4REe4REe4fmL469XIyI2o0hl7AIMAHWMFZvH71F2AAAAAElFTkSuQmCC);
    height: 114px;
    width: 102px;
}
.fileupload-button input[type=file]{
    color:
}
</style>

<template>
    <!-- Alert-dialog start -->
    <alert-dialog :msg ="msg"></alert-dialog>
    <div  :class="css_user.left_cont" v-if="!isedit">
        <ul :class="css_user.info_list">
            <li>
                <label>当前头像：</label>
                <p :class="css_user.head">
                    <img v-if="user_info.head_img_url" v-bind:src="user_info.head_img_url">
                    <img v-else src="../../static/images/head.jpg"/>
                </p>
            </li>
            <li>
                <label>昵      称：</label>
                <p>{{user_info.nickname}}</p>
            </li>
            <li>
                <label>真实姓名：</label>
                <p>{{user_info.user_name}}</p>
            </li>
            <li>
                <label>电话号码：</label>
                <p>{{user_info.user_phone}}</p>
            </li>
            <li>
                <label>性      别：</label>
                <p>{{user_info.sex_text}}</p>
            </li>
        </ul>
        <a href="javascript:;" @click="edit" :class="css_user.but">修改</a>
    </div>
    <div :class="css_user.left_cont" v-if="isedit">
        <ul :class="css_user.info_list">
            <li>
                <label>当前头像：</label>
                <img v-if="isuploadSuccess" :class="css_user.up_img_url" :src="user_info.head_img_url"/>
                <vue-file-upload 
                    style="background-color: #ffffff;border-color: #ffffff"
                    url='http://api.dev.yixiaochu.com/file/upload',
                    v-bind:files.sync = 'files',
                    v-bind:filters = "filters",
                    v-bind:events = 'cbEvents',
                    v-bind:request-options = "reqopts"
                    label = ''>
                </vue-file-upload>
                
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
        <a href="javascript:;" @click="save" :class="css_user.but">保存</a>
    </div>
</template>

<script>
    import alertDialog from './common/alertDialog';
    import store from '../store.js';
    import VueFileUpload from 'vue-file-upload';
    export default{
        components:{
          alertDialog,
          store,
          VueFileUpload,
        },
        props:['user_info','css_user'],
        data: function(){
          return {

            isuploadSuccess: false,
            msg: {
              msg: '',
              isErr: true,
            },
            isedit: false,
            //vue-upload
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
                this.msg = {msg: '上傳成功', isErr: false};
                
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
        watch:{
          'user_info.sex': function(value) {
            this.user_info.sex_text = value == 1 ? '男' : '女';
          },
          'files': function(files) {
              files[0].upload();
              this.files.pop();
          }
        },
        methods:{
          checkInput: function(){
            if(this.user_info.nickname == ''){
              this.msg = {msg: '昵称不能为空!'};
              return;
            }
            
            let isHanzi=/^[\u4E00-\u9FA5\uF900-\uFA2D]{2,4}$/;
            if(!isHanzi.test(this.user_info.user_name)){
              this.msg = {msg: '请输入正确的真实姓名!'};
              return;
            }
            
            return true;
          },

          edit: function(){
            this.isedit = !this.isedit;
          },
          
          save: function(){
            if(!this.checkInput()){
              return;
            }
            this.$http.post('user/save_info', {
              user: store.fetch('user'),
              head_img: this.user_info.head_img_url,
              nickname: this.user_info.nickname,
              user_name: this.user_info.user_name,
              sex: this.user_info.sex,
            })
            .then((response) => {
              if(response.body.status == 0){
                this.msg = {msg: response.body.msg, isErr: false};
                this.isedit = !this.isedit;
              }else{
                this.msg = {msg: response.body.msg};
              }
            })
            .catch(function(error) {
              this.msg = {msg:'网络异常，请稍后再试！'};
            })
          },

        },

        
    }
</script>
