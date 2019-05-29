import Resource from './functions/resource'

let errorHandler = (error) => {
  let message = error.response.data.message || error.message

  window.Vue.prototype.$message.error(message)

  return Promise.reject(error)
}

export default {
  users: new Resource('/admin/users', errorHandler),
  settings: new Resource('/admin/settings', errorHandler),
}
