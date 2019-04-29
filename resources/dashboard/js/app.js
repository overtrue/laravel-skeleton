import router from './router'
import ElementUI from 'element-ui'
import VueLocalStorage from 'vue-localstorage'


require('./bootstrap')

// Components
const files = require.context('./components', true, /\.vue$/i)
files.keys().map(key => Vue.component('o-' + key.split('/').pop().split('.')[0], files(key).default))

Vue.use(ElementUI)
Vue.use(VueLocalStorage)

const app = new Vue({
    router,
}).$mount('#app');
