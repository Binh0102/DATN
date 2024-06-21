<template>
  <v-dialog class="custom-dialog" transition="dialog-top-transition" width="500px">
    <v-card class="rounded-0">
      <v-toolbar class="d-flex justify-space-between align-center" style="background-color: whitesmoke; color: black;">
        <v-toolbar-title class="ml-4 bold-text">Quên mật khẩu</v-toolbar-title>
        <v-btn icon @click="$emit('close')">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-toolbar>
      <v-card-text>
        <v-row>
          <v-col cols="12">
            <v-text-field v-if="codeApi === ''" v-model="Username" prepend-icon="mdi-account" label="Tài khoản"
                          required></v-text-field>
            <v-text-field v-if="codeApi === ''" v-model="Fullname" prepend-icon="mdi-account" label="Họ và Tên"
                          required></v-text-field>
            <v-text-field v-if="codeApi === ''" v-model="Phone" prepend-icon="mdi-account" label="Số Điện Thoại"
                          required></v-text-field>
            <v-text-field v-else type="password" v-model="FormData.NewPass" prepend-icon="mdi-account" label="Mật khẩu mới"
                          required></v-text-field>
          </v-col>
          <v-col cols="12" v-if="codeApi !== ''">
            <v-text-field type="password" v-model="FormData.CfNewPass" prepend-icon="mdi-account"
                          label="Nhập lại mật khẩu mới" required></v-text-field>
          </v-col>
          <v-col cols="12" v-if="codeApi !== ''">
            <v-text-field v-model="codeClient" prepend-icon="mdi-account" label="Nhập mã xác minh" required></v-text-field>
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-actions class="justify-center">
        <v-btn class="rounded-0" @click="codeApi === '' ? submit() : save()"
               :style="{ backgroundColor: codeApi === '' ? '#3b0532' : '#028bda', color: 'white', borderColor: codeApi === '' ? '#3b0532' : 'white' }">
          {{ codeApi === '' ? 'Submit' : 'Lưu' }}
        </v-btn>
        <v-btn class="rounded-0" @click="$emit('close')"
               :style="{ backgroundColor: codeApi === '' ? '#3b0532' : '#ABBAC3', color: 'white', borderColor: 'white' }">
          Hủy
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>

</template>

<script>
import axios from 'axios';

export default {
  name: 'FormQuenMatKhau',
  data() {
    return {
      Username: '',
      Fullname:'',
      Address:'',
      Phone:'',
      FormData: {
        Username: '',
        NewPass: '',
        CfNewPass: '',
      },
      codeClient: '',
      codeApi: '',
    };
  },
  methods: {
    submit() {
      axios.post('http://localhost:5224/api/Account/QuenPassword', null, {
        params: {
          username: this.Username,
        },
      }).then(rs => {
        this.codeApi = rs.data.Code;
        this.FormData.Username = rs.data.Username;
      }).catch(er => {
        this.$emit('close');
        this.showError(er.response.data);
      });
    },
    save() {
      if (this.codeApi !== this.codeClient) {
        this.$emit('close');
        this.showError('Mã xác minh không đúng');
        return;
      }
      if (this.FormData.CfNewPass !== this.FormData.NewPass) {
        this.$emit('close');
        this.showError('2 mật khẩu không giống nhau');
        return;
      }
      axios.post('http://localhost:5224/api/Account/DoiMatKhau', this.FormData).then(rs => {
        this.$emit('close');
        this.showSuccess(rs.data);
      }).catch(er => {
        this.$emit('close');
        this.showError(er.message);
      });
    },
    showError(message) {
      this.$store.commit('setLoginError', {
        show: true,
        icon: '$error',
        content: message,
        color: 'error',
      });
      setTimeout(() => {
        this.$store.commit('clearLoginError');
      }, 3000);
    },
    showSuccess(message) {
      this.$store.commit('setLoginError', {
        show: true,
        icon: '$success',
        content: message,
        color: 'success',
      });
      setTimeout(() => {
        this.$store.commit('clearLoginError');
      }, 3000);
    },
  },
};
</script>

<style scoped>
.custom-dialog {
  margin-top: 10vh;
}

.bold-text {
  font-weight: bold;
}
</style>
