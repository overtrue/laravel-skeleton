<template>
  <el-button plain :type="type" :class="{'only-icon': !label}" :size="size" @click="$router.push({name: 'one.items.create', params: $props})">
    <slot><o-icon name="plus" /> <span v-if="label"> {{ label }}</span></slot>
  </el-button>
</template>

<script>
  export default {
    props: {
      resourceName: {
        required: true
      },
      label: String,
      type: {
        type: String,
        default: 'primary'
      },
      size: {
        type: String,
        default: 'default'
      },
    }
  }
</script>
