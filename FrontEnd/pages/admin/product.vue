<template>
  <div>
    <!-- Start block -->
    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5 antialiased">
      <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
        <!-- Start coding here -->
        <div
          class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden"
        >
          <div
            class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4"
          >
            <div class="w-full md:w-1/2">
              <form class="flex items-center">
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-full">
                  <div
                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                  >
                    <Icon name="mdi:search" size="20" />
                  </div>
                  <input
                    type="text"
                    id="simple-search"
                    v-model="search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search"
                    required=""
                  />
                </div>
              </form>
            </div>
            <div
              class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0"
            >
              <button
                type="button"
                @click="addProdct = true"
                class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
              >
                <Icon name="mdi:plus" size="20" />
                Add product
              </button>
            </div>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
              >
                <tr>
                  <th scope="col" class="px-4 py-4">Tên sản phẩm</th>
                  <th scope="col" class="px-4 py-3">Loại giày</th>
                  <th scope="col" class="px-4 py-3">Số lượng</th>
                  <th scope="col" class="px-4 py-3">Hình ảnh</th>
                  <th scope="col" class="px-4 py-3">Giá</th>
                  <th scope="col" class="px-4 py-3">
                    <span class="sr-only">Actions</span>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  class="border-b dark:border-gray-700"
                  v-for="product in displayProducts"
                  :key="product.id"
                >
                  <th
                    scope="row"
                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                  >
                    {{ product.name }}
                  </th>
                  <td class="px-4 py-3">{{ product.category }}</td>
                  <td class="px-4 py-3">{{ product.quantity }}</td>
                  <td class="px-4 py-3 max-w-[12rem] truncate">
                    <img :src="product.image" alt="" class="h-12 w-12" />
                  </td>
                  <td class="px-4 py-3">{{ formatCurrency(product.price) }}</td>
                  <td class="px-4 py-3 flex items-center justify-end">
                    <button
                      :id="product.id - button"
                      :data-dropdown-toggle="product.id"
                      class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                      type="button"
                    >
                      <Icon name="mdi:dots-horizontal" size="20" />
                    </button>
                    <div
                      :id="product.id"
                      class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600"
                    >
                      <ul class="py-1 text-sm">
                        <li>
                          <button
                            type="button"
                            @click="openUpdateProduct(product.id)"
                            class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200"
                          >
                            <Icon name="mdi:square-edit-outline" size="16" />
                            <p class="ps-2">Sửa</p>
                          </button>
                        </li>
                        <li>
                          <button
                            class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200"
                          >
                            <Icon name="mdi:eye" size="16" />
                            <p class="ps-2">Xem chi tiết</p>
                          </button>
                        </li>
                        <li>
                          <button
                            type="button"
                            @click="(deleteProduct = true), (id = product.id)"
                            class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 text-red-500 dark:hover:text-red-400"
                          >
                            <Icon name="mdi:delete" size="16" />
                            <p class="ps-2">Xóa</p>
                          </button>
                        </li>
                      </ul>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <nav
            class="flex flex-col md:flex-row justify-end items-start md:items-center space-y-3 md:space-y-0 p-4 hover:cursor-pointer"
          >
            <ul class="inline-flex items-stretch -space-x-px">
              <li>
                <a
                  @click="previousPage()"
                  class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                >
                  <Icon name="mdi:chevron-left" size="20" />
                </a>
              </li>
              <li v-for="i in totalPages" :key="i">
                <a
                  :class="currentPage === i ? 'bg-gray-300' : 'bg-white'"
                  @click="getCurrentPage(i)"
                  class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                  >{{ i }}</a
                >
              </li>

              <li>
                <a
                  @click="nextPage()"
                  class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                >
                  <Icon name="mdi:chevron-right" size="20" />
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </section>
    <ProductAdd :addProduct="addProdct" @close="close" @updateCurrent="updateCurrent" />
    <ProductUpdate
      :updateProduct="updateProduct"
      @close="close"
      @updateCurrent="updateCurrent"
    />
    <ProductDelete
      :id="id"
      :deleteProduct="deleteProduct"
      @close="close"
      @updateCurrent="updateCurrent"
    />
  </div>
</template>

<script setup>
import { onMounted } from "vue";
import { initFlowbite } from "flowbite";
const id = ref(null);
const addProdct = ref(false);
const deleteProduct = ref(false);
const updateProduct = ref(false);
const close = () => {
  addProdct.value = false;
  updateProduct.value = false;
  deleteProduct.value = false;
};
const itemsPerPage = ref(10);
const currentPage = ref(1);
const totalProducts = computed(() => {
  return products.value.length;
});

const totalPages = computed(() => {
  return Math.ceil(totalProducts.value / itemsPerPage.value);
});
const displayProducts = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage.value;
  const endIndex = startIndex + itemsPerPage.value;
  return filteredProducts.value.slice(startIndex, endIndex);
});

const axios = useProductStore();
onMounted(async () => {
  await axios.getProductsList();
  await delay(3000).then(() => {
    initFlowbiteDropdown();
  });
});
const delay = (ms) => {
  return new Promise((reject) => setTimeout(reject, ms));
};
const search = ref(null);

const products = computed({
  get: () => axios.productsList,
});
const getCurrentPage = (i) => {
  currentPage.value = i;
  initFlowbiteDropdown();
};

const filteredProducts = computed(() => {
  if (!search.value) {
    return products.value;
  }
  return products.value.filter(
    (product) =>
      product.name.toLowerCase().includes(search.value.toLowerCase()) ||
      product.category.toLowerCase().includes(search.value.toLowerCase())
  );
});
const updateCurrent = () => {
  axios.getProductsList();
};
const previousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
    initFlowbiteDropdown();
  }
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
    initFlowbiteDropdown();
  }
};
const initFlowbiteDropdown = async () => {
  await nextTick();
  initFlowbite();
};
const openUpdateProduct = async (id) => {
  await axios.getProduct(id);
  updateProduct.value = true;
};
const formatCurrency = (value) => {
  const formatter = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  });
  return formatter.format(value);
};

definePageMeta({
  layout: "admin",
});
</script>

<style></style>
