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

