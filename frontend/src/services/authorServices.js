import httpClient from "../api/httpClient";
import {
  API_GETAUTHORFOLLOWED,
  API_GETFOLLOWAUTHOR
} from "../config/apis";

export const AuthorService = {
  getfollowauthor(authorid) {
    return httpClient.post(`${API_GETFOLLOWAUTHOR}/${authorid}`)
  },
  getauthorfollowed(authorid) {
    return httpClient.post(`${API_GETAUTHORFOLLOWED}/${authorid}`)
  } 
};

