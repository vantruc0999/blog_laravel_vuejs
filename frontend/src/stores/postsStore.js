import { defineStore } from "pinia";
import { toast } from "vue3-toastify";
import { AuthService } from "../services/authServices";
import router from "../route/router";

export const usePostsStore = defineStore("postsStore", {
  state: () => ({
    posts: [],
    post: {},
  }),
 
});