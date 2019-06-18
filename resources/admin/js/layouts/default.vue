<template>
  <div class="flex items-stretch min-h-screen">
    <sidebar></sidebar>
    <div class="flex-1 overflow-hidden">
      <navbar/>

      <div class="px-6 py-4">
        <child/>
      </div>
    </div>
  </div>
</template>
