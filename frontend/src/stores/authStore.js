import { defineStore } from "pinia";
import { toast } from "vue3-toastify";
import { AuthService } from "../services/authServices";
import router from "../route/router";

export const useAuthStore = defineStore("authStore", {
  state: () => ({
    users: [],
    user: {},
    isLoading: false,
    isLogin: false
  }),
  actions: {
    async signup(userData) {
      try {
        this.isLoading = true;
        const response = await AuthService.signup(userData);
        console.log(response.data);
        this.isLoading = false;
        toast.success("Đăng ký thành công", {
          position: "top-right",
          duration: 2500,
        });
      } catch (error) {
        toast.fail("Đăng ký thất bại", {
          position: "top-right",
          duration: 2500,
        });
        console.error(error);
        this.isLoading = false;
      }
    },
    async signin(userData) {
      try {
        this.isLoading = true;
        const response = await AuthService.signin(userData);
        // console.log(response.data.access_token);
        this.user = response.data.blogger_infor;
        // Lưu token vào LocalStorage
        localStorage.setItem("token", response.data.access_token);
        localStorage.setItem("user", JSON.stringify(response.data.blogger_infor));
        localStorage.setItem("isLogin", "true");
        router.push('/'); // Sử dụng router từ Vue Router để chuyển hướng
        this.isLoading = false;
      } catch (error) {
        toast.error("Đăng nhập thất bại", {
          position: "top-right",
          duration: 2500,
        });
        console.error(error);
        this.isLoading = false;
      }
    },
    async logout() {
      try {
        // Xóa token khỏi localStorage
        localStorage.removeItem("token");
        localStorage.removeItem("isLogin");
        localStorage.removeItem("user");

        this.isLogin = false
        // Đẩy lại đến trang /auth/signin
        toast.success("Đăng xuất thành công", {
          position: "top-right",
          duration: 2500,
        });
        router.push("/auth/signin");

      } catch (error) {
        console.error(error);
      }
    },
  },
});