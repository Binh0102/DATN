<template>
  <div class="bg-white">
    <div class="w-[72%] mt-40 mx-auto">
      <div class="flex">
        <div class="flex mr-[30px]">
          <div class="pr-[80px]" for="scroll">
            <img
              :src="selectedImage"
              class="rounded-lg h-[666px] w-[520px]"
              alt=""
              id="mainImage"
            />
          </div>
        </div>
        <div class="mt-3 flex-1 max-h-[666px] overflow-y-auto" id="scroll">
          <p class="text-2xl font-medium mb-4">{{ product.name }}</p>
          <p class="font-semibold">{{ product.category }}</p>
          <p class="my-5 font-medium">{{ formatCurrency(product.price) }}</p>

          <Swiper :slides-per-view="4">
            <SwiperSlide
              class="relative hover:cursor-pointer"
              v-for="item in variants"
              :key="item"
              @click="changeImage(item.image, item.color)"
            >
              <img
                :src="item.image"
                alt=""
                class="hover:border border-black rounded-lg hover:bg-black h-28 w-28 hover:opacity-35"
                :class="{
                  'border border-black rounded-lg': selectedImage == item.image,
                }"
              />
              <p class="text-center">{{ item.color }}</p>
            </SwiperSlide>
          </Swiper>
          <div class="mt-[30px]">
            <div class="flex justify-between font-bold text-sm">
              <p>Chọn kích thước</p>
              <button class="text-[#0d0d2888]">Hướng dẫn</button>
            </div>
            <div class="mt-3 flex flex-wrap gap-2">
              <button
                @click="changeSize(i)"
                :class="{ 'border-black': selectedSize == i }"
                class="border rounded-2xl py-2 px-4 text-sm hover:border-black"
                v-for="i in 6"
                :key="i"
              >
                {{ 38 + i }}
              </button>
            </div>
            <div class="mt-5 text-center">
              <button
                @click="addToCart"
                class="py-[18px] w-full bg-black text-white rounded-3xl"
              >
                Thêm vào giỏ hàng
              </button>
            </div>
            <div class="mt-5 flex justify-center">
              <button
                @click="addFavorite()"
                class="py-[18px] w-full flex border border-black rounded-3xl font-medium items-center justify-center gap-3"
              >
                Yêu thích
                <Icon name="mdi:heart-outline" size="20" />
              </button>
            </div>
            <p
              v-if="product.discount < 20"
              class="text-center text-[#656761] mx-[60px] mt-4"
            >
              Sản phẩm này được loại trừ khỏi chương trình khuyến mãi và giảm giá của
              trang web
            </p>
            <div class="mt-10 border-b pb-8">
              <p>
                {{ product.description }}
              </p>
            </div>
            <div class="py-3 border-b">
              <div
                @click="dropdown1 = !dropdown1"
                class="flex justify-between hover:cursor-pointer"
              >
                <p class="text-xl">Giao hàng và trả lại miễn phí</p>
                <Transition>
                  <Icon
                    :name="dropdown1 ? 'mdi:chevron-up' : 'mdi:chevron-down'"
                    size="32"
                  />
                </Transition>
              </div>
              <div v-if="dropdown1">
                <p class="mt-5 mr-[45px] leading-[28px] mb-8">
                  Đơn hàng từ 5.000.000₫ trở lên của bạn sẽ được giao hàng tiêu chuẩn miễn
                  phí.
                </p>
                <li class="leading-[28px]">Giao hàng tiêu chuẩn 4-5 ngày làm việc</li>
                <li class="leading-[28px]">Chuyển phát nhanh 2-4 ngày làm việc</li>
                <p class="mt-8 pb-8">
                  Đơn hàng được xử lý và giao từ Thứ Hai đến Thứ Sáu (trừ ngày lễ)
                </p>
              </div>
            </div>
            <div class="py-3 border-b">
              <div
                @click="dropdown2 = !dropdown2"
                class="flex justify-between hover:cursor-pointer"
              >
                <p class="text-xl">Làm thế nào điều này được thực hiện</p>
                <Transition>
                  <Icon
                    :name="dropdown2 ? 'mdi:chevron-up' : 'mdi:chevron-down'"
                    size="32"
                  />
                </Transition>
              </div>
              <div v-if="dropdown2">
                <ul class="list-disc ml-5 mt-5">
                  <li class="leading-[28px]">
                    Sản phẩm này được thiết kế có trách nhiệm sử dụng vật liệu tái chế từ
                    rác thải sau tiêu dùng và/hoặc rác thải sau sản xuất. Một trong những
                    bước tiến lớn nhất của chúng tôi trên hành trình hướng tới không
                    carbon và không rác thải là lựa chọn vật liệu vì chúng chiếm hơn 70%
                    dấu chân của bất kỳ sản phẩm nào. Bằng cách tái sử dụng nhựa, sợi và
                    hàng dệt hiện có, chúng tôi giảm đáng kể lượng khí thải. Mục tiêu của
                    chúng tôi là sử dụng càng nhiều vật liệu tái chế càng tốt mà không ảnh
                    hưởng đến hiệu suất, độ bền và kiểu dáng.
                  </li>
                  <li class="leading-[28px]">
                    Tìm hiểu thêm về hành trình Move to Zero của chúng tôi hướng tới không
                    carbon và không rác thải, bao gồm cả cách chúng tôi đang nỗ lực thiết
                    kế sản phẩm với mục tiêu bền vững và giúp bảo vệ tương lai của nơi
                    chúng ta sống và vui chơi.
                  </li>
                </ul>
              </div>
            </div>
            <div class="py-3 border-b mb-3">
              <div
                @click="dropdown3 = !dropdown3"
                class="flex justify-between hover:cursor-pointer"
              >
                <p class="text-xl">Đánh giá({{ comment.comments.length || 0 }})</p>
                <div class="flex">
                  <div class="flex items-center">
                    <Icon
                      v-for="(star, index) in stars"
                      :name="star.icon"
                      size="20"
                      :class="star.color"
                      :style="star.style"
                      :key="index"
                    />
                  </div>
                  <Transition>
                    <Icon
                      :name="dropdown3 ? 'mdi:chevron-up' : 'mdi:chevron-down'"
                      size="32"
                    />
                  </Transition>
                </div>
              </div>
              <div v-if="dropdown3" class="mt-10">
                <div class="flex">
                  <div class="flex items-center">
                    <Icon
                      v-for="(star, index) in stars"
                      :name="star.icon"
                      size="20"
                      :class="star.color"
                      :style="star.style"
                      :key="index"
                    />
                  </div>
                  <p class="ps-6">{{ rating }} sao</p>
                </div>
                <div class="mt-10" v-for="(review, index) in selecteComment" :key="index">
                  <div class="flex gap-2">
                    <img :src="review.user.image" alt="" class="h-6 w-6 rounded-full" />
                    <p>{{ review.user.name }}</p>
                  </div>
                  <div class="my-3">
                    <div class="flex items-center">
                      <Icon
                        v-for="i in 5"
                        :key="i"
                        name="mdi:star"
                        size="16"
                        :class="i - 1 < review.rating ? 'text-balck' : 'text-gray-500'"
                      />
                    </div>
                  </div>
                  <div class="">
                    <p :class="review.isExpant ? '' : 'line-clamp-3'">
                      {{ review.content }}
                    </p>
                  </div>
                  <div class="flex gap-2">
                    <img
                      :src="item.image"
                      v-for="item in review.images"
                      :key="item"
                      alt=""
                      class="h-20 w-20"
                    />
                  </div>
                </div>
                <div class="mt-10 pb-5 flex justify-between">
                  <p
                    @click="openCommentBox()"
                    class="underline underline-offset-[10px] hover:cursor-pointer hover:text-gray-600"
                  >
                    Viết đánh giá
                  </p>
                  <p
                    @click="moreComment"
                    :class="
                      numberComment > comment.comments.length
                        ? 'text-gray-400'
                        : 'hover:cursor-pointer hover:text-gray-400'
                    "
                    class="underline underline-offset-[10px]"
                  >
                    Thêm đánh giá
                  </p>
                </div>

                <form v-if="openBox">
                  <div class="flex mb-3">
                    <span
                      v-for="star in 5"
                      :key="star"
                      @click="setRating(star)"
                      @mouseover="hoverRating(star)"
                      @mouseleave="resetHover"
                      class="cursor-pointer"
                    >
                      <Icon
                        v-if="star <= (hover || addComment.rating)"
                        name="mdi:star"
                        size="24"
                      />
                      <Icon v-else name="mdi:star-outline" size="25" />
                    </span>
                  </div>
                  <div
                    class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600"
                  >
                    <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                      <textarea
                        id="comment"
                        rows="4"
                        v-model="addComment.content"
                        class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                        placeholder="Write a comment..."
                        required
                      ></textarea>
                    </div>
                    <div
                      class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600"
                    >
                      <button
                        type="button"
                        @click="clickAddComment"
                        class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800"
                      >
                        Thêm đánh giá
                      </button>
                      <div class="flex ps-0 space-x-1 rtl:space-x-reverse sm:ps-2">
                        <button
                          type="button"
                          class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600"
                        >
                          <svg
                            class="w-4 h-4"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 12 20"
                          >
                            <path
                              stroke="currentColor"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M1 6v8a5 5 0 1 0 10 0V4.5a3.5 3.5 0 1 0-7 0V13a2 2 0 0 0 4 0V6"
                            />
                          </svg>
                          <span class="sr-only">Attach file</span>
                        </button>
                        <button
                          type="button"
                          class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600"
                        >
                          <svg
                            class="w-4 h-4"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 16 20"
                          >
                            <path
                              d="M8 0a7.992 7.992 0 0 0-6.583 12.535 1 1 0 0 0 .12.183l.12.146c.112.145.227.285.326.4l5.245 6.374a1 1 0 0 0 1.545-.003l5.092-6.205c.206-.222.4-.455.578-.7l.127-.155a.934.934 0 0 0 .122-.192A8.001 8.001 0 0 0 8 0Zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"
                            />
                          </svg>
                          <span class="sr-only">Set location</span>
                        </button>
                        <button
                          type="button"
                          @click="clickImage"
                          class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600"
                        >
                          <label class="hover:cursor-pointer">
                            <svg
                              class="w-4 h-4"
                              aria-hidden="true"
                              xmlns="http://www.w3.org/2000/svg"
                              fill="currentColor"
                              viewBox="0 0 20 18"
                            >
                              <path
                                d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z"
                              />
                            </svg>
                          </label>
                          <input
                            type="file"
                            ref="image"
                            name=""
                            class="sr-only"
                            @change="selectImage"
                            multiple
                          />
                          <span class="sr-only">Upload image</span>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="flex flex-wrap gap-4">
                    <img
                      :src="getImageUrl(item.image)"
                      v-for="item in addComment.commentImages"
                      :key="item"
                      class="w-16 h-16"
                    />
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-10 mx-[48px] flex-1 justify-between">
      <p class="text-2xl font-bold text-[#006007]" @click="an">
        Các sản phẩm nổi bật khác
      </p>
    </div>
    <div class="mt-5">
      <SliderProduct :products="products" />
    </div>
    <FormLoading v-if="load" />
  </div>
