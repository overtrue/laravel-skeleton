<template>
  <div class="one-field one-field-text" v-if="editing">
    <el-input type="text" v-model="input" :placeholder="placeholder" />
  </div>
  <div class="one-field one-field-text" v-else>{{ input }}</div>
</template>

<script>
import FormControl from "../../mixins/form-control"
export default {
  mixins: [FormControl]
}
</script>
