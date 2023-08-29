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
    async actCreatePost(postData, token) {
      try {
        this.isLoading = true
        const response = await PostService.postblog(postData);
        this.posts.push(response.data.posts);
        // // router.push(`/posts/${response.data.post.id}`);
        toast.success("Bài viết đã được đăng thành công!");
        this.isLoading = false
        // createPost(postData, token).then(() => {
          
          // })
          
      } catch (error) {
        toast.error("Đã xảy ra lỗi khi đăng bài. Vui lòng thử lại sau.");
      }
    },
  },
});

 