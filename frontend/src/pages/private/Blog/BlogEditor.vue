<template></template>

<script setup>
import { watch, ref, computed } from 'vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
// import CKEditor from '@ckeditor/ckeditor5-vue';
// import { Select } from 'ant-design-vue';


const selectedCategory = ref('');
const selectedCategoryType = ref([]);

const categoryData = [
    {
        category: {
            id: 1,
            name: 'Văn học',
        },
        categoryType: [
            { id: 1, type: 'Dân gian' },
            { id: 2, type: 'Bút kí' },
        ],
    },
    {
        category: {
            id: 2,
            name: 'IT',
        },
        categoryType: [
            { id: 1, type: 'An ninh mạng' },
            { id: 2, type: 'Lập trình web' },
        ],
    },
    {
        category: {
            id: 3,
            name: 'Công nghệ',
        },
        categoryType: [
            { id: 1, type: 'Xu hướng' },
            { id: 2, type: 'Tác hại công nghệ' },
        ],
    },
    {
        category: {
            id: 4,
            name: 'Khoa học',
        },
        categoryType: [
            { id: 1, type: 'Trừu tượng' },
            { id: 2, type: 'Thiên văn' },
        ],
    },
    {
        category: {
            id: 5,
            name: 'Xã hội',
        },
        categoryType: [
            { id: 1, type: 'Đời thường' },
            { id: 2, type: 'Lên án' },
        ],
    },
    {
        category: {
            id: 7,
            name: 'Thể thao',
        },
        categoryType: [
            { id: 1, type: 'Bóng rổ' },
            { id: 2, type: 'Bóng đá' },
        ],
    },
];

const filteredOptions = computed(() => {
    const selectedCategoryData = categoryData.find(item => item.category.name === selectedCategory.value);
    if (selectedCategoryData) {
        return selectedCategoryData.categoryType.map(item => {
            return { value: item.type, label: item.type };
        });
    } else {
        return [];
    }
});

// watch(() => selectedCategory.value, (newValue) => {
//     selectedCategoryType.value = [];
//     console.log("🚀 ~ file: BlogEditor.vue:130 ~ watch ~ selectedCategoryType.value:", selectedCategoryType.value)
// });

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
        // const reader = new FileReader();
        // reader.onload = () => {
        //     //     temporaryImage.value = reader.result;
        //     imagePath.value = reader.result; // Gán đường dẫn ảnh cho imagePath
        // };
        // reader.readAsDataURL(file);
    }
};
// Validate data
const isFormValid = computed(() => {
    return intro.value.trim() !== '' && title.value.trim() !== '' && editorData.value.trim() !== '' && selectedCategory.value !== '';
});

const handleCategoryChange = (value) => {
    selectedCategory.value = value;
};
const handleCategoryTypeChange = (value) => {
    selectedCategoryType.value = value;
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
    const selectedCategoryData = categoryData.find(item => item.category.name === selectedCategory.value);
    const selectedCategoryTypeIdList = selectedCategoryType.value.map(type => {
        const selectedTypeData = selectedCategoryData.categoryType.find(item => item.type === type);
        return selectedTypeData.id;
    });

    const submittedSelectedCategoryId = selectedCategoryData.category.id;

    console.log("Selected Category Type IDs:", selectedCategoryTypeIdList);
    console.log("Submitted Category ID:", submittedSelectedCategoryId);

    const submittedTitle = title.value;
    const submittedEditorData = editorData.value;
    // const submittedSelectedCategory = selectedCategory.value;
    const submittedIntro = intro.value;
    const submittedBanner = imagePath.value;
    const formData = new FormData();
    formData.append('banner', imagePath.value)
    formData.append('title', submittedTitle)
    formData.append('intro', submittedIntro)
    formData.append('description', submittedEditorData)
    formData.append('category_id', 1)
    formData.append('tags', [1, 2])

    console.log("🚀 ~ file: BlogEditor.vue:134 ~ handlePostBlog ~ blogData:", formData)
    // postStore.actCreatePost(formData)

    title.value = '';
    intro.value = '';
    editorData.value = '';
    selectedCategory.value = '';
    temporaryImage.value = '';

};


</script>

<style lang="scss" scoped></style>