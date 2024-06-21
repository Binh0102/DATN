<template>
  <div class="max-w-[1536px] bg-white">
    <div class="flex items-center h-[64px] justify-between w-screen">
      <div class="flex justify-between h-full items-center">
        <NuxtLink to="/" class="ml-4 flex items-center font-normal pr-6">
          <p class="text-xl">NikeShoes</p>
          <Icon name="mdi:shoe-sneaker" size="30" />
          <p>---</p>
        </NuxtLink>
        <div class="flex items-center h-full">
          <NuxtLink
            to="/"
            :class="{
              'bg-slate-500 bg-opacity-50': $route.path === '/',
            }"
            class="px-4 hover:bg-slate-500 hover:bg-opacity-20 h-full flex items-center"
          >
            TRANG CHỦ
          </NuxtLink>
          <NuxtLink
            to="/"
            class="px-4 focus:bg-slate-500 focus:bg-opacity-50 hover:bg-slate-500 hover:bg-opacity-20 h-full flex items-center"
          >
            GIỚI THIỆU
          </NuxtLink>
          <button class="relative h-[64px] focus:bg-slate-500 focus:bg-opacity-50 w-40">
            <div
              @mouseenter="isMenuOpen = true"
              @mouseleave="isMenuOpen = false"
              class="px-4 hover:bg-slate-500 hover:bg-opacity-20 h-full flex items-center"
            >
              <div class="flex hover:cursor-pointer">
                <p>SẢN PHẨM</p>
                <div class="">
                  <Icon name="mdi:chevron-down" size="24" />
                </div>
              </div>
            </div>
            <Transition>
              <div
                v-if="isMenuOpen || isMouseInDropdown"
                @mouseenter="isMouseInDropdown = true"
                @mouseleave="isMouseInDropdown = false"
                class="absolute w-full max-h-[165px] overflow-y-auto z-10 bg-white border-x border-b border-[#0000001A]"
              >
                <button
                  v-for="item in categories"
                  :key="item.id"
                  @click="openCategory(item.id)"
                >
                  <div
                    class="text-start text-[16px] p-[15px] border-b border-[#0000001A] hover:bg-gray-200 hover:cursor-pointer"
                  >
                    {{ item.name }}
                  </div>
                </button>
              </div>
            </Transition>
          </button>
          <button
            class="px-4 focus:bg-slate-500 focus:bg-opacity-50 hover:bg-slate-500 hover:bg-opacity-20 h-full flex items-center"
          >
            LIÊN HỆ
          </button>
          <button
            class="px-4 focus:bg-slate-500 focus:bg-opacity-50 hover:bg-slate-500 hover:bg-opacity-20 h-full flex items-center"
          >
            TIN TỨC
          </button>
        </div>
      </div>
      <div class="flex items-center gap-4">
        <form class="flex items-center relative" @submit.prevent="sendSearch">
          <input
            type="text"
            placeholder="Tìm kiếm"
            v-model="issearch"
            class="h-[50px] w-[400px] border rounded-md ps-3"
          />
          <Icon
            name="mdi:search"
            size="24"
            class="absolute z-10 right-3"
            @click="sendSearch"
          />
        </form>
        <div v-if="!a" class="flex items-center">
          <button class="mx-4 relative" @click="openFavorite">
            <Icon name="mdi:heart-outline" size="24" />
            <span
              v-if="user"
              class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full transform translate-x-1/2 -translate-y-1/2"
            >
              {{ favorite.favoriteList.length || 0 }}
            </span>
          </button>
          <button class="mx-4 relative" @click="openCart()">
            <Icon name="mdi:cart" size="24" />
            <span
              v-if="user"
              class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full transform translate-x-1/2 -translate-y-1/2"
            >
              {{ cart.cartsList.length || 0 }}
            </span>
          </button>
          <div
            v-if="!user"
            class="hover:cursor-pointer ml-4 mr-8 p-1"
            @click="abc = !abc"
          >
            <p class="mx-4">ĐĂNG NHẬP</p>
          </div>
          <div
            v-if="user"
            class="h-full w-full m-auto ml-4 mr-8 p-1 hover:cursor-pointer border rounded-full"
          >
            <NuxtLink to="/profile">
              <img :src="auth.User.image" alt="" class="w-6 h-6 rounded-full" />
            </NuxtLink>
          </div>
        </div>
      </div>
    </div>
    <FormLogin :abc="abc" :load="load" @close="close" @update="update" />
    <FormLoading v-if="load" />
  </div>
</template>

<script setup>
const load = ref(true);
const issearch = ref("");
const abc = ref(false);
const isInfo = ref(false);
const isMenuOpen = ref(false);
const isMouseInDropdown = ref(false);
const handleClickOutside = (event) => {
  if (dropdown.value && !dropdown.value.contains(event.target)) {
    closeMenu();
  }
};
const search = useSearch();
const route = useRouter();
const product = useProductStore();
const sendSearch = () => {
  console.log(issearch.value);
  route.push("/search");
  search.addSearch(issearch);
};

const close = async () => {
  abc.value = false;
  load.value = true;
  await delay(500).then(() => {
    load.value = false;
  });
};
watch(isMenuOpen, (newValue) => {
  if (newValue) {
    document.addEventListener("click", handleClickOutside);
  } else {
    document.removeEventListener("click", handleClickOutside);
  }
});

const category = useCategoryStore();
const auth = useAuthStore();
const cart = useCartStore();
const favorite = useFavoriteStore();
const delay = (ms) => {
  return new Promise((resolve) => setTimeout(resolve, ms));
};

const update = async () => {
  await delay(2000);
  auth.info();
};
onMounted(async () => {
  await Promise.all([
    category.getCategories(),
    auth.info(),
    cart.getCarts(),
    favorite.getFavorites(),
  ]);
  await delay(500)
    .then(async () => {
      if (user.value.role == 2) {
        load.value = false;
      } else {
        auth.logout();
        load.value = false;
      }
    })
    .catch(() => (load.value = false));
});
const categories = computed(() => category.categoriesList);
const user = computed(() => auth.User);

const openCart = () => {
  if (user.value) {
    route.push("/cart");
  } else {
    route.push("/login");
  }
};
const openFavorite = () => {
  if (user.value) {
    route.push("/favorite");
  } else {
    route.push("/login");
  }
};

const openCategory = (id) => {
  product.getProductCategory(id);
  route.push("/productCategory/" + id);
};
</script>

<style></style>
