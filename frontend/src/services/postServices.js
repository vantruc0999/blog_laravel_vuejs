import httpClient from "../api/httpClient";
import {
  API_POSTBLOG
} from "../config/apis";

export const PostService = {
  postblog(postData) {
    return httpClient.post(API_POSTBLOG, postData);
  },
};
