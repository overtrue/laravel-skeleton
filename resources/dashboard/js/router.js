import Vue from 'vue'
import Router from 'vue-router'
import Login from './views/auth/login'
import ResourceShow from './views/resources/detail'
import ResourceForm from './views/resources/form'
import ResourceIndex from './views/resources/index'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: '/dashboard',
  routes: [
    {
      name: 'auth.login',
      path: '/login',
      component: Login
    },
    {
      name: 'one.items.index',
      path: '/items/:resourceName',
      component: ResourceIndex,
      props: route => route.params,
    },
    {
      name: 'one.items.create',
      path: '/items/:resourceName/create',
      component: ResourceForm,
      props: route => Object.assign(route.params, {mode: 'create'}),
    },
    {
      name: 'one.items.edit',
      path: '/items/:resourceName/:resourceId/edit',
      component: ResourceForm,
      props: route => Object.assign(route.params, {mode: 'edit'}),
    },

    {
      name: 'one.items.detail',
      path: '/items/:resourceName/:resourceId',
      component: ResourceShow,
      props: route => route.params,
    },
  ],
})
