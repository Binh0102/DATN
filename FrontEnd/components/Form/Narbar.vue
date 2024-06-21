<template>
  <div class="min-h-screen w-64 transition duration-300 transform lg:static bg-[#f1f9fd]">
    <div class="flex items-center justify-center mt-5 border-b-4 pb-4 border-[#6c6868]">
      <div class="flex items-center">
        <div class="flex justify-center">
          <img :src="image" alt="" class="h-10 w-10 rounded-full" />
          <p class="mt-2.5">Thông tin tài khoản</p>
        </div>
      </div>
    </div>

    <nav class="mt-5">
      <NuxtLink
        to="/profile"
        :class="{
          'text-gray-100 bg-gray-700 bg-opacity-25': $route.path === '/profile',
        }"
        class="flex border-b items-center px-6 py-2 mt-4 text-black hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
      >
        <Icon name="mdi:person" size="24" />

        <span class="mx-3">Thông tin tài khoản</span>
      </NuxtLink>
      <NuxtLink
        to="/profile/order"
        :class="{
          'text-gray-100 bg-gray-700 bg-opacity-25': $route.path === '/profile/order',
        }"
        class="flex border-b items-center px-6 py-2 mt-4 text-black hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
      >
        <Icon name="mdi:shopping" size="24" />

        <span class="mx-3">Đơn hàng của bạn</span>
      </NuxtLink>
      <NuxtLink
        to="/profile/changePassword"
        :class="{
          'text-gray-100 bg-gray-700 bg-opacity-25':
            $route.path === '/profile/changePassword',
        }"
        class="flex border-b items-center px-6 py-2 mt-4 text-black hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
      >
        <Icon name="mdi:password" size="24" />

        <span class="mx-3">Đổi mật khẩu</span>
      </NuxtLink>

      <NuxtLink
        class="flex items-center px-6 py-2 mt-4 text-black hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
      >
        <button type="button" @click="logout">
          <Icon name="mdi:logout" size="24" />

          <span class="mx-3">Đăng xuất</span>
        </button>
      </NuxtLink>
    </nav>
  </div>
</template>

<script setup>
const image = ref("http://localhost:8000/storage/images/avatar.png");
const auth = useAuthStore();
onMounted(async () => {
  await auth.info();
  image.value = auth.User.image;
});
const route = useRouter();
const logout = () => {
  auth.logout();
  route.push("/");
};
</script>

<style></style>
