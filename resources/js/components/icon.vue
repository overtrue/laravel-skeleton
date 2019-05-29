<template>
  <span><i class="mdi" :class="'mdi-' + name"></i> <slot></slot></span>
</template>

<script>
  export default {
    props: {
      name: {
        type: String,
        required: true
      }
    }
  }
</script>
