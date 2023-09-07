import httpClient from "../api/httpClient";
import {
  API_SIGNIN,
  API_SIGNUP,
  API_CHANGEPASSWORD,
  API_GETALLBLOGGER,
  API_GETAUTHOR,
  API_GETMYPROFILE,
  API_GETFOLLOWAUTHOR,
  API_UPDATEPROFILE,
  API_LOGOUT,
  API_CHANGEEMAIL
} from "../config/apis";

export const AuthService = {
  signin(user) {
    return httpClient.post(API_SIGNIN, user);
  },
  signup(user) {
    return httpClient.post(API_SIGNUP, user);
  },
  changepassword(data) {
    return httpClient.post(API_CHANGEPASSWORD, data)
  },
  changeemail(data) {
    return httpClient.post(API_CHANGEEMAIL,data)
  },
  logout() {
    return httpClient.delete(API_LOGOUT)
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

