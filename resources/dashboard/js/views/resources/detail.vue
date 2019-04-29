<template>
  <div class="resource-example">
    <o-resource-detail :resource-name="resourceName" :resource-id="resourceId"></o-resource-detail>
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
      }
    }
  }
</script>

<style scoped>

</style>