</template>

<script setup>
const hover = ref(null);
const dropdown1 = ref(false);
const dropdown2 = ref(false);
const dropdown3 = ref(false);
const stars = ref([]);
const openComment = ref(false);
const openBox = ref(false);
const selectedImage = ref(null);
const load = ref(true);
const selectedSize = ref(null);
const selectedColor = ref(null);
const numberComment = ref(3);
const image = ref(null);
const clickImage = () => {
  image.value.click();
};
const addComment = ref({
  product_id: null,
  rating: 0,
  content: null,
  commentImages: [],
});
const changeImage = (newImageUrl, newColor) => {
  selectedImage.value = newImageUrl;
  selectedColor.value = newColor;
  generateStars();
};
const changeSize = (newSize) => {
  selectedSize.value = newSize;
};
const formatCurrency = (value) => {
  const formatter = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  });
  return formatter.format(value);
};
const generateStars = async () => {
  const fullStars = Math.floor(rating.value);
  const hasHalfStar = rating.value % 1 !== 0;
  const percentage = (rating.value - fullStars) * 100;
  console.log(percentage);

  for (let i = 0; i < 5; i++) {
    if (i < fullStars) {
      stars.value.push({ icon: "mdi:star", color: "text-black" });
    } else if (hasHalfStar && i === fullStars) {
      await stars.value.push({
        icon: "mdi:star",
        color: "text-black-half relative absolute z-10",
        style:
          "mask: linear-gradient(to left, transparent 0%, transparent " +
          (100 - percentage) +
          "%, black 0%, black 100%)",
      });
      await stars.value.push({
        icon: "mdi:star",
        color: "text-gray-500 relative -ml-5 absolute",
      });
    } else {
      await stars.value.push({ icon: "mdi:star", color: "text-gray-500" });
    }
  }
};

