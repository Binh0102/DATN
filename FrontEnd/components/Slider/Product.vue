<template>
  <div class="flex flex-wrap">
    <div v-for="i in products" :key="i" class="w-1/4">
      <div class="mx-[15px] drop-shadow">
        <div class="relative">
          <NuxtLink :to="'/detail/' + i.id">
            <img class="container rounded-t-lg w-[350] h-[350]" :src="i.image" alt="" />
          </NuxtLink>
        </div>
        <div class="mb-[14px] pb-4 rounded-b-xl shadow-md">
          <NuxtLink :to="'/detail/' + i.id">
            <p class="pl-2.5 pt-2.5 text-sm pr-[90px]">{{ i.name }}</p>
          </NuxtLink>
          <div class="inline-flex w-full">
            <div class="w-full">
              <p class="pl-2.5 text-[12px] line-through text-[#ACACAC]">
                {{ formatCurrency(i.price) }}
              </p>
              <p class="pl-2.5 text-sm text-[#AB1515]">
                {{ formatCurrency(discounted(i.price, i.discount)) }}
              </p>
            </div>
            <div class="pr-4">
              <button
                class="flex justify-center items-center rounded-full h-10 w-10 bg-[#007006]"
                @click="addToCart(i)"
              >
                <Icon name="mdi:cart-outline" size="20" color="white" />
              </button>
            </div>
          </div>
          <div class="flex justify-between mt-3">
            <div class="flex ml-2">
              <Icon name="mdi:star" size="15" color="yellow" v-for="i in 5" :key="i" />
            </div>
            <p class="text-[12px] mr-5">
              Đã bán <span>{{ i.sold }}</span>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const formatCurrency = (value) => {
  const formatter = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  });
  return formatter.format(value);
};

const cart = ref({
  product_id: null,
  color: null,
});
const axios = useCartStore();
const route = useRouter();
const addToCart = async (item) => {
  cart.value.product_id = item.id;
  cart.value.color = item.color;
  await axios.addToCart(cart.value);
  console.log(axios.Message);
  if (axios.Message == 401) {
    alert("Bạn chưa đăng nhập");
    route.push("/login");
  }
  if (axios.Message == 409) {
    alert("Sản phẩm đã tồn tại");
  } else {
    alert("Thêm sản phẩm thành công");
  }
};

const discounted = (price, discount) => {
  if (discount == 0) {
    return price;
  } else {
    return price - (price * discount) / 100;
  }
};
const props = defineProps(["products"]);
const { products } = toRefs(props);
</script>
<style>
.swiper-button-disabled {
  display: none;
}
</style>
