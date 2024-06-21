<template>
  <div class="containser mx-auto p-4">
    <div class="grid grid-cols-2 gap-8">
      <div>
        <div class="mb-4">
          <NuxtLink to="/cart" class="text-blue-500 flex underline items-center">
            <Icon name="mdi:arrow-left" />
            <p>Trở về</p>
          </NuxtLink>
          <h1 class="text-2xl font-bold text-center">Danh sách đơn hàng</h1>
        </div>
        <div class="bg-white shadow-md rounded-lg p-4">
          <table class="w-full">
            <thead>
              <tr>
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
                    <span class="text-center w-8">{{ quantities[item.id] || 1 }}</span>
                  </div>
                </td>
                <td class="py-4">
                  {{ formatCurrency(item.price * quantities[item.id] || item.price) }}
                </td>
              </tr>
              <!-- More product rows -->
            </tbody>
          </table>
        </div>
      </div>
      <div class="bg-white shadow-md rounded-lg p-6 ml-6">
        <h1 class="text-2xl font-bold mb-6">Thanh toán</h1>
        <form>
          <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="col-span-2">
              <label for="name" class="block text-sm font-medium text-gray-700"
                >Họ và tên</label
              >
              <input
                required
                type="text"
                name="name"
                id="name"
                v-model="user.name"
                class="mt-1 block w-full p-2 border rounded-md"
              />
            </div>
            <div class="col-span-2">
              <label for="phone" class="block text-sm font-medium text-gray-700"
                >Số điện thoại</label
              >
              <input
                required
                type="text"
                name="phone"
                id="phone"
                v-model="user.phone"
                class="mt-1 block w-full p-2 border rounded-md"
              />
            </div>
          </div>

          <div class="col-span-2">
            <label for="address" class="block text-sm font-medium text-gray-700"
              >Address</label
            >
            <input
              required
              type="text"
              name="address"
              id="address"
              v-model="user.address"
              class="mt-1 block w-full p-2 border rounded-md"
            />
          </div>
          <div class="mt-5 border-t pt-2">
            <p>Chọn thức thanh toán</p>
          </div>
          <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="mt-5">
              <input
                v-model="method"
                id="default-radio-1"
                type="radio"
                value="1"
                name="default-radio"
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
              />
              <label
                for="default-radio-1"
                class="ms-2 font-medium text-gray-900 dark:text-gray-300"
                >Thanh toán khi nhận hàng</label
              >
            </div>
            <div class="mt-5">
              <input
                v-model="method"
                id="default-radio-1"
                type="radio"
                value="2"
                name="default-radio"
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
              />
              <label
                for="default-radio-1"
                class="ms-2 font-medium text-gray-900 dark:text-gray-300"
                >Thanh toán ngay</label
              >
            </div>
          </div>
        </form>
        <div class="flex justify-between mb-2">
          <span>Tổng tiền</span>
          <span>{{ formatCurrency(totalPrice) }}</span>
        </div>
        <div class="flex justify-between mb-2">
          <span>Phí ship</span>
          <span>{{ formatCurrency(totalPrice * 0.03) }}</span>
        </div>
        <hr class="my-2" />
        <div class="flex justify-between mb-2">
          <span class="">Thành tiền</span>
          <span class="">{{ formatCurrency(totalPrice + totalPrice * 0.03) }}</span>
        </div>
        <button
          @click="addOrder"
          :disabled="method == 0"
          :class="{ 'opacity-50': method == 0 }"
          class="w-full mt-6 bg-blue-500 text-white py-2 rounded-lg font-bold"
        >
          Đặt hàng
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
const id = ref(null);
const load = ref(true);
const method = ref(0);
const quantities = computed(() => cart.quantities);
const ship = ref(0);
const cart = useCartStore();
const auth = useAuthStore();
const user = ref({
  name: null,
  gender: null,
  phone: null,
  email: null,
  address: null,
});
const order = ref({
  user_id: null,
  address: null,
  total: null,
  status: 1,
  orderDetails: [],
});
onMounted(async () => {
  await auth.info();
  user.value.name = auth.User.name;
  user.value.gender = auth.User.gender;
  user.value.phone = auth.User.phone;
  user.value.email = auth.User.email;
  user.value.address = auth.User.address;
  delay(3000).then(() => {
    load.value = false;
  });
});
const delay = (ms) => {
  return new Promise((resolve) => setTimeout(resolve, ms));
};

const carts = computed(() => cart.selectProducts);
const formatCurrency = (value) => {
  const formatter = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  });
  return formatter.format(value);
};
const totalPrice = computed(() => {
  let total = 0;
  for (let i = 0; i < carts.value.length; i++) {
    let cartItem = carts.value[i];
    let quantity = quantities.value[cartItem.id] || 1;
    total += carts.value[i].price * quantity;
  }
  return total;
});
const axios = useOrderStore();
const addOrder = () => {
  order.value.user_id = auth.User.id;
  order.value.address = auth.User.address;
  order.value.total = totalPrice.value;
  for (let i = 0; i < carts.value.length; i++) {
    let cartItem = carts.value[i];
    let product_id = carts.value[i].product_id;
    let color = cart.value[i].color;
    let quantity = quantities.value[cartItem.id] || 1;
    order.value.orderDetails.push({
      product_id: product_id,
      quantity: quantity,
      color: color,
    });
  }
  axios.addOrder(order);
};
</script>

<style scoped></style>
