import { v4 as uuidv4 } from 'uuid';
import uploadApi from "../api/uploadApi";

export default function uploadImage(loader) {
  return {
    upload: () => {
      return new Promise(async (resolve, reject) => {
        try {
          const file = await loader.file;
          if (!file) return;

          const response = await uploadApi.image(file);
          console.log("🚀 ~ file: uploadImage.js:12 ~ loader.file.then ~ response:", response);

          if (response) {
            const urlImage = response;
            resolve({ default: urlImage });
          }
        } catch (error) {
          reject(error);
        }
      });
    }
  };
}