import { defineStore } from "pinia";
import { toast } from "vue3-toastify";
import { PostService } from "../services/postServices";
// import { createPost } from "../api/httpClient";
// import router from "../route/router";

export const usePostStore = defineStore("postStore", {
  state: () => ({
    posts: [],
    post: {},
    isLoading: false,
  }),
  actions: {
    async fetchAllPosts() {
      try {
        this.isLoading = true;
        const response = await PostService.getallpost();
        this.posts = response?.data?.data;
        console.log("🚀 ~ file: postStore.js:20 ~ fetchAllPosts ~ posts:", this.posts)
        this.isLoading = false;
      } catch (error) {
        toast.error("Đã xảy ra lỗi khi lấy danh sách bài viết. Vui lòng thử lại sau.");
      }
    },
    async actCreatePost(postData) {
      try {
        this.isLoading = true
        const response = await PostService.postblog(postData);
        this.posts.push(response.data.posts);
        // // router.push(`/posts/${response.data.post.id}`);
        this.isLoading = false
      } catch (error) {
        toast.error("Đã xảy ra lỗi khi đăng bài. Vui lòng thử lại sau.");
      }
    },
    async getPostById(postId) {
      try {
        this.isLoading = true;
        const response = await PostService.getpostbyid(postId);
        this.post = response?.data;
        console.log("🚀 ~ file: postStore.js:44 ~ getPostById ~ this.post:", this.post)
        this.isLoading = false;
      } catch (error) {
        toast.error("Đã xảy ra lỗi khi lấy bài viết. Vui lòng thử lại sau.");
      }
    },
  },
});

 