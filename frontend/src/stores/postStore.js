import { defineStore } from "pinia";
import { toast } from "vue3-toastify";
import { PostService } from "../services/postServices";
// import { createPost } from "../api/httpClient";
// import router from "../route/router";

export const usePostStore = defineStore("postStore", {
  state: () => ({
    posts: [],
    post: {},
    comments: [],
    comment: {},
    tags: [],
    isLoading: false,
  }),
  actions: {
    async fetchAllPosts() {
      try {
        this.isLoading = true;
        const response = await PostService.getallpost();
        this.posts = response?.data?.data;
        // console.log("🚀 ~ file: postStore.js:19 ~ fetchAllPosts ~ this.posts:", this.posts)
        this.isLoading = false;
      } catch (error) {
        console.log(error);
      }
    },
    async getAllTags() {
      try {
        this.isLoading = true;
        const response = await PostService.getalltags();
        console.log("🚀 ~ file: postStore.js:32 ~ getAllTags ~ response:", response)
        this.tags = response?.data;
        // console.log("🚀 ~ file: postStore.js:33 ~ getAllTags ~  this.tags:",  this.tags)
        this.isLoading = false;
      } catch (error) {
        console.log(error);
      }
    },
    async actCreatePost(postData) {
      try {
        this.isLoading = true
        const response = await PostService.postblog(postData);
        this.posts.push(response.data.posts);
        toast.warning("Bài viết của bạn đang được duyệt, vui lòng đợi trong giây lát");
        // // router.push(`/posts/${response.data.post.id}`);
        this.isLoading = false
      } catch (error) {
        console.log(error);
      }
    },
    async getPostById(postId) {
      try {
        this.isLoading = true;
        const response = await PostService.getpostbyid(postId);
        this.post = response?.data;
        // console.log("🚀 ~ file: postStore.js:44 ~ getPostById ~ this.post:", this.post)
        this.isLoading = false;
      } catch (error) {
        console.log(error);
      }
    },
    async updatePost(postId, postData) {
      try {
        this.isLoading = true;
        const response = await PostService.updatepost(postId, postData);
        const updatedPost = response?.data;
        const index = this.posts.findIndex(post => post.id === postId);
        if (index !== -1) {
          this.posts[index] = updatedPost;
        }
        if (this.post.id === postId) {
          this.post = updatedPost;
        }
        toast.success("Cập nhật bài viết thành công.");
        this.isLoading = false;
      } catch (error) {
        console.log(error);
      }
    },
    async deletePost(id) {
      try {
        this.isLoading = true;
        const response = await PostService.deletepost(id);
        console.log(id);
        await this.fetchAllPosts(); // Đợi cho danh sách bài viết được cập nhật trước khi xóa bài viết và hiển thị toast
        this.posts = this.posts.filter(post => post.id !== id);
        toast.success("Xóa bài viết thành công.");
        this.isLoading = false;
      } catch (error) {
        console.log(error);
      }
    },
    async postComment( id, commentDescription ) {
      try {
        this.isLoading = true;
        const response = await PostService.postcomment(id, commentDescription);
        this.isLoading = false;
      } catch (error) {
        console.log(error);
      }
    },
   async editComment(postId, postData) {
      try {
        this.isLoading = true;
        const response = await PostService.editcomment(postId, postData);
        const updatedPost = response?.data;
        const index = this.posts.findIndex(post => post.id === postId);
        if (index !== -1) {
          this.posts[index] = updatedPost;
        }
        if (this.post.id === postId) {
          this.post = updatedPost;
        }
        toast.success("Cập nhật bài viết thành công.");
        this.isLoading = false;
      } catch (error) {
        console.log(error);
      }
    },
    async deleteComment(commentId) {
      try {
        this.isLoading = true;
        PostService.deletecomment(commentId).then((res) => {
          toast.success("Xóa comment thành công.");
          console.log("====", res);
          this.isLoading = false;
        })    
      } catch (error) {
        console.log(error);
         this.isLoading = false;
      }
    },
    async likePost(postid) {
      try {
        this.isLoading = true;
        const response = await PostService.likepost(postid);
        this.getPostById(postid)
        
        this.isLoading = false;
      } catch (error) {
        console.log(error);
      }
    },
  },
});

 