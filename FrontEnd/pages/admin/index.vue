<template>
  <div>
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
      <div class="container px-6 py-8 mx-auto">
        <h3 class="text-3xl font-medium text-gray-700">Thống kê</h3>

        <div class="mt-4">
          <div class="flex flex-wrap -mx-6">
            <div class="w-full px-6 sm:w-1/2 xl:w-1/3">
              <div class="flex items-center px-5 py-6 bg-white rounded-md shadow-sm">
                <div class="p-3 bg-indigo-600 bg-opacity-75 rounded-full">
                  <Icon name="mdi:account-group" size="32" color="white" />
                </div>

                <div class="mx-5">
                  <h4 class="text-2xl font-semibold text-gray-700">
                    {{ user.Users.length || 0 }}
                  </h4>
                  <div class="text-gray-500">Người dùng mới</div>
                </div>
              </div>
            </div>

            <div class="w-full px-6 mt-6 sm:w-1/2 xl:w-1/3 sm:mt-0">
              <div class="flex items-center px-5 py-6 bg-white rounded-md shadow-sm">
                <div class="p-3 bg-orange-600 bg-opacity-75 rounded-full">
                  <Icon name="mdi:cart" size="32" color="white" />
                </div>

                <div class="mx-5">
                  <h4 class="text-2xl font-semibold text-gray-700">
                    {{ order.ordesrList.length || 0 }}
                  </h4>
                  <div class="text-gray-500">Tổng số đơn hàng</div>
                </div>
              </div>
            </div>

            <div class="w-full px-6 mt-6 sm:w-1/2 xl:w-1/3 xl:mt-0">
              <div class="flex items-center px-5 py-6 bg-white rounded-md shadow-sm">
                <div class="p-3 bg-pink-600 bg-opacity-75 rounded-full">
                  <Icon name="mdi:shopping" size="32" color="white" />
                </div>

                <div class="mx-5">
                  <h4 class="text-2xl font-semibold text-gray-700">
                    {{ product.productsList.length }}
                  </h4>
                  <div class="text-gray-500">Sản phẩm có sẵn</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-8"></div>

        <div class="flex flex-col mt-8">
          <canvas ref="chartCanvas"></canvas>
        </div>
      </div>
    </main>
    <FormLoading v-if="load" />
  </div>
</template>

<script setup>
import Chart from "chart.js/auto";
const load = ref(true);
const chartData = ref({
  labels: null,
  datasets: [
    {
      label: "Doanh thu theo tháng",
      data: null,
      backgroundColor: [
        "rgba(255, 99, 132, 0.2)",
        "rgba(54, 162, 235, 0.2)",
        "rgba(255, 206, 86, 0.2)",
        "rgba(75, 192, 192, 0.2)",
        "rgba(153, 102, 255, 0.2)",
        "rgba(255, 159, 64, 0.2)",
        "rgba(255, 99, 132, 0.2)",
      ],
      borderColor: [
        "rgba(255, 99, 132, 1)",
        "rgba(54, 162, 235, 1)",
        "rgba(255, 206, 86, 1)",
        "rgba(75, 192, 192, 1)",
        "rgba(153, 102, 255, 1)",
        "rgba(255, 159, 64, 1)",
        "rgba(255, 99, 132, 1)",
      ],
      borderWidth: 1,
    },
  ],
});
const order = useOrderStore();
const user = useAuthStore();
const product = useProductStore();
onMounted(async () => {
  await Promise.all([user.getAll(), product.getProducts(), order.getAll()]);
  await delay(2000).then(() => {
    set();
    load.value = false;
  });
  console.log(chartData.value);
  const ctx = chartCanvas.value.getContext("2d");
  new Chart(ctx, {
    type: "line",
    data: chartData.value,
    options: chartOptions.value,
  });
});
const set = () => {
  chartData.value.labels = Object.keys(totalByMonth.value);
  chartData.value.datasets[0].data = Object.values(totalByMonth.value);
};
const totalByMonth = computed(() => {
  const orders = order.ordesrList;
  const totalByMonth = {};

  orders.forEach((order) => {
    const date = new Date(order.time);
    const month = date.getMonth() + 1;
    const monthYearKey = `Tháng ${month.toString().padStart(1)}`;

    if (!totalByMonth[monthYearKey]) {
      totalByMonth[monthYearKey] = 0;
    }

    totalByMonth[monthYearKey] += order.total;
  });

  return totalByMonth;
});
const delay = (ms) => {
  return new Promise((resolve) => setTimeout(resolve, ms));
};
const chartOptions = ref({
  scales: {
    y: {
      beginAtZero: true,
    },
  },
});

const chartCanvas = ref(null);

definePageMeta({
  layout: "admin",
});
</script>

<style></style>
