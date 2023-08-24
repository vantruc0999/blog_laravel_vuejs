import { createRouter, createWebHistory } from "vue-router";

// page
import AuthenLayout from "../layout/AuthenLayout.vue";
import HomeLayout from "../layout/HomeLayout.vue";
import SignIn from "../pages/public/Authentication/SignIn.vue";
import SignUp from "../pages/public/Authentication/SignUp.vue";
import HomePage from "../pages/public/Home/HomePage.vue";
import DetailPage from "../pages/public/Home/DetailPage.vue";
import ProfilePage from "../pages/public/ProfilePage/ProfilePage.vue";
import PostBlog from "../pages/private/Blog/PostBlog.vue";
import SettingPage from "../pages/private/SettingPage/SettingPage.vue";
import Account from "../pages/private/SettingPage/Account.vue";
import BanUser from "../pages/private/SettingPage/BanUser.vue";

const routes = [
  {
    path: "/",
    name: "homepage",
    component: HomeLayout,
    children: [
      {
        path: "/",
        name: "homepage",
        component: HomePage,
      },
      {
        path: "/detail",
        name: "detail",
        component: DetailPage,
      },
      {
        path: "/setting/account",
        name: "setting",
        component: SettingPage,
        children : [
          {
            path: "/setting/account",
            name: "setting",
            component: Account,
          },
          {
            path: "/setting/ban",
            name: "ban",
            component: BanUser,
          },
        ]
      },
    ],
  },
  {
    path: "/auth",
    name: "auth",
    component: AuthenLayout,
    children: [
      {
        path: "/auth/signin",
        name: "signin",
        component: SignIn,
      },
      {
        path: "/auth/signup",
        name: "signup",
        component: SignUp,
      },
    ],
  },
  {
    path: "/profile",
    name: "profile",
    component: ProfilePage,
  },
  {
    path: "/blog-post",
    name: "postblog",
    component: PostBlog,
  },
  // {
  //   path: "/:pathMatch(.*)*",
  //   name: "Error",
  //   component: ErrorBound,
  // },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
