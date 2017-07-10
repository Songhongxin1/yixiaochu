import Vue from 'vue';
import App from './App';
import VueRouter from 'vue-router';
import vueresource from 'vue-resource';
import routes from './router/router';


Vue.use(vueresource);
Vue.use(VueRouter)
const router = new VueRouter({
  routes
})

Vue.http.options.root = process.env.domain;
Vue.http.options.emulateJSON = true;

Vue.config.async = false;

import Mint from 'mint-ui';
import 'mint-ui/lib/style.css';
Vue.use(Mint);

new Vue({
  router
}).$mount("#app")

//router.start(app, 'body');
/* eslint-disable no-new */
