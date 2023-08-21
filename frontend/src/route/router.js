import { createRouter, createWebHistory } from "vue-router";

// page
import AuthenLayout from "../layout/AuthenLayout.vue";
import HomeLayout from "../layout/HomeLayout.vue";
import SignIn from "../pages/public/Authentication/SignIn.vue";
import SignUp from "../pages/public/Authentication/SignUp.vue";
import HomePage from "../pages/public/Home/HomePage.vue";

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
