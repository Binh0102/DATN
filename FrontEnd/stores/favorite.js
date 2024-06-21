import { defineStore } from 'pinia'
import axios from 'axios';

export const useFavoriteStore = defineStore({
    id: 'favorite-store',
    state: () => {
        return {
            favorites: {},
            message: null
        }
    },
    actions: {
        async getFavorites() {
            const token = localStorage.getItem('token');
            await axios.get('http://localhost:8000/api/v1/favorite/getAll', {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            })
                .then(response => {
                    this.favorites = response.data.data;
                })
                .catch(error => {
                    console.error("There was an error fetching the categories:", error);
                });
        },
        delete(id) {
            const token = localStorage.getItem('token');
            axios.delete('http://localhost:8000/api/v1/favorite/deleteFavorite/' + id, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then(response => {
                console.log(response.data);
            })
                .catch(error => {
                    this.message = error.response.request.status
                    console.error("There was an error fetching the categories:", error);
                });
        },
        async addFavorite(favorite) {
            const token = localStorage.getItem('token');
            await axios.post('http://localhost:8000/api/v1/favorite/addFavorite', favorite, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then(response => {
                this.getFavorites()
                this.message = null;
                console.log(response.data.data);
            }).catch(error => {
                this.message = error.response.request.status
                console.log('ư', error.response.request.status);
            });

        }
    },
    getters: {
        favoriteList: state => state.favorites,
        Message: state => state.message
    },
})
