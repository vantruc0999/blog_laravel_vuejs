import { defineStore } from "pinia";
import { toast } from "vue3-toastify";
import { AuthorService } from "../services/authorServices";
import { PostService } from "../services/postServices";
import { AuthService } from "../services/authServices";

export const useAuthorStore = defineStore("authorStore", {
  state: () => ({
    authors: [],
    author: {},
    authorsFollowed: [],
    authorsFollowing: [],
    users: [],
    isLoading: false,
    isFollowed: false,
    notFollowed: false
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
        // this.isLoading = true;
        const response = await AuthorService.getfollowing();
        this.authorsFollowing = response?.data?.my_following
        this.isLoading = false;
      } catch (error) {
        console.log(error)
      }
    },
    async fetchAllBlogger() {
      try {
        this.isLoading = true;
        const response = await AuthService.getallblogger();
        if(response?.data) {
          this.users = response?.data;
          this.isLoading = false;
        }
        this.isLoading = false;
      } catch (error) {
        console.error(error);
      }
    },
    async getFollowAuthor(authorId, id) {
      try {
        // this.isLoading = true;
        const response = await AuthorService.getfollowauthor(id);
        this.fetchAllBlogger()
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
        this.isLoading = false;
        console.log(error)
      }
    },
    
    async getAuthorFollowed(authorId) {
      try {
        this.isLoading = true;
        const response = await AuthorService.getauthorfollowed(authorId);
        this.isFollowed = response.data.is_followed === 1 ? true : false;
        this.isLoading = false;
      } catch (error) {
        this.isLoading = false;
        console.log(error)
      }
    },
    async deletePost(authorId,id) {
      try {
        this.isLoading = true;
        const response = await PostService.deletepost(id);
        await this.getAuthorById(authorId)
        toast.success("Xóa bài viết thành công.");
        this.isLoading = false;
      } catch (error) {
        console.log(error);
      }
    },
  },
});