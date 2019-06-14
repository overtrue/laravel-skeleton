<template>
  <div class="text-center">
    <h3 class="mb-4 text-4xl font-bold">{{ $t('page_not_found') }}</h3>

    <div class="links">
      <router-link
        :to="{ name: 'home' }"
        class="text-blue-600"
      >{{ $t('go_home') }}</router-link>
    </div>
  </div>
</template>

<script>
export default {
  layout: 'basic'
}
</script>
