<template>
  <el-pagination
    :page-count="items.meta.last_page"
    :page-size="parseInt(items.meta.per_page)"
    :page-sizes="[20, 50, 100, 200, 300, 400]"
    :total="items.meta.total"
    @current-change="page => $emit('change', page)"
    @size-change="size => $emit('sizeChange', size)"
    background
    layout="total, sizes, prev, pager, next, jumper"
  ></el-pagination>
</template>

<script>
export default {
  props: {
    items: {
      type: Object,
      required: true
    }
  }
}
</script>

<style>
</style>
