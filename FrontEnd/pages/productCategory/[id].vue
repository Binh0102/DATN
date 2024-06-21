<template>
  <div>
    <FormLoading v-if="load" />
    <div class="ml-6 pt-20 pb-10 text-2xl text-center uppercase">
      <h2 class="relative text-center font-bold mb-10 mt-5">
        <p class="absolute text-[130px] opacity-5 w-full leading-[90px]">Nike-SHOOP</p>
        <p class="text-[60px] text-[#006007] uppercase">{{ nameCategory.name }}</p>
      </h2>
    </div>
    <SliderProduct :products="products" />
  </div>
</template>

<script setup>
const product = useProductStore();
const category = useCategoryStore();
const route = useRoute();
onMounted(async () => {
  const id = route.params.id;
  await Promise.all([
    category.getNameCategory(id),
    ,
    delay(500).then(() => {
      load.value = false;
    }),
  ]);
});
const products = computed(() => product.producsCategoryList);
const nameCategory = computed(() => category.Category);
const an = () => {
  console.log(nameCategory);
};

const load = ref(true);
const delay = () =>
  new Promise((resolve) => {
    setTimeout(resolve, 3000);
  });
</script>

<style></style>
