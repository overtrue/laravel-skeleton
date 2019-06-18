<template>
  <div>
    <h2>Welcome !</h2>
    <div>{{ user.name }} {{ $t('you_are_logged_in') }}</div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  middleware: 'auth',

  computed: {
    ...mapGetters({ user: 'auth/user' })
  },

  metaInfo() {
    return { title: this.$t('home') }
  }
}
</script>
