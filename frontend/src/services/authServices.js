import httpClient from "../api/httpClient";
import {
  API_SIGNIN,
  API_SIGNUP,
  API_GETALLBLOGGER,
  API_GETAUTHOR,
  API_GETMYPROFILE,
  API_GETFOLLOWAUTHOR,
  API_UPDATEPROFILE
} from "../config/apis";

export const AuthService = {
  signin(user) {
    return httpClient.post(API_SIGNIN, user);
  },
  signup(user) {
    return httpClient.post(API_SIGNUP, user);
  },
  getallblogger() {
    return httpClient.get(API_GETALLBLOGGER)
  },
  getauthorbyid(authorid) {
    return httpClient.get(`${API_GETAUTHOR}/${authorid}`)
  },
  getmyprofile() {
    return httpClient.get(API_GETMYPROFILE)
  },
  getfollowauthor(authorid) {
    return httpClient.get(`${API_GETFOLLOWAUTHOR}/${authorid}`)
  },
  updatemyprofile(data) {
      return httpClient.post(API_UPDATEPROFILE,data)
  }
};

