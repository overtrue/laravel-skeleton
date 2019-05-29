import Vue from 'vue'
import Router from 'vue-router'

import Home from './views/home/routes'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: '/',
  routes: [
    ...Home,
  ],
})
