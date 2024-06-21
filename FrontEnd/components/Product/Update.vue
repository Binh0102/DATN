<template>
  <div
    v-if="updateProduct"
    @click.self="closeUpdateProduct"
    class="overflow-y-auto overflow-x-hidden fixed flex top-0 right-0 left-0 z-50 justify-center w-full inset-0 md:h-full bg-black bg-opacity-30"
  >
    <div class="relative m-4 w-full max-w-screen-lg h-full md:h-auto">
      <!-- Modal content -->
      <div class="relative p-4 mt-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
        <!-- Modal header -->
        <div
          class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600"
        >
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            Thêm sản phẩm
          </h3>
          <button
            type="button"
            @click="closeUpdateProduct"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
          >
            <Icon name="mdi:close" size="20" />
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <form @submit.prevent="updateProductClick">
          <div class="grid gap-4 mb-4 sm:grid-cols-2">
            <div>
              <label
                for="name"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Tên sản phẩm</label
              >
              <input
                type="text"
                v-model="product.name"
                id="name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Tên sản phẩm"
                required=""
              />
            </div>
            <div>
              <label
                for="category"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Loại giày</label
              ><select
                id="category"
                v-model="product.category_id"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              >
                <option v-for="item in categories" :key="item.id" :value="item.id">
                  {{ item.name }}
                </option>
              </select>
            </div>
            <div>
              <label
                for="brand"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Số lượng</label
              >
              <input
                type="number"
                v-model="product.quantity"
                id="brand"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Số lượng"
                required=""
              />
            </div>
            <div>
              <label
                for="price"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Giá</label
              >
              <input
                type="number"
                v-model="product.price"
                id="price"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Giá"
                required=""
              />
            </div>

            <div class="sm:col-span-2">
              <label
                for="description"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Mô tả</label
              ><textarea
                id="description"
                rows="8"
                v-model="product.description"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Viết mô tả của bạn ở đây"
              ></textarea>
            </div>
            <div class="flex items-center h-10">
              <p
                @click="addVariant"
                class="text-sm text-[#007006] leading-[16.94px] hover:cursor-pointer"
              >
                + Thêm thông tin
              </p>
            </div>
            <div
              class="grid gap-4 sm:col-span-2 md:gap-6 sm:grid-cols-4"
              v-for="(item, index) in product.variants"
              :key="item"
            >
              <div>
                <label
                  for="weight"
                  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                  >Tên màu</label
                >
                <input
                  type="text"
                  v-model="item.color"
                  id="weight"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Tên màu"
                  required=""
                />
              </div>
              <div>
                <p class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                  Hình ảnh
                </p>
                <div class="w-[105px]">
                  <button
                    type="button"
                    @click="addImg(index)"
                    class="hover:cursor-pointer"
                  >
                    <div
                      class="bg-green-500 border text-slate-100 font-bold border-gray-300 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block py-2.5 px-5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    >
                      Chọn ảnh
                    </div>
                    <input
                      type="file"
                      :ref="(el) => (imageRefs[index] = el)"
                      class="hidden"
                      accept="image/jpeg, image/png, image/jpg"
                      @change="displayImage(index, $event)"
                    />
                  </button>
                </div>
              </div>
              <div :class="item.image ? '' : 'hidden'">
                <img :src="getImageUrl(item.image)" alt="" class="w-28 h-28" />
              </div>
              <div class="flex items-center">
                <button type="button" @click="deleteVariant(index)">
                  <Icon
                    name="mdi:delete"
                    size="24"
                    color="red"
                    :class="item.image ? '' : 'mt-7'"
                  />
                </button>
              </div>
            </div>
          </div>
          <div class="items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
            <button
              type="submit"
              class="w-full sm:w-auto justify-center text-white inline-flex bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            >
              Lưu lại
            </button>

            <button
              type="button"
              @click="an"
              class="w-full justify-center sm:w-auto text-gray-500 inline-flex items-center bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"
            >
              <svg
                class="mr-1 -ml-1 w-5 h-5"
                fill="currentColor"
                viewbox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                />
              </svg>
              Discard
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
const emit = defineEmits("close", "updateCurrent");
const props = defineProps(["updateProduct"]);
const { updateProduct } = toRefs(props);
const closeUpdateProduct = () => {
  emit("close");
};
const axios = useProductStore();
const updateProductClick = () => {
  let formData = new FormData();
  formData.append("name", product.value.name);
  formData.append("category_id", product.value.category_id);
  formData.append("quantity", product.value.quantity);
  formData.append("description", product.value.description);
  formData.append("price", product.value.price);
  if (product.value.discount) {
    formData.append("discount", product.value.discount);
  }
  for (let i = 0; i < product.value.variants.length; i++) {
    if (product.value.variants[i].id) {
      console.log(product.value.variants[i].id);
      formData.append("variants[" + i + "][id]", product.value.variants[i].id);
    }
    formData.append("variants[" + i + "][color]", product.value.variants[i].color);
    formData.append("variants[" + i + "][image]", product.value.variants[i].image);
  }
  formData.append("_method", "PUT");
  axios.updateProductId(product.value.id, formData);
  closeUpdateProduct();
  emit("updateCurrent");
};
const an = () => {
  console.log(product.value);
};
const product = computed(() => axios.oneProduct);
const deleteProductId = () => {
  axios.deleteProduct(id);
};
const formatCurrency = (value) => {
  const formatter = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  });
  return formatter.format(value);
};
const category = useCategoryStore();
onMounted(() => {
  category.getCategories();
});
const categories = computed(() => category.categoriesList);
const imageRefs = ref([]);
const addImg = (index) => {
  const fileInput = imageRefs.value[index];
  if (fileInput) {
    fileInput.click();
  } else {
    console.error(`File input for index ${index} not found`);
  }
};
const addVariant = () => {
  product.value.variants.push({ color: null, image: null });
};
const deleteVariant = (index) => {
  console.log(product.value.variants);
  product.value.variants.splice(index, 1);
};
const displayImage = (index, event) => {
  const selectedFiles = event.target.files[0];
  product.value.variants[index].image = selectedFiles;
};
const getImageUrl = (file) => {
  if (typeof file === "string") {
    return file;
  } else if (file instanceof File || file instanceof Blob) {
    return URL.createObjectURL(file);
  }
  return "";
};
</script>

<style></style>
