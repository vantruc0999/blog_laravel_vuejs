<template>
    <div v-if="authStore.isLoading">
        <Loading />
    </div>
    <div class="sidebar__container">
        <div class="account__infor">
            <div class="image-select">
                <img :src="'http://127.0.0.1:8000/images/banner/' + authStore.user.blogger_info?.banner" alt="avatar"
                    class="temporary-image">
                <img :src="temporaryBanner" alt="" class="temporary-image temporary-image--banner">
                <input type="file" @change="handleBannerChange" accept="image/*" class="image-input">
                <span class="image-icon">
                    <ion-icon name="camera-outline"></ion-icon>
                </span>
            </div>
            <div class="account__detail">
                <div class="account__avatar">
                    <img :src="'http://127.0.0.1:8000/images/avatar/' + authStore.user.blogger_info?.profile_image"
                        alt="avatar" class="temporary-image">
                    <img :src="temporaryAvatar" alt="" class="temporary-image temporary-image--avatar">
                    <input type="file" @change="handleAvatarChange" accept="image/*" class="image-input">
                    <span class="image-icon">
                        <ion-icon name="camera-outline"></ion-icon>
                    </span>
                </div>
                <div class="account__desc">
                    <textarea v-model="bio" ref="textarea" class="editor__input"
                        :placeholder="authStore.user.blogger_info?.bio ? authStore.user.blogger_info?.bio : 'Bio...'"
                        @input="handleBioInput"></textarea>
                    <p class="message">{{ bioLength }}/150</p>
                </div>
            </div>
            <form class="account__name">
                <div class="account__col">
                    <div class="account__name--text">Tên hiển thị</div>
                    <input type="text" :value="authStore.user.blogger_info?.name" @input="updateName"
                        class="account__name--input">
                </div>
                <div class="account__col">
                    <div class="account__name--text">Email</div>
                    <div class="account__name--input" @click="handleOpenEmailChange">{{ authStore.user.blogger_info?.email
                    }}</div>
                    <ion-icon name="pencil-outline" @click="handleOpenEmailChange"></ion-icon>
                </div>
                <form class="account__col">
                    <label for="birthday" class="account__name--text">Birthday:</label>
                    <input type="date" id="birthday" name="birthday" class="account__name--input" v-model="birthValue"
                        @input="handleBirthInput">
                </form>
                <!-- <a-space direction="vertical" :size="12">
                    <div>Ngày sinh</div>
                    <a-date-picker v-model:value="birthValue" />
                </a-space> -->

                <div class="account__col">
                    <div class="account__name--text">Giới tính</div>
                    <a-radio-group v-model:value="genderValue" @change="handleGenderChange">
                        <a-radio :value="1">Nam</a-radio>
                        <a-radio :value="0">Nữ</a-radio>
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
            <button class="account__btn" @click="handleCancel">Hủy</button>
            <button class="account__btn account__btn--save" @click="handleUpdateProfile">Lưu</button>
        </div>
    </div>
    <div class="modal__edit" v-if="idOpenChangeEmail">
        <form class="modal__form">
            <label class="modal__label">*Email*</label>
            <input v-model="emailValue" type="email" placeholder="Nhập gmail bạn muốn đổi..." class="modal__input">
            <div class="modal__edit__error" v-if="isError">Email không hợp lệ !!</div>
            <div class="modal__controller">
                <button class="modal__btn modal__btn__cancel" @click="handleCloseEmailChange">Hủy</button>
                <button class="modal__btn modal__btn__submit" @click="handleSaveEmail">Lưu</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { watch, ref, onMounted } from 'vue';
import { useAuthStore } from '../../../stores/authStore';
import Loading from "../../../components/Loading.vue"
// store
const authStore = useAuthStore()

// form password
const passwordMatchError = ref('');
const isOpenForgotPassword = ref(false);
const oldPassword = ref('');
const newPassword = ref('');
const confirmPassword = ref('');
const errorMessages = {
    oldPassword: '',
    newPassword: '',
    confirmPassword: '',
};
// form information
const bannerPath = ref(null);
const avatarPath = ref(null);
const temporaryBanner = ref('');
const temporaryAvatar = ref('');
const birthValue = ref(null);
const genderValue = ref(null);
const idOpenChangeEmail = ref(false)
const isError = ref(false)
const bio = ref('')
const emailValue = ref('')
onMounted(async () => {
    await authStore.getMyProfile()
    genderValue.value = authStore.user?.blogger_info?.gender
    birthValue.value = authStore.user?.blogger_info?.birthday
})
const maxBioLength = 150;

const bioLength = ref(0);

const handleBioInput = () => {
    if (bio.value.length > maxBioLength) {
        bio.value = intro.value.slice(0, maxBioLength);
    }
};

