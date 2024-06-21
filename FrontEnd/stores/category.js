import { defineStore } from 'pinia'
import axios from 'axios';

export const useCategoryStore = defineStore({
    id: 'category-store',
    state: () => {
        return {
            categories: [],
            category: {}
        }
    },
    actions: {
        getCategories() {
            axios.get('http://localhost:8000/api/v1/categories')
                .then(response => {
                    this.categories = response.data.data;
                })
                .catch(error => {
                    console.error("There was an error fetching the categories:", error);
                });
        },
        getNameCategory(id) {
            axios.get('http://localhost:8000/api/v1/category/' + id)
                .then(response => {
                    this.category = response.data.data;
                    console.log(this.category);
                })
                .catch(error => {
                    console.error("There was an error fetching the categories:", error);
                });
        }
    },
    getters: {
        categoriesList: state => state.categories,
        Category: state => state.category
    },
})