const openCommentBox = async () => {
  await auth.info();
  console.log(auth.Message);
  if (auth.Message == 401) {
    alert("Bạn chưa đăng nhập");
    router.push("/login");
  }
  openBox.value = !openBox.value;
};

const delay = (ms) => {
  return new Promise((reject) => setTimeout(reject, ms));
};
const axios = useProductStore();
const route = useRoute();
const router = useRouter();
const auth = useAuthStore();
const comment = useCommentStore();
onMounted(async () => {
  const id = route.params.id;
  await Promise.all([
    axios.getProduct(id),
    comment.getComments(id),
    axios.getProductOther(),
  ]);

  await delay(3000).then(async () => {
    await changeImage(product.value.image);
    load.value = false;
  });
});

const comments = computed(() => comment.commentsList);
const rating = computed(() => {
  let total = 0;
  for (let i = 0; i < comments.value.length; i++) {
    total += comments.value[i].rating;
  }
  return comments.value.length ? total / comments.value.length : 0;
});
const selecteComment = computed({
  get: () => comments.value.slice(0, numberComment.value),
});
const moreComment = () => {
  numberComment.value += 3;
};
const setRating = (value) => {
  addComment.value.rating = value;
};
const hoverRating = (value) => {
  hover.value = value;
};
const resetHover = () => {
  hover.value = null;
};
const products = computed(() => axios.productOtherList);
const variants = computed(() => product.value.variants);

