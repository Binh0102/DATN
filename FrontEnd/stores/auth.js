import { defineStore } from 'pinia'
import axios from 'axios';

export const useAuthStore = defineStore({
    id: 'auth-store',
    state: () => {
        return {
            user: null,
            users: null,
            message: null,
        }
    },
    actions: {
        async login(login) {
            await axios.post('http://localhost:8000/api/v1/login', login._rawValue)
                .then(response => {
                    localStorage.setItem('token', response.data.data[0]);
                    const route = useRouter();
                    console.log(response.data.data[1]);
                    if (response.data.data[1] == 1) {
                        route.push('/admin')
                    }
                    const cart = useCartStore();
                    cart.getCarts();
                    this.message = null

                })
                .catch(err => {
                    console.log(err.response.request.status);
                    this.message = err.response.request.status
                })
        },
        async info() {
            const token = localStorage.getItem('token');
            await axios.get('http://localhost:8000/api/v1/user/info', {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then(response => {
                console.log(response.data.data);
                this.user = response.data.data;
                this.message = null
            }).catch(err => {
                this.message = err.response.request.status
            })
        },
        register(register) {
            console.log(register._rawValue);
            axios.post('http://localhost:8000/api/v1/register', register._rawValue)
                .then(response => {
                    console.log(response)
                }).catch(err => {
                    console.log(err);
                })
        },
        async logout() {
            localStorage.removeItem('token');
            await this.info();
            this.user = null

        },
        getAll() {
            const token = localStorage.getItem('token');
            axios.get('http://localhost:8000/api/v1/users', {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then(response => {
                this.users = response.data.data;
            }).catch(err => {
                console.log(err);
            })
        },
        async updateInfo(formdata) {
            const token = localStorage.getItem('token');
            await axios.post('http://localhost:8000/api/v1/updateInfo', formdata, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then(response => {
                this.user = response.data.data;
                this.message = null

            }).catch(err => {
                console.log(err);
                this.message = err.response.request.status
            })
        },
        async updatePassword(formdata) {
            const token = localStorage.getItem('token');
            await axios.post('http://localhost:8000/api/v1/updatePassword', formdata, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then(response => {
                this.user = response.data.data;
                const route = useRouter();
                this.message = null
                route.push('/')
                this.logout()
            }).catch(err => {
                console.log(err.response.request.status);
                this.message = err.response.request.status

            })
        },
        async updateRole(id, role) {
            const token = localStorage.getItem('token');
            await axios.post('http://localhost:8000/api/v1/updateRole/' + id, role, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then(response => {
                console.log(response.data);
            }).catch(err => {
                console.log(err);
            })
        }
    },
    getters: {
        User: state => state.user,
        Users: state => state.users,
        Message: state => state.message,
    },
})
