<template>
  <div class="pb-16">
    <div class="max-w-3xl mx-auto border bg-white">
      <el-page-header
        :content="title"
        @back="$router.back()"
        class="border-b pb-4 p-6"
        v-if="title"
      ></el-page-header>

      <div class="p-6">
        <slot></slot>
      </div>
    </div>
    <div class="fixed bottom-0 p-4 bg-white right-0 left-0 ml-64 shadow">
      <div class="max-w-3xl mx-auto">
        <slot name="bar">
          <div class="flex items-center justify-between">
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
    </div>
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
