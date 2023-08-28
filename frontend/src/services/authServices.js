import httpClient from "../api/httpClient";
import {
  API_SIGNIN,
  API_SIGNUP,
} from "../config/apis";

export const AuthService = {
  signin(user) {
    return httpClient.post(API_SIGNIN, user);
  },
  signup(user) {
    return httpClient.post(API_SIGNUP, user);
  },
};

//   signout(next) {
//     if (window !== "undefined") {
//       localStorage.removeItem("user");
//       next();
//       return httpClient.get("/signout");
//     }
//   },
//   postarticle(post) {
//     return httpClient.post(API_POSTARTICLE, post);
//   },
//   getAllUsers(users) {
//     return httpClient.get(API_GETALLUSER);
//   },
//   resetPassword(data) {
//     return httpClient.post(`${API_GETALLUSER}/password/reset`, data);
//   },
