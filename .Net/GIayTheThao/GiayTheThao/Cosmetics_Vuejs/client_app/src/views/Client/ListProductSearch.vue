<template>
    <CarouselView />
    <div style="background-color: #eee;">
        <v-row>
        <v-col cols="2">
            <v-card class="rounded-0 mt-3 ml-2">
                <v-card-title><strong>DANH MỤC</strong></v-card-title>
                <v-list lines="one">
                    <v-list-item class="hover"
                        @click="searchByCategory(item.CategoryId)"
                        v-for="item in this.Categories"
                        :key="item.CategoryId"
                        :title="item.CategoryName"
                    ></v-list-item>
                    </v-list>
            </v-card>
        </v-col>
        <v-col cols="10">
            <div style="background-color: white;">
                <h2 class="block-title position-relative text-center bold mb-4 mt-3">
                <span class="position-absolute">Nike-DuyBeus</span>
                <span> {{ this.CategoryName }}</span>
            </h2>
            <v-row class="ma-1">
                <v-col v-for="product in products" :key="product.id" cols="12" md="3">
                    <v-hover v-slot="{ isHovering, props }">
                        <v-card class="mx-auto" max-width="344" min-height="300px">
                            <v-img v-bind="props" class="text-right" :src="product.ProductImage" height="200px" cover>
                                <v-btn v-if="this.$store.state.FavoriteProductForUserId != null"
       @click="AddFavoriteProduct(product)" icon>
    <v-icon style="background: rgba(255, 255, 255, 0);" color="red">{{
        this.$store.state.FavoriteProductForUserId.some(x => x.ProductId ===
            product.ProductId) ?
        'mdi-heart' : 'mdi-heart-outline' }}</v-icon>
</v-btn>

                                <v-btn v-else @click="AddFavoriteProduct(product)" icon>
                                    <v-icon color="red">mdi-heart-outline</v-icon>
                                </v-btn>
                                <v-expand-transition>
    <v-row v-if="isHovering" class="overlay">
        <v-col cols="6">
            <v-btn @click="AddCart(product)" class="rounded-lg" color="" text>
                <span style="font-size: 0.8em;">Thêm giỏ hàng</span>
            </v-btn>
        </v-col>
        <v-col cols="6">
            <v-btn class="rounded-lg" color="   " text>
                <span style="font-size: 0.8em;">Xem chi tiết</span>
            </v-btn>
        </v-col>
    </v-row>
</v-expand-transition>


                            </v-img>
                           
                            <v-card-title>
                                {{ product.ProductName }}
                            </v-card-title>

                            <v-card-subtitle class="mb-5">
                                {{ formatCurrency(product.Price) }}
                            </v-card-subtitle>
                            <v-row>
                                <v-col>
                                    <v-icon color="yellow" size="x-small">mdi mdi-star</v-icon>
                                    <v-icon color="yellow" size="x-small">mdi mdi-star</v-icon>
                                    <v-icon color="yellow" size="x-small">mdi mdi-star</v-icon>
                                    <v-icon color="yellow" size="x-small">mdi mdi-star</v-icon>
                                </v-col>
                                <v-btn>Đã bán 12,3k</v-btn>
                            </v-row>
                        </v-card>
                    </v-hover>
                </v-col>
            </v-row>
            </div>
        </v-col>
    </v-row>
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
            Categories:[],
            idCategpry:null,
            CategoryName:''
        }
    },
    methods: {
        getProducts(categoryid) {
            if(categoryid==-1)
            {
                axios.get("http://localhost:5224/api/Product/getAll").then(rs => {
                    this.products = rs.data
                }).catch(erro => {
                    console.log(erro)
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
            else
            {
                axios.get("http://localhost:5224/api/Product/getProductByCategoryId", {
                params: {
                    id: categoryid
                }
                }).then(rs => {
                    this.products = rs.data
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
        getCategoryNameByCategoryId(categoryid)
        {
            if(categoryid==-1)
            {
                this.CategoryName="Danh sách sản phẩm"
                return
            }
            axios.get('http://localhost:5224/api/Category/'+categoryid).then(rs=>{
                this.CategoryName=rs.data.CategoryName
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
                //console.log(rs)

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
        },
        searchByCategory(categoryid)
        {
            this.getCategoryNameByCategoryId(categoryid)
            this.getProducts(categoryid)
        }
    },
    created() {
        this.getAllCategory()
        this.getProducts(this.$route.params.id)
        this.getCategoryNameByCategoryId(this.$route.params.id)
    },
    updated() {
        this.getProducts(this.$route.params.id)
        this.getCategoryNameByCategoryId(this.$route.params.id)
    },
}
</script>
<style scoped>
.overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(255, 255, 255, 0.8);
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
.hover{
    cursor: pointer;
}
.hover :hover{
    color: red;
}
</style>