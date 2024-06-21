import { defineStore } from 'pinia'
import axios from 'axios';

export const useProductStore = defineStore({
    id: 'product-store',
    state: () => {
        return {
            products: [],
            productsSpecial: [],
            productsSale: [],
            products_category: [],
            product: {},
            productOther: [],
        }
    },
    actions: {
        getProducts() {
            axios.get('http://localhost:8000/api/v1/products')
                .then(response => {
                    this.products = response.data.data;

                })
                .catch(error => {
                    console.error(error);
                });
        },
        getProductsList() {
            const token = localStorage.getItem('token');
            axios.get('http://localhost:8000/api/v1/productsList', {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            })
                .then(response => {
                    this.products = response.data.data;

                })
                .catch(error => {
                    console.error(error);
                });
        },
        getProductSpecial() {
            axios.get('http://localhost:8000/api/v1/productSpecial')
                .then(response => {
                    this.productsSpecial = response.data.data;

                })
                .catch(error => {
                    console.error(error);
                });
        },
        getProductSale() {
            axios.get('http://localhost:8000/api/v1/getProductSell')
                .then(response => {
                    this.productsSale = response.data.data;

                })
                .catch(error => {
                    console.error(error);
                });
        },
        getProductCategory(id) {
            axios.get('http://localhost:8000/api/v1/products_category/' + id)
                .then(response => {
                    this.products_category = response.data.data;

                })
                .catch(error => {
                    console.error(error);
                });
        },

        getProduct(id) {
            axios.get('http://localhost:8000/api/v1/detail/' + id)
                .then(response => {
                    this.product = response.data.data;
                    console.log(this.product);
                })
                .catch(error => {
                    console.error(error);
                });
        },
        getProductOther() {
            axios.get('http://localhost:8000/api/v1/other/')
                .then(response => {
                    this.productOther = response.data.data;
                    console.log(this.product);
                })
                .catch(error => {
                    console.error(error);
                });
        },
        createProduct(product) {
            const token = localStorage.getItem('token');
            axios.post('http://localhost:8000/api/v1/createProduct', product, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            })
                .then(response => {
                    console.log(response.data);

                })
                .catch(error => {
                    console.error(error);
                });
        },
        updateProductId(id, product) {
            console.log(product);
            const token = localStorage.getItem('token');
            axios.post('http://localhost:8000/api/v1/updateProduct/' + id, product, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error(error);
                });
        },
        deleteProduct(id) {
            const token = localStorage.getItem('token');
            axios.delete('http://localhost:8000/api/v1/deleteProduct/' + id, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error(error);
                });
        }
    },
    getters: {
        productsList: state => state.products,
        productsSpecialList: state => state.productsSpecial,
        productsSaleList: state => state.productsSale,
        producsCategoryList: state => state.products_category,
        oneProduct: state => state.product,
        productOtherList: state => state.productOther,
    },
})
