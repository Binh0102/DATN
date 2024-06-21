<template>
    <v-card class="rounded-0">
        <v-tabs v-model="tab" bg-color="primary">
            <v-tab value="one">Đơn Đang chuẩn bị</v-tab>
            <v-tab value="four">Đơn Đang Giao</v-tab>
            <v-tab value="two">Đơn hoàn thành</v-tab>
            <v-tab value="three">Đơn Hủy</v-tab>
        </v-tabs>
        <v-card-text>
            <v-window v-model="tab">
                <v-window-item value="one">
                    <DonDangChuanBiVue @send="show" />
                </v-window-item>
                <v-window-item value="four">
                    <DonHangDangGiaoVue @send="show" />
                </v-window-item>
                <v-window-item value="two">
                    <DonHoanThanhVue @send="show" />
                </v-window-item>
                <v-window-item value="three">
                    <DonHangHuyVue @send="show" />
                </v-window-item>
            </v-window>
        </v-card-text>
    </v-card>
    <ChiTietDonHangVue :orderId="this.orderId" v-model="ShowDialogDetail" />
</template>

<script>
import DonDangChuanBiVue from './DonDangChuanBi.vue'
import DonHangDangGiaoVue from './DonHangDangGiao.vue'
import DonHangHuyVue from './DonHangHuy.vue'
import DonHoanThanhVue from './DonHoanThanh.vue'
import ChiTietDonHangVue from './ChiTietDonHang.vue'
export default {
    components: {
        DonDangChuanBiVue,
        DonHangDangGiaoVue,
        DonHangHuyVue,
        DonHoanThanhVue,
        ChiTietDonHangVue,
    },
    data() {
        return {
            tab: null,
            ShowDialogDetail: false,
            orderId: ''
        }
    },
    methods: {
        show(id) {
            this.orderId = id
            this.ShowDialogDetail = true
        }
    }
}
</script>

<style></style>