<template>
  <div>
    <o-resource-table :resource-name="resourceName"></o-resource-table>
  </div>
</template>

<script>
  export default {
    name: 'resource-page-index',
    props: {
      resourceName: {
        required: true
      }
    }
  }
</script>

<style scoped>

</style>
