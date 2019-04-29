<template>
  <div class="one-field one-field-passowrd" v-if="editing">
    <el-input type="password" v-model="input" :placeholder="placeholder" />
  </div>
  <div class="one-field one-field-passowrd" v-else>******</div>
</template>

<script>
import FormControl from "../../mixins/form-control"
export default {
  mixins: [FormControl]
}
</script>
