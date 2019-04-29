<template>
  <el-radio-group class="resource-scopes" v-model="selected" v-if="scopes && Object.keys(scopes).length > 0">
    <el-radio-button label="all">全部</el-radio-button>
    <el-radio-button :label="key" :key="item" v-for="(item, key) of scopes">{{ key }}</el-radio-button>
  </el-radio-group>
</template>

<script>
export default {
  props: {
    resourceName: {
      type: String,
      required: true
    },
    resourceLabel: {
      type: String,
      default: ""
    },
    value: {
      type: String,
      default: "all"
    }
  },
  data() {
    return {
      scopes: null,
      selected: this.value || "all"
    }
  },
  watch: {
    selected() {
      this.$emit("input", this.selected)
      this.$emit("change", this.selected)
    }
  },
  methods: {
    loadScopes() {
      axios
        .get(`/one/resources/${this.resourceName}/scopes`)
        .then(({ data }) => {
          this.scopes = data
        }).catch(() => {
          this.scopes = []
        })
    }
  },
  mounted() {
    this.loadScopes()
  }
}
</script>

<style scoped>
</style>
