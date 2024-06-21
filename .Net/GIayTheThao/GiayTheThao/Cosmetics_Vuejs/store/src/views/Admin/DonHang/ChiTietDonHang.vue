<template>
    <v-dialog :style="{ left: '20%' }">
        <v-table height="400px" fixed-header class="bottom-border">
            <thead>
                <tr>
                    <th colspan="1.5">Thông tin sản phẩm</th>
                    <th style="min-width: 150px;">Đơn giá</th>
                    <th style="min-width: 150px;">Số lượng</th>
                    <th style="min-width: 150px;">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="orderdetail in this.listorderDetail" :key="orderdetail.Id">
                    <td colspan="1.5" max-width="20px">
                        <v-row class="ma-1">
                            <v-col cols="2">
                                <v-img height="80" width="80" :src="orderdetail.LinkAnh"></v-img>
                            </v-col>
                            <v-col cols="8">
                                <span style="max-width: 100px;">{{ orderdetail.ProductName }}</span>
                            </v-col>
                        </v-row>
                    </td>
                    <td>
                        <span class="text-red">{{ formatCurrency(orderdetail.Price) }}</span>
                    </td>
                    <td>
                        <span>{{ orderdetail.Quantity }}</span>
                    </td>
                    <td>
                        <span class="text-red">{{ formatCurrency(orderdetail.Price * orderdetail.Quantity) }}</span>
                    </td>
                </tr>
            </tbody>
        </v-table>
    </v-dialog>
</template>

<script>
import axios from 'axios'
export default {
    props: {
        orderId: String
    },
    data() {
        return {
            listorderDetail: []
        }
    },
    methods:
    {
        formatCurrency(value) {
            const formatter = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
            });
            return formatter.format(value);
        },
        getAll(orderId) {
            axios.get('http://localhost:5224/api/OrderDetail', {
                params: {
                    orderId: orderId,
                },

            }).then(rs => {
                this.listorderDetail = rs.data
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
    watch: {
        orderId(newVal) {
            if (newVal == '')
                return
            this.getAll(newVal)
        }
    }
}
</script>

<style></style>