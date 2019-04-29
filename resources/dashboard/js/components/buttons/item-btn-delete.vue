<template>
  <btn-delete @confirmed="handleDelete">
    <el-button plain :type="type" :class="{'only-icon': !label}" :size="size">
      <slot>
        <o-icon name="delete" /><span v-if="label">{{ label }}</span></slot>
    </el-button>
  </btn-delete>
</template>

<script>
import BtnDelete from "../btn-delete"
export default {
  components: { BtnDelete },
  props: {
    label: String,
    resourceId: {
      required: true
    },
    resourceName: {
      required: true
    },
    type: {
      type: String,
      default: "danger"
    },
    size: {
      type: String,
      default: "default"
    }
  },
  methods: {
    handleDelete() {
      axios
        .delete(`/one/items/${this.resourceName}/${this.resourceId}`)
        .then(() => {
          this.$emit("deleted")
          console.log("deleted")
        })
    }
  }
}
</script>
