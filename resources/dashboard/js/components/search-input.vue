<template>
  <form class="subnav-search">
    <el-input v-model="input" :placeholder="placeholder" suffix-icon="el-icon-search"></el-input>
  </form>
</template>
<script>
import FormControl from "../mixins/form-control";
export default {
  mixins: [FormControl],
}
</script>
