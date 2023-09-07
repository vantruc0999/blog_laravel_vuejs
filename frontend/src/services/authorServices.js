import httpClient from "../api/httpClient";
import {
  API_GETAUTHORFOLLOWED,
  API_GETFOLLOWAUTHOR,
  API_GETFOLLOWER,
  API_GETFOLLOWING
} from "../config/apis";

export const AuthorService = {
  getfollowauthor(authorid) {
    return httpClient.post(`${API_GETFOLLOWAUTHOR}/${authorid}`)
  },
  getauthorfollowed(authorid) {
    return httpClient.post(`${API_GETAUTHORFOLLOWED}/${authorid}`)
  },
  getfollowing() {
    return httpClient.get(`${API_GETFOLLOWING}`)
  },
  getfollowered() {
    return httpClient.get(`${API_GETFOLLOWER}`)
  }
};

