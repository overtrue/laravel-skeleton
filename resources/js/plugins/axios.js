import axios from 'axios'
import { Message } from 'element-ui'
import i18n from '~/plugins/i18n'
import router from '~/router'
import store from '~/store'

// Request interceptor
axios.interceptors.request.use(request => {
  const token = store.getters['auth/token']
  if (token) {
    request.headers.common['Authorization'] = `Bearer ${token}`
  }

  const locale = store.getters['lang/locale']
  if (locale) {
    request.headers.common['Accept-Language'] = locale
  }

  // request.headers['X-Socket-Id'] = Echo.socketId()

  return request
})

// Response interceptor
axios.interceptors.response.use(
  response => response,
  error => {
    const { status, data } = error.response

    if (status >= 500 || [405, 400, 403].indexOf(status) > -1) {
      Message.error(data.message || i18n.t('error_alert_text'))
    }

    if (status === 401 && store.getters['auth/check']) {
      Message.warning(i18n.t('token_expired_alert_text'))
      store.commit('auth/LOGOUT')
      router.push({ name: 'login' })
    }

    return Promise.reject(error)
  }
)
