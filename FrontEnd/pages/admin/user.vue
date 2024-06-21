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
            <div class="uppercase font-bold text-blue-700 flex gap-2 items-center">
              <Icon name="mdi:person" size="20" />
              <p>Tài khoản người dùng</p>
            </div>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
              >
                <tr>
                  <th scope="col" class="px-4 py-4">Tên người dùng</th>
                  <th scope="col" class="px-4 py-3">Email</th>
                  <th scope="col" class="px-4 py-3">Số điện thoại</th>
                  <th scope="col" class="px-4 py-3">Địa chỉ</th>
                  <th scope="col" class="px-4 py-3">Hình ảnh</th>
                  <th scope="col" class="px-4 py-3">
                    <span class="sr-only">Actions</span>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  class="border-b dark:border-gray-700"
                  v-for="user in displayUsers"
                  :key="user.id"
                >
                  <th
                    scope="row"
                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                  >
                    {{ user.name }}
                  </th>
                  <td class="px-4 py-3">{{ user.email }}</td>
                  <td class="px-4 py-3">{{ user.phone }}</td>
                  <td class="px-4 py-3 max-w-[12rem] truncate">
                    {{ user.address }}
                  </td>
                  <td class="px-4 py-3">
                    <img :src="user.image" alt="" class="h-10 w-10" />
                  </td>
                  <td class="px-4 py-3 flex items-center justify-end">
                    <button
                      v-if="user.role == 1 || user.role == 2"
                      type="button"
                      @click="updateRole(user.id, 4)"
                      class="flex w-full justify-center items-center p-2 hover:bg-gray-100 hover:rounded-lg dark:hover:bg-gray-600 text-red-500 dark:hover:text-red-400"
                    >
                      <Icon name="mdi:lock" size="16" />
                      <p class="ps-2">Khóa</p>
                    </button>
                    <button
                      v-if="user.role == 4"
                      type="button"
                      @click="updateRole(user.id, 2)"
                      class="flex w-full justify-center items-center p-2 hover:bg-gray-100 hover:rounded-lg dark:hover:bg-gray-600 text-green-500 dark:hover:text-red-400"
                    >
                      <Icon name="mdi:key" size="16" />
                      <p class="ps-2">Mở khóa</p>
                    </button>
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
                  :class="currentPage === i ? 'bg-gray-300' : ''"
                  @click="getCurrentPage(i)"
                  class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
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
  </div>
</template>

<script setup>
import { onMounted } from "vue";
import { initFlowbite } from "flowbite";
const search = ref(null);
const itemsPerPage = ref(10);
const currentPage = ref(1);
const auth = useAuthStore();

onMounted(async () => {
  await auth.getAll();
  await delay(3000);
  initFlowbiteDropdown();
});
const delay = (ms) => {
  return new Promise((resolve) => setTimeout(resolve, ms));
};
const users = computed(() => auth.Users || []);
const displayUsers = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage.value;
  const endIndex = startIndex + itemsPerPage.value;
  return filteredUsers.value.slice(startIndex, endIndex);
});
const getCurrentPage = (i) => {
  currentPage.value = i;
  initFlowbiteDropdown();
};
const previousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
    initFlowbiteDropdown();
  }
};
const totalProducts = computed(() => {
  return 20;
});
const totalPages = computed(() => {
  return Math.ceil(totalProducts.value / itemsPerPage.value);
});
const filteredUsers = computed(() => {
  if (!search.value) {
    return users.value;
  }
  return users.value.filter((user) =>
    user.name.toLowerCase().includes(search.value.toLowerCase())
  );
});
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
definePageMeta({
  layout: "admin",
});

const updateRole = async (id, role) => {
  let formData = new FormData();
  formData.append("status", role);
  formData.append("_method", "PUT");
  await auth.updateRole(id, formData);
  await auth.getAll();
};
</script>

<style></style>
