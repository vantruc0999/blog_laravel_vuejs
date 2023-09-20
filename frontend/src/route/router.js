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
  import updatedBlog from "../pages/private/Blog/updatedBlog.vue";
  import UpdatedDraft from "../pages/private/Blog/UpdatedDraft.vue";
  import UpdatedPending from "../pages/private/Blog/UpdatedPending.vue";
  import SettingPage from "../pages/private/SettingPage/SettingPage.vue";
  import Account from "../pages/private/SettingPage/Account.vue";
  import BanUser from "../pages/private/SettingPage/BanUser.vue";
  import AuthorPage from "../pages/public/Author/AuthorPage.vue"
  import RelatedPost from "../pages/public/Home/RelatedPage/RelatedPost.vue"
  import ForYouPage from "../pages/public/Home/RelatedPage/PageContent/ForYouPage.vue"
  import SearchPage from "../pages/public/SearchPage/SearchPage.vue"
  import FavoritesPage from "../pages/public/FavoritesPage/FavoritesPage.vue"
  import CategoriesPage from "../pages/public/CategoriesPage/CategoriesPage.vue"
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
          path: "/detail/:id",
          name: "detail",
          component: DetailPage,
        },
        {
          path: "/author",
          name: "author",
          component: AuthorPage,
        },
        {
          path: "/blog-post",
          name: "postblog",
          component: PostBlog,
        },
        {
          path: "/updated-post/:id",
          name: "updatedBlog",
          component: updatedBlog,
        },
        {
          path: "/updated-post/update-draft/:id",
          name: "UpdatedDraft",
          component: UpdatedDraft,
        },
        {
          path: "/updated-post/update-pending/:id",
          name: "UpdatedPending",
          component: UpdatedPending,
        },
        {
          path: "/filter/filter-post",
          name: "filter",
          component: SearchPage,
        },
        {
          path: "/",
          name: "related",
          component: RelatedPost,
          children: [
              {
              path: "/",
              name: "foryou",
              component: ForYouPage,
            },
          ]
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
        {
          path: "/favorites",
          name: "favorites",
          component: FavoritesPage,
        },
        {
          path: "/posts/category/:id",
          name: "categories",
          component: CategoriesPage,
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
      path: "/profile/:id",
      name: "profile",
      component: ProfilePage,
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
  
  router.beforeEach(function (to, from, next) { 
    setTimeout(() => {
        window.scrollTo(0, 0);
    }, 100);
    next();
});

  export default router;
