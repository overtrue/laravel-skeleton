<template>
  <div class="one-field one-field-number" v-if="editing">
    <el-input type="text" v-model.number="input" />
  </div>
  <div class="one-field one-field-number" v-else>{{ input }}</div>
</template>

<script>
import FormControl from "../../mixins/form-control"
export default {
  mixins: [FormControl]
}
</script>
