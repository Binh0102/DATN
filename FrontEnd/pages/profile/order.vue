<template>
  <div class="pt-10 cursor-pointer">
    <div
      class="w-[70%] min-h-screen bg-white mx-auto cursor-auto pb-6 shadow-md rounded-lg"
    >
      <div class="bg-cover relative">
        <div class="pb-5 border-b mx-6">
          <h2 class="text-2xl font-semibold pt-4 ml-3">Đơn hàng của bạn</h2>
        </div>
        <div
          class="flex flex-col md:flex-row items-center space-y-3 md:space-y-0 md:space-x-4 p-4"
        >
          <div class="flex mb-4 gap-4">
            <button
              @click="status1"
              class="p-4"
              :class="
                status === 1 ? 'bg-blue-500 text-white' : 'border-b-4 border-blue-500'
              "
            >
              Chờ xác nhận
            </button>
            <button
              @click="status2"
              class="p-4"
              :class="
                status === 2 ? 'bg-blue-500 text-white' : 'border-b-4 border-blue-500'
              "
            >
              Đang vận chuyển
            </button>
            <button
              @click="status3"
              class="p-4"
              :class="
                status === 3 ? 'bg-blue-500 text-white' : 'border-b-4 border-blue-500'
              "
            >
              Đã hoàn thành
            </button>
            <button
              @click="status4"
              class="p-4"
              :class="
                status === 4 ? 'bg-blue-500 text-white' : 'border-b-4 border-blue-500'
              "
            >
              Đơn hàng đã hủy
            </button>
          </div>
        </div>
        <div class="overflow-x-auto" v-if="status == 1">
          <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead
              class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
              <tr>
                <th scope="col" class="px-4 py-4">Tên sản phẩm</th>
                <th scope="col" class="px-4 py-3">Số điện thoại</th>
                <th scope="col" class="px-4 py-3">Địa chỉ</th>
                <th scope="col" class="px-4 py-3">Tổng tiền</th>
                <th scope="col" class="px-4 py-3">
                  <span class="sr-only">Actions</span>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                class="border-b dark:border-gray-700"
                v-for="item in orders1"
                :key="item.id"
              >
                <th
                  scope="row"
                  class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                >
                  {{ item.nameProduct }}
                </th>
                <td class="px-4 py-3">{{ item.phone }}</td>
                <td class="px-4 py-3 max-w-[12rem] truncate">
                  {{ item.address }}
                </td>
                <td class="px-4 py-3">
                  {{ formatCurrency(item.total) }}
                </td>
                <td class="px-4 py-3 flex items-center justify-end">
                  <button
                    type="button"
                    @click="openOrderDetail(item.id)"
                    class="flex justify-center items-center p-2 hover:bg-gray-100 hover:rounded-full dark:hover:bg-gray-600 dark:hover:text-red-400"
                  >
                    <Icon name="mdi:eye" size="24" />
                  </button>
                  <button
                    type="button"
                    @click="cancel(item.id, 4)"
                    class="flex w-full justify-center items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-red-500 dark:hover:text-red-400"
                  >
                    <Icon name="mdi:close" size="24" />
                    <p class="ps-2">Hủy</p>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="overflow-x-auto" v-if="status == 2">
          <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead
              class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
              <tr>
                <th scope="col" class="px-4 py-4">Tên sản phẩm</th>
                <th scope="col" class="px-4 py-3">Số điện thoại</th>
                <th scope="col" class="px-4 py-3">Địa chỉ</th>
                <th scope="col" class="px-4 py-3">Tổng tiền</th>
                <th scope="col" class="px-4 py-3">
                  <span class="sr-only">Actions</span>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                class="border-b dark:border-gray-700"
                v-for="item in orders2"
                :key="item.id"
              >
                <th
                  scope="row"
                  class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                >
                  {{ item.nameProduct }}
                </th>
                <td class="px-4 py-3">{{ item.phone }}</td>
                <td class="px-4 py-3 max-w-[12rem] truncate">
                  {{ item.address }}
                </td>
                <td class="px-4 py-3">
                  {{ formatCurrency(item.total) }}
                </td>
                <td class="px-4 py-3 flex items-center justify-end">
                  <button
                    type="button"
                    @click="openOrderDetail(item.id)"
                    class="flex mr-4 justify-center items-center p-2 hover:rounded-full hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-red-400"
                  >
                    <Icon name="mdi:eye" size="24" />
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="overflow-x-auto" v-if="status == 3">
          <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead
              class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
              <tr>
                <th scope="col" class="px-4 py-4">Tên sản phẩm</th>
                <th scope="col" class="px-4 py-3">Số điện thoại</th>
                <th scope="col" class="px-4 py-3">Địa chỉ</th>
                <th scope="col" class="px-4 py-3">Tổng tiền</th>
                <th scope="col" class="px-4 py-3">
                  <span class="sr-only">Actions</span>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                class="border-b dark:border-gray-700"
                v-for="item in orders3"
                :key="item.id"
              >
                <th
                  scope="row"
                  class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                >
                  {{ item.nameProduct }}
                </th>
                <td class="px-4 py-3">{{ item.phone }}</td>
                <td class="px-4 py-3 max-w-[12rem] truncate">
                  {{ item.address }}
                </td>
                <td class="px-4 py-3">
                  {{ formatCurrency(item.total) }}
                </td>
                <td class="px-4 py-3 flex items-center justify-end">
                  <button
                    type="button"
                    @click="openOrderDetail(item.id)"
                    class="flex w-full justify-center items-center py-2 hover:bg-gray-100 hover:rounded-lg dark:hover:bg-black-600 text-black dark:hover:text-red-400"
                  >
                    <Icon name="mdi:eye" size="24" />
                    <p class="ps-2">Xem chi tiết</p>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="overflow-x-auto" v-if="status == 4">
          <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead
              class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
              <tr>
                <th scope="col" class="px-4 py-4">Tên sản phẩm</th>
                <th scope="col" class="px-4 py-3">Số điện thoại</th>
                <th scope="col" class="px-4 py-3">Địa chỉ</th>
                <th scope="col" class="px-4 py-3">Tổng tiền</th>
                <th scope="col" class="px-4 py-3">
                  <span class="sr-only">Actions</span>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                class="border-b dark:border-gray-700"
                v-for="item in orders4"
                :key="item.id"
              >
                <th
                  scope="row"
                  class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                >
                  {{ item.nameProduct }}
                </th>
                <td class="px-4 py-3">{{ item.phone }}</td>
                <td class="px-4 py-3 max-w-[12rem] truncate">
                  {{ item.address }}
                </td>
                <td class="px-4 py-3">
                  {{ formatCurrency(item.total) }}
                </td>
                <td class="px-4 py-3 flex items-center justify-end">
                  <button
                    type="button"
                    @click="openOrderDetail(item.id)"
                    class="flex w-full justify-center items-center py-2 hover:bg-gray-100 hover:rounded-lg dark:hover:bg-black-600 text-black dark:hover:text-red-400"
                  >
                    <Icon name="mdi:eye" size="24" />
                    <p class="ps-2">Xem chi tiết</p>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <FormOrderDetail :opendetail="opendetail" @close="close" />
  </div>
