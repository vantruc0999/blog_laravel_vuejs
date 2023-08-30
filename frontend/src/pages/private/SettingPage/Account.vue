<template>
    <div class="sidebar__container">
        <div class="account__infor">
            <div class="image-select">
                <img :src="temporaryBanner" alt="" class="temporary-image">
                <input type="file" @change="handleBannerChange" accept="image/*" class="image-input">
                <span class="image-icon">
                    <ion-icon name="camera-outline"></ion-icon>
                </span>
            </div>
            <div class="account__detail">
                <div class="account__avatar">
                    <img :src="temporaryAvatar" alt="" class="temporary-image">
                    <input type="file" @change="handleAvatarChange" accept="image/*" class="image-input">
                    <span class="image-icon">
                        <ion-icon name="camera-outline"></ion-icon>
                    </span>
                </div>
                <div class="account__desc">
                    <textarea v-model="title" ref="textarea" class="editor__input" placeholder="@Bio..."></textarea>
                </div>
            </div>
            <form class="account__name">
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
                    <a-radio-group v-model:value="valueChecked" @click="handleGenderChange">
                        <a-radio :value="1">Nam</a-radio>
                        <a-radio :value="2">Nữ</a-radio>
                        <a-radio :value="3">Giới tính khác</a-radio>
                    </a-radio-group>
                </div>
            </form>
            <button class="account__password" @click="handleOpenForgotPassword">Đổi mật khẩu</button>
            <form class="forgot__form" :class="{ active: isOpenForgotPassword }">
                <div class="forgot__field">
                    <label for="oldPassword" class="forgot__text">Mật khẩu cũ</label>
                    <input type="password" v-model="oldPassword" placeholder="********" class="forgot__input" />
                    <p v-if="errorMessages.oldPassword" class="error">{{ errorMessages.oldPassword }}</p>
                </div>
                <div class="forgot__field">
                    <label for="newPassword" class="forgot__text">Mật khẩu mới</label>
                    <input type="password" v-model="newPassword" placeholder="********" class="forgot__input"
                        @blur="checkPasswordMatch" />
                    <p v-if="errorMessages.newPassword" class="error">{{ errorMessages.newPassword }}</p>
                </div>
                <div class="forgot__field">
                    <label for="confirmPassword" class="forgot__text">Nhập lại mật khẩu mới</label>
                    <input type="password" v-model="confirmPassword" placeholder="********" class="forgot__input"
                        @blur="checkPasswordMatch" />
                    <p v-if="errorMessages.confirmPassword" class="error">{{ errorMessages.confirmPassword }}</p>
                    <p v-if="passwordMatchError" class="error">{{ passwordMatchError }}</p>
                </div>
                <button class="forgot__button" @click="handleSave">Xác nhận</button>
            </form>
        </div>
        <div class="account__controller">
            <button class="account__btn">Hủy</button>
            <button class="account__btn account__btn--save">Lưu</button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const isOpenForgotPassword = ref(false);
const oldPassword = ref('');
const newPassword = ref('');
const confirmPassword = ref('');
const errorMessages = {
    oldPassword: '',
    newPassword: '',
    confirmPassword: '',
};
const passwordMatchError = ref('');


const value1 = ref();
const valueChecked = ref();
const temporaryBanner = ref('');
const temporaryAvatar = ref('');


const handleGenderChange = (value) => {
    valueChecked.value = value;
    console.log(valueChecked.value);
};
const handleBannerChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = () => {
            temporaryBanner.value = reader.result;
        };
        reader.readAsDataURL(file);
    }
};

const handleAvatarChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = () => {
            temporaryAvatar.value = reader.result;
        };
        reader.readAsDataURL(file);
    }
};

const handleOpenForgotPassword = () => {
    isOpenForgotPassword.value = !isOpenForgotPassword.value;
};

const checkPasswordMatch = () => {
    if (newPassword.value !== confirmPassword.value) {
        passwordMatchError.value = "Mật khẩu mới và xác nhận không khớp.";
    } else {
        passwordMatchError.value = "";
    }
};

const handleSave = (e) => {
    e.preventDefault();

    // Reset error messages
    errorMessages.oldPassword = '';
    errorMessages.newPassword = '';
    errorMessages.confirmPassword = '';

    // Perform validation
    if (oldPassword.value === '') {
        errorMessages.oldPassword = 'Vui lòng nhập mật khẩu cũ.';
    }
    if (newPassword.value === '') {
        errorMessages.newPassword = 'Vui lòng nhập mật khẩu mới.';
    }

    if (newPassword.value !== confirmPassword.value) {
        passwordMatchError.value = "Mật khẩu mới và xác nhận không khớp.";
    }
    if (newPassword.value === confirmPassword.value) {
        console.log(newPassword.value, confirmPassword.value);
    }
};
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
                position: relative;

                .temporary-image {
                    border-radius: 50%;

                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }

                .image-input {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    opacity: 0;
                    cursor: pointer;
                }

                .image-icon {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    font-size: 24px;
                    color: #000;
                }
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
            z-index: -1;

        }

        .image-select:hover::before {
            opacity: 1;
        }

        .forgot__form.active {
            height: 435px;
            transition: height 0.4s ease-in-out;
        }

        .forgot__form {
            position: relative;
            height: 0;
            overflow: hidden;
            transition: height 0.4s ease-in-out;

            .forgot__field {
                display: flex;
                flex-direction: column;
                margin-bottom: 10px;

                .forgot__text {
                    text-transform: uppercase;
                    color: var(--black-color);
                    font-weight: 600;
                    font-size: 15px;
                    margin-bottom: 10px;
                }

                .forgot__input {
                    width: 100% height;
                    background-color: #edf2f7;
                    height: 50px;
                    padding: 10px;
                    border-radius: 12px;
                    border: 1px solid var(--border-color);
                }

                .error {
                    margin: 5px 0px;
                    font-size: 14px;
                    color: red;
                }
            }

            .forgot__button {
                margin-top: 10px;
                width: 100%;
                padding: 15px;
                border-radius: 13px;
                color: var(--white-color);
                font-weight: 600;
                background-color: var(--secondary-color);
            }
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
