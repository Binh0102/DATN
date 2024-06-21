<template>
  <div class="pt-10 cursor-pointer">
    <div class="w-[70%] bg-white mx-auto cursor-auto pb-6 shadow-md rounded-lg">
      <form @submit.prevent="updatePassword()">
        <div class="bg-cover relative pb-10">
          <div class="pb-5 border-b mx-6">
            <h2 class="text-2xl font-semibold pt-4 ml-3">Đổi mật khẩu</h2>
          </div>
          <div class="flex">
            <div class="w-9/12">
              <div class="ml-28 mt-10 flex">
                <p class="w-[110px]">Mật khẩu cũ</p>
                <input
                  type="password"
                  class="ml-6 w-[400px]"
                  v-model="user.password_current"
                  placeholder="Mật khẩu cũ"
                  required
                />
              </div>

              <div class="ml-28 mt-8 flex">
                <p class="w-[110px]">Mật khẩu mới</p>
                <input
                  type="password"
                  class="ml-6 w-[400px]"
                  v-model="user.password"
                  placeholder="Mật khẩu mới"
                  required
                />
              </div>
              <div class="ml-28 mt-8 flex">
                <p class="w-[110px]">Nhập lại mật khẩu mới</p>
                <input
                  type="password"
                  class="ml-6 w-[400px]"
                  v-model="user.password_confirmation"
                  placeholder="Nhập lại mật khẩu mới"
                  required
                />
              </div>
            </div>
          </div>
          <div class="ml-28 mt-6 flex">
            <p class="w-[110px]"></p>
            <button class="ml-6 py-2 px-8 border bg-green-700 text-white" type="submit">
              Lưu
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
const user = ref({
  password_current: null,
  password: null,
  password_confirmation: null,
});
const auth = useAuthStore();
const updatePassword = async () => {
  let formdata = new FormData();
  formdata.append("password_current", user.value.password_current);
  formdata.append("password", user.value.password);
  formdata.append("password_confirmation", user.value.password_confirmation);
  formdata.append("_method", "PUT");
  await auth.updatePassword(formdata);

  if (auth.Message == 500) {
    alert("Mật khẩu cũ không đúng");
    user.value.password_current = null;
  }
  if (auth.Message == 422) {
    alert("Mật khẩu không khớp");
    user.value.password = null;
    user.value.password_confirmation = null;
  }
};
definePageMeta({
  layout: "profile",
});
</script>

<style></style>
