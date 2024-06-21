<template>
    <v-container>
        <v-card class="rounded-0" >
            <v-toolbar max-height="60px" class="text-center bold-text" style="background-color: #46694f;color: white;">
                <v-icon left class="mx-6" size="40" color="white">mdi-cart</v-icon>
                <h3>Đơn hàng của bạn</h3>
            </v-toolbar>
            <v-card-text>
                <div class="ma-1">
                    <v-table fixed-header class="bottom-border">
                        <thead>
                            <tr>
                                <th>Mã Đơn</th>
                                <th style="min-width: 150px;">Người Nhận</th>
                                <th style="min-width: 150px;">Địa Chỉ</th>
                                <th style="min-width: 150px;">Tổng Tiền</th>
                                <th style="min-width: 150px;">Ngày Đặt</th>
                                <th style="min-width: 150px;">Trạng Thái</th>
                                <th style="min-width: 150px;">Xác Nhận</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in this.listDonHangByUserId" :key="item.Id">
                                <td>{{ item.Id }}</td>
                                <td>{{ item.NguoiNhan }}</td>
                                <td>{{ item.DiaChi }}</td>
                                <td>{{ formatCurrency(item.Total) }}</td>
                                <td>{{ formatDateTime(item.NgayDat) }}</td>
                                <td v-if="item.TrangThai === 0"><span class="text-green">Chờ duyệt</span></td>
                                <td v-if="item.TrangThai === -1"><span class="text-white pa-2"
                                        style="background-color: rgb(242, 12, 12);min-width: 30px;">Đã hủy</span></td>
                                <td v-if="item.TrangThai === 1"><span class="text-green">Đang chuẩn bị hàng</span></td>
                                <td v-if="item.TrangThai === 2"><span class="text-blue">Đang giao</span></td>
                                <td v-if="item.TrangThai === 3"><span class="text-white pa-2"
                                        style="background-color: rgb(12, 242, 12);">Thành công</span></td>
                                <td v-if="item.TrangThai === 2">
                                    <v-btn @click="DaNhan(item.Id)" variant="tonal" color="green">Đã nhận</v-btn>
                                </td>
                                <td v-else></td>
                                <td>
                                    <v-btn @click="ShowDetails(item)" variant="text"><v-icon color="green">mdi-eye</v-icon></v-btn>
                                </td>
                                <td v-if="item.TrangThai===0 || item.TrangThai===1">
                                    <v-btn @click="HuyDon(item.Id)" variant="tonal" color="red">Hủy</v-btn>
                                </td>
                            </tr>
                        </tbody>
                    </v-table>
                </div>
            </v-card-text>
        </v-card>
        <ChiTietDonHangVue :orderId="this.orderId" v-model="this.ShowDialogDetails" />
    </v-container>
</template>
<script>
import axios from 'axios';
import ChiTietDonHangVue from './ChiTietDonHang.vue';
export default {
    name: 'DonHang',
    components: {
        ChiTietDonHangVue
    },
    props: {
        id: String
    },
    data() {
        return {
            listDonHangByUserId: [],
            ShowDialogDetails: false,
            orderId: ''
        }
    },
    mounted() {
        this.getlistDonHangByUserId(this.$store.state.UserId)
    },
    methods: {
        getlistDonHangByUserId(UserId) {
            if (sessionStorage.getItem('UserId')) {
                axios.get('http://localhost:5224/api/Order', {
                    params: {
                        id: UserId,
                    },
                    headers: {
                        'Authorization': `Bearer ` + this.$store.state.token,
                    },
                }).then(rs => {
                    this.listDonHangByUserId = rs.data
                    //console.log(this.listDonHangByUserId)
                    //console.log(rs.data)
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
            }
        },
        formatDateTime(dateTimeString) {
            const dateObject = new Date(dateTimeString);
            const day = String(dateObject.getDate()).padStart(2, '0');
            const month = String(dateObject.getMonth() + 1).padStart(2, '0');
            const year = String(dateObject.getFullYear()).slice(2);
            const hours = String(dateObject.getHours()).padStart(2, '0');
            const minutes = String(dateObject.getMinutes()).padStart(2, '0');
            const seconds = String(dateObject.getSeconds()).padStart(2, '0');
            return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
        },
        formatCurrency(value) {
            const formatter = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
            });
            return formatter.format(value);
        },
        ShowDetails(item) {
            this.orderId = item.Id
            this.ShowDialogDetails = true
        },
        DaNhan(id) {
            axios.get('http://localhost:5224/api/Order/DaNhanDonHang', {
                params: {
                    id: id
                },
                headers: {
                    'Authorization': `Bearer ` + this.$store.state.token,
                },
            }).then(() => {
                this.getlistDonHangByUserId(this.$store.state.UserId)
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
        HuyDon(id)
        {
            axios.get('http://localhost:5224/api/Order/HuyDon', {
                params: {
                    id: id
                },
                headers: {
                    'Authorization': `Bearer ` + this.$store.state.token,
                },
            }).then(() => {
                this.getlistDonHangByUserId(this.$store.state.UserId)
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
        }
    },
    watch: {
        id(newVal) {
            this.getlistDonHangByUserId(newVal)
        }
    }
}
</script>

<style></style>