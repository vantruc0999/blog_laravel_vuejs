<template>
    <div class="sidebar__container">
        <div class="account__infor">
            <div class="image-select">
                <img :src="temporaryImage" alt="" class="temporary-image">
                <input type="file" @change="handleImageChange" accept="image/*" class="image-input">
                <span class="image-icon">
                    <ion-icon name="camera-outline"></ion-icon>
                </span>
            </div>
            <div class="account__detail">
                <div class="account__avatar"></div>
                <div class="account__desc">
                    <textarea v-model="title" ref="textarea" class="editor__input" placeholder="@Bio..."></textarea>
                </div>
            </div>
            <div class="account__name">
                <div class="account__col">
                    <div class="account__name--text">Tên hiển thị</div>
                    <input type="text" value="Dong Pham" class="account__name--input">
                </div>
                <div class="account__col">
                    <div class="account__name--text">Email</div>
                    <input type="text" placeholder="dongpham@gmail.com" class="account__name--input">
                </div>
                <a-space direction="vertical" :size="12">
                    <div class="account__name--text">Ngày sinh</div>
                    <a-date-picker v-model:value="value1" />
                </a-space>
                <div class="account__col">
                    <div class="account__name--text">Giới tính</div>
                    <a-radio-group v-model:value="valueChecked">
                        <a-radio :value="1">Nam</a-radio>
                        <a-radio :value="2">Nữ</a-radio>
                        <a-radio :value="3">Giới tính khác</a-radio>
                    </a-radio-group>
                </div>
            </div>
            <button class="account__password">Đổi mật khẩu</button>
        </div>
        <div class="account__controller">
            <button class="account__btn">Hủy</button>
            <button class="account__btn account__btn--save">Lưu</button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const value1 = ref();
const valueChecked = ref()
const temporaryImage = ref("");
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
const handleDateChange = (date) => {
    // Lấy giá trị ngày sinh được chọn
    console.log("Ngày sinh:", date);
    // Hoặc bạn có thể lưu giá trị vào một biến khác để sử dụng sau này
    // selectedDate.value = date;
}
</script>

<style lang="scss" scoped>
.sidebar__container {
    .account__infor {
        .account__detail {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;

            .account__avatar {
                width: 100px;
                height: 100px;
                border: 1px solid var(--border-color);
                border-radius: 50%;
            }

            .editor__input {
                border: 1px solid var(--border-color);
                height: 120px;
                width: 500px;
                padding: 10px;
            }
        }

        .temporary-image {
            width: 100%;
            // z-index: 20;
        }

        .image-select {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 720px;
            height: 160px;
            position: relative;
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

        .image-select .image-icon {
            cursor: pointer;
            position: absolute;
            top: 50%;
            left: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: #999;
            font-size: 30px;
            z-index: 1;

        }

        .image-select:hover::before {
            opacity: 1;
        }
    }

    .account__name {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
        margin-top: 30px;

        .account__col {
            display: flex;
            flex-direction: column;
            gap: 20px;

            .account__name--text {
                text-transform: uppercase;
                color: #B0A99F;
                font-weight: 600;
            }

            .account__name--input {
                width: 100% height;
                background-color: #edf2f7;
                height: 50px;
                padding: 5px;
                border-radius: 12px;
                border: 1px solid var(--border-color);
            }
        }


    }

    .account__password {
        width: 100%;
        margin: 40px 0;
        padding: 13px;
        background-color: var(--white-color);
        border-radius: 12px;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
        font-weight: 500;


        &:hover {
            background-color: #edf2f7;
        }
    }

    .account__controller {
        display: flex;
        justify-content: flex-end;
        margin-top: 30px;
        gap: 20px;
        font-weight: 700;
        font-size: 16px;

        .account__btn {
            width: 110px;
            height: 40px;
            border-radius: 12px;
            cursor: pointer;
            padding: 10px;

            &--save {
                background-image: linear-gradient(to right bottom, #2ebac1, #a4d96c);
                color: var(--white-color);
            }
        }
    }
}

.ant-picker {
    width: 100%;
    background-color: #edf2f7;
}
</style>
