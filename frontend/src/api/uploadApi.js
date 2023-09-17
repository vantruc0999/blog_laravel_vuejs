import { v4 as uuidv4 } from 'uuid';

// const widget = windown.cloudinary.createUploadWidget( {
//   cloud_name: "kc-cloud", upload_preset: "upload-demo",
//   (error, result)=> {
//     if(error && result && result.event === "success") {
//       console.log("done....", result.infor);
//     }
//   }
// })

// function openUploadWidget() {
//   widget.open()
// }

const uploadApi = {
  image: async (file) => {
    try {
      const formData = new FormData();
      formData.append('file', file);
      formData.append('upload_preset', import.meta.env.VITE_CLOUDINARY_UPLOAD_PRESET);
      const response = await fetch(
        `https://api.cloudinary.com/v1_1/${import.meta.env.VITE_CLOUDINARY_CLOUD_NAME}/image/upload`,
        {
          method: 'POST',
          body: formData,
        }
      );
      const data = await response.json();
      console.log("🚀 ~ file: uploadApi.js:17 ~ image: ~ data:", data);
      return data.secure_url;
    } catch (error) {
      console.error(error);
      throw new Error('Image upload failed');
    }
  },
};

export default uploadApi;