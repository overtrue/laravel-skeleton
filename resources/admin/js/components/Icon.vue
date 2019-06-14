<template>
  <span>
    <i
      :class="'mdi-' + name"
      class="mdi"
    ></i>
    <slot></slot>
  </span>
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
