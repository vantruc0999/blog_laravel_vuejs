import { defineStore } from "pinia";
import { toast } from "vue3-toastify";
import { AuthorService } from "../services/authorServices";
import router from "../route/router";
import { AuthService } from "../services/authServices";

export const useAuthorStore = defineStore("authorStore", {
  state: () => ({
    authors: [],
    author: {},
    authorsFollowed: [],
    authorsFollowing: [],
    isLoading: false,
    isFollow: false,
  }),
  actions: {
    async getAuthorById(authorId) {
      try {
        this.isLoading = true;
        const response = await AuthService.getauthorbyid(authorId);
        this.author = response?.data;
        console.log("🚀 ~ file: authStore.js:90 ~ getAuthorById ~ this.author:", this.author)
        this.isLoading = false;
      } catch (error) {
        console.error(error);
      }
    },
    async getFollowing() {
      try {
        this.isLoading = true;
        const response = await AuthorService.getfollowing();
        this.authorsFollowing = response?.data?.my_following
        this.isLoading = false;
      } catch (error) {
        console.log(error)
      }
    },
    async getFollowAuthor(authorId, id) {
      try {
        this.isLoading = true;
        const response = await AuthorService.getfollowauthor(id);
        this.getFollowing()
        this.getAuthorById(authorId)
        this.isLoading = false;
      } catch (error) {
        console.log(error)
      }
    },
    async getFollowered() {
      try {
        this.isLoading = true;
        const response = await AuthorService.getfollowered();
        this.authorsFollowed = response?.data?.my_followers
        this.isLoading = false;
      } catch (error) {
        console.log(error)
      }
    },
    
    async getAuthorFollowed(authorId) {
      try {
        this.isLoading = true;
        const response = await AuthorService.getauthorfollowed(authorId);
        this.isFollow = response.data.is_followed === 1 ? true : false;
        this.isLoading = false;
      } catch (error) {
        console.log(error)
      }
    },
    
  },
});