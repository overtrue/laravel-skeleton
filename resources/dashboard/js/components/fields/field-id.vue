<template>
  <div class="one-field one-field-id" v-if="editing">
    <el-input type="text" v-model="input" :readonly="!field.editable" />
  </div>
  <div class="one-field one-field-id" v-else>{{ input }}</div>
</template>

<script>
import FormControl from "../../mixins/form-control"
export default {
  mixins: [FormControl]
}
</script>
