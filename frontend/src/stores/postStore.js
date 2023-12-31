import { defineStore } from "pinia";
import { toast } from "vue3-toastify";
import { PostService } from "../services/postServices";
import axios from "axios";
// import router from "../route/router";
// import { ref } from "vue";


// const userData = ref(JSON.parse(localStorage.getItem("user")));
export const usePostStore = defineStore("postStore", {
  state: () => ({
    posts: [],
    post: {},
    postsAuthor: [],
    favorites: [],
    comments: [],
    comment: {},
    replyComments: [],
    tags: [],
    isLoading: false,
    dataSearch: [],
    dataFilters: [],
    draftsPost: [],
    draft: {},
    pendingPost: {},
    isLiked: {}
  }),
  actions: {
    async fetchAllPosts() {
      try {
        // this.isLoading = true;
        const response = await PostService.getallpost();
        if(response?.data?.data) {
          this.posts = response?.data?.data;
          console.log("store" , response?.data?.data);
          this.isLoading = false;
        }
      } catch (error) {
        this.isLoading = false;
        console.log(error);
      }
    },
    async fetchPostsByFollowAuhor() {
      try {
        this.isLoading = true;
        const response = await PostService.getpostfollowauthor();
        if(response?.data?.data) {
          this.postsAuthor = response?.data?.data;
          this.isLoading = false;
        }
      } catch (error) {
        this.isLoading = false;
        console.log(error);
      }
    },
    async getAllTags() {
      try {
        // this.isLoading = true;
        const response = await PostService.getalltags();
        this.tags = response?.data;
        this.isLoading = false;
      } catch (error) {
        this.isLoading = false;
        console.log(error);
      }
    },
    async actCreatePost(postData) {
      try {
        this.isLoading = true
        const response = await PostService.postblog(postData);
        this.posts.push(response.data.posts);
        toast.warning("Bài viết của bạn đang được duyệt, vui lòng đợi trong giây lát");
        // setTimeout(() => {
        //   router.push(`/profile/${userData.value.id}`);
        // }, 3000); 
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
        console.log("🚀 ~ file: postStore.js:44 ~ getPostById ~ this.post:", this.post)
        this.isLoading = false;
      } catch (error) {
        console.log(error);
      }
    },
    async updatePost(userId,postId, postData) {
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
        await this.getAllDraftPost()
        await this.getAllPendingPosts()
        this.posts = this.posts.filter(post => post.id !== id);
        toast.success("Xóa bài viết thành công.");
        this.isLoading = false;
      } catch (error) {
        console.log(error);
      }
    },

    async postComment(id, commentDescription) {
      try {
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
    async replyComment(idPost, idCommenter, commentDescription) {
      try {
        const response = await PostService.replycomment(idCommenter, commentDescription);
        this.getPostById(idPost)
        const { comment } = response.data;
        const postIndex = this.posts.findIndex(post => post.id === id);
        if (postIndex !== -1) {
          this.posts[postIndex].replyComments.push(comment);
        }
        this.isLoading = false;
      } catch (error) {
        console.log(error);
        this.isLoading = false;
      }
    },
   async editComment(postId,idComment, postData) {
      try {
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
    async checkLikedPost(postid) {
      try {
        // this.isLoading = true;
        const response = await PostService.checklikedpost(postid);
        // this.isLiked = response?.data?.is_like === 1 ? true : false;
        this.isLiked = response?.data;
        console.log("🚀 ~ file: postStore.js:204 ~ checkLikedPost ~ this.isLiked:", this.isLiked)
        this.isLoading = false;
      } catch (error) {
        console.log(error);
      }
    },
    async likeComment(postid, cmtId) {
      try {
        const response = await PostService.likecomment(cmtId);
        this.getPostById(postid)
        this.isLoading = false;
      } catch (error) {
        console.log(error);
      }
    },
    
    async getAllSavePosts() {
      try {
        // this.isLoading = true;
        const response = await PostService.getallsavepost();
        if(response.data) {
          this.favorites = response.data?.posts;
          this.isLoading = false;
        }
      } catch (error) {
        console.log(error);
        this.isLoading = false;
      } finally {
        this.isLoading = false;
      }
    },
    async savePost(id) {
      try {
        const response = await PostService.savepost(id);
        const savedPost = response?.data;
        const index = this.posts.findIndex(post => post.id === savedPost.id);
        if (index !== -1) {
          this.posts[index] = savedPost;
        }
        this.getAllSavePosts()
        this.isLoading = false;
      } catch (error) {
        console.log(error);
        this.isLoading = false;
      }
    },
    async searchPost(searchText, category) {
      try {
        this.isLoading = true;
        const data = await axios(`http://127.0.0.1:8000/api/posts/filter/filter-post?search=${searchText}&category_id=${category}`)
        console.log("🚀 ~ file: postStore.js:206 ~ searchPost ~ data:", data)
        if(data) {
          this.dataSearch = data.data
          console.log("=======",this.dataSearch);
          this.isLoading = false
        } 
      } catch (error) {
        console.log(error);
        this.isLoading = false;
      }
      finally {
        this.isLoading = false;
      }
    },
    async filterByCategori(categoryId) {
      try {
        this.isLoading = true;
        const data = await PostService.filterByCategori(categoryId);
        console.log("🚀 ~ file: postStore.js:206 ~ searchPost ~ data:", data)
        if(data) {
          this.dataFilters = data.data.posts
          console.log("=======",this.dataFilters);
          this.isLoading = false
        } 
      } catch (error) {
        console.log(error);
        this.isLoading = false;
      }
      finally {
        this.isLoading = false;
      }
    },
    async handleDraftData(draftData) {
      try {
        this.isLoading = true
        const response = await PostService.draftpost(draftData);
        this.posts.push(response.data.posts);
        toast.warning("Bài viết của bạn đã được lưu thành công");
        // setTimeout(() => {
        //   router.push(`/profile/${userData.value.id}`);
        // }, 3000); 
        this.isLoading = false
      } catch (error) {
        console.log(error);
      }
    },
    async getAllDraftPost() {
      try {
        this.isLoading = true;
        const response = await PostService.getAllDraftPost();
        if(response?.data?.posts) {
          this.post = response?.data?.posts;
          console.log("🚀 ~ file: postStore.js:284 ~ getAllDraftPost ~ this.post:", this.post)
          this.isLoading = false;
        }
      } catch (error) {
        this.isLoading = false;
        console.log(error);
      }
    },
    async getAllPendingPosts() {
      try {
        this.isLoading = true;
        const response = await PostService.getAllPendingPosts();
        if(response?.data?.posts) {
          this.posts = response?.data?.posts;
          this.isLoading = false;
        }
      } catch (error) {
        this.isLoading = false;
        console.log(error);
      }
    },
    async getDraftPostById(draftId) {
      try {
        this.isLoading = true;
        const response = await PostService.getDraftPostById(draftId);
        this.draft = response?.data?.data;
        console.log("🚀 ~ file: postStore.js:312 ~ getDraftPostById ~ this.draft:", this.draft)
        this.isLoading = false;
      } catch (error) {
        console.log(error);
      }
    },
    async getPendingPostById(pendingId) {
      try {
        this.isLoading = true;
        const response = await PostService.getPendingPostById(pendingId);
        console.log("🚀 ~ file: postStore.js:320 ~ getDraftPostById ~ response:", response.data.data)
        this.pendingPost = response?.data?.data;
        console.log("🚀 ~ file: postStore.js:322 ~ getPendingPostById ~ this.pendingPost:", this.pendingPost)
        this.isLoading = false;
      } catch (error) {
        console.log(error);
      }
    },
  },
});

 