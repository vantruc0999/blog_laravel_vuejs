<template >
    <div class="blog__container">
        <div class="editor__container">
            <div class="editor__wrapper">
                <div class="editor__content">
                    <textarea v-model="title" ref="textarea" :style="{ height: `${height}px` }" class="editor__input"
                        @input="handleResize" placeholder="Nhập tiêu đề của bạn..."></textarea>
                    <p class="message">{{ titleLength }}/150</p>
                    <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                </div>
                <div class="editor__tool">
                    <span class="editor__title">Thể loại</span>
                    <div class="editor__category">
                        <a-select v-model="selectedCategory" placeholder="Thể loại" @change="handleCategoryChange">
                            <a-select-option v-for="tag in postStore.tags" :key="tag?.id" :value="tag?.name">
                                {{ tag?.name }}
                            </a-select-option>
                        </a-select>
                        <a-space direction="vertical">
                            <a-select v-model="selectedTag" :options="filteredTags" mode="multiple" :size="size"
                                placeholder="Please select" style="width: 250px" @change="handleTagChange"
                                @popupScroll="popupScroll"></a-select>
                        </a-space>
                    </div>

                    <div class="editor__intro">
                        <span class="editor__title">Lời giới thiệu</span>
                        <textarea v-model="intro" ref="textarea" class="editor__intro__input"
                            placeholder="Nhập giới thiệu của bạn..." @input="handleIntroInput"></textarea>
                        <p class="message">{{ introLength }}/100</p>
                    </div>

                    <span class="editor__title">Chọn ảnh cho tiêu đề</span>
                    <div class="image-select">
                        <img :src="temporaryImage" alt="" class="temporary-image">
                        <input type="file" @change="handleImageChange" accept="image/*" class="image-input">
                    </div>
                    <div class="editor__controller">
                        <div class="editor__btn">Hủy</div>
                        <div class="editor__btn editor__btn--submit" @click="handlePostBlog" :disabled="!isFormValid">Đăng
                            bài
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { watch, ref, computed } from 'vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { usePostStore } from '../../../stores/postStore';
// import CKEditor from '@ckeditor/ckeditor5-vue';
// import { Select } from 'ant-design-vue';

const postStore = usePostStore();
postStore.getAllTags();

const selectedCategory = ref('');
const selectedTag = ref('');

const filteredTags = ref([]);

watch(() => selectedCategory.value, () => {
    const selectedTagData = postStore.tags.find(tag => tag.name === selectedCategory.value);
    if (selectedTagData) {
        filteredTags.value = selectedTagData.tags.map(tag => ({ value: tag.id, label: tag.name }));
    } else {
        filteredTags.value = [];
    }
});


const temporaryImage = ref(null);
const imagePath = ref(null);

const editor = ref(ClassicEditor);
const editorData = ref('');

const editorConfig = ref({
    placeholder: 'Nhập nội dung...'
});

const height = ref(35);
const title = ref('');
const intro = ref('');
const textarea = ref('');

const maxIntroLength = 100;
const maxTitleLength = 150;

const introLength = ref(0);
const titleLength = ref(0);

const handleResize = () => {
    height.value = textarea.value.scrollHeight;
    if (title.value.length > maxTitleLength) {
        title.value = title.value.slice(0, maxTitleLength);
    }
};

const handleIntroInput = () => {
    if (intro.value.length > maxIntroLength) {
        intro.value = intro.value.slice(0, maxIntroLength);
    }
};


watch(intro, (newIntro) => {
    introLength.value = newIntro.length;
    if (newIntro.length > maxIntroLength) {
        intro.value = newIntro.slice(0, maxIntroLength);
    }
});
watch(title, (newTitle) => {
    titleLength.value = newTitle.length;
    if (newTitle.length > maxTitleLength) {
        title.value = newTitle.slice(0, maxTitleLength);
    }
});
const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        temporaryImage.value = URL.createObjectURL(file)
        imagePath.value = file
    }
};
// Validate data
const isFormValid = computed(() => {
    return intro.value.trim() !== '' && title.value.trim() !== '' && editorData.value.trim() !== '' && selectedCategory.value !== '';
});

const handleCategoryChange = (value) => {
    selectedCategory.value = value;
};
const handleTagChange = (value) => {
    selectedTag.value = value;
};
// Handle submit post
const handlePostBlog = () => {
    const errors = {};

    if (title.value.trim() === '') {
        errors.title = true;
    }
    if (intro.value.trim() === '') {
        errors.title = true;
    }

    if (editorData.value.trim() === '') {
        errors.editorData = true;
    }

    if (selectedCategory.value === '') {
        errors.selectedCategory = true;
    }

    if (Object.keys(errors).length > 0) {
        alert("Vui lòng điền đầy đủ thông tin bài đăng, chúc bạn có một bài đăng tuyệt vời ❤️❤️❤️");
        return;
    }
    let selectedTagData = null;
    let selectedTagById = ref(null)
    if (selectedCategory.value !== '') {
        selectedTagData = postStore.tags.find((tag) => tag.name === selectedCategory.value);
    }

    if (selectedTagData) {
        const selectedTagIdList = selectedTag.value.map((tagName) => {
            const tag = selectedTagData.tags.find((tag) => {
                return selectedTagById.value = tag.id
            })
            return tag ? tag.id : null;
        });

    }
    const submittedTitle = title.value;
    const submittedEditorData = editorData.value;
    const submittedIntro = intro.value;
    const formData = new FormData();
    formData.append('title', submittedTitle)
    formData.append('intro', submittedIntro)
    formData.append('description', submittedEditorData)
    formData.append('category_id', selectedTagData.id)
    formData.append('banner', imagePath.value)
    formData.append('tags', selectedTagById.value)

    console.log("🚀 ~ file: BlogEditor.vue:134 ~ handlePostBlog ~ blogData:", formData)
    postStore.actCreatePost(formData)

    title.value = '';
    intro.value = '';
    editorData.value = '';
    selectedCategory.value = '';
    temporaryImage.value = '';
};


</script>
<style lang="scss" scoped>
.blog__container {
    padding: 40px 140px;
    margin: 80px 0px 100px 0px;

    .blog__logo {
        width: 150px;
    }

    .editor__container {
        width: 100%;

        .editor__wrapper {
            // max-width: 750px;
            width: 100%;
            padding: 0px 50px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;

            .editor__intro {
                .editor__intro__input {
                    width: 100%;
                    margin: 10px 0px;
                    width: 100%;
                    height: 90px;
                    font-size: 20px;
                    border: none;
                }
            }

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
                .editor__category {
                    display: flex;
                    gap: 10px;
                }

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

    .message {
        color: red;
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
            background-color: var(--white-color);
            cursor: pointer;
            width: 130px;
            height: 50px;
            border-radius: 12px;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-color);
            font-weight: 700;

            &--submit {
                background-color: var(--secondary-color);
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
}
</style>