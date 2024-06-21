<template>
  <v-layout>
    <v-navigation-drawer v-model="drawer" permanent location="left"
      style="background-color: #ffffff; color: rgb(10, 0, 0);">
      <template v-slot:prepend>
        <v-list-item class="text-black" lines="two">
          <v-list-item class="text-black" lines="two"
          prepend-avatar="https://scontent.fhan17-1.fna.fbcdn.net/v/t39.30808-6/407939318_1449381672660511_5070455768013579666_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=efb6e6&_nc_eui2=AeFRGkRI0iWcF5Nq1kGikY1HbaIBQgN1iVRtogFCA3WJVG0QTSzHZyJ6bo5SrqSQXlm5eDd5VXuJSyWuYcQAmfeB&_nc_ohc=o9a5UnPN_GMAX9V9WTX&_nc_oc=AQmmaveVXdb0XIUCr9lAfsbhgHUAbRMUcoECJnxfJHp_hRFRngk2IdHtUMqmaRRqN4Y&_nc_ht=scontent.fhan17-1.fna&oh=00_AfCY-vAWrT2n1Gl67sptbEqs-oDJqL5aclwRUG-UPy26Mw&oe=65E17203">  
          </v-list-item>

    <v-list-item-content>
      <v-list-item-title>NikeShoes</v-list-item-title>
      <v-list-item-subtitle>
        <!-- Thêm icon vào phần subtitle -->
        <v-icon>mdi-shoe-sneaker</v-icon>------ 
      </v-list-item-subtitle>
    </v-list-item-content>
  </v-list-item>
      </template>
      <v-divider></v-divider>
      <v-list density="compact" nav>
        <v-list-item :to="{ name: 'Dashboard' }" prepend-icon="mdi-account-group-outline" title="Dashboard"
          value="users"></v-list-item>
        <v-list-item :to="{ name: 'CategoryView' }" prepend-icon="mdi-home-city" title="Danh Mục"
          value="Danh mục"></v-list-item>
        <v-list-item :to="{ name: 'ProductView' }" prepend-icon="mdi-account" title="Sản Phẩm"
          value="Sản Phẩm"></v-list-item>
        <v-list-item :to="{ name: 'DonHang' }" prepend-icon=" mdi-cart" title="Đơn Hàng" value="Đơn Hàng"></v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-main>
      <v-toolbar style=" background-color: #ffffff;" dense app height="60">
        <v-app-bar-nav-icon color="black" @click="drawer = !drawer"></v-app-bar-nav-icon>
        <v-card-text>
          <v-text-field :loading="loading" density="compact" variant="solo" label="Search templates"
            append-inner-icon="mdi-magnify" single-line hide-details @click:append-inner="onClick"></v-text-field>
        </v-card-text>
        <v-spacer></v-spacer>
        <p class="text-black ma-2">{{ this.currentDateTime }}</p>

        <v-btn color="black" icon>
          <v-badge content="2" color="error">
            <v-icon>mdi-bell-outline</v-icon>
          </v-badge>
        </v-btn>
        <v-menu open-on-hover>
          <template v-slot:activator="{ props }">
            <v-btn v-bind="props">
              <v-avatar
                image="https://scontent.fhan17-1.fna.fbcdn.net/v/t39.30808-6/407939318_1449381672660511_5070455768013579666_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=efb6e6&_nc_eui2=AeFRGkRI0iWcF5Nq1kGikY1HbaIBQgN1iVRtogFCA3WJVG0QTSzHZyJ6bo5SrqSQXlm5eDd5VXuJSyWuYcQAmfeB&_nc_ohc=o9a5UnPN_GMAX9V9WTX&_nc_oc=AQmmaveVXdb0XIUCr9lAfsbhgHUAbRMUcoECJnxfJHp_hRFRngk2IdHtUMqmaRRqN4Y&_nc_ht=scontent.fhan17-1.fna&oh=00_AfCY-vAWrT2n1Gl67sptbEqs-oDJqL5aclwRUG-UPy26Mw&oe=65E17203"></v-avatar>
            </v-btn>
          </template>
          <v-list>
            <v-list-item v-for="(item, index) in items" :key="index">
              <v-list-item-title style="cursor: pointer;">{{ item.title }}</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </v-toolbar>
      <router-view />
    </v-main>
  </v-layout>
  
</template>
  
<script>
export default {
  name: 'HeaderView',
  data() {
    return {
      drawer: true,
      currentDateTime: '',
      items: [
        { title: 'DuyBeus' }
      ],
      loaded: false,
      loading: false,
    };
  },
  methods: {
    onClick() {
      this.loading = true
      setTimeout(() => {
        this.loading = false
        this.loaded = true
      }, 2000)
    },
    formatTime: function (time) {
      return time < 10 ? `0${time}` : time;
    },
    // Cập nhật thời gian và ngày tháng năm
    updateDateTime: function () {
      const now = new Date();
      const day = now.getDate();
      const month = now.getMonth() + 1; // Tháng bắt đầu từ 0
      const year = now.getFullYear();
      const hours = now.getHours();
      const minutes = now.getMinutes();
      const seconds = now.getSeconds();
      this.currentDateTime = `${this.formatTime(day)}/${this.formatTime(month)}/${year} ${this.formatTime(hours)}:${this.formatTime(minutes)}:${this.formatTime(seconds)}`;
    }
  },
  mounted: function () {
    // Cập nhật thời gian ban đầu
    this.updateDateTime();
    // Cập nhật thời gian mỗi giây
    setInterval(this.updateDateTime, 1000);
  }
}
</script>
  
<style></style>
  