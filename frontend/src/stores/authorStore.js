import { defineStore } from "pinia";
import { toast } from "vue3-toastify";
import { AuthorService } from "../services/authorServices";
import router from "../route/router";

export const useAuthorStore = defineStore("authorStore", {
  state: () => ({
    authors: [],
    author: {},
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
        toast.error("Đã xảy ra lỗi khi lấy người dùng. Vui lòng thử lại sau.");
      }
    },
    async getAuthorFollowed(authorId) {
      try {
        this.isLoading = true;
        const response = await AuthorService.getauthorfollowed(authorId);
        this.isFollow = response.data.is_followed === 1 ? true : false;
        console.log("🚀 ~ file: authorStore.js:33 ~ getAuthorFollowed ~ this.isTerm:", this.isFollow)
        this.isLoading = false;
      } catch (error) {
        toast.error("Đã xảy ra lỗi khi lấy người dùng. Vui lòng thử lại sau.");
      }
    },
    
  },
});