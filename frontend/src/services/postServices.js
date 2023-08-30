import httpClient from "../api/httpClient";
import {
  API_POSTBLOG,
  API_GETALLPOST
} from "../config/apis";

export const PostService = {
  postblog(postData) {
    return httpClient.post(API_POSTBLOG, postData);
  },
  getallpost() {
    return httpClient.get(API_GETALLPOST)
  },
  getpostbyid(id) {
    return httpClient.get(`${API_GETALLPOST}/${id}`)
  }
};
