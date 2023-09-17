import { createApp } from "vue";
import "./globalStyle.scss";
import App from "./App.vue";
import router from "./route/router";
import VueToastify from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { createPinia } from "pinia";
import CKEditor from "@ckeditor/ckeditor5-vue";
import Antd from 'ant-design-vue';
import 'ant-design-vue/dist/reset.css';
import Cloudinary from 'cloudinary-vue';
import 'vue3-emoji-picker/css'

createApp(App)
  .use(Antd)
  .use(CKEditor)
  .use(VueToastify)
  .use(createPinia())
  .use(router)
  .use(Cloudinary, {
    configuration: {
      cloudName: import.meta.env.VITE_CLOUDINARY_CLOUD_NAME,
    },
  })
  .mount("#app");
