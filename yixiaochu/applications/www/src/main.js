import Vue from 'vue';
import App from './App';
import vuerouter from 'vue-router';
import vueresource from 'vue-resource';

Vue.use(vuerouter);
Vue.use(vueresource);

Vue.http.options.root = process.env.domain;
Vue.http.options.emulateJSON = true;

Vue.config.async = false;

var router = new vuerouter({
    hashbang:false,
    history:true
});
var app = Vue.extend(App);

router.map({
    '/home':{
        component:function(resolve){
            require(['./components/home'], resolve)
        }
    },
    '/today':{
        component:function(resolve){
            require(['./components/today'], resolve)
        }
    },
    '/detail/:id':{
        component:function(resolve){
            require(['./components/detail'], resolve)
        }
    },
    '/login':{
        component:function(resolve){
            require(['./components/login'], resolve)
        }
    },
    '/reg':{
        component:function(resolve){
            require(['./components/reg'], resolve)
        }
    },
    '/order':{
    	component:function(resolve){
            require(['./components/order'], resolve)
        }
    },
    '/order_detail/:id':{
    	component:function(resolve){
            require(['./components/order_detail'], resolve)
        }
    },
    '/user_order':{
    	component:function(resolve){
            require(['./components/user_order'], resolve)
        }
    },
    '/user_point':{
    	component:function(resolve){
            require(['./components/user_point'], resolve)
        }
    },
    '/story':{
        component:function(resolve){
            require(['./components/story'], resolve)
        }
    },
    '/story_detail':{
        component:function(resolve){
            require(['./components/story_detail'], resolve)
        }
    },
    '/story_detail/:id':{
    	name:'story_detail',
        component:function(resolve){
            require(['./components/story_detail'], resolve)
        }
    },
    '/story/:type':{
    	name:'/story',
        component:function(resolve){
            require(['./components/story'], resolve)
        }
    },
    '/userinfo':{
        component:function(resolve){
            require(['./components/userinfo'], resolve);
        }
    },
    '/scoff':{
        component:function(resolve){
            require(['./components/scoff'], resolve);
        }
    },
    '/useredit':{
        component:function(resolve){
            require(['./components/useredit'], resolve);
        }
    },
    '/allpay':{
        component:function(resolve){
            require(['./components/allpay'], resolve);
        }
    },
    '/aapay':{
        component:function(resolve){
            require(['./components/aapay'], resolve);
        }
    }
})

router.redirect({
    '*':'home'
})
router.start(app, 'body');
/* eslint-disable no-new */