const product = computed(() => axios.oneProduct);

const cartItem = ref({
  product_id: null,
  color: null,
});
const cart = useCartStore();
const addToCart = async () => {
  cartItem.value.product_id = product.value.id;
  cartItem.value.color = selectedColor.value;
  console.log(cartItem.value);
  await cart.addToCart(cartItem.value);
  if (cart.Message == 401) {
    alert("Bạn chưa đăng nhập");
    router.push("/login");
  }
  if (cart.Message == 409) {
    alert("Sản phẩm đã tồn tại");
  } else {
    alert("Thêm sản phẩm thành công");
  }
};
const selectImage = (event) => {
  const selcetedFiles = event.target;
  if (selcetedFiles.files.length > 0) {
    for (let i = 0; i < selcetedFiles.files.length; i++) {
      const selectedFile = selcetedFiles.files[i];
      addComment.value.commentImages.push({ image: selectedFile });
    }
  }
};
const clickAddComment = async () => {
  let formData = new FormData();
  formData.append("product_id", route.params.id);
  formData.append("rating", addComment.value.rating);
  formData.append("content", addComment.value.content);
  for (let i = 0; i < addComment.value.commentImages.length; i++) {
    formData.append(
      "commentImages[" + i + "][image]",
      addComment.value.commentImages[i].image
    );
  }
  await comment.addComment(formData);
  addComment.value.rating = 0;
  addComment.value.content = null;
  addComment.value.images = [];
  await comment.getComments(route.params.id);
  openBox.value = false;
};
const getImageUrl = (file) => {
  if (typeof file === "string") {
    return file;
  } else if (file instanceof File || file instanceof Blob) {
    return URL.createObjectURL(file);
  }
};

const favorite = useFavoriteStore();
const addFavorite = async () => {
  cartItem.value.product_id = product.value.id;
  cartItem.value.color = selectedColor.value;
  await favorite.addFavorite(cartItem.value);
  if (favorite.Message == 409) {
    alert("Sản phẩm đã tồn tại");
  }
};
</script>

<style scoped>
::-webkit-scrollbar {
  display: none;
}
</style>
