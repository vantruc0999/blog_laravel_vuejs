<template>
    <div class="editor__container">
        <router-link to="/">
            <img src="../../../assets/images/logo-small.png" alt="">
        </router-link>
        <div class="editor__wrapper">
            <div class="editor__content">
                <textarea v-model="title" ref="textarea" :style="{ height: `${height}px` }" class="editor__input"
                    @input="handleResize" placeholder="Nhập tiêu đề của bạn..."></textarea>
                <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
            </div>
            <div class="editor__tool">
                <a-select v-model="selectedCategory" placeholder="Thể loại">
                    <a-select-option v-for="item in categoryData" :key="item.name" :value="item.name">
                        {{ item.name }}
                    </a-select-option>
                </a-select>
                <span class="editor__title">Chọn ảnh cho tiêu đề</span>
                <div class="image-select">
                    <img :src="temporaryImage" alt="" class="temporary-image">
                    <input type="file" @change="handleImageChange" accept="image/*" class="image-input">
                </div>
                <div class="editor__controller">
                    <div class="editor__btn">Hủy</div>
                    <div class="editor__btn editor__btn--submit" @click="handleSubmit" :disabled="!isFormValid">Đăng bài
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import CKEditor from '@ckeditor/ckeditor5-vue';
import { Select } from 'ant-design-vue';

const temporaryImage = ref('');
const categoryData = [
    { id: 1, name: 'Văn học' },
    { id: 2, name: 'IT' },
    { id: 3, name: 'Công nghệ' },
    { id: 4, name: 'Khoa học' },
    { id: 5, name: 'Xã hội' },
    { id: 6, name: 'Bàn luận' }
];

const selectedCategory = ref('');
const editor = ref(ClassicEditor);
const editorData = ref('');
const editorConfig = ref({
    placeholder: 'Nhập nội dung...'
});

const title = ref('');
const textarea = ref('');
const height = ref(35);

const handleResize = () => {
    height.value = textarea.value.scrollHeight;
    // console.log(textarea.value.scrollHeight);
};

const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = () => {
            temporaryImage.value = reader.result;
        };
        reader.readAsDataURL(file);
    }
};



const handleSubmit = () => {
    // if (!isFormValid.value) {
    //     console.log('Vui lòng điền đầy đủ thông tin.');
    //     return;
    // }

    const submittedTitle = title.value;
    const submittedEditorData = editorData.value;
    const submittedSelectedCategory = selectedCategory.value; // Lấy đối tượng được chọn

    // Kiểm tra submittedSelectedCategory có tồn tại và lấy giá trị name
    const selectedCategoryName = submittedSelectedCategory ? submittedSelectedCategory.name : '';

    // Gửi các giá trị đi theo yêu cầu của bạn
    console.log('Title:', submittedTitle);
    console.log('Editor Data:', submittedEditorData);
    console.log('Selected Category:', submittedSelectedCategory);
};
</script>

<style lang="scss" scoped>
.editor__container {
    width: 100%;

    .editor__wrapper {
        // max-width: 750px;
        width: 100%;
        padding: 0px 50px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;

        .editor__input {
            background-color: #f5f7fa;
            margin: 30px 0px;
            width: 100%;
            resize: none;
            height: auto;
            min-height: 35px;
            font-size: 30px;
            font-family: Montserrat, Raleway, sans-serif;
            line-height: 3rem;
            font-weight: 700;
            border: none;

            &::placeholder {
                font-size: 30px;
                color: #c4c4c4;
            }
        }

        .editor__tool {
            .ant-select {
                width: 100%
            }

            .editor__title {
                font-size: 22px;
                font-weight: 700;
                margin: 30px 0;
                display: inline-block;
            }
        }
    }

}

.image-select {
    position: relative;
    width: 100%;
    height: 200px;
    border: 2px dashed #ccc;
    border-radius: 8px;
    overflow: hidden;
}

.temporary-image {
    width: 100%;
}

.image-select .temporary-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-select .image-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    object-fit: cover;
    cursor: pointer;
}

.image-select::before {
    content: "Chọn ảnh";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #999;
    font-size: 16px;
    font-weight: bold;
    opacity: 0.8;
    pointer-events: none;
}

.image-select:hover::before {
    opacity: 1;
}

.editor__controller {
    display: flex;
    justify-content: flex-end;
    gap: 20px;
    margin-top: 40px;

    .editor__btn {
        cursor: pointer;
        width: 100px;
        border-radius: 12px;
        padding: 10px;
        display: flex;
        justify-content: center;
        border: 1px solid var(--border-color);
        font-weight: 700;

        &--submit {
            background-image: linear-gradient(to right bottom, #2ebac1, #a4d96c);
            color: var(--white-color);
        }

        &:hover {
            opacity: .9;
        }
    }
}

.ske-container {
    width: 700px;
}

.ske-content {
    height: auto;

}


.ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
    border-color: red !important;
}
</style>