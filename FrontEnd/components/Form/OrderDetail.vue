<template>
  <div
    v-if="opendetail"
    @click.self="closeOrderDetail"
    class="overflow-y-auto overflow-x-hidden fixed flex top-0 right-0 left-0 z-50 justify-center w-full inset-0 md:h-full bg-black bg-opacity-30"
  >
    <div class="relative m-4 w-full p-10 h-full md:h-auto">
      <!-- Modal content -->
      <div
        @click.self="closeOrderDetail"
        class="relative p-4 mt-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5"
      >
        <div class="relative flex justify-start item-start space-y-2 flex-col">
          <h1
            class="text-3xl flex justify-between dark:text-white lg:text-4xl font-semibold leading-7 lg:leading-9 text-gray-800 uppercase"
          >
            Đơn hàng #{{ order.Order.id }}
            <button
              type="button"
              @click="closeOrderDetail"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
            >
              <Icon name="mdi:close" size="24" />
              <span class="sr-only">Close modal</span>
            </button>
          </h1>
          <p class="text-base dark:text-gray-300 font-medium leading-6 text-gray-600">
            {{ formattedDate }}
          </p>
        </div>
        <div
          class="mt-10 flex flex-col xl:flex-row jusitfy-center items-stretch w-full xl:space-x-8 space-y-4 md:space-y-6 xl:space-y-0"
        >
          <div
            class="flex flex-col justify-start items-start w-full space-y-4 md:space-y-6 xl:space-y-8"
          >
            <div
              class="flex flex-col justify-start items-start dark:bg-gray-800 bg-gray-50 px-4 py-4 md:py-6 md:p-6 xl:p-8 w-full"
            >
              <p
                class="text-lg md:text-xl dark:text-white font-semibold leading-6 xl:leading-5 text-gray-800 uppercase"
              >
                Sản phẩm
              </p>
              <div class="overflow-y-auto w-full max-h-[380px]">
                <div
                  v-for="item in order.Order.orderDetails"
                  :key="item"
                  class="mt-4 md:mt-6 flex flex-col md:flex-row justify-start items-start md:items-center md:space-x-6 xl:space-x-8 w-full"
                >
                  <div class="pb-4 md:pb-8 w-full md:w-40">
                    <img
                      :src="item.image"
                      class="w-full h-[130px] object-contain"
                      alt=""
                    />
                  </div>
                  <div
                    class="border-b border-gray-200 md:flex-row flex-col flex justify-between items-start w-full pb-8 space-y-4 md:space-y-0"
                  >
                    <div class="w-full flex flex-col justify-start items-start space-y-8">
                      <h3
                        class="text-xl dark:text-white xl:text-2xl font-semibold leading-6 text-gray-800"
                      >
                        {{ item.name }}
                      </h3>
                      <div class="flex justify-start items-start flex-col space-y-3">
                        <p class="text-sm dark:text-white leading-none text-gray-800">
                          <span class="dark:text-gray-400 text-gray-400">Màu: </span>
                          {{ item.color }}
                        </p>
                      </div>
                    </div>
                    <div class="flex ml-[80px] gap-[100px] items-start w-full">
                      <p class="text-base dark:text-white xl:text-lg leading-6">
                        {{ formatCurrency(item.price) }}
                      </p>
                      <p
                        class="text-base dark:text-white xl:text-lg font-semibold leading-6 text-gray-800"
                      >
                        {{ formatCurrency(item.price * item.quantity) }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div
              class="flex justify-center flex-col md:flex-row items-stretch w-full space-y-4 md:space-y-0 md:space-x-6 xl:space-x-8"
            >
              <div
                class="flex flex-col px-4 py-6 md:p-6 xl:p-8 w-full bg-gray-50 dark:bg-gray-800 space-y-6"
              >
                <h3 class="text-xl dark:text-white font-semibold leading-5 text-gray-800">
                  Chi tiết thanh toán
                </h3>
                <div
                  class="flex justify-center items-center w-full space-y-4 flex-col border-gray-200 border-b pb-4"
                >
                  <div class="flex justify-between w-full">
                    <p class="text-base dark:text-white leading-4 text-gray-800">
                      Tạm tính
                    </p>
                    <p class="text-base dark:text-gray-300 leading-4 text-gray-600">
                      {{ formatCurrency(order.Order.total) }}
                    </p>
                  </div>
                  <div class="flex justify-between items-center w-full">
                    <p class="text-base dark:text-white leading-4 text-gray-800">
                      Phí ship
                    </p>
                    <p class="text-base dark:text-gray-300 leading-4 text-gray-600">
                      {{ formatCurrency(order.Order.total * 0.03) }}
                    </p>
                  </div>
                  <div class="flex justify-between items-center w-full">
                    <p class="text-base dark:text-white leading-4 text-gray-800">Thuế</p>
                    <p class="text-base dark:text-gray-300 leading-4 text-gray-600">
                      Đã tính
                    </p>
                  </div>
                </div>
                <div class="flex justify-between items-center w-full">
                  <p
                    class="text-base dark:text-white font-semibold leading-4 text-gray-800"
                  >
                    Tổng
                  </p>
                  <p
                    class="text-base dark:text-gray-300 font-semibold leading-4 text-gray-600"
                  >
                    {{ formatCurrency(order.Order.total + order.Order.total * 0.03) }}
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div
            class="bg-gray-50 dark:bg-gray-800 w-full xl:w-96 flex justify-between items-center md:items-start px-4 py-6 md:p-6 xl:p-8 flex-col"
          >
            <h3 class="text-xl dark:text-white font-semibold leading-5 text-gray-800">
              Thông tin thanh toán
            </h3>
            <div
              class="flex flex-col md:flex-row xl:flex-col justify-start items-stretch h-full w-full md:space-x-6 lg:space-x-8 xl:space-x-0"
            >
              <div class="flex flex-col justify-start items-start flex-shrink-0">
                <div
                  class="flex justify-center w-full md:justify-start items-center space-x-4 py-8 border-b border-gray-200"
                >
                  <div class="flex justify-start items-start flex-col space-y-2">
                    <p
                      class="text-base dark:text-white font-semibold leading-4 text-left text-gray-800"
                    >
                      {{ order.Order.nameUser }}
                    </p>
                  </div>
                </div>

                <div
                  class="flex justify-center text-gray-800 dark:text-white md:justify-start items-center space-x-4 py-4 border-b border-gray-200 w-full"
                >
                  <img
                    class="dark:hidden"
                    src="https://tuk-cdn.s3.amazonaws.com/can-uploader/order-summary-3-svg1.svg"
                    alt="email"
                  />
                  <p class="cursor-pointer text-sm leading-5">{{ order.Order.email }}</p>
                </div>
              </div>
              <div
                class="flex justify-between xl:h-full items-stretch w-full flex-col mt-6 md:mt-0"
              >
                <div
                  class="flex justify-center md:justify-start xl:flex-col flex-col md:space-x-6 lg:space-x-8 xl:space-x-0 space-y-4 xl:space-y-12 md:space-y-0 md:flex-row items-center md:items-start"
                >
                  <div
                    class="flex justify-center md:justify-start items-center md:items-start flex-col space-y-4 xl:mt-8"
                  >
                    <p
                      class="text-base dark:text-white font-semibold leading-4 text-center md:text-left text-gray-800"
                    >
                      Địa chỉ giao hàng
                    </p>
                    <p
                      class="w-48 lg:w-full dark:text-gray-300 xl:w-48 text-center md:text-left text-sm leading-5 text-gray-600"
                    >
                      {{ order.Order.address }}
                    </p>
                  </div>
                  <div
                    class="flex justify-center md:justify-start items-center md:items-start flex-col space-y-4"
                  >
                    <p
                      class="text-base dark:text-white font-semibold leading-4 text-center md:text-left text-gray-800"
                    >
                      Thông tin chi tiết
                    </p>
                    <p
                      class="w-48 lg:w-full dark:text-gray-300 xl:w-48 text-center md:text-left text-sm leading-5 text-gray-600"
                    >
                      {{ "Không có" }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { format } from "date-fns";
const props = defineProps(["opendetail"]);
const { opendetail } = toRefs(props);
const emit = defineEmits("close");
const formattedDate = ref(null);
const order = useOrderStore();
onMounted(async () => {
  formattedDate.value = format(new Date(order.Order.time), "HH:mm' 'dd-MM-yyyy");
});
const closeOrderDetail = () => {
  emit("close");
};
const formatCurrency = (value) => {
  const formatter = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  });
  return formatter.format(value);
};
</script>
