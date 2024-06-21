<template>
    <v-table fixed-header min-height="100px" max-height="400px">
        <thead>
            <tr>
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
</template>

<script>
import axios from 'axios'
export default {
    name: 'DonDangHoanThanh',
    data() {
        return {
            listDonHangDangChuanBi: [],
        }
    },
    methods: {
        getDonHangDangChuanBi() {
            axios.get('http://localhost:5224/api/DashBoard/getDonHangHoanThanh').then(rs => {
                this.listDonHangDangChuanBi = rs.data
                console.log(rs.data)
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
    },
    created() {
        this.getDonHangDangChuanBi()
    },
}
</script>

<style></style>