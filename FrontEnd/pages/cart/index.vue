<template>
  <div class="bg-gray-100 py-8">
    <div class="w-5/6 mx-auto px-4">
      <div class="flex -ml-20 py-4">
        <NuxtLink to="/" class="text-xl mb-4 font-bold">Trang chủ</NuxtLink>
        <p class="text-xl mb-4">/ Giỏ Hàng</p>
      </div>
      <div class="flex gap-4 w-full">
        <div class="w-[75%]">
          <div v-if="!carts.length" class="text-center">
            <p class="uppercase font-bold">"Chưa có sản phẩm nào trong giỏ hàng "</p>
            <NuxtLink to="/">
              <button class="mt-4 px-4 py-2 bg-green-500 border rounded-xl">
                Về trang chủ
              </button>
            </NuxtLink>
          </div>
          <div
            class="bg-white rounded-lg shadow-md p-6 mb-4 max-h-[430px] overflow-y-auto"
            v-if="carts.length"
          >
            <table class="w-full">
              <thead>
                <tr>
                  <th class="text-left st">
                    <input
                      id="default-checkbox"
                      type="checkbox"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                      @change="selectAll()"
                      v-model="isCheckedAll"
                    />
                  </th>
                  <th class="text-left">Hình ảnh</th>
                  <th class="text-left">Tên sản phẩm</th>
                  <th class="text-left">Màu sắc</th>
                  <th class="text-left">Giá</th>
                  <th class="text-left">Số lượng</th>
                  <th class="text-left">Thành tiền</th>
                  <th class="text-left"><span class="hidden">action</span></th>
                </tr>
              </thead>
              <tbody>
                <tr class="border-b" v-for="item in carts" :key="item.id">
                  <td class="py-4">
                    <input
                      type="checkbox"
                      :value="item.id"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                      @change="selectProduct($event.target.checked, item)"
                    />
                  </td>
                  <td class="py-4">
                    <div class="flex items-center">
                      <img class="h-16 w-16 mr-4" :src="item.image" alt="Product image" />
                    </div>
                  </td>
                  <td>{{ item.name }}</td>
                  <td class="flex items-center h-[95px]">
                    <p>{{ item.color }}</p>
                  </td>
                  <td class="py-4">{{ formatCurrency(item.price) }}</td>
                  <td class="py-4">
                    <div class="flex items-center">
                      <button
                        class="border rounded-md py-2 px-4 mr-2"
                        @click="decreaseQuantity(item.id)"
                      >
                        -
                      </button>
                      <span class="text-center w-8">{{ quantities[item.id] || 1 }}</span>
                      <button
                        class="border rounded-md py-2 px-4 ml-2"
                        @click="increaseQuantity(item.id)"
                      >
                        +
                      </button>
                    </div>
                  </td>
                  <td class="py-4">
                    {{ formatCurrency(item.price * quantities[item.id] || item.price) }}
                  </td>
                  <td class="py-4" @click="(deleteProduct = true), (id = item.id)">
                    <button>
                      <Icon name="mdi:delete" size="24" color="red" />
                    </button>
                  </td>
                </tr>
                <!-- More product rows -->
              </tbody>
            </table>
          </div>
        </div>
        <div class="w-1/4">
          <div class="bg-white rounded-lg shadow-md p-6 min-h-[400px]">
            <h2 class="text-2xl mb-4 font-bold text-center mt-5 pb-5">Thanh toán</h2>
            <div class="flex justify-between py-2">
              <span>Tổng tiền</span>
              <span>{{ formatCurrency(totalPrice) }}</span>
            </div>
            <div class="flex justify-between py-2">
              <span>Phí ship</span>
              <span>{{ formatCurrency(totalPrice * 0.03) }}</span>
            </div>
            <hr class="py-2" />
            <div class="flex justify-between py-2">
              <span class="">Thành tiền</span>
              <span class="">{{ formatCurrency(totalPrice + totalPrice * 0.03) }}</span>
            </div>
            <button
              @click="checkout"
              :disabled="selectProducts.length == 0"
              :class="{ 'opacity-50': selectProducts.length == 0 }"
              class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full flex justify-center"
            >
              Thanh toán
            </button>
          </div>
        </div>
      </div>
      <FormDeleteCart
        :id="id"
        :deleteProduct="deleteProduct"
        @close="close"
        @update="update"
      />
    </div>
  </div>
</template>

<script setup>
const deleteProduct = ref(false);
const id = ref(null);
const load = ref(true);
const quantities = ref([]);
const selectProducts = ref([]);
const ship = ref(0);
const cart = useCartStore();
const auth = useAuthStore();
const route = useRouter();
const checkout = async () => {
  await cart.checkout(selectProducts, quantities);
  route.push("/cart/checkout");
};
onMounted(async () => {
  await Promise.all([auth.info(), cart.getCarts()]);

  await delay(500).then(() => {
    load.value = false;
  });
});
const delay = (ms) => {
  return new Promise((resolve) => setTimeout(resolve, ms));
};
const carts = computed(() => cart.cartsList);
const formatCurrency = (value) => {
  const formatter = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  });
  return formatter.format(value);
};
const increaseQuantity = (id) => {
  if (!quantities.value[id]) {
    quantities.value[id] = 1;
  }
  quantities.value[id]++;
};

const decreaseQuantity = (id) => {
  if (quantities.value[id] > 1) {
    quantities.value[id]--;
  }
};
const totalPrice = computed(() => {
  let total = 0;
  for (let i = 0; i < selectProducts.value.length; i++) {
    let cartItem = selectProducts.value[i];
    let quantity = quantities.value[cartItem.id] || 1;
    total += selectProducts.value[i].price * quantity;
  }
  return total;
});

const close = () => {
  deleteProduct.value = false;
};
const update = () => {
  cart.getCarts(auth.User.id);
};
const selectProduct = (checked, product) => {
  if (checked) {
    selectProducts.value.push(product);
  } else {
    const index = selectProducts.value.findIndex((item) => item.id === product.id);
    if (index !== -1) {
      selectProducts.value.splice(index, 1);
    }
  }
  console.log(isCheckedAll.value);
};
const isCheckedAll = computed(() => {
  return selectProducts.value.length === carts.value.length;
});

const selectAll = async () => {
  if (isCheckedAll.value) {
    selectProducts.value = [];
    selectProducts.value = carts.value;
  } else {
    selectProducts.value = [];
  }
};
</script>

<style></style>
