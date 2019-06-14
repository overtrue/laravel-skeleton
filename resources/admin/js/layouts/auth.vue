<template>
  <div class="flex flex-col h-screen items-center justify-center">
    <div class="background-inherit max-w-sm w-full mb-2 mt-6 mx-4">
      <div class="background-inherit flex items-center pb-3 pt-6 px-1">
        <div class="w-2/3 text-xl">{{ $metaInfo.title }}</div>
        <div class="w-1/3 text-right"></div>
      </div>
    </div>
    <div class="w-full mb-32 mx-8 md:mx-0 md:w-1/2 lg:w-1/4 max-w-sm xl:1/5 bg-white border p-6 shadow-xl rounded">
      <router-view/>
    </div>
  </div>
</template>

<script>
export default {
  metaInfo() {
    const { appName } = window.config

    return {
      title: appName,
      titleTemplate: `%s · ${appName}`
    }
  }
}
</script>