</template>

<script setup>
const status = ref(1);
const opendetail = ref(false);
const delay = (ms) => {
  return new Promise((reject) => setTimeout(reject, ms));
};
const order = useOrderStore();
const auth = useAuthStore();
onMounted(async () => {
  await Promise.all([auth.info(), order.getOrdersUser()]);
});
const orders1 = computed(() => order.ordesrList.filter((order) => order.status === 1));
const orders2 = computed(() => order.ordesrList.filter((order) => order.status === 2));
const orders3 = computed(() => order.ordesrList.filter((order) => order.status === 3));
const orders4 = computed(() => order.ordesrList.filter((order) => order.status === 4));
const status1 = async () => {
  status.value = 1;
};
const status2 = async () => {
  status.value = 2;
};
const status3 = async () => {
  status.value = 3;
};
const status4 = async () => {
  status.value = 4;
};
const formatCurrency = (value) => {
  const formatter = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  });
  return formatter.format(value);
};
definePageMeta({
  layout: "profile",
});
const cancel = async (id, number) => {
  let formData = new FormData();
  formData.append("status", number);
  formData.append("_method", "PUT");
  await order.update(id, formData);
  await order.getOrdersUser(status.value);
};

const openOrderDetail = async (id) => {
  await order.getOrderDetail(id);
  opendetail.value = true;
};
const close = () => {
  opendetail.value = false;
};
</script>

<style></style>
