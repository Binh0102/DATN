import { defineStore } from 'pinia'
import axios from 'axios';

export const useCommentStore = defineStore({
    id: 'comment-store',
    state: () => {
        return {
            comments: [],
            message: null,
        }
    },
    actions: {
        getComments(id) {
            axios.get('http://localhost:8000/api/v1/comments/' + id)
                .then(response => {
                    this.comments = response.data.data;

                })
                .catch(error => {
                    console.error("There was an error fetching the categories:", error);
                });
        },
        addComment(formData) {
            const token = localStorage.getItem('token');
            axios.post('http://localhost:8000/api/v1/addComment', formData, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then(response => {
                console.log(response.data);
            }).catch(e => {
                console.log(e.response.request.status);
            })
        }

    },
    getters: {
        commentsList: state => state.comments,
    },
})
