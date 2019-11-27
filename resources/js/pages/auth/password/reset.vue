<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="$t('reset_password')">
        <form
          @keydown="form.onKeydown($event)"
          @submit.prevent="reset"
        >
          <alert-success
            :form="form"
            :message="status"
          />

          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
            <div class="col-md-7">
              <input
                :class="{ 'is-invalid': form.errors.has('email') }"
                class="form-control"
                name="email"
                readonly
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

          <!-- Password Confirmation -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('confirm_password') }}</label>
            <div class="col-md-7">
              <input
                :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
                class="form-control"
                name="password_confirmation"
                type="password"
                v-model="form.password_confirmation"
              >
              <has-error
                :form="form"
                field="password_confirmation"
              />
            </div>
          </div>

          <!-- Submit Button -->
          <div class="form-group row">
            <div class="col-md-9 ml-md-auto">
              <v-button :loading="form.busy">{{ $t('reset_password') }}</v-button>
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

  layout: 'auth',

  metaInfo() {
    return { title: this.$t('reset_password') }
  },

  data: () => ({
    status: '',
    form: new Form({
      token: '',
      email: '',
      password: '',
      password_confirmation: ''
    })
  }),

  created() {
    this.form.email = this.$route.query.email
    this.form.token = this.$route.params.token
  },

  methods: {
    async reset() {
      const { data } = await this.form.post('/api/password/reset')

      this.status = data.status

      this.form.reset()
    }
  }
}
</script>
