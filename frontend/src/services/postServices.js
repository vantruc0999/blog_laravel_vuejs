import httpClient from "../api/httpClient";
import {
  API_POSTBLOG,
  API_GETALLPOST,
  API_UPDATEPOST,
  API_DELETEPOST,
  API_POSTCOMMENT,
  API_DELETECOMMENT,
  API_REPLYCOMMENT,
  API_GETALLTAGS,
  API_EDITCOMMENT,
  API_LIKEPOST,
  API_LIKECOMMENT,
  API_SAVEPOST,
  API_GETALLSAVEPOST,
  API_SEARCHPOST,
  API_GETPOSTAUTHORFOLLOWING,
  API_FILTERBYCATEGORI,
  API_DRAFTPOST,
  API_GETALLDRAFTPOST,
  API_GETALLPENDINGPOST,
  API_GETPOSTDRAFTBYID,
  API_GETPENDINGPOSTBYID,
  API_CHECKLIKEDPOST
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
  replycomment(id,commentDescription) {
    return httpClient.post(`${API_REPLYCOMMENT}/${id}`, commentDescription)
  },
  getalltags() {
    return httpClient.get(API_GETALLTAGS)
  },
  likepost(postid) {
    return httpClient.post(`${API_LIKEPOST}/${postid}`)
  },
  likecomment(cmtId) {
    return httpClient.post(`${API_LIKECOMMENT}/${cmtId}`)
  },
  checklikedpost(postid) {
    return httpClient.post(`${API_CHECKLIKEDPOST}/${postid}`)
  },
  savepost(id) {
    return httpClient.post(`${API_SAVEPOST}/${id}`)
  },
  getallsavepost(){
    return httpClient.get(API_GETALLSAVEPOST)
  },
  searchPost(searchText) {
    return httpClient.get(`${API_SEARCHPOST}=${searchText}`)
  },
  filterByCategori(id) {
    return httpClient.get(`${API_FILTERBYCATEGORI}/${id}`)
  },
  getpostfollowauthor() {
    return httpClient.get(API_GETPOSTAUTHORFOLLOWING)
  },
  draftpost(draftData) {
    return httpClient.post(API_DRAFTPOST, draftData)
  },
  getAllDraftPost() {
    return httpClient.get(API_GETALLDRAFTPOST)
  },
  getAllPendingPosts() {
    return httpClient.get(API_GETALLPENDINGPOST)
  },
  getDraftPostById(draftId) {
    return httpClient.get(`${API_GETPOSTDRAFTBYID}/${draftId}`)
  },
  getPendingPostById(pendingId) {
    return httpClient.get(`${API_GETPENDINGPOSTBYID}/${pendingId}`)
  }
};
