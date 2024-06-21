<template>
  <div class="bg-[#F3F4F6]">
    <div class="fixed top-0 w-full z-10">
      <DefaultHeader />
    </div>
    <div class="mt-[64px]">
      <div class="flex h-full bg-gray-200">
        <FormNarbar />
        <div class="flex flex-col flex-1">
          <slot />
        </div>
      </div>
    </div>
    <DefaultFooter />
  </div>
</template>
<script setup></script>
