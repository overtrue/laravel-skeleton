<template>
  <FormPage
    :ready="formReady"
    :title="isEditing ? '编辑用户' : '新建用户'"
    @submit="leave => leave ? handleSubmitAndBack() : handleSubmit()"
    continueable
  >
    <el-form
      :model="user"
      label-position="top"
      ref="form"
      v-if="user"
      v-loading="loading"
    >
      <el-form-item
        :rules="[{required: true, message: '登录账号不能为空'}]"
        class="w-1/2"
        label="登录账号"
      >
        <el-input
          maxlength="12"
          placeholder="5-12位英文数字字母组合"
          v-model="user.username"
        ></el-input>
      </el-form-item>
      <el-form-item
        :rules="[{required: true, message: '真实姓名不能为空'}]"
        class="w-1/2"
        label="真实姓名"
      >
        <el-input
          placeholder="真实姓名"
          v-model="user.real_name"
        ></el-input>
      </el-form-item>
      <el-form-item
        class="w-1/2"
        label="手机号"
      >
        <el-input
          :rules="[{required: true, message: '密码不能为空'}]"
          maxlength="11"
          placeholder="11位手机号码"
          v-model.number="user.phone"
        ></el-input>
      </el-form-item>
      <el-form-item
        class="w-1/2"
        label="性别"
      >
        <el-select
          placeholder="请选择性别"
          v-model="user.gender"
        >
          <el-option
            label="女"
            value="female"
          ></el-option>
          <el-option
            label="男"
            value="male"
          ></el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="管理员">
        <el-radio-group v-model="user.is_admin">
          <el-radio :label="true">是</el-radio>
          <el-radio :label="false">否</el-radio>
        </el-radio-group>
      </el-form-item>

      <div class="pb-1 mb-2 border-b pb-4 mb-4">{{ isEditing ? '修改密码' : '登录密码' }}</div>
      <el-form-item
        :rules="[isEditing ? {} : { required: true, message: '密码不能为空'}]"
        class="w-1/2"
        label="登录密码"
      >
        <el-input
          maxlength="14"
          placeholder="6-14位密码"
          type="password"
          v-model="user.password"
        ></el-input>
      </el-form-item>
      <el-form-item
        :rules="[isEditing ? {} : { required: true, message: '密码不能为空'}]"
        class="w-1/2"
        label="确认密码"
      >
        <el-input
          maxlength="14"
          placeholder="再次输入上面的密码"
          type="password"
          v-model="user.password_confirmation"
        ></el-input>
      </el-form-item>
      <el-form-item
        :rules="[isEditing ? {} : { required: true, message: '密码不能为空'}]"
        class="w-1/2"
        label="确认密码"
      >
        <el-input
          maxlength="14"
          placeholder="再次输入上面的密码"
          type="password"
          v-model="user.password_confirmation"
        ></el-input>
      </el-form-item>
      <el-form-item
        :rules="[isEditing ? {} : { required: true, message: '密码不能为空'}]"
        class="w-1/2"
        label="确认密码"
      >
        <el-input
          maxlength="14"
          placeholder="再次输入上面的密码"
          type="password"
          v-model="user.password_confirmation"
        ></el-input>
      </el-form-item>
      <el-form-item
        :rules="[isEditing ? {} : { required: true, message: '密码不能为空'}]"
        class="w-1/2"
        label="确认密码"
      >
        <el-input
          maxlength="14"
          placeholder="再次输入上面的密码"
          type="password"
          v-model="user.password_confirmation"
        ></el-input>
      </el-form-item>
      <el-form-item
        :rules="[isEditing ? {} : { required: true, message: '密码不能为空'}]"
        class="w-1/2"
        label="确认密码"
      >
        <el-input
          maxlength="14"
          placeholder="再次输入上面的密码"
          type="password"
          v-model="user.password_confirmation"
        ></el-input>
      </el-form-item>
    </el-form>
  </FormPage>
</template>

<script>
export default {
  name: 'users.form',
  data() {
    return {
      loading: false,
      user: {
        username: '',
        real_name: '',
        password: '',
        password_confirmation: '',
        gender: 'female',
        is_admin: false
      }
    }
  },
  computed: {
    isEditing() {
      return this.$route.name === 'users.edit'
    },
    formReady() {
      let basicFieldIsReady =
        this.user.real_name &&
        this.user.real_name.length >= 2 &&
        this.user.username.length > 4

      if (this.isEditing) {
        return !!basicFieldIsReady
      }

      return (
        basicFieldIsReady &&
        this.user.password > 5 &&
        this.user.password_confirmation.length === this.user.password.length
      )
    }
  },
  methods: {
    loadUser() {
      this.loading = true
      this.$resources.users
        .find(this.$route.params.id)
        .then(user => (this.user = user))
        .then(() => (this.loading = false))
    },
    handleSubmit() {
      this.loading = true
      let promise = this.isEditing
        ? this.$resources.users.update(this.$route.params.id, this.user)
        : this.$resources.users.store(this.user)
      return promise
        .then(() => {
          this.$message.success('已保存')
        })
        .finally(() => (this.loading = false))
    },
    handleSubmitAndBack() {
      this.handleSubmit().then(() => {
        setTimeout(() => {
          this.$router.back()
        }, 600)
      })
    }
  },
  mounted() {
    this.isEditing && this.loadUser()
  }
}
</script>

<style scoped>
</style>
