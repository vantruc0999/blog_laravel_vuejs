import { createApp } from "vue";
import "./globalStyle.scss";
import App from "./App.vue";
import router from "./route/router";
import VueToastify from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { createPinia } from "pinia";

createApp(App).use(VueToastify).use(createPinia()).use(router).mount("#app");
