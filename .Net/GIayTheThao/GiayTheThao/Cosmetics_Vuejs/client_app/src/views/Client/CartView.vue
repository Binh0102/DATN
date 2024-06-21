<template>
    <v-container>
        <v-card class="rounded-0" v-if="this.$store.state.listCart == null || this.$store.state.listCart.length === 0">
            <v-toolbar max-height="60px" class="text-center bold-text" style="background-color: #46694f;color: white;">
                <v-icon left class="mx-6" size="40" color="white">mdi-check-underline-circle-outline</v-icon>
                <h3>Giỏ hàng </h3>
            </v-toolbar>
            <v-card-text>
                <p class="text-center text-red ma-10">Chưa có sản phẩm nào</p>
            </v-card-text>
        </v-card>
        <v-card class="rounded-0" v-else>
            <v-toolbar max-height="60px" class="text-center bold-text" style="background-color: #46694f;color: white;">
                <v-icon left class="mx-6" size="40" color="white">mdi-check-underline-circle-outline</v-icon>
                <h3>Giỏ hàng </h3>
            </v-toolbar>

            <v-card-text v-if="this.$store.state.listCart == null || this.$store.state.listCart.length === 0">
                <p class="text-center text-red ma-10">Chưa có sản phẩm nào</p>
            </v-card-text>
            <v-card-text v-else>
                <div class="ma-1">
                    <p>Giỏ hàng bạn đang hiện có <span class="text-red">{{ this.$store.state.listCart.length }}</span> Sản
                        Phẩm</p>
                    <v-table fixed-header class="bottom-border">
                        <thead>
                            <tr>
                                <th colspan="4" v-if="this.textErro != ''">
                                    <span style="color: rgb(239, 105, 105);">{{ this.textErro }}</span>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <p><v-checkbox v-model="selectAll" color="success"
                                            class="d-flex align-center justify-center"></v-checkbox></p>
                                </th>
                                <th colspan="1.5">Thông tin sản phẩm</th>
                                <th style="min-width: 150px;">Đơn giá</th>
                                <th style="min-width: 150px;">Số lượng</th>
                                <th style="min-width: 150px;">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="cart in this.$store.state.listCart" :key="cart">
                                <td>
                                    <v-checkbox color="success" @change="handClick()" v-model="chooseListProduct"
                                        :value="cart.CartId"></v-checkbox>
                                </td>
                                <td colspan="1.5" max-width="20px">
                                    <v-row class="ma-1">
                                        <v-col cols="2">
                                            <v-img height="80" width="80" :src="cart.Image"></v-img>
                                        </v-col>
                                        <v-col cols="8">
                                            <span style="max-width: 100px;">{{ cart.ProductName }}</span>
                                            <p><v-btn @click="deleteCart(cart)" variant="plain" class="text-red">Xóa</v-btn>
                                            </p>
                                        </v-col>
                                    </v-row>
                                </td>
                                <td>
                                    <span class="text-red">{{ formatCurrency(cart.Price) }}</span>
                                </td>
                                <td>
                                    <button type="button" @click="decrementQuantity(cart)" class="button1">-</button>
                                    <span class="span1">{{ cart.Quantity }}</span>
                                    <button type="button" @click="incrementQuantity(cart)" class="button2">+</button>
                                </td>
                                <td>
                                    <span class="text-red">{{ formatCurrency(cart.Price * cart.Quantity) }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </v-table>
                </div>
            </v-card-text>
            <v-card-actions>
                <v-row>
                    <v-col cols="8">

                    </v-col>
                    <v-col cols="2">
                        <p>Tổng tiền: </p>
                    </v-col>
                    <v-col cols="2">
                        <span class="text-red">{{ formatCurrency(total) }}</span>
                    </v-col>
                </v-row>
            </v-card-actions>
            <v-card-actions>
                <v-btn min-width="35%" height="50px" class="ml-auto mr-3" @click="ThanhToan"
                    style="background-color: #46694f !important;color: white;">Thanh toán</v-btn>
            </v-card-actions>
        </v-card>



        <v-dialog v-model="showFormThonTin" transition="dialog-top-transition" width="600px" :style="{ bottom: '80px' }">
            <v-card class="rounded-0">
                <v-toolbar max-height="60px" class="text-center bold-text" style="background-color: #46694f;color: white;">
                    <v-icon left class="mx-6" size="40" color="white">mdi-information</v-icon>
                    <h3>Thông tin nhận hàng</h3>
                    <v-btn class="ml-auto" icon="mdi mdi-close" @click="this.showFormThonTin = false"></v-btn>
                </v-toolbar>
                <v-card-text>
                    <div class="ma-1">
                        <v-row>
                            <v-col cols="12" v-if="this.textErro != ''">
                                <span style="color: red;">{{ this.textErro }}</span>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field prepend-icon="mdi-account-circle" v-model="this.formThongtin.NguoiNhan"
                                    label="Tên người nhận"></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field prepend-icon="mdi-phone-in-talk" v-model="this.formThongtin.Phone"
                                    label="Số điện thoại"></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field prepend-icon="mdi-map-marker" v-model="this.formThongtin.DiaChi"
                                    label="Địa chỉ"></v-text-field>
                            </v-col>
                        </v-row>
                    </div>
                </v-card-text>
                <v-card-actions>
                    <v-btn min-width="35%" height="50px" class="ml-auto mr-3"
                        style="background-color: #46694f !important;color: white;" @click="DatHang()">Đặt hàng</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
import axios from 'axios';
export default {
    name: 'CartView',
    data() {
        return {
            total: null,
            chooseListProduct: [],
            selectAll: false,
            showFormThonTin: false,
            textErro: '',
            formThongtin: {
                NguoiNhan: '',
                Phone: '',
                DiaChi: ''
            },
            orderInfo: {
                NguoiNhan: "",
                Phone: "",
                DiaChi: "",
                Total: 0, // Bạn có thể tính tổng giá tiền ở đây nếu cần thiết
                ListCartId: [],
                UserId: "", // Đặt giá trị UserId theo người dùng đăng nhập
            },
        }
    },
    methods: {
        handClick() {
            this.TinhTongTien()
        },
        formatCurrency(value) {
            const formatter = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
            });
            return formatter.format(value);
        },
        TinhTongTien() {
            if (this.$store.state.listCart == null || this.$store.state.listCart.length === 0)
                return
            this.total = this.$store.state.listCart.filter(product => this.chooseListProduct.includes(product.CartId)).reduce((sum, product) => sum + product.Price * product.Quantity, 0);
        },
        decrementQuantity(item) {
            axios.get('http://localhost:5224/api/Cart/UpdateCart', {
                params: {
                    userId: item.UserId,
                    productId: item.ProductId,
                    status: 0
                },
                headers: {
                    'Authorization': `Bearer ` + this.$store.state.token,
                },
            }).then(() => {
                this.$store.dispatch('getListCart', this.$store.state.UserId)
                setTimeout(() => {
                    this.TinhTongTien()
                }, 100);
            }).catch(erro => {
                if (erro.response.statusText === 'Unauthorized')
                    this.$store.dispatch('logout')
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
        },
        incrementQuantity(item) {
            axios.get('http://localhost:5224/api/Cart/UpdateCart', {
                params: {
                    userId: item.UserId,
                    productId: item.ProductId,
                    status: 1
                },
                headers: {
                    'Authorization': `Bearer ` + this.$store.state.token,
                },
            }).then(() => {
                this.$store.dispatch('getListCart', this.$store.state.UserId)
                setTimeout(() => {
                    this.TinhTongTien()
                }, 100);
            }).catch(erro => {
                if (erro.response.statusText === 'Unauthorized')
                    this.$store.dispatch('logout')
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
        },
        deleteCart(cart) {
            axios.delete('http://localhost:5224/api/Cart/' + cart.CartId, {
                headers: {
                    'Authorization': `Bearer ` + this.$store.state.token,
                },
            }).then(() => {
                this.$store.dispatch('getListCart', this.$store.state.UserId)
                setTimeout(() => {
                    if (this.$store.state.listCart.length === 0) {
                        this.total = 0
                    }
                    else
                        this.TinhTongTien()
                }, 100);

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
        },
        ThanhToan() {
            if (this.total == 0 || this.total == null) {
                this.setTextErro("Vui lòng chọn sản phẩm cần mua")
                return
            }
            if (this.chooseListProduct.length === 0) {
                this.setTextErro("Vui lòng chọn sản phẩm cần mua")
                return
            }
            this.showFormThonTin = true
        },
        setTextErro(content) {
            this.textErro = content,
                setTimeout(() => {
                    this.textErro = ''
                }, 5000);
        },
        DatHang() {
            if (this.formThongtin.NguoiNhan === '' || this.formThongtin.Phone === '' || this.formThongtin.DiaChi === '') {
                this.setTextErro("Vui lòng nhập đủ thông tin đặt hàng")
                return
            }

            this.orderInfo.DiaChi = this.formThongtin.DiaChi
            this.orderInfo.NguoiNhan = this.formThongtin.NguoiNhan
            this.orderInfo.Phone = this.formThongtin.Phone
            this.orderInfo.Total = this.total
            this.orderInfo.ListCartId = this.chooseListProduct
            this.orderInfo.UserId = this.$store.state.UserId

            axios.post('http://localhost:5224/api/Order', this.orderInfo, {
                headers: {
                    'Authorization': `Bearer ` + this.$store.state.token,
                },
            }).then(rs => {
                this.showFormThonTin = false
                this.$emit('close')
                this.$store.commit('setLoginError', {
                    show: true,
                    icon: '$success',
                    content: rs.data,
                    color: 'success'
                });
                setTimeout(() => {
                    this.$store.commit('clearLoginError');
                }, 3000);
                this.$store.dispatch('getListCart', this.$store.state.UserId)
                setTimeout(() => {
                    this.TinhTongTien()
                }, 100);
                setTimeout(() => {
                    location.reload();
                }, 3000);
            }).catch(erro => {
                if (erro.response.statusText === 'Unauthorized')
                    this.$store.dispatch('logout')
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
        },
        setEmpty() {
            this.chooseListProduct = []
        }
    },

    updated() {
        this.TinhTongTien()
    },
    watch:
    {
        chooseListProduct(newvl) {
        },
        selectAll(newVal) {
            if (!newVal) {
                this.setEmpty()
                this.TinhTongTien()
                return
            }
            this.chooseListProduct = this.$store.state.listCart.map(cart => cart.CartId);
            this.TinhTongTien()
        }
    }
}   
</script>

<style scoped>
.bottom-border {
    border-bottom: 1px solid #ddd;
    /* Màu và kiểu đường viền của bạn */
}

.span1 {
    display: inline-block;
    padding: 0;
    text-align: center;
    border-radius: 0;
    width: 35px;
    min-height: 28px;
    border: 1px solid #e5e5e5;
    color: #222;
    height: 28px;
    font-size: 14px;
    margin: 0;
    float: left;
    border-left: none;
    border-right: none;
}

.button1 {
    border-radius: 0;
    border: 1px solid #e5e5e5;
    border-color: #e5e5e5;
    color: #222;
    line-height: 26px;
    padding: 0;
    margin: 0;
    width: 28px;
    background-color: #fff;
    height: 28px;
    float: left;
}

.button2 {
    border-radius: 0;
    border: 1px solid #e5e5e5;
    border-color: #e5e5e5;
    color: #222;
    line-height: 26px;
    padding: 0;
    margin: 0;
    width: 28px;
    background-color: #fff;
    height: 28px;
    float: left;
}
</style>