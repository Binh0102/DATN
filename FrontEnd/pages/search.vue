<template>
  <div>
    <FormLoading v-if="load" />
    <div class="flex ml-6 py-10 text-2xl">
      <p>Trang chủ</p>
      <p>/ Tìm kiếm</p>
    </div>
    <div class="ml-6 text-xl pb-5">Tìm kiếm: {{ isSearch }}</div>
    <SliderProduct :products="filteredProducts" />
  </div>
</template>

<script setup>
const product = useProductStore();
const search = useSearch();
onMounted(() => {
  product.getProducts();
});
const isSearch = computed({
  get: () => search.getterSearch,
});
const products = computed({
  get: () => product.productsList,
});
const load = ref(false);
const delay = (ms) => {
  return new Promise((resolve) => setTimeout(resolve, ms));
};
const filteredProducts = computed(() => {
  if (!isSearch.value) {
    return products.value;
  }
  return products.value.filter((product) =>
    product.name.toLowerCase().includes(isSearch.value.value.toLowerCase())
  );
});
</script>

<style></style>
