import axios from 'axios'

export default class Resource {
  constructor (baseUri) {
    this.baseUri = baseUri.replace(/\/+$/, '')
  }

  getData ({ data }) {
    return data
  }

  get (uri, params = {}) {
    return axios.get(`${this.baseUri}/${uri}`, { params }).then(this.getData)
  }

  post (uri, payload) {
    return axios.post(`${this.baseUri}/${uri}`, payload).then(this.getData)
  }

  patch (uri, payload) {
    return axios.patch(`${this.baseUri}/${uri}`, payload).then(this.getData)
  }

  put (uri, payload) {
    return axios.put(`${this.baseUri}/${uri}`, payload).then(this.getData)
  }

  delete (uri) {
    return axios.delete(`${this.baseUri}/${uri}`).then(this.getData)
  }

  find (id, params = {}) {
    return this.get(id, params)
  }

  index (params = {}) {
    return this.get('', params)
  }

  store (payload) {
    return this.post('', payload)
  }

  update (id, payload) {
    return this.patch(id, payload)
  }

  destroy (id) {
    return this.delete(id)
  }
}
