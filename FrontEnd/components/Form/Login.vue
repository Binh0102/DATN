<template>
  <div
    v-if="abc"
    class="fixed top-0 right-0 left-0 bottom-0 w-full z-auto h-full bg-black bg-opacity-50"
  >
    <div class="text-center pt-24 min-h-screen cursor-pointer" @click.self="closeAuth">
      <div class="w-[70%] bg-[#202123] mx-auto flex cursor-auto">
        <div class="w-1/2">
          <Transition name="slide-left" mode="out-in">
            <div
              v-if="isLogin"
              key="login"
              class="bg-[url('~/assets/images/bg-nike.jpg')] object-cover bg-no-repeat h-[555px] bg-cover text-white relative z-10"
              :class="{ hidden: isLogin == false }"
            >
              <h2 class="pt-[200px] pb-[15px] text-[40px] uppercase font-bold">
                NikeShoop
              </h2>
            </div>
          </Transition>
          <Transition name="slide-left" mode="out-in">
            <div
              class="mt-[25px]"
              :class="{ hidden: isLogin == true }"
              v-if="!isLogin"
              key="register"
            >
              <form action="#" method="post" class="" @submit.prevent="Register">
                <input
                  class="h-[50px] w-[330px] px-[15px] border-0 text-white text-[17px] placeholder-white font-[400] bg-transparent border-b-[5px] border-[white] mb-5 mx-auto outline-none hover:border-[#3970b0] focus:border-[#3970b0] hover:placeholder-[#3970b0] focus:placeholder-[#3970b0]"
                  type="text"
                  id="firstname"
                  v-model="register.name"
                  placeholder="Họ và Tên"
                  title="Please enter your First Name"
                  required=""
                />

                <input
                  class="h-[50px] w-[330px] px-[15px] border-0 text-white text-[17px] placeholder-white font-[400] bg-transparent border-b-[5px] border-[white] mb-5 mx-auto outline-none hover:border-[#3970b0] focus:border-[#3970b0] hover:placeholder-[#3970b0] focus:placeholder-[#3970b0]"
                  type="email"
                  id="email"
                  v-model="register.email"
                  placeholder="mail@example.com"
                  title="Please enter a valid email"
                  required="vui lòng nhập email 1"
                />

                <input
                  class="h-[50px] w-[330px] px-[15px] border-0 text-white text-[17px] placeholder-white font-[400] bg-transparent border-b-[5px] border-[white] mb-5 mx-auto outline-none hover:border-[#3970b0] focus:border-[#3970b0] hover:placeholder-[#3970b0] focus:placeholder-[#3970b0]"
                  type="password"
                  v-model="register.password"
                  placeholder="Password"
                  id="password1"
                  required=""
                />

                <input
                  class="h-[50px] w-[330px] px-[15px] border-0 text-white text-[17px] placeholder-white font-[400] bg-transparent border-b-[5px] border-[white] mb-5 mx-auto outline-none hover:border-[#3970b0] focus:border-[#3970b0] hover:placeholder-[#3970b0] focus:placeholder-[#3970b0]"
                  type="password"
                  v-model="register.password_confirmation"
                  placeholder="Confirm Password"
                  id="password2"
                  required=""
                />

                <button
                  type="submit"
                  class="h-[50px] w-[330px] my-2.5 text-[17px] text-white bg-[#3970b0]"
                >
                  Đăng ký
                </button>
              </form>
              <div class="text-[12px] flex justify-end mr-[100px] mb-[30px]">
                <p
                  @click="toggle"
                  class="text-white hover:text-[#5bff65] hover:cursor-pointer"
                >
                  Bạn đã có tài khoản?
                </p>
              </div>
              <p class="text-white mb-5">Hoặc</p>
              <div class="flex mt-3 gap-1 justify-center">
                <button class="h-12 w-12 border border-white">
                  <Icon name="mdi:facebook" size="24" color="white" />
                </button>
                <button class="h-12 w-12 border border-white">
                  <Icon name="mdi:twitter" size="24" color="white" />
                </button>
                <button class="h-12 w-12 border border-white">
                  <Icon name="mdi:linkedin" size="24" color="white" />
                </button>
                <button class="h-12 w-12 border border-white">
                  <Icon name="mdi:instagram" size="24" color="white" />
                </button>
              </div>
            </div>
          </Transition>
        </div>
        <div class="w-1/2">
          <Transition name="slide-right" mode="out-in">
            <div
              v-if="!isLogin"
              key="register"
              class="bg-[url('~/assets/images/bg-nike.jpg')] bg-no-repeat h-[555px] bg-cover text-white"
              :class="{ hidden: isLogin == true }"
            >
              <h2 class="pt-[200px] pb-[15px] text-[40px] uppercase font-bold">
                NikeShoop
              </h2>
            </div>
          </Transition>
          <Transition name="slide-right" mode="out-in">
            <div
              class="mt-[25px]"
              :class="{ hidden: isLogin == false }"
              v-if="isLogin"
              key="login"
            >
              <form action="#" method="post" @submit.prevent="Login">
                <p class="text-white text-2xl mb-5">Đăng nhập</p>
                <div class="form-control w3layouts">
                  <input
                    class="h-[50px] w-[335px] px-[15px] border-0 text-white text-[17px] placeholder-white font-[400] bg-transparent border-b-[5px] border-[white] mb-5 mx-auto outline-none hover:border-[#3970b0] focus:border-[#3970b0] hover:placeholder-[#3970b0] focus:placeholder-[#3970b0]"
                    type="email"
                    id="email"
                    v-model="login.email"
                    placeholder="Nhập email"
                    title="Please enter a valid email"
                    required=""
                    autocomplete="off"
                  />
                </div>

                <div class="form-control agileinfo">
                  <input
                    class="h-[50px] w-[335px] px-[15px] border-0 text-white text-[17px] placeholder-white font-[400] bg-transparent border-b-[5px] border-[white] mb-5 mx-auto outline-none hover:border-[#3970b0] focus:border-[#3970b0] hover:placeholder-[#3970b0] focus:placeholder-[#3970b0]"
                    type="password"
                    v-model="login.password"
                    placeholder="Nhập Mật khẩu"
                    id="password1"
                    required=""
                  />
                </div>

                <button
                  type="submit"
                  class="h-[50px] w-[335px] mt-2.5 mb-5 text-[17px] text-white bg-[#3970b0]"
                >
                  Đăng nhập
                </button>
              </form>
              <div
                class="text-white mb-[30px] flex mx-[100px] justify-between text-[12px]"
              >
                <p>
                  Bạn chưa có tài khoản?
                  <span
                    @click="toggle"
                    class="hover:text-[#01ff12] hover:cursor-pointer ms-1"
                    >Đăng ký</span
                  >
                </p>
                <p class="hover:text-[#01ff12] hover:cursor-pointer" @click="Login">
                  Quên mật khẩu?
                </p>
              </div>
              <div class="flex mx-[80px] justify-between items-center">
                <p class="text-[#c9e2f5] text-sm">Hoặc đăng nhập với</p>
                <div class="flex gap-1">
                  <button
                    class="h-10 w-10 flex items-center justify-center border border-white"
                  >
                    <Icon name="mdi:facebook" size="20" color="white" />
                  </button>
                  <button
                    class="h-10 w-10 flex items-center justify-center border border-white"
                  >
                    <Icon name="mdi:twitter" size="20" color="white" />
                  </button>
                  <button
                    class="h-10 w-10 flex items-center justify-center border border-white"
                  >
                    <Icon name="mdi:linkedin" size="20" color="white" />
                  </button>
                  <button
                    class="h-10 w-10 flex items-center justify-center border border-white"
                  >
                    <Icon name="mdi:instagram" size="20" color="white" />
                  </button>
                </div>
              </div>
            </div>
          </Transition>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps(["abc"]);
const { abc } = toRefs(props);
const isLogin = ref(true);
const emit = defineEmits("close", "update");
const toggle = () => {
  isLogin.value = !isLogin.value;
};
const auth = useAuthStore();
const Login = async () => {
  await auth.login(login);
  if (auth.Message == 404) {
    alert("Tài khoản không tồn tại");
    login.value.email = null;
    login.value.password = null;
  } else {
    auth.info();
    emit("update");
    closeAuth();
  }
};
const closeAuth = () => {
  emit("close");
};

const login = ref({
  email: null,
  password: null,
});

const register = ref({
  name: null,
  email: null,
  password: null,
});

const Register = () => {
  auth.register(register);
  console.log(register);
  abc.value = false;
};
</script>

<style scope>
.slide-left-enter-active {
  transition: transform 0.6s ease-in-out;
}

.slide-right-enter-from {
  transform: translateX(-50%);
}

.slide-right-enter-active {
  transition: transform 0.6s ease-in-out;
}

.slide-left-enter-from {
  transform: translateX(50%);
}
</style>
