<template>
  <div class="alert_dialog">
      <ul>
          <li v-for="item in list"
              transition="staggered"
              stagger="3000"
              :class="{'err': isErr, 'normal': !isErr}"
              >
            {{item.msg}}
           </li>
      </ul>
  </div>
</template>

<script>

export default{

    data(){
        return {
          isErr: true,
          list: [],
        }
    },
    props:['msg'],
    watch: {
      msg: function(value) {
        this.dispalyMsg(value.msg, value.isErr);
      }
    },
    methods:{
      dispalyMsg: function(msg ,isErr = true){
        console.log(msg);
        this.isErr = isErr,
        this.list.push({ msg: msg });
        setTimeout(()=> {
          this.list.shift();
        }, 5000);
      }
    },
}
</script>

<style scope>
.alert_dialog .staggered-transition {
  transition: all 0.5s ease;
  overflow: hidden;
  margin: 0.5em;
  height: 20px;
}
.alert_dialog .staggered-enter, .staggered-leave {
  transition: all 0.5s ease;
  opacity: 0;
  height: 0;
}

.alert_dialog{
  font-family: '微软雅黑', Arial, sans-serif;
  z-index: 9999;
}
.alert_dialog ul{
  position: fixed;
  z-index: 9999;
  bottom: 10em;
  left: .5em;
  color: #666;
}
.alert_dialog ul li{
  cursor: pointer;
  padding: .5em .8em;
  margin: .5em;
  color: #fff;
  font-size: .8em;
  background-color: #f56c65;
}

.alert_dialog ul .err{
  background-color: #f56c65;
}

.alert_dialog ul .normal{
  background-color: #0a9e0a;
}
</style>
