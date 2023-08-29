import axios from "axios";

const httpClient = axios.create({
  baseURL: "http://127.0.0.1:8000/api",
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});
httpClient.interceptors.request.use(function (config) {
  const token = localStorage.getItem("token");
  if (token) {
    config.headers.Authorization = "Bearer " + token;
  }
  return config;
});
export default httpClient;

// export const createPost = async(post, token) => {
//  try {
//   console.log("axios", token);
//     const data = await axios.post(`http://127.0.0.1:8000/api/posts/create-post`,post, {
//       headers: {
//         Authorization: `Bearer ${token}`
//       }
//     })
//     if(data) {
//       alert("Success");
//     }
//     return data;
//   } catch (error) {
//     console.log(error);
//   }

// }