<template>
  <div class="resource-form" v-if="resource">
    <el-form ref="resource" label-position="top" class="list-group" v-if="!loading">
      <el-form-item :prop="name" :label="layout.field.label" v-for="(layout, name) of resource.layouts[resourceId ? 'edit' : 'create']" v-if="layout.field.editable" :key="name">
        <component :is="'o-field-'+(layout.field.type || 'text')" :editing="true" :attributes="layout.options" :field="layout.field" v-model="item[layout.field.name]" />
      </el-form-item>
    </el-form>

    <div class="mt-2">
      <div class="text-right">
        <o-back />
        <el-button plain type="primary" @click="handleSaveAndContinue(resource)">提交并继续</el-button>
        <el-button type="primary" @click="handleSaveAndGoBack(resource)">提交</el-button>
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
      type: [String, Number]
    }
  },
  data() {
    return {
      loading: true,
      resource: null,
      item: null
    }
  },
  watch: {
    resourceName() {
      this.loadItem()
    },
    resourceId() {
      this.loadItem()
    }
  },
  methods: {
    loadResource() {
      return axios
        .get(`/one/resources/${this.resourceName}`)
        .then(({ data }) => (this.resource = data))
    },
    loadItem() {
      if (this.resourceId) {
        return axios
          .get(`/one/items/${this.resourceName}/${this.resourceId}`)
          .then(({ data }) => (this.item = data))
      }
    },
    saveResource(resource) {
      let method = this.resourceId ? "patch" : "post"
      let url =
        method == "post"
          ? `/one/items/${this.resourceName}`
          : `/one/items/${this.resourceName}/${this.resourceId}`

      return axios[method](url, this.resource).then(({ data }) => {
        this.$emit("saved", data)
        this.$emit(this.resourceId ? "updated" : "created", data)
      })
    },
    handleSaveAndContinue(resource) {
      this.saveResource(resource).then()
    },
    handleSaveAndGoBack(resource) {
      this.saveResource(resource).then(() => this.$router.go(-1))
    }
  },
  mounted() {
    this.loadResource()
      .then(this.loadItem)
      .then(() => (this.loading = false))
  }
}
</script>

<style scoped>
</style>
