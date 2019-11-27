<template>
  <div class="max-w-3xl mx-auto border bg-white relative">
    <el-page-header
      :content="title"
      @back="$router.back()"
      class="border-b pb-4 p-6"
      v-if="title"
    ></el-page-header>

    <div class="p-6 mb-16">
      <slot></slot>
    </div>

    <slot name="bar">
      <div class="flex items-center justify-between bg-white p-6 border-t sticky bottom-0 left-0">
        <el-button
          @click="$router.back()"
          icon="el-icon-back"
        >返回</el-button>
        <div>
          <el-button
            :disabled="!ready"
            @click="$emit('submit', true)"
            type="primary"
          >提交</el-button>
          <el-button
            :disabled="!ready"
            @click="$emit('submit', false)"
            plain
            type="primary"
            v-if="continueable"
          >提交并继续</el-button>
        </div>
      </div>
    </slot>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String
    },
    ready: {
      type: Boolean,
      default: false
    },
    continueable: {
      type: Boolean,
      default: false
    }
  }
}
</script>
