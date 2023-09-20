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
        this.user = response.data.blogger_infor;
        // Lưu token vào LocalStorage
        localStorage.setItem("token", response.data.access_token);
        localStorage.setItem("user", JSON.stringify(response.data.blogger_infor));
        localStorage.setItem("isLogin", "true");
        localStorage.setItem("isAuthen", "true");
        router.push('/'); 
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
    async changePassword(data) {
      try {
        console.log(data);
        this.isLoading = true;
        await AuthService.changepassword(data);
        const user = JSON.parse(localStorage.getItem("user"));
        user.email = formData.get("email");
        localStorage.setItem("user", JSON.stringify(user));
        this.getMyProfile()
        this.isLoading = false;
        toast.success("Thay đổi mật khẩu thành công", {
          position: "top-right",
          duration: 2500,
        });
      } catch (error) {
        console.error(error);
        toast.error("Thay đổi mật khẩu thất bại", {
          position: "top-right",
          duration: 2500,
        });
        this.isLoading = false;
      }
    },
    async changeEmail(data) {
      try {
        await AuthService.changeemail(data);
        this.getMyProfile()
        toast.success("Thay đổi email khẩu thành công", {
          position: "top-right",
          duration: 2500,
        });
      } catch (error) {
        console.error(error);
        toast.error("Thay đổi email khẩu thất bại", {
          position: "top-right",
          duration: 2500,
        });
      }
    },
    async logout() {
      try {
        await AuthService.logout(); // Gọi hàm logout từ AuthService
        // Xóa token khỏi localStorage
        localStorage.removeItem("token");
        localStorage.removeItem("isLogin");
        localStorage.removeItem("user");
        localStorage.setItem("isAuthen", "false");
        this.isLogin = false;
        router.push("/auth/signin");
      } catch (error) {
        console.error(error);
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
    
    async getMyProfile() {
      try {
        this.isLoading = true;
        const response = await AuthService.getmyprofile();
        this.user = response?.data;
        this.isLoading = false;
      }catch (error) {
        console.error(error);
      }
    },
    async updateMyProfile(data) {
      try {
        this.isLoading = true;
        const response = await AuthService.updatemyprofile(data);
        console.log("🚀 ~ Updated user profile:", response.data);
        this.user = response?.data;
        this.getMyProfile()
        this.isLoading = false;
        toast.success("Cập nhật thông tin thành công", {
          position: "top-right",
          duration: 2500,
        });
      } catch (error) {
        console.error(error);
        toast.error("Cập nhật thông tin thất bại", {
          position: "top-right",
          duration: 2500,
        });
        this.isLoading = false;
      }
    }
  },
});