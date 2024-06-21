<template>
  <div class="bg-gray-100 py-8">
    <div class="w-5/6 mx-auto px-4">
      <div class="flex -ml-20 py-4">
        <NuxtLink to="/" class="text-xl mb-4 font-bold">Trang chủ</NuxtLink>
        <p class="text-xl mb-4">/ Sản phẩm yêu thích</p>
      </div>
      <div class="flex gap-4 w-full">
        <div class="w-[75%] mx-auto">
          <div v-if="!favorites.length" class="text-center">
            <p class="uppercase font-bold">"Chưa có sản phẩm nào trong giỏ "</p>
            <NuxtLink to="/">
              <button class="mt-4 px-4 py-2 bg-green-500 border rounded-xl">
                Về trang chủ
              </button>
            </NuxtLink>
          </div>
          <div
            class="bg-white rounded-lg shadow-md p-6 mb-4 max-h-[360px] overflow-y-auto"
            v-if="favorites.length"
          >
            <table class="w-full">
              <thead>
                <tr>
                  <th class="text-left">Hình ảnh</th>
                  <th class="text-left">Tên sản phẩm</th>
                  <th class="text-left">Giá</th>
                  <th class="text-left">Hành động</th>
                  <th class="text-left"><span class="hidden">action</span></th>
                </tr>
              </thead>
              <tbody>
                <tr class="border-b" v-for="item in favorites" :key="item.id">
                  <td class="py-4">
                    <div class="flex items-center">
                      <img class="h-16 w-16 mr-4" :src="item.image" alt="Product image" />
                    </div>
                  </td>
                  <td>{{ item.name }}</td>
                  <td class="py-4">{{ formatCurrency(item.price) }}</td>

                  <td class="py-4">
                    <button @click="addToCart(item)">
                      <Icon name="mdi:cart-outline" size="24" color="green" />
                    </button>
                    <button class="ml-6" @click="(deleteFavorite = true), (id = item.id)">
                      <Icon name="mdi:delete" size="24" color="red" />
                    </button>
                  </td>
                </tr>
                <!-- More product rows -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <FormDeleteFavorite
        :id="id"
        :deleteFavorite="deleteFavorite"
        @close="close"
        @update="update"
      />
    </div>
  </div>
</template>

<script setup>
const deleteFavorite = ref(false);
const id = ref(null);
const load = ref(true);
const favorite = useFavoriteStore();
const auth = useAuthStore();
const cart = useCartStore();
onMounted(async () => {
  await Promise.all([auth.info(), favorite.getFavorites()]);
  await delay(500).then(() => {
    load.value = false;
  });
});
const delay = (ms) => {
  return new Promise((resolve) => setTimeout(resolve, ms));
};
const favorites = computed(() => favorite.favoriteList);
const formatCurrency = (value) => {
  const formatter = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  });
  return formatter.format(value);
};
const cartItem = ref({
  product_id: null,
  color: null,
});
const addToCart = (favorite) => {
  (cartItem.value.product_id = favorite.product_id),
    (cartItem.value.color = favorite.color),
    cart.addToCart(cartItem.value);
  if (cart.Message == 409) {
    alert("Sản phẩm đã tồn tại");
  } else {
    alert("Thêm sản phẩm thành công");
  }
};
const close = () => {
  deleteFavorite.value = false;
};
const update = () => {
  favorite.getFavorites();
};
</script>

<style></style>
