import { AlertError, AlertSuccess, HasError } from 'vform'
import Vue from 'vue'
import Child from './Child'

// Components that are registered globaly.
;[Child, HasError, AlertError, AlertSuccess].forEach(Component => {
  Vue.component(Component.name, Component)
})
