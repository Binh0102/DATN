<template>
    <CarouselView />
    <h2 class="block-title position-relative text-center bold mb-4 mt-3">
        <span class="position-absolute">Nike-DuyBeus</span>
        <span> SẢN PHẨM NỔI BẬT</span>
    </h2>
    <v-row class="ma-1">
        <v-col v-for="product in products" :key="product.id" cols="12" md="3">
            <v-hover v-slot="{ isHovering, props }">
                <v-card class="mx-auto" max-width="344" min-height="300px">
                    <v-img v-bind="props" class="text-right"
                        src="https://static.nike.com/a/images/q_auto:eco/t_product_v1/f_auto/dpr_1.3/h_467,c_limit/19fef02d-3e4e-44ab-83fc-33092c6a8b2e/tc-7900-shoes-5pxlWt.png"
                        height="200px" cover>
                        <v-btn v-if="this.$store.state.FavoriteProductForUserId != null"
                            @click="AddFavoriteProduct(product)" icon>
                            <v-icon style="background: rgba(248, 243, 243, 0.3);" color="red">{{
                                this.$store.state.FavoriteProductForUserId.some(x => x.ProductId ===
                                product.ProductId) ?
                                'mdi-heart' : 'mdi-heart-outline' }}</v-icon>
                        </v-btn>

                        <v-expand-transition>
                            <v-row v-if="isHovering" class="overlay">
                                <v-col cols="6">
                                    <v-btn @click="AddCart(product)" class="rounded-lg" color="" text>
                                        <span style="font-size: 0.8em;"><b>Thêm giỏ hàng</b></span>
                                    </v-btn>
                                </v-col>
                                <v-col cols="6">
                                    <v-btn class="rounded-lg" color="" text>
                                        <span style="font-size: 0.8em;"><b>Xem chi tiết</b></span>
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-expand-transition>
                    </v-img>

                    <v-card-title>
                        {{ product.ProductName }}
                    </v-card-title>

                    <v-card-subtitle class="mb-5">
                        <v-row>
                            <v-col cols="6">
                                {{ formatCurrency(product.Price) }}
                            </v-col>
                            <v-col cols="6" class="text-right">
                                <v-btn @click="AddCart(product)" style="margin-bottom: 10px;" color="primary">Mua
                                    ngay</v-btn>
                            </v-col>
                        </v-row>
                    </v-card-subtitle>

                    <v-row>
                        <v-col>
                            <v-icon color="yellow" size="x-small">mdi mdi-star</v-icon>
                            <v-icon color="yellow" size="x-small">mdi mdi-star</v-icon>
                            <v-icon color="yellow" size="x-small">mdi mdi-star</v-icon>
                            <v-icon color="yellow" size="x-small">mdi mdi-star</v-icon>
                        </v-col>
                        <v-col cols="6" class="text-right">
                            <v-btn> Đã bán 1,6k </v-btn>
                        </v-col>
                    </v-row>
                </v-card>
            </v-hover>
        </v-col>
    </v-row>


    <div style="width: 100%;" class="text-center">
        <v-btn :to="{ name: 'ListProductSearch',params:{id:-1} }" class="ma-5"
            style="background-color: #3b0532;color: white;" width="200">Xem tất cả</v-btn>
    </div>
</template>
  
<script>
import CarouselView from '@/components/CarouselView.vue';

import axios from 'axios';
export default {
    components: {
        CarouselView
    },
    data() {
        return {
            show: false,
            selection: [],
            products: [],
        }
    },
    methods: {
        getProducts() {
            axios.get("http://localhost:5224/api/Product/UserGetProduct").then(rs => {
                this.products = rs.data
            }).catch(er => {
                alert(er.message)
            })
        },
        formatCurrency(value) {
            const formatter = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
            });

            return formatter.format(value);
        },
        AddFavoriteProduct(item) {
            if (this.$store.state.UserId == null) {
                this.$store.commit('setLoginError', {
                    show: true,
                    icon: '$error',
                    content: "Vui lòng đăng nhập",
                    color: 'error'
                });
                setTimeout(() => {
                    this.$store.commit('clearLoginError');
                }, 3000);
                return
            }

            const formData = new FormData();
            formData.append('ProductId', item.ProductId);
            formData.append('UserId', this.$store.state.UserId);
            axios.post('http://localhost:5224/api/FavoriteProduct', formData, {
                headers: {
                    'Authorization': `Bearer ` + this.$store.state.token,
                },
            }).then(rs => {

                if (rs.data.status === "Add") {
                    this.$store.commit('setLoginError', {
                        show: true,
                        icon: '$success',
                        content: rs.data.message,
                        color: 'success'
                    });
                    setTimeout(() => {
                        this.$store.commit('clearLoginError');
                    }, 3000);
                }
                else {
                    this.$store.commit('setLoginError', {
                        show: true,
                        icon: '$warning',
                        content: rs.data.message,
                        color: 'warning'
                    });
                    setTimeout(() => {
                        this.$store.commit('clearLoginError');
                    }, 3000);
                }

                this.$store.dispatch('getFavoriteProductForUserId', this.$store.state.UserId)
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
        AddCart(item) {
            if (this.$store.state.UserId == null) {
                this.$store.commit('setLoginError', {
                    show: true,
                    icon: '$error',
                    content: "Vui lòng đăng nhập",
                    color: 'error'
                });
                setTimeout(() => {
                    this.$store.commit('clearLoginError');
                }, 3000);
                return
            }

            const formData = new FormData();
            formData.append('ProductId', item.ProductId);
            formData.append('Quantity', 1);
            formData.append('UserId', this.$store.state.UserId);
            axios.post('http://localhost:5224/api/Cart', formData, {
                headers: {
                    'Authorization': `Bearer ` + this.$store.state.token,
                },
            }).then(rs => {
                if (rs.data.status === 0) {
                    this.$store.commit('setLoginError', {
                        show: true,
                        icon: '$warning',
                        content: rs.data.message,
                        color: 'warning'
                    });
                    setTimeout(() => {
                        this.$store.commit('clearLoginError');
                    }, 3000);
                }
                else {
                    this.$store.dispatch('getListCart', sessionStorage.getItem('UserId'))
                    this.$store.commit('setLoginError', {
                        show: true,
                        icon: '$success',
                        content: rs.data.message,
                        color: 'success'
                    });
                    setTimeout(() => {
                        this.$store.commit('clearLoginError');
                    }, 3000);
                }


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
    created() {
        this.getProducts()
    }
}
</script>
<style scoped>
.overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(248, 243, 243, 0.3);
    padding: 10px;
    justify-content: space-around;
}

.block-title {
    padding: 20px 0;
    font-size: 48px;
}

.position-relative {
    position: relative !important;
}

.block-title span:nth-child(1) {
    font-size: 130px;
    width: 100%;
    opacity: 0.05;
    top: 0;
    left: 50%;
    line-height: 1;
    transform: translateX(-50%);
    letter-spacing: 30px;
}

.position-absolute {
    position: absolute !important;
}

.block-title span:nth-child(2) {
    color: #46694f;
    font-size: 60px;
}
</style>