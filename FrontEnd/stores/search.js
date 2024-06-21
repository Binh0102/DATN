import { defineStore } from 'pinia'

export const useSearch = defineStore({
    id: 'search-store',
    state: () => {
        return {
            search: []
        }
    },
    actions: {
        addSearch(value) {
            this.search = []
            this.search.push(value);
        }

    },
    getters: {
        getterSearch: state => state.search[0],
    },
})
