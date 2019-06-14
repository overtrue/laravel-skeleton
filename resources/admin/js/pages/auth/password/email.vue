<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="$t('reset_password')">
        <form
          @keydown="form.onKeydown($event)"
          @submit.prevent="send"
        >
          <alert-success
            :form="form"
            :message="status"
          />

          <!-- Email -->
          <div class="mb-6">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
            <div class="col-md-7">
              <input
                :class="{ 'is-invalid': form.errors.has('email') }"
                class="form-input my-2 w-full"
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

          <!-- Submit Button -->
          <el-button
            :loading="form.busy"
            class="w-full"
          >{{ $t('send_password_reset_link') }}</el-button>
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
      email: ''
    })
  }),

  methods: {
    async send() {
      const { data } = await this.form.post('/api/password/email')

      this.status = data.status

      this.form.reset()
    }
  }
}
</script>
