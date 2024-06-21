<template>
  <div class="bg-[#F3F4F6]">
    <FormLoading v-if="load" />
    <div class="fixed top-0 w-full z-10">
      <DefaultHeader />
    </div>
    <div class="mt-[64px]">
      <slot />
    </div>
    <DefaultFooter />
  </div>
</template>
<script setup>
</script>
