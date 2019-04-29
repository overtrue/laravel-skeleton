<template>
  <div class="resource-detail">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h5 class="mb-0">{{ resourceName }} 详情 </h5>
      <div class="right-actions">
        <back/>
        <resource-btn-delete :resource-name="resourceName" :resource-id="resourceId"/>
        <resource-btn-edit :resource-name="resourceName" :resource-id="resourceId"/>
      </div>
    </div>

    <div class="field-group"  v-for="group of fields" v-if="resource">
      <h5 class="mt-4" v-if="group.label">{{ group.label }}</h5>
      <div class="list-group" v-if="resource">
        <div class="list-group-item py-1" v-for="field of group.fields">
          <div class="row align-items-center">
            <label class="col-sm-2 col-form-label text-black-50">{{field.label}}</label>
            <div class="col-sm-10"><component :is="'field-' + (field.type || 'text')" :value="resource[field.name]"></component></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      resourceName: {
        required: true
      },
      resourceId: {
        required: true
      },
    },
    data() {
      return {
        fields: [],
        resource: null,
      }
    },
    methods: {
      loadFields() {
        return axios.get(`/one/resources/${this.resourceName}/fields`).then(({data}) => this.fields = data)
      },
      loadResource() {
        return axios.get(`/one/resources/${this.resourceName}/${this.resourceId}`).then(({data}) => this.resource = data)
      }
    },
    mounted() {
      this.loadFields().then(this.loadResource)
    }
  }
</script>

<style scoped>

</style>
