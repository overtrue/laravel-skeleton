<template>
  <el-popover
    placement="top"
    v-model="deleteDialogVisible"
  >
    <div class="text-center">确定删除？</div>
    <div class="text-center mt-2">
      <el-button
        @click="deleteDialogVisible = false"
        size="mini"
        type="text"
      >取消</el-button>
      <el-button
        @click="handleConfirmed"
        size="mini"
        type="danger"
      >确定</el-button>
    </div>
    <el-button
      :plain="plain"
      :size="size"
      :type="type"
      slot="reference"
    >删除</el-button>
  </el-popover>
</template>

<script>
export default {
  props: {
    type: { type: String, default: 'danger' },
    size: { type: String, default: undefined },
    plain: {
      type: Boolean,
      default: true
    }
  },
  data() {
    return {
      deleteDialogVisible: false
    }
  },
  methods: {
    handleConfirmed() {
      this.deleteDialogVisible = false
      this.$emit('confirmed')
    }
  }
}
</script>
