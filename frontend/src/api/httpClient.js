import axios from "axios";
import { v4 as uuidv4 } from "uuid"; // Import the uuid library

const httpClient = axios.create({
  baseURL: "http://127.0.0.1:8000/api",
  headers: {
    "Content-Type": "multipart/form-data",
    Accept: "application/json",
  },
});

// Add an interceptor to set the multipart/form-data boundary
httpClient.interceptors.request.use(function (config) {
  const token = localStorage.getItem("token");
  if (token) {
    config.headers.Authorization = "Bearer " + token;
  }
  
  // Generate a unique boundary using UUID v4
  const boundary = uuidv4();
  config.headers["Content-Type"] = `multipart/form-data; boundary=${boundary}`;
  
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