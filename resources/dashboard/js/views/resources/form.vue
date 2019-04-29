<template>
  <div class="resource-form">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h2 class="mb-0">编辑 {{ resourceName }} </h2>
      <o-back />
    </div>
    <o-resource-form :resource-name="resourceName" :resource-id="resourceId"></o-resource-form>
  </div>
</template>

<script>
export default {
  props: {
    resourceName: {
      required: true
    },
    resourceId: {
      required: false
    }
  }
}
</script>

<style scoped>
.resource-form {
  max-width: 980px;
  margin-left: auto;
  margin-right: auto;
}
</style>
