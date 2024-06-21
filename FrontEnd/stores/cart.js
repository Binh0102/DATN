import { defineStore } from 'pinia'
import axios from 'axios';

export const useCartStore = defineStore({
    id: 'cart-store',
    state: () => {
        return {
            carts: {},
            selectProducts1: [],
            quantities1: [],
            message: null
        }
    },
    actions: {

        checkout(selectProducts, quantities) {
            this.selectProducts1 = selectProducts;
            this.quantities1 = quantities;
        },
        async getCarts() {
            const token = localStorage.getItem('token');
            await axios.get('http://localhost:8000/api/v1/cart/', {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            })
                .then(response => {
                    this.carts = response.data.data;
                })
                .catch(error => {
                    console.error("There was an error fetching the categories:", error);
                });
        },
        delete(id) {
            const token = localStorage.getItem('token');
            axios.delete('http://localhost:8000/api/v1/cart/delete/' + id, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then(response => {
                console.log(response.data);
                this.message = null
            })
                .catch(error => {
                    this.message = error.response.request.status
                    console.error("There was an error fetching the categories:", error);
                });
        },
        async addToCart(cart) {
            const token = localStorage.getItem('token');
            await axios.post('http://localhost:8000/api/v1/addToCart/', cart, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then(response => {
                this.getCarts()
                this.message = null;
                console.log(response);
            }).catch(error => {
                this.message = error.response.request.status
                console.log(error);
            });

        }
    },
    getters: {
        cartsList: state => state.carts,
        selectProducts: state => state.selectProducts1,
        quantities: state => state.quantities1,
        Message: state => state.message
    },
})
