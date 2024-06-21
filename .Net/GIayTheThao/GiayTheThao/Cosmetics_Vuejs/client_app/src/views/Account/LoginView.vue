<template>
  <v-dialog class="custom-dialog" transition="dialog-top-transition" width="600px">
    <v-card class="rounded-16">
      <v-tabs v-model="tab" background-color="#46694f" align-tabs="center">
        <v-tab value="DangNhap">Đăng Nhập</v-tab>
        <v-tab value="DangKy">Đăng Ký</v-tab>
      </v-tabs>

      <v-card-text>
        <v-window v-model="tab">
          <v-window-item value="DangNhap">
            <v-form>
  <v-row justify="center">
    <v-col cols="15" md="6">
      <v-text-field rounded-2 prepend-icon="mdi-account" type="email" v-model="formDangNhap.Username" label="Tài khoản" required></v-text-field>
    </v-col>
    <v-col cols="15" md="6">
      <v-text-field rounded-2 prepend-icon="mdi-lock" type="password" v-model="formDangNhap.Password" label="Mật khẩu" required></v-text-field>
    </v-col>
  </v-row>
  <v-row justify="center">
    <v-col cols="15" class="d-flex justify-center">
      <v-btn @click="Login()" dark color="blue">Đăng Nhập</v-btn>
    </v-col>
    <v-col cols="15" class="text-center mt-3">
      <v-btn text @click="this.$emit('showFormQuenMatKhau')" color="">Quên mật khẩu?</v-btn>
    </v-col>
  </v-row>
</v-form>



            <v-row justify="center" class="mt-4">
              <v-col cols="15" class="text-center">
                <v-btn icon color="" @click="loginWithFacebook">
                  <v-icon size="24">mdi-facebook</v-icon>
                </v-btn>
                <v-btn icon color="" @click="loginWithInstagram">
                  <v-icon size="24">mdi-instagram</v-icon>
                </v-btn>
                <v-btn icon color="" @click="loginWithGoogle">
                  <v-icon size="24">mdi-google</v-icon>
                </v-btn>
                
              </v-col>
            </v-row>
          </v-window-item>

          <v-window-item value="DangKy">
            <v-form>
              <v-row justify="center">
                <v-col cols="15" md="6">
                  <v-text-field prepend-icon="mdi-account" v-model="formDangKy.Fullname" label="Họ và Tên" required></v-text-field>
                </v-col>
                
                <v-col cols="15" md="6">
                  <v-text-field prepend-icon="mdi mdi-google-maps" v-model="formDangKy.Address" label="Địa Chỉ" required></v-text-field>
                </v-col>
                <v-col cols="15" md="6">
                  <v-text-field prepend-icon="mdi mdi-phone-classic" v-model="formDangKy.Phone" label="Số Điện Thoại" required></v-text-field>
                </v-col>
                <v-col cols="15" md="6">  
                  <v-text-field prepend-icon="mdi mdi-account-alert-outline" v-model="formDangKy.Username" label="Tài khoản" required></v-text-field>
                </v-col>
                <v-col cols="15" md="6">
                  <v-text-field type="password" prepend-icon="mdi-lock" v-model="formDangKy.Password" label="Mật khẩu" required></v-text-field>
                </v-col>
                <v-col cols="15" md="6">
                  <v-text-field type="password" prepend-icon="mdi mdi-lock-check" v-model="formDangKy.cfPassword" label="Nhập lại mật khẩu" required></v-text-field>
                </v-col>
              </v-row>
              <v-row justify="center">
                <v-col cols="15" class="d-flex justify-center">
                  <v-btn class="rounded-0" @click="SingUp()" dark color="" style="margin-right: 15px;">Đăng ký</v-btn>
                  <v-btn class="rounded-0" @click="tab = 'DangNhap'" dark color="">Hủy</v-btn>
                </v-col>
              </v-row>
            </v-form>
              </v-window-item>
          </v-window>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>



  
  <script>
  import { mapActions } from 'vuex';
  import axios from 'axios';
  
  export default {
    name: 'LoginView',
    data() {
      return {
        tab: null,
        formDangNhap: {
          Username: '',
          Password: ''
        },
        formDangKy: {
          Fullname:'',
          Address:'',
          Phone:'',
          Username: '',
          Password: '',
          cfPassword: ''
        }
      };
    },
    methods: {
      resetForm() {
    // Kiểm tra xem $refs.loginForm đã tồn tại hay chưa
    if (this.$refs.loginForm) {
      // Nếu tồn tại, thì gọi reset()
      this.$refs.loginForm.reset();
    }

    // Đặt lại dữ liệu
    this.formDangNhap.Username = '';
    this.formDangNhap.Password = '';
    this.formDangKy.Fullname = '';
    this.formDangKy.Address = '';
    this.formDangKy.Phone = '';
    this.formDangKy.Username = '';
    this.formDangKy.Password = '';
    this.formDangKy.cfPassword = '';
  },
  
      ...mapActions(['login']),
  
      Login() {
        this.login(this.formDangNhap);
        this.$emit('close');
        this.resetForm();
      },
      
  
      SingUp() {
        if (this.formDangKy.Password !== this.formDangKy.cfPassword) {
          this.$store.commit('setLoginError', {
            show: true,
            icon: '$error',
            content: "Mật khẩu phải giống nhau",
            color: 'error'
          });
  
          setTimeout(() => {
            this.$store.commit('clearLoginError');
          }, 3000);
          return;
        }
  
        const formData = new FormData();
        formData.append('Username', this.formDangKy.Username);
        formData.append('Password', this.formDangKy.Password);
  
        axios.post("http://localhost:5224/api/Account/singup", formData)
          .then(rs => {
            console.log(rs);
            if (rs.status === 200) {
              this.$emit('close');
              this.$store.commit('setLoginError', {
                show: true,
                icon: '$success',
                content: rs.data,
                color: 'success'
              });
  
              setTimeout(() => {
                this.$store.commit('clearLoginError');
                this.resetForm(); // Gọi resetForm sau khi đăng ký thành công
              }, 3000);
            }
          })
          .catch(erro => {
            if (erro.response.status === 409) {
              this.$emit('close');
              this.$store.commit('setLoginError', {
                show: true,
                icon: '$error',
                content: erro.response.data.message,
                color: 'error'
              });
  
              setTimeout(() => {
                this.$store.commit('clearLoginError');
              }, 3000);
            } else {
              console.error('Lỗi đăng ký:', erro);
            }
          });
      }
    }
  }
  </script>
  

<style scoped>
.custom-dialog {
  border-radius: 16px;
}

.v-tabs__slider {
  background-color: #fff;
}

.v-tabs__item {
  color: white;
}

.rounded-16 {
  border-radius: 16px;
}

.custom-button {
  background-color: #46694f !important;
  border-color: #3b0632 !important;
  color: white !important;
}

.custom-button:hover {
  background-color: #3b033b !important;
}

.custom-button:active {
  transform: scale(0.96);
}
</style>