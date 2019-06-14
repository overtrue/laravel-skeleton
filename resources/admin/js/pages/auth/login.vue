<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="$t('login')">
        <form
          @keydown="form.onKeydown($event)"
          @submit.prevent="login"
        >
          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
            <div class="col-md-7">
              <input
                :class="{ 'is-invalid': form.errors.has('email') }"
                class="form-control"
                name="email"
                type="email"
                v-model="form.email"
              >
              <has-error
                :form="form"
                field="email"
              />
            </div>
          </div>

          <!-- Password -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('password') }}</label>
            <div class="col-md-7">
              <input
                :class="{ 'is-invalid': form.errors.has('password') }"
                class="form-control"
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
          <div class="form-group row">
            <div class="col-md-3"/>
            <div class="col-md-7 d-flex">
              <checkbox
                name="remember"
                v-model="remember"
              >{{ $t('remember_me') }}</checkbox>

              <router-link
                :to="{ name: 'password.request' }"
                class="small ml-auto my-auto"
              >{{ $t('forgot_password') }}</router-link>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button :loading="form.busy">{{ $t('login') }}</v-button>
            </div>
          </div>
        </form>
      </card>
    </div>
  </div>
</template>

<script>
import Form from 'vform'

export default {
  middleware: 'guest',

  metaInfo() {
    return { title: this.$t('login') }
  },

  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
    remember: false
  }),

  methods: {
    async login() {
      // Submit the form.
      const { data } = await this.form.post('/api/login')

      // Save the token.
      this.$store.dispatch('auth/saveToken', {
        token: data.token,
        remember: this.remember
      })

      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      // Redirect home.
      this.$router.push({ name: 'home' })
    }
  }
}
</script>
