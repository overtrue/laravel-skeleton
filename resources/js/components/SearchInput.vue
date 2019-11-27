<template>
  <form>
    <el-input
      :placeholder="placeholder"
      suffix-icon="el-icon-search"
      v-model="input"
    ></el-input>
  </form>
</template>
<script>
export default {
  props: {
    value: {
      type: null
    },
    placeholder: String
  },
  data() {
    return {
      input: this.value
    }
  },
  watch: {
    input() {
      this.$emit('input', this.input)
      this.$emit('change', this.input)
    }
  }
}
</script>
