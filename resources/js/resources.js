import Resource from '~/plugins/resource'

export default {
  users: new Resource('/api/admin/users'),
  settings: new Resource('/api/admin/settings')
  //
}
