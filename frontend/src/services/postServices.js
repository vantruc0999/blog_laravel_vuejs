import httpClient from "../api/httpClient";
import {
  API_POSTBLOG,
  API_GETALLPOST,
  API_UPDATEPOST,
  API_DELETEPOST,
  API_POSTCOMMENT,
  API_DELETECOMMENT,
  API_GETALLTAGS
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
  },
  deletepost(id) {
    return httpClient.delete(`${API_DELETEPOST}/${id}`)
  },
  postcomment(id, commentDescription) {
    return httpClient.post(`${API_POSTCOMMENT}/${id}`,commentDescription )
  },
  updatepost(id, updateData) {
    return httpClient.post(`${API_UPDATEPOST}/${id}`, updateData)
  },
  deletecomment(id) {
    return httpClient.delete(`${API_DELETECOMMENT}/${id}`)
  },
  getalltags() {
    return httpClient.get(API_GETALLTAGS)
  }
};
