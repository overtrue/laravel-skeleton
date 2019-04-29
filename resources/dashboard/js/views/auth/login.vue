<template>
  <div class="auth-page login d-flex justify-content-center align-items-center h-85">
    <el-card shadow="never">
      <div slot="header" class="text-center">管理中心</div>
      <el-form class="p-2">
        <el-form-item>
          <el-input autocomplete="on">
            <i class="mdi mdi-account" slot="prefix"></i>
          </el-input>
        </el-form-item>
        <el-form-item>
          <el-input type="password" autocomplete="off">
            <i class="mdi mdi-lock" slot="prefix"></i>
          </el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" plain class="d-block w-100">登录</el-button>
        </el-form-item>
      </el-form>
    </el-card>
  </div>
  </div>
</template>

<script>
  export default {
    name: 'login'
  }
</script>

<style scoped lang="scss">
  .el-form {
    width: 300px;

    .el-input--prefix .el-input__inner {
      padding-left: 50px;
    }
  }

  .mdi {
    width: 30px;
    display: block;
  }
</style>
