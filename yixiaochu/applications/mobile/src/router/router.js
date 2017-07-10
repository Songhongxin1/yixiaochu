import App from '../App'

export default [{
      path: '/',
      redirect: '/home'
},
{
    path: '/',
    component: App,
    children: [{
        path: 'home',
        component: r => require.ensure([], () => r(require('../pages/home')), 'home')
    },
    {
      path: 'shopping_car',
      component: r => require.ensure([], () => r(require('../pages/shopping_car')), 'shopping_car')
    },
    {
      path: 'user',
      component: r => require.ensure([], () => r(require('../pages/user')), 'user')
    },
    {
      path: 'userinfo',
      component: r => require.ensure([], () => r(require('../pages/userinfo')), 'userinfo')
    },
    {
      path: 'login',
      component: r => require.ensure([], () => r(require('../pages/login')), 'login')
    },
    {
      path: 'single_detail/:id',
      component: r => require.ensure([], () => r(require('../pages/single_detail')), 'single_detail')
    },
    {
      path: 'combo_detail/:id',
      component: r => require.ensure([], () => r(require('../pages/combo_detail')), 'combo_detail')
    }
    
    ]
}]
