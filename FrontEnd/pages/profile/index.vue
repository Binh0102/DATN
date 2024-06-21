<template>
  <div>
    <div class="pt-10 min-h-screen cursor-pointer">
      <div class="w-[70%] bg-white mx-auto cursor-auto pb-6 rounded-lg shadow-lg">
        <form @submit.prevent="updateInfo()">
          <div class="h-[575px] bg-cover relative">
            <div class="pb-5 border-b mx-6">
              <h2 class="text-2xl font-semibold pt-4 ml-3">Hồ Sơ Của Tôi</h2>
              <p class="text-[15px] ml-3">Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
            </div>
            <div class="flex">
              <div class="w-9/12">
                <div class="ml-28 mt-10 flex">
                  <p class="w-[110px]">Tên</p>
                  <input
                    type="text"
                    class="ml-6 w-[400px]"
                    v-model="user.name"
                    placeholder="Họ và tên"
                  />
                </div>

                <div class="ml-28 mt-8 flex">
                  <p class="w-[110px]">Email</p>
                  <input
                    type="text"
                    v-model="user.email"
                    class="ml-6 w-[400px]"
                    disabled
                  />
                </div>

                <div class="ml-28 mt-8 flex">
                  <p class="w-[110px]">Số điện thoại</p>
                  <input
                    type="text"
                    class="ml-6 w-[400px]"
                    v-model="user.phone"
                    placeholder="Số điện thoại"
                  />
                </div>

                <div class="ml-28 mt-8 flex">
                  <p class="w-[110px]">Địa chỉ</p>
                  <input
                    type="text"
                    class="ml-6 w-[400px]"
                    v-model="user.address"
                    placeholder="Địa chỉ"
                  />
                </div>

                <div class="ml-28 mt-4 flex">
                  <p class="w-[110px]">Giới tính</p>
                  <div class="flex items-center ml-6">
                    <input
                      v-model="user.gender"
                      id="check-radio-1"
                      type="radio"
                      value="1"
                      name="radio"
                      class="w-4 h-4 text-[#007006] focus:ring-[#00000033] dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-1 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <label
                      for="check-radio-1"
                      class="ps-2 pr-4 text-[#0000006B] dark:text-gray-500"
                      >Nam</label
                    >
                  </div>
                  <div class="flex items-center ml-5">
                    <input
                      v-model="user.gender"
                      id="check-radio-2"
                      type="radio"
                      value="2"
                      name="radio"
                      class="w-4 h-4 text-[#007006] border-gray-300 focus:ring-[#00000033] dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-1 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <label
                      for="check-radio-2"
                      class="ps-2 pr-4 text-[#0000006B] dark:text-gray-500"
                      >Nữ</label
                    >
                  </div>
                  <div class="flex items-center ml-5">
                    <input
                      v-model="user.gender"
                      id="check-radio-2"
                      type="radio"
                      value="3"
                      name="radio"
                      class="w-4 h-4 text-[#007006] border-gray-300 focus:ring-[#00000033] dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-1 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <label
                      for="check-radio-2"
                      class="ps-2 pr-4 text-[#0000006B] dark:text-gray-500"
                      >Khác</label
                    >
                  </div>
                </div>
              </div>
              <div class="mt-[25px] w-3/12">
                <div class=" ">
                  <div class="flex justify-center">
                    <div class="">
                      <div class="mx-12">
                        <img
                          :src="getImageUrl(image)"
                          class="container rounded-full w-[200px] h-[200px]"
                          alt=""
                        />
                      </div>
                      <div class="text-center pt-[25px] text-[#000000B2] pb-[30px]">
                        <input
                          type="file"
                          class="hidden"
                          ref="avatar"
                          @change="displayImage"
                        />
                        <button type="button" @click="addAvatar" class="border py-4 px-5">
                          Chọn ảnh
                        </button>
                      </div>
                      <div class="text-[#0000006B] text-center">
                        <p>Dung lượng file tối đa 1 MB</p>
                        <p>Định dạng: JPEG, JPG, PNG</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="ml-28 mt-6 flex">
              <p class="w-[110px]"></p>
              <button type="submit" class="ml-6 py-2 px-8 border bg-green-700 text-white">
                Lưu
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script setup>
const image = ref("http://localhost:8000/storage/images/avatar.png");
const avatar = ref(null);
const user = ref({
  name: null,
  gender: null,
  phone: null,
  email: null,
  address: null,
});
const addAvatar = () => {
  avatar.value.click();
  console.log(image);
};

const displayImage = (event) => {
  const selectedFiles = event.target.files[0];
  image.value = selectedFiles;
};
const auth = useAuthStore();
onMounted(async () => {
  await auth.info();
  user.value.name = auth.User.name;
  user.value.gender = auth.User.gender;
  user.value.phone = auth.User.phone;
  user.value.email = auth.User.email;
  user.value.address = auth.User.address;
  image.value = auth.User.image;
});
definePageMeta({
  layout: "profile",
});

const updateInfo = () => {
  console.log(user.value.gender);
  let formData = new FormData();
  formData.append("name", user.value.name);
  formData.append("phone", user.value.phone);
  formData.append("address", user.value.address);
  formData.append("gender", user.value.gender);
  formData.append("image", image.value);
  formData.append("_method", "PUT");
  console.log(formData);
  auth.updateInfo(formData);
  auth.info();
};
const getImageUrl = (file) => {
  if (typeof file === "string") {
    return file;
  } else if (file instanceof File || file instanceof Blob) {
    return URL.createObjectURL(file);
  }
};
</script>

<style></style>
