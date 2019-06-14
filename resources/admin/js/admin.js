import ElementUI from 'element-ui'
import Vue from 'vue'
import '~/components'
import App from '~/components/App'
import '~/plugins'
import i18n from '~/plugins/i18n'
import router from '~/router'
import store from '~/store'

Vue.use(ElementUI)
Vue.config.productionTip = false

const files = require.context('./components', true, /\.vue$/i)
files.keys().map(key =>
  Vue.component(
    key
      .split('/')
      .pop()
      .split('.')[0],
    files(key).default
  )
)

/* eslint-disable no-new */
new Vue({
  el: '#app',
  i18n,
  store,
  router,
  ...App
})
