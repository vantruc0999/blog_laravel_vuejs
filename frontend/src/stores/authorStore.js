import { defineStore } from "pinia";
import { toast } from "vue3-toastify";
import { AuthorService } from "../services/authorServices";
import router from "../route/router";

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
    async getFollowAuthor(authorId) {
      try {
        this.isLoading = true;
        const response = await AuthorService.getfollowauthor(authorId);
        toast.success("Follow thành công", {
          position: "top-right",
          duration: 2500,
        });
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