<template>
  <div class="flex h-full bg-gray-200">
    <Formloading />
    <AdminNavbar :isNavbar="isNavbar" />
    <div
      :class="isNavbar ? '' : '-translate-x-[265px] ease-in -mr-[265px]'"
      class="flex flex-col flex-1"
    >
      <AdminHeader v-on:data="handleData" />
      <slot />
    </div>
  </div>
</template>

<script setup>
const isNavbar = ref(true);
const handleData = (data) => {
  isNavbar.value = data;
  console.log(data);
  return isNavbar;
};
</script>
