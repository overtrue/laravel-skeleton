function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  {
    path: '/admin',
    meta: { title: '管理后台' },
    component: { template: `<router-view></router-view>` },
    children: [
      { path: '', name: 'home', component: page('home.vue'), meta: { title: '首页' } },

      { path: 'login', name: 'login', component: page('auth/login.vue'), meta: { title: '登录' } },
      { path: 'password/reset', name: 'password.request', component: page('auth/password/email.vue'), meta: { title: '重置密码' } },
      { path: 'password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue'), meta: { title: '重置密码' } },

      {
        path: 'users',
        component: { template: `<router-view/>` },
        meta: { title: '用户管理' },
        children: [
          { path: '', name: 'users.index', component: page('users/index.vue'), meta: { title: '用户列表' } },
          { path: 'create', name: 'users.create', component: page('users/form.vue'), meta: { title: '新建用户' } },
          { path: ':id/edit', name: 'users.edit', component: page('users/form.vue'), meta: { title: '编辑用户' } }
        ]
      },

      { path: '*', component: page('errors/404.vue'), meta: { title: '404' } }
    ]
  }
]
