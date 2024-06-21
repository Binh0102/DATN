import { defineStore } from 'pinia'
import axios from 'axios';

export const useOrderStore = defineStore({
    id: 'order-store',
    state: () => {
        return {
            orders: [],
            order: {}
        }
    },
    actions: {
        getAll() {
            const token = localStorage.getItem('token');
            axios.get('http://localhost:8000/api/v1/orders', {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then(response => {
                this.orders = response.data.data;
            }).catch(e => {
                console.log(e);
            })
        },
        getOrders(status) {
            const token = localStorage.getItem('token');
            axios.get('http://localhost:8000/api/v1/orders/' + status, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then(response => {
                this.orders = response.data.data;
            }).catch(e => {
                console.log(e);
            })
        },

        addOrder(order) {
            const token = localStorage.getItem('token');
            axios.post('http://localhost:8000/api/v1/addOrder', order._rawValue, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then(response => {
                console.log(response.data);
                if (response.data.status == true) {
                    ('Thêm đơn hàng thành công')
                }
            }).catch(e => {
                console.log(e);
            })
        },
        update(id, status) {
            console.log(status);
            const token = localStorage.getItem('token');
            axios.post('http://localhost:8000/api/v1/updateStatus/' + id, status, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then(response => {
                console.log(response.data);
                if (response.data.status == true) {
                    ('Cập nhật trạng thái đơn hàng')
                }
            }).catch(e => {
                console.log(e);
            })
        },
        async getOrderDetail(id) {
            const token = localStorage.getItem('token');
            await axios.get('http://localhost:8000/api/v1/getOrder/' + id, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then(response => {
                this.order = response.data.data
            }).catch(e => {
                console.log(e);
            })
        }, getOrdersUser() {
            const token = localStorage.getItem('token');
            axios.get('http://localhost:8000/api/v1/user/orders', {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then(response => {
                this.orders = response.data.data;
            }).catch(e => {
                console.log(e);
            })
        },
    },
    getters: {
        ordesrList: state => state.orders,
        Order: state => state.order
    },
})
