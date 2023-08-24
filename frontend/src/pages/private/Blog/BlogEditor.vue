<template>
    <div class="editor__container">
        <img src="../../../assets/images/logo-small.png" alt="">
        <div class="editor__wrapper">
            <div class="editor__content">
                <textarea v-model="title" ref="textarea" :style="{ height: `${height}px` }" class="editor__input"
                    @input="handleResize" placeholder="Nhập tiêu đề của bạn..."></textarea>
                <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
            </div>
            <div class="editor__tool">
                <Space direction="horizontal" size="15" class="dropdown">
                    <Select placeholder="Thể loại">
                        <template #default>
                            <Option v-for="item in filterCategory" :key="item.name" :value="item.name">
                                {{ item.name }}
                            </Option>
                        </template>
                    </Select>
                </Space>
                <div class="image-select">
                    <img :src="temporaryImage" alt="" class="temporary-image">
                    <input type="file" @change="handleImageChange" accept="image/*" class="image-input">
                </div>
                <div class="editor__controller">
                    <div class="editor__btn">
                        Hủy
                    </div>
                    <div class="editor__btn editor__btn--submit">
                        Đăng bài
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
import { toRefs } from 'vue';
import { Select, Space } from "ant-design-vue";


const temporaryImage = ref("")
const { Option } = Select;

const categoryData = [
    {
        name: "Văn học"
    },
    {
        name: "IT"
    },
    {
        name: "Công nghệ"
    },
    {
        name: "Khoa học"
    },
    {
        name: "Xã hội"
    },
    {
        name: "Bàn luận"
    }
];
const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = () => {
            temporaryImage.value = reader.result;
        };
        reader.readAsDataURL(file);
    }
}

const editor = ref(ClassicEditor);
const editorData = ref('');
const editorConfig = ref({
    placeholder: 'Nhập nội dung...',
});
let title = ref('');
const textarea = ref('');
const height = ref(35);
const handleResize = () => {
    height.value = textarea.value.scrollHeight;
    console.log(textarea.value.scrollHeight);
};

const filterCategory = computed(() => {
    return categoryData.map(item => {
        return item;
    });
});

</script>

<style lang="scss" scoped>
.editor__container {
    width: 100%;

    .editor__wrapper {
        width: 750px;
        display: flex;

        .editor__input {
            margin-top: 30px;
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
                font-size: 22px;
                color: #c4c4c4;
            }
        }
    }

}

.image-select {
    margin-top: 20px;
    position: relative;
    width: 540px;
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
</style>