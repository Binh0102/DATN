<template>
    <v-card>
        <v-table fixed-header min-height="100px" max-height="400px">
            <thead>
                <tr>
                    <th>
                        <v-checkbox v-model="selectAll" color="sublackcess"
                            class="d-flex align-center justify-center"></v-checkbox>
                    </th>
                    <th>MĐH</th>
                    <th>Tên KH</th>
                    <th>Địa Chỉ</th>
                    <th>Total</th>
                    <th>Time</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in listDonHangDangChuanBi" :key="item.Id">
                    <td><v-checkbox v-model="chooseListDonHang" :value="item.Id" color="black"
                            class="d-flex align-center justify-center"></v-checkbox></td>
                    <td>
                        <p>{{ item.Id }}</p>
                    </td>
                    <td>{{ item.NguoiNhan }}</td>
                    <td>{{ item.DiaChi }}</td>
                    <td>{{ formatCurrency(item.Total) }}</td>
                    <td>{{ formatDateTime(item.NgayDat) }}</td>
                    <td><v-btn @click="this.$emit('send', item.Id)" variant="text"><v-icon
                                color="green">mdi-eye</v-icon></v-btn></td>
                </tr>
            </tbody>
        </v-table>
        <v-card-actions v-if="this.listDonHangDangChuanBi.length !== 0">
            <v-btn @click="setDonHangDangGiao()" min-width="20%" height="40" class="ml-auto mr-3" style="color: white;"
                color="success" variant="elevated">Đang Giao</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
import axios from 'axios'
export default {
    name: 'DonDangChuanBi',
    data() {
        return {
            listDonHangDangChuanBi: [],
            selectAll: false,
            chooseListDonHang: [],
            orderId: '',
        }
    },
    methods: {
        getDonHangDangChuanBi() {
            axios.get('http://localhost:5224/api/DashBoard/getDonHangDanhChuanBi').then(rs => {
                this.listDonHangDangChuanBi = rs.data
            }).catch(erro => {
                alert(erro)
                console.log(erro)
            })
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
        setEmpty() {
            this.selectAll = false
            this.chooseListDonHang = []
        },
        setDonHangDangGiao() {
            if (this.chooseListDonHang.length === 0 || this.chooseListDonHang == []) {
                this.$store.commit('setLoginError', {
                    show: true,
                    icon: '$error',
                    content: "Vui lòng chọn đơn hàng cần duyệt",
                    color: 'error'
                });
                setTimeout(() => {
                    this.$store.commit('clearLoginError');
                }, 3000);
                return
            }
            axios.post('http://localhost:5224/api/DashBoard/setDonHangDangGiao', this.chooseListDonHang).then(rs => {
                this.getDonHangDangChuanBi()
                this.selectAll = false
                this.chooseListDonHang = []
                this.$store.commit('setLoginError', {
                    show: true,
                    icon: '$success',
                    content: rs.data,
                    color: 'success'
                });
                setTimeout(() => {
                    this.$store.commit('clearLoginError');
                }, 3000);
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
    created() {
        this.getDonHangDangChuanBi()
    },
    watch: {
        selectAll(newVal) {
            //alert(newVal)
            if (!newVal) {
                this.setEmpty()
                return
            }
            this.chooseListDonHang = this.listDonHangDangChuanBi.map(cart => cart.Id);
        },
    }
}
</script>

<style></style>