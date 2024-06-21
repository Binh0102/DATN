<template>
  <div class="relative w-max" ref="dropdown">
    <div
      @mouseenter="isMenuOpen = true"
      @mouseleave="isMenuOpen = false"
      @focus="isFocused = true"
      @blur="isFocused = false"
      class="flex hover:cursor-pointer"
    >
      <p>{{ name }}</p>
      <div class="">
        <Icon name="mdi:chevron-down" size="24" />
      </div>
    </div>
    <Transition>
      <div
        v-if="isMenuOpen || isMouseInDropdown || isFocused"
        @mouseenter="isMouseInDropdown = true"
        @mouseleave="isMouseInDropdown = false"
        class="absolute w-full max-h-[165px] overflow-auto z-10 bg-white border-x border-b border-[#0000001A]"
      >
        <div
          v-for="item in search"
          :key="item"
          @click="(dataComputed = item), (isMenuOpen = false)"
          class="text-[16px] p-[15px] border-b border-[#0000001A] hover:bg-gray-200 hover:cursor-pointer"
        >
          {{ item }}
        </div>
      </div>
    </Transition>
  </div>
</template>

<script setup>
const props = defineProps(["name", "input", "items"]);
const emit = defineEmits(["update:input"]);
const { name, input, items } = toRefs(props);
const isMenuOpen = ref(false);
const isFocused = ref(false);
const isMouseInDropdown = ref(false);
const dataComputed = computed({
  get: () => input.value,
  set: (val) => emit("update:input", val),
});
const search = computed(() => {
  if (!dataComputed.value) {
    return items.value;
  }
  const query = dataComputed.value.toLowerCase();
  return items.value.filter((item) => item.toLowerCase().includes(query));
});
const handleClickOutside = (event) => {
  if (dropdown.value && !dropdown.value.contains(event.target) && !isFocused.value) {
    closeMenu();
  }
};

watch(isMenuOpen, (newValue) => {
  if (newValue) {
    document.addEventListener("click", handleClickOutside);
  } else {
    document.removeEventListener("click", handleClickOutside);
  }
});
</script>

<style></style>
