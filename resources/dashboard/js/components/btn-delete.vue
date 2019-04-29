<template>
  <el-popover placement="top" v-model="deleteDialogVisible">
    <div class="text-center">确定删除？</div>
    <div class="text-center mt-2">
      <el-button size="mini" plain @click="deleteDialogVisible = false">取消</el-button>
      <el-button type="danger" size="mini" @click="onConfirmDelete">确定</el-button>
    </div>
    <template slot="reference">
      <slot>
        <el-button plain class="mt-1">删除</el-button>
      </slot>
    </template>
  </el-popover>
</template>

<script>
export default {
  data() {
    return {
      deleteDialogVisible: false
    }
  },
  methods: {
    onConfirmDelete() {
      this.deleteDialogVisible = false
      this.$emit("confirmed")
    }
  }
}
</script>