const handleOpenEmailChange = () => {
    idOpenChangeEmail.value = !idOpenChangeEmail.value
}
const handleCloseEmailChange = (e) => {
    e.preventDefault()
    idOpenChangeEmail.value = false
}
const isValidEmail = (value) => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(value);
};
const handleSaveEmail = (e) => {
    e.preventDefault()
    const formData = new FormData();
    formData.append('email', emailValue.value)
    console.log(isValidEmail(emailValue.value));
    if (isValidEmail(emailValue.value) == false) {
        isError.value = true
    }
    else {
        authStore.changeEmail(formData)
        isError.value = false
        idOpenChangeEmail.value = false
    }
}
watch(bio, (newBio) => {
    bioLength.value = newBio.length;
    if (newBio.length > maxBioLength) {
        bio.value = newBio.slice(0, maxBioLength);
    }
});
// handle udpdate information
const updateName = (event) => {
    authStore.user.blogger_info.name = event.target.value;
};
const handleGenderChange = (value) => {
    if (value === 1) {
        genderValue.value = 1;
    } else if (value === 0) {
        genderValue.value = 0;
    }
};
//  handle image
const handleBannerChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        temporaryBanner.value = URL.createObjectURL(file)
        bannerPath.value = file
    };

};

const handleAvatarChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        temporaryAvatar.value = URL.createObjectURL(file)
        avatarPath.value = file
    };

};
const handleBirthInput = (event) => {
    birthValue.value = event.target.value;
};
const handleUpdateProfile = () => {
    if (birthValue.value) {
        const date = new Date(birthValue.value);
        const day = date.getDate().toString().padStart(2, '0');
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const year = date.getFullYear().toString();
        const formattedDate = `${day}/${month}/${year}`;
        authStore.user.blogger_info.birthday = formattedDate;
    }
    const formData = new FormData();
    formData.append('name', authStore.user?.blogger_info?.name)
    formData.append('bio', bio.value)
    formData.append('profile_image', avatarPath.value)
    formData.append('profile_banner', bannerPath.value)
    formData.append('gender', genderValue.value)
    formData.append('birthday', birthValue.value)
    authStore.updateMyProfile(formData)
    // const updatedUser = {
    //     profile_image: authStore.user?.blogger_info?.profile_image,
    //     name: authStore.user?.blogger_info?.name,
    //     bio: bio.value
    // };
    // localStorage.setItem('user', JSON.stringify(updatedUser));
};

// handle password
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
    if (newPassword.value !== confirmPassword.value) {
        passwordMatchError.value = "Mật khẩu mới và xác nhận không khớp.";
    }
    if (newPassword.value === confirmPassword.value) {
        const formData = new FormData();
        formData.append('old_password', oldPassword.value)
        formData.append('password', newPassword.value)
        authStore.changePassword(formData)
    }
    // Perform validation
    // if (oldPassword.value === '') {
    //     errorMessages.oldPassword = 'Vui lòng nhập mật khẩu cũ.';
    // }
    // if (newPassword.value === '') {
    //     errorMessages.newPassword = 'Vui lòng nhập mật khẩu mới.';
    // }

    // if (newPassword.value === confirmPassword.value) {
    //     console.log(newPassword.value, confirmPassword.value);
    // }
};
const handleCancel = () => {
    // Đặt lại các giá trị ban đầu ở đây
    bio.value = authStore.user?.blogger_info?.bio ? authStore.user.blogger_info?.bio : '';
    // Đặt lại các giá trị khác tương tự ở đây
};
</script>

<style lang="scss" scoped>
.modal__edit {
    position: fixed;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    background-color: hsla(0, 0%, 100%, 0.5);
    -webkit-backdrop-filter: blur(15px);
    backdrop-filter: blur(15px);
    z-index: 999px;

    .modal__edit__error {
        color: red;
        font-size: 12px;
    }

    .modal__form {
        margin: 200px auto;
        // background-color: var(--black-color);
        max-width: 500px;
        max-height: 500px;
        display: flex;
        // align-items: center;
        flex-direction: column;
        justify-content: center;
        gap: 10px;

        .modal__label {
            font-size: 22px;
        }

        .modal__input {
            width: 100%;
            background-color: var(--border-color);
            height: 45px;
            border-radius: 12px;
            padding: 5px;
        }
    }

    .modal__controller {
        display: flex;
        justify-content: flex-end;
        gap: 10px;

        .modal__btn {
            width: 70px;
            height: 40px;
            border-radius: 12px;
            padding: 8px;
            color: var(--black-color);

            &__cancel {
                background-color: var(--white-color);

            }

            &__submit {
                background-color: var(--primary-color);
            }
        }
    }
}

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
                    position: absolute;
                }

                .image-input {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    opacity: 0;
                    cursor: pointer;
                    z-index: 1;
                }

                .image-icon {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    font-size: 24px;
                    color: #000;
                    z-index: -1;
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
            position: absolute;

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
            position: relative;

            ion-icon {
                position: absolute;
                top: 51px;
                font-size: 18px;
                right: 15px;
                cursor: pointer;
            }

            .account__name--text {
                text-transform: uppercase;
                color: #B0A99F;
                font-weight: 600;
            }

            .account__name--input {
                cursor: pointer;
                width: 100% height;
                background-color: #edf2f7;
                height: 50px;
                padding: 5px;
                display: flex;
                justify-content: flex-start;
                align-items: center;
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

.message {
    color: red;
}

.ant-picker {
    width: 100%;
    background-color: #edf2f7;
}
</style>
