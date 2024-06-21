<script setup>
const a = ref(true);
const isInfo = ref(false);
const isNavbar = ref(true);
const emit = defineEmits("data");
const sendData = () => {
  isNavbar.value = !isNavbar.value;
  emit("data", isNavbar.value);
};
const auth = useAuthStore();
const route = useRouter();
const name = ref(null);
const user = computed(() => auth.User);
const delay = (ms) => {
  return new Promise((resolve) => setTimeout(resolve, ms));
};
onMounted(async () => {
  await auth.info();
  await delay(1000)
    .then(() => {
      if (!user.value) {
        route.push("/");
      } else {
        if (user.value.role == 1) {
          name.value = user.value.name;
        } else {
          route.push("/404");
        }
      }
    })
    .catch(() => {
      a.value = false;
    });
  a.value = false;
});
const logout = () => {
  auth.logout();
  route.push("/");
};
</script>
<template>
  <header
    class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-indigo-600"
  >
    <div @click="sendData" class="hover:cursor-pointer">
      <Icon name="mdi:menu" size="30" />
    </div>
    <div class="flex items-center">
      <div class="relative border-b border-black">
        <Icon name="mdi:search" size="20" class="absolute top-2 opacity-50" />
        <input
          type="text"
          name=""
          id=""
          class="h-[30px] border-0 focus:outline-none ps-7"
          placeholder="Tìm kiếm"
        />
      </div>
      <div class="relative">
        <button
          @click="notificationOpen = !notificationOpen"
          class="flex mx-4 text-gray-600 focus:outline-none"
        >
          <Icon name="mdi:bell-outline" size="24" />
        </button>
      </div>
      <div class="mr-4 w-full">
        <p>{{ name }}</p>
      </div>
      <div class="flex items-center gap-4">
        <div
          v-if="user"
          @click="isInfo = !isInfo"
          class="w-10 h-10 flex justify-center items-center m-auto ml-4 p-1 hover:cursor-pointer border rounded-full"
        >
          <Icon name="mdi:person" size="24" />
        </div>
        <button @click="logout">
          <Icon name="mdi:logout" size="24" />
        </button>
      </div>
    </div>
  </header>
</template>

<style></style>
