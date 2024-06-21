<template>
    <v-app-bar style="background-color: #ffffff !important;" class="text-black">
        <v-app>
            <v-app-bar app>
    <v-toolbar-title class="ml-4">
        <router-link to="/" class="text-decoration-none text-black">NikeShoes</router-link>
        <v-icon>mdi-shoe-sneaker</v-icon>----
    </v-toolbar-title>
</v-app-bar>

  </v-app>
        <v-toolbar-items>
            <v-btn :to="{ name: 'TrangChu' }">Trang Chủ</v-btn>
            <v-btn>Giới Thiệu</v-btn>
            <v-menu open-on-hover >
                <template v-slot:activator="{ props }">
                    <v-btn v-bind="props">
                        Sản Phẩm 
                        <v-icon>mdi-chevron-down</v-icon>
                    </v-btn>
                </template>
                <v-list class="rounded-0">
                    <v-list-item :to="{ name: 'ListProductSearch',params:{id:item.CategoryId} }"  v-for="item in this.Categories" :key="item.CategoryId">
                        <p class="hover" style="font-size: 14px;cursor: pointer;">{{ item.CategoryName }}</p>
                    </v-list-item>
                </v-list>
            </v-menu>
            <v-btn>Liên Hệ</v-btn>
            <v-btn>Tin Tức</v-btn>
        </v-toolbar-items>
        <v-spacer></v-spacer>
        <v-autocomplete hide-no-data hide-selected color="white" label="Search" prepend-inner-icon="search"
            flat></v-autocomplete>
        <v-btn v-if="this.$store.state.token != null">
            <v-menu open-on-hover width="500px" min-height="100px" max-height="500px">
                <template v-slot:activator="{ props }">
                    <v-badge @click="showCart()" v-if="this.$store.state.listCart === null" v-bind="props" floating
                        content="0" color="red">
                        <v-icon>mdi-cart</v-icon>
                    </v-badge>
                    <v-badge @click="showCart()" v-else v-bind="props" floating :content="this.$store.state.listCart.length"
                        color="red">
                        <v-icon>mdi-cart</v-icon>
                    </v-badge>
                </template>
                <v-list class="mt-3">
                    <v-list-item>
                        <v-card v-if="this.$store.state.listCart == null || this.$store.state.listCart.length === 0">
                            <v-row>
                                <v-col cols="12" class="text-center">
                                    <span color="red" style="color: red;">Chưa có sản phẩm trong giỏ hàng</span>
                                </v-col>
                            </v-row>
                        </v-card>
                        <v-card v-else>
                            <v-row>
                                <v-col cols="12">
                                    <span style="color: #3b0532;">Sản phẩm mới thêm</span>
                                </v-col>
                            </v-row>
                            <v-row v-for="cart in this.$store.state.listCart" :key="cart">
                                <v-col cols="2">
                                    <v-img width="50" height="50" :src="cart.Image"></v-img>
                                </v-col>
                                <v-col cols="7">
                                    <span>{{ cart.ProductName }}</span>
                                </v-col>
                                <v-col cols="3">
                                    <v-card-text>{{ formatCurrency(cart.Price) }}</v-card-text>
                                </v-col>
                            </v-row>
                        </v-card>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-btn>
        <v-btn v-if="this.$store.state.token == null" @click="this.showformLogin = true">
            Đăng Nhập
        </v-btn>
        <v-btn v-if="this.$store.state.token != null">
            <v-menu open-on-hover>
                <template v-slot:activator="{ props }">
                    <v-btn v-bind="props">
                        <v-avatar
                            image="https://scontent.fhan17-1.fna.fbcdn.net/v/t39.30808-6/407939318_1449381672660511_5070455768013579666_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=efb6e6&_nc_eui2=AeFRGkRI0iWcF5Nq1kGikY1HbaIBQgN1iVRtogFCA3WJVG0QTSzHZyJ6bo5SrqSQXlm5eDd5VXuJSyWuYcQAmfeB&_nc_ohc=o9a5UnPN_GMAX9V9WTX&_nc_oc=AQmmaveVXdb0XIUCr9lAfsbhgHUAbRMUcoECJnxfJHp_hRFRngk2IdHtUMqmaRRqN4Y&_nc_ht=scontent.fhan17-1.fna&oh=00_AfCY-vAWrT2n1Gl67sptbEqs-oDJqL5aclwRUG-UPy26Mw&oe=65E17203"></v-avatar>
                    </v-btn>
                </template>
                <v-list class="mt-3">
                    <v-list-item>
                        <template v-slot:prepend>
                            <v-icon icon="mdi-account-circle"></v-icon>
                        </template>
                        <v-list-item-title @click="ShowProfile()" style="cursor: pointer;">Hồ sơ</v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                        <template v-slot:prepend>
                            <v-icon icon="mdi-cart"></v-icon>
                        </template>
                        <v-list-item-title @click="ShowDonHang()" style="cursor: pointer;">Đơn hàng của
                            bạn</v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                        <template v-slot:prepend>
                            <v-icon icon="mdi-lock"></v-icon>
                        </template>
                        <v-list-item-title @click="ShowDoiMatKhau()" style="cursor: pointer;">Đổi mật khẩu</v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                        <template v-slot:prepend>
                            <v-icon icon="mdi-logout"></v-icon>
                        </template>
                        <v-list-item-title @click="this.$store.dispatch('logout')" style="cursor: pointer;">Đăng
                            xuất</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-btn>
    </v-app-bar>
    <LoginView @showFormQuenMatKhau="showFormQuenMatKhau" @close="closeFormLogin" v-model="this.showformLogin" />

    <form-quen-mat-khau @close="closeFormQuenMatKhau" v-model="isShowFormQuenMatKhau" />
</template>
<script>
import FormQuenMatKhau from '@/views/Account/FormQuenMatKhau.vue'
import LoginView from '@/views/Account/LoginView.vue'
import axios from 'axios'
// import DonHang from '@/views/Client/DonHang.vue'
export default {
    components: {
        LoginView, FormQuenMatKhau,
        // DonHang
    },
    name: 'NavBar',
    data() {
        return {
            drawer: null,
            showformLogin: false,
            items: [
                { title: 'DuyBeus' },
                { title: 'Click Me' },
            ],
            isShowFormQuenMatKhau: false,
            Categories:[]
        }
    },
    methods: {
        closeFormLogin() {
            this.showformLogin = false
        },
        closeFormQuenMatKhau() {
            this.isShowFormQuenMatKhau = false
        },
        showFormQuenMatKhau() {
            this.isShowFormQuenMatKhau = true,
                this.closeFormLogin()
        },
        formatCurrency(value) {
            const formatter = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
            });

            return formatter.format(value);
        },
        showCart() {
            this.cartVisible = true
            this.$router.push({ name: 'CartView' })
        },
        ShowDonHang()
        {
            this.$router.push({ name: 'DonHang' })
        },
        ShowProfile()
        {
            this.$router.push({ name: 'ProfileView' })
        },
        ShowDoiMatKhau()
        {
            this.$router.push({ name: 'DoiMatKhau' })
        },
        getAllCategory()
        {
            axios.get('http://localhost:5224/api/Category').then(rs=>{
                this.Categories=rs.data
            }).catch(erro => {
                this.$store.commit('setLoginError', {
                    show: true,
                    icon: '$error',
                    content: erro.message,
                    color: 'error'
                });
                setTimeout(() => {
                    this.$store.commit('clearLoginError');
                }, 3000);
            })
        }
    },
    created()
    {
        this.getAllCategory()
    }
}
</script>

<style>
.hover:hover{
    color: red;
}
</style>