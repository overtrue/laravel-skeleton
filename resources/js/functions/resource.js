export default class Resource {
    constructor(baseUri, errorHandler = null) {
      this.baseUri = baseUri.replace(/\/+$/, '')

      if (!errorHandler) {
        errorHandler = (error) => {
          console.log(error)
          return error
        }
      }

      this.errorHandler = errorHandler
    }

    get(uri, params = {}) {
        return axios.get(`${this.baseUri}/${uri}`, { params }).catch(this.errorHandler)
    }

    post(uri, payload) {
        return axios.post(`${this.baseUri}/${uri}`, payload).catch(this.errorHandler)
    }

    patch(uri, payload) {
        return axios.patch(`${this.baseUri}/${uri}`, payload).catch(this.errorHandler)
    }

    put(uri, payload) {
        return axios.put(`${this.baseUri}/${uri}`, payload).catch(this.errorHandler)
    }

    delete(uri) {
        return axios.delete(`${this.baseUri}/${uri}`).catch(this.errorHandler)
    }

    find(id, params = {}) {
        return this.get(id, params)
    }

    index(params = {}) {
        return this.get('', params)
    }

    store(payload) {
        return this.post('', payload)
    }

    update(id, payload) {
        return this.patch(id, payload)
    }

    destroy(id) {
        return this.delete(id)
    }
}
