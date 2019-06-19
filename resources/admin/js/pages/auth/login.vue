<template>
  <div :title="$t('login')">
    <h2 class="text-lg font-medium text-gray-700 mb-3">欢迎回来！</h2>
    <p class="text-gray-600 text-sm mb-6">请使用您的账号密码登录</p>

    <form
      @keydown="form.onKeydown($event)"
      @submit.prevent="login"
    >
      <!-- Email -->
      <div class="mb-6">
        <label class="text-sm font-bold">{{ $t('username') }}</label>
        <div class="my-2">
          <input
            :class="{ 'is-invalid': form.errors.has('username') }"
            class="form-input w-full"
            name="username"
            type="text"
            v-model="form.username"
          >
          <has-error
            :form="form"
            field="username"
          />
        </div>
      </div>

      <!-- Password -->
      <div class="mb-6">
        <label class="text-sm font-bold">{{ $t('password') }}</label>
        <div class="my-2">
          <input
            :class="{ 'is-invalid': form.errors.has('password') }"
            class="form-input w-full"
            name="password"
            type="password"
            v-model="form.password"
          >
          <has-error
            :form="form"
            field="password"
          />
        </div>
      </div>

      <!-- Remember Me -->
      <div class="flex items-center justify-between">
        <router-link
          :to="{ name: 'password.request' }"
          class="text-blue-600"
        >{{ $t('forgot_password') }}</router-link>
        <el-button
          :disabled="!formReady"
          :loading="form.busy"
          @click="login"
          class="outline-none focus:outline-shadow"
          type="primary"
        >{{ $t('login') }}</el-button>
      </div>
    </form>
  </div>
</template>

<script>
import Form from 'vform'

export default {
  middleware: 'guest',

  layout: 'auth',

  metaInfo() {
    return { title: this.$t('login') }
  },

  data: () => ({
    form: new Form({
      username: '',
      password: ''
    })
  }),

  computed: {
    formReady() {
      return this.form.username.length > 3 && this.form.password.length > 4
    }
  },

  methods: {
    async login() {
      let data = null
      try {
        let response = await this.form.post('/api/login')
        data = response.data
      } catch (error) {
        return this.$message.error(this.$i18n.t('invalid_username_or_password'))
      }

      // Save the token.
      this.$store.dispatch('auth/saveToken', {
        token: data.access_token,
        expires: data.expires_in
      })

      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      // Redirect home.
      this.$router.push({ name: 'home' })
    }
  }
}
</script>
