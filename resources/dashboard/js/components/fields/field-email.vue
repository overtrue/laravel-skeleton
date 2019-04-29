<template>
  <div class="one-field one-field-email" v-if="editing">
    <el-input type="email" v-model="input" :placeholder="placeholder" />
  </div>
  <div class="one-field one-field-email" v-else>{{ input }}</div>
</template>

<script>
import FormControl from "../../mixins/form-control"
export default {
  mixins: [FormControl]
}
</script>
