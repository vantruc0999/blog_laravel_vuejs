import httpClient from "../api/httpClient";
import {
  API_SIGNIN,
  API_SIGNUP,
  API_GETALLAUTHOR
} from "../config/apis";

export const AuthService = {
  signin(user) {
    return httpClient.post(API_SIGNIN, user);
  },
  signup(user) {
    return httpClient.post(API_SIGNUP, user);
  },
  // getallauthor() {
  //   return httpClient.get(API_GETALLAUTHOR)
  // },
  getauthorbyid(authorid) {
    return httpClient.get(`${API_GETALLAUTHOR}/${authorid}`)
  }
};

