import httpClient from "../api/httpClient";
import {
  API_POSTBLOG,
  API_GETALLPOST,
  API_UPDATEPOST,
  API_DELETEPOST,
  API_POSTCOMMENT,
  API_DELETECOMMENT,
  API_GETALLTAGS,
  API_EDITCOMMENT,
  API_LIKEPOST,
  API_SAVEPOST,
  API_GETALLSAVEPOST,
  API_SEARCHPOST
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
  editcomment(id, updateData) {
    return httpClient.post(`${API_EDITCOMMENT}/${id}`, updateData)
  },
  deletecomment(id) {
    return httpClient.delete(`${API_DELETECOMMENT}/${id}`)
  },
  getalltags() {
    return httpClient.get(API_GETALLTAGS)
  },
  likepost(postid) {
    return httpClient.post(`${API_LIKEPOST}/${postid}`)
  },
  savepost(id) {
    return httpClient.post(`${API_SAVEPOST}/${id}`)
  },
  getallsavepost(){
    return httpClient.get(API_GETALLSAVEPOST)
  },
  searchPost(searchText) {
    return httpClient.get(`${API_SEARCHPOST}=${searchText}`)
  }
};
