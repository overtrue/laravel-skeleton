<template>
  <el-button plain :type="type" :class="{'only-icon': !label}" :size="size"  @click="$router.push({name: 'one.items.edit', params: $props})">
    <slot><o-icon name="pencil" /><span v-if="label"> {{ label }}</span></slot>
  </el-button>
</template>

<script>
  export default {
    props: {
      resourceId: {
        required: true
      },
      resourceName: {
        required: true
      },
      label: String,
      type: {
        type: String,
        default: ''
      },
      size: {
        type: String,
        default: 'default'
      },
    }
  }
</script>
