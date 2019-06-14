<template>
  <div :title="$t('your_password')">
    <form
      @keydown="form.onKeydown($event)"
      @submit.prevent="update"
    >
      <alert-success
        :form="form"
        :message="$t('password_updated')"
      />

      <!-- Password -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('new_password') }}</label>
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
          <v-button
            :loading="form.busy"
            type="success"
          >{{ $t('update') }}</v-button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import Form from 'vform'

export default {
  scrollToTop: false,

  metaInfo() {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      password: '',
      password_confirmation: ''
    })
  }),

  methods: {
    async update() {
      await this.form.patch('/api/settings/password')

      this.form.reset()
    }
  }
}
</script>
