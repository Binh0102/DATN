<template>
  <div>
    <SliderBanner />
    <h2 class="relative text-center font-bold mb-10 mt-5">
      <p class="absolute text-[130px] opacity-5 w-full leading-[90px]">Nike-SHOOP</p>
      <p class="text-[60px] text-[#006007] uppercase">Sản phẩm nổi bật</p>
    </h2>
    <SliderProduct :products="products" />
    <div class="mt-10 bg-[url('assets/images/nen.jpg')] bg-no-repeat bg-cover bg-center">
      <div class="bg-black bg-opacity-30 h-full w-full py-[30px]">
        <div class="flex w-[70%] mx-auto py-[30px]">
          <div class="w-1/2 px-[15px]">
            <div class="px-[50px]">
              <p class="text-[45px] text-white font-bold mb-6">
                NikeShoop - Thương hiệu bán giày chính hãng uy tin
              </p>
              <p class="text-white font-bold pb-5">
                NikeShoop là shop chuyên cung cấp và phân phối các mẫu giày đến từ các
                thương hiệu khác nhau, mang đến cho bạn da dạng sự lựa chọn, độ bền, độ uy
                tín khi sử dụng sản phẩm.
              </p>
              <button
                class="uppercase text-[#666] bg-white py-[5px] px-[30px] font-bold border leading-[38px]"
              >
                Tìm hiểu thêm
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <h2 class="relative text-center font-bold mb-10 mt-5">
      <p class="absolute text-[130px] opacity-5 w-full leading-[90px]">Nike-SHOOP</p>
      <p class="text-[60px] text-[#006007] uppercase">Sản phẩm ưu đãi</p>
    </h2>
    <SliderProduct class="pb-6" :products="productsSale" />
    <div class="text-center text-white pb-12">
      <NuxtLink to="/search">
        <button
          @click="an"
          class="border rounded-lg bg-[#3b0532] py-4 px-[50px] leading-[18px] uppercase"
        >
          Xem tất cả
        </button>
      </NuxtLink>
    </div>
  </div>
</template>

<script setup>
const product = useProductStore();
onMounted(async () => {
  await Promise.all([product.getProductSpecial(), product.getProductSale()]);
});
const products = computed(() => product.productsSpecialList);
const productsSale = computed(() => product.productsSaleList);
const an = () => {
  console.log(productsSale);
};
</script>

<style></style>
