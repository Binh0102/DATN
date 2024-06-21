<template>
  <div class="relative w-full">
    <div
      @click="isMenuOpen = !isMenuOpen"
      class="w-full flex items-center justify-between border border-[#0000001A] rounded leading-[19.36px]"
    >
      <input
        type="text"
        v-model="dataComputed"
        :placeholder="placeholder"
        class="h-[50px] w-full ps-3 rounded pe-8 focus:outline-none"
        @blur="isMenuOpen = false"
      />

      <div class="absolute right-3">
        <img
          src="~/assets/images/down-arrow 1.png"
          width="16px"
          class="transition duration-700"
          :class="isMenuOpen ? 'rotate-180' : ''"
        />
      </div>
    </div>
    <span v-if="error" class="text-red-500 text-[14px]">
      {{ error }}
    </span>
    <Transition>
      <div
        v-if="isMenuOpen"
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
const props = defineProps(["placeholder", "error", "input", "items"]);
const emit = defineEmits(["update:input"]);
const { placeholder, error, input, items } = toRefs(props);
const isMenuOpen = ref(false);
const dataComputed = computed({
  get: () => input.value,
  set: (val) => emit("update:input", val),
});
const an = () => {
  console.log(items.value);
};
const search = computed(() => {
  if (!dataComputed.value) {
    return items.value;
  }
  const query = dataComputed.value.toLowerCase();
  return items.value.filter((item) => item.toLowerCase().includes(query));
});