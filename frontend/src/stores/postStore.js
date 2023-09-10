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
        console.log("🚀 ~ file: postStore.js:57 ~ getPostById ~ response?.data:", response?.data)
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
        await this.fetchAllPosts(); 
        this.posts = this.posts.filter(post => post.id !== id);
        toast.success("Xóa bài viết thành công.");
        this.isLoading = false;
      } catch (error) {
        console.log(error);
      }
    },
    async postComment(id, commentDescription) {
      try {
        this.isLoading = true;
        const response = await PostService.postcomment(id, commentDescription);
        this.getPostById(id)
        const { comment } = response.data;
        const postIndex = this.posts.findIndex(post => post.id === id);
        if (postIndex !== -1) {
          this.posts[postIndex].comments.push(comment);
        }
        toast.success("Bình luận của bạn đã được đăng.");
        this.isLoading = false;
      } catch (error) {
        console.log(error);
        this.isLoading = false;
      }
    },
   async editComment(postId,idComment, postData) {
      try {
        this.isLoading = true;
        const response = await PostService.editcomment(idComment, postData);
        const updatedPost = response?.data;
        this.getPostById(postId)
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
    async deleteComment(postId,commentId) {
      try {
        this.isLoading = true;
        const response = await PostService.deletecomment(commentId);
        this.getPostById(postId)
        this.posts.forEach(post => {
          post.comments = post.comments.filter(comment => comment.id !== commentId);
        });
        toast.success("Xóa comment thành công.");
        this.isLoading = false;
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
    async getAllSavePosts() {
      try {
        this.isLoading = true;
        const response = await PostService.getallsavepost();
        console.log("🚀 ~ file: postStore.js:177 ~ getAllSavePosts ~ response.data?.posts:", response.data?.posts)
        this.posts = response.data?.posts;
        this.isLoading = false;
      } catch (error) {
        console.log(error);
      }
    },
    async savePost(id) {
      try {
        this.isLoading = true;
        const response = await PostService.savepost(id);
        const savedPost = response?.data;
        const index = this.posts.findIndex(post => post.id === savedPost.id);
        if (index !== -1) {
          this.posts[index] = savedPost;
        }
        this.getAllSavePosts()
        toast.success("Lưu bài viết thành công.");
        this.isLoading = false;
      } catch (error) {
        console.log(error);
        this.isLoading = false;
      }
    },
    
  },
});

 