<template>
  <div :title="$t('your_info')">
    <form
      @keydown="form.onKeydown($event)"
      @submit.prevent="update"
    >
      <alert-success
        :form="form"
        :message="$t('info_updated')"
      />

      <!-- Name -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
        <div class="col-md-7">
          <input
            :class="{ 'is-invalid': form.errors.has('name') }"
            class="form-control"
            name="name"
            type="text"
            v-model="form.name"
          >
          <has-error
            :form="form"
            field="name"
          />
        </div>
      </div>

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
import { mapGetters } from 'vuex'

export default {
  scrollToTop: false,

  metaInfo() {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      name: '',
      email: ''
    })
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  created() {
    // Fill the form with user data.
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key]
    })
  },

  methods: {
    async update() {
      const { data } = await this.form.patch('/api/settings/profile')

      this.$store.dispatch('auth/updateUser', { user: data })
    }
  }
}
</script>
