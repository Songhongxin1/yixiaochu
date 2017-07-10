<style  scoped>

</style>

<template>
    <!-- Alert-dialog start -->
    <alert-dialog :msg ="msg"></alert-dialog>
    <div :class="css_user.right_cont" v-if="!isedit">
        <p :class="css_user.title">默认地址：</p>
        <ul :class="css_user.adres_list">
            <li v-for="(k,v) in user_addr" name="{{v.is_default}}"  :class="{[css_user.act] : v.is_default == 1}" @click="edit(v)">
                <i :class="css_user.edit" alt='编辑' @click="edit(v)"></i> 
                <i :class="css_user.del" alt='删除' @click.stop="delete(v.id)"></i>
                {{allarea[v.bus_area]+ '-' + allarea[v.area] + '-' +v.addr_name}}
            </li>
            <a href="javascript:;" :class="css_user.add_adres" @click="edit">添加新地址﹀</a>
        </ul>
        
    </div>

    <div :class="css_user.right_cont" v-if="isedit">
        <ul :class="css_user.edit_cont">
            <li>
                <p>送餐地址：</p>
                
              
                <select v-model="editInfo.bus_area">
                  <option v-for="option in bus_area_options" v-bind:value="option.id"">
                    {{ option.name }}
                  </option>
                </select>
                <select v-model="editInfo.area">
                  <option v-for="option in area_options" v-bind:value="option.id">
                    {{ option.name }}
                  </option>
                </select>
            </li>
            <li><textarea v-model="editInfo.addr_name" placeholder="请输入详细地址"></textarea></li>
            <li>
                <p>收货人姓名：</p>
                <input type="text"   v-model="editInfo.user_name">
            </li>
            <li>
                <p>收货人联系电话：</p>
                <input type="text"   v-model="editInfo.addr_phone">
            </li>
            <li>
                <p>设置为默认收货地址：</p>
                <label><input  type="radio" value="1" v-model="editInfo.is_default">是</label>
                <label><input  type="radio" value="0" v-model="editInfo.is_default">否</label>
            </li>
        </ul>
        <a href="javascript:;" @click="save" :class="css_user.but">保存</a> 
        
    </div>

</template>

<script>
    import alertDialog from './common/alertDialog';
    import store from '../store.js';
    export default{
        components:{
          alertDialog,
          store,
        },
        props:['user_addr','css_user'],
        data: function(){
          return{
            msg: '',
            isedit: false,
            editInfo:{
              id: -1,
              bus_area: 1,
              area: '',
              addr_name: '',
              user_name: '',
              addr_phone: '',
              is_default: 1,
            },
            bus_area_options: {
              
            },
            area_options: {
              
            },
            allarea: [],
          }
        },
        methods:{
          checkInput: function(){
            if(this.editInfo.addr_name == ''){
              this.msg = {msg: '收货地址不能为空!'};
              return;
            }
            
            if(this.editInfo.addr_phone == ''){
              this.msg = {msg: '收货人联系电话不能为空!'};
              return;
            }

            
            return true;
          },

          edit: function(addressInfo){
            if(addressInfo.id > 0){
              this.editInfo.id = addressInfo.id;
              this.editInfo.user_id = addressInfo.user_id;
              this.editInfo.bus_area = addressInfo.bus_area;
              this.editInfo.area = addressInfo.area;
              this.editInfo.addr_name = addressInfo.addr_name;
              this.editInfo.user_name = addressInfo.user_name;
              this.editInfo.addr_phone = addressInfo.addr_phone;
              this.editInfo.is_default = addressInfo.is_default;
              
            }else{
              this.editInfo.id = -1;
              this.editInfo.user_id = '';
              this.editInfo.bus_area = '';
              this.editInfo.area = '';
              this.editInfo.addr_name = '';
              this.editInfo.user_name = '';
              this.editInfo.addr_phone = '';
              this.editInfo.is_default = 1;
            }
            this.isedit = !this.isedit;
          },
          
          delete: function(addressId){
            if(!confirm("确定要删除该收货地址吗？"))
            {
              return
            }
            
            this.$http.post('user/del_address', {
              user: store.fetch('user'),
              id: addressId,
            })
            .then((response) => {
              if(response.body.status == 0){
                this.user_addr = response.body.data;
                this.msg = {msg: response.body.msg, isErr: false};
              }else{
                this.msg = {msg: response.body.msg};
              }
            })
            .catch(function(error) {
              this.msg = {msg:'网络异常，请稍后再试！'};
            })
          },

          save: function(){
            if(!this.checkInput()){
              return;
            }
            this.$http.post('user/save_address', {
              user: store.fetch('user'),
              id: this.editInfo.id,
              bus_area: this.editInfo.bus_area,
              area: this.editInfo.area,
              addr_name: this.editInfo.addr_name,
              user_name: this.editInfo.user_name,
              addr_phone: this.editInfo.addr_phone,
              is_default: this.editInfo.is_default,
            })
            .then((response) => {
              if(response.body.status == 0){
                this.msg = {msg: response.body.msg, isErr: false};
                this.user_addr = response.body.data;
                this.isedit = !this.isedit;
              }else{
                this.msg = {msg: response.body.msg};
              }
            })
            .catch(function(error) {
              this.msg = {msg:'网络异常，请稍后再试！'};
            })
          },
          
          changeArea: function(pid){
            this.$http.post('user/get_area', {
              bus_area: pid || 1,
            })
            .then((response) => {
              if(response.body.status == 0){
                this.area_options = response.body.data;
              }else{
                this.msg = {msg: response.body.msg};
              }
            })
            .catch(function(error) {
              this.msg = {msg:'网络异常，请稍后再试！'};
            })
          }
        },
        ready(){
          this.$http.get('user/get_bus_area')
          .then((response) => {
            if(response.body.status == 0){
              this.bus_area_options = response.body.data;
            }else{
              this.msg = {msg: response.body.msg};
            }
          })
          .catch(function(error) {
            this.msg = {msg:'网络异常，请稍后再试！'};
          });
          
          this.$http.post('user/get_area', {
            bus_area_id: this.editInfo.bus_area || 1,
          })
          .then((response) => {
            if(response.body.status == 0){
              this.area_options = response.body.data;
            }else{
              this.msg = {msg: response.body.msg};
            }
          })
          .catch(function(error) {
            this.msg = {msg:'网络异常，请稍后再试！'};
          });
          
          this.$http.get('user/get_all_area')
          .then((response) => {
            if(response.body.status == 0){
              this.allarea = response.body.data;
            }else{
              this.msg = {msg: response.body.msg};
            }
          })
          .catch(function(error) {
            this.msg = {msg:'网络异常，请稍后再试！'};
          });
        },
        watch: {
          'editInfo.bus_area': function (val) {
            this.$http.post('user/get_area', {
              bus_area_id: val || 1,
            })
            .then((response) => {
              if(response.body.status == 0){
                this.area_options = response.body.data;
              }else{
                this.msg = {msg: response.body.msg};
                this.area_options = {};
              }
            })
            .catch(function(error) {
              this.msg = {msg:'网络异常，请稍后再试！'};
            });
          },
        }

    }
</script>
