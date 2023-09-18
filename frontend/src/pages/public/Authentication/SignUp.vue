<template>
    <div class="login__header">
        <h1 class="login__title">SignIn</h1>
        <p class="login__account">
            Already have an account?
            <router-link to="/auth/signin" class="login__switch">Sign in</router-link>
        </p>
        <button class="login__btn">
            <img src="../../../assets/images/google.png" alt="google" />
            <span>Sign up with google</span>
        </button>
        <p class="login__option">Or sign up with email</p>

        <form class="login__form">
            <div class="login__input">
                <label for="name">Full Name *</label>
                <input v-model="nameValue" type="text" placeholder="Enter Your Name..." class="login__text"
                    @blur="validateName" />
                <p class="error" v-if="nameError && !nameValue">This field must have a value</p>
            </div>
            <div class="login__input">
                <label for="email">Email *</label>
                <input v-model="emailValue" type="email" placeholder="Enter email..." class="login__text"
                    @blur="validateEmail" />
                <p class="error" v-if="emailError && !emailValue">Please enter a valid email address</p>
            </div>
            <div class="login__input">
                <label for="password">Password *</label>
                <input v-model="passwordValue" :type="showPassword ? 'text' : 'password'" placeholder="Enter password..."
                    class="login__text" @blur="validatePassword" />
                <p class="error" v-if="passwordError && !passwordValue">This field must have a value</p>
                <span class="login__icon" @click="togglePasswordVisibility">
                    <ion-icon :name="showPassword ? 'eye-outline' : 'eye-off-outline'"></ion-icon>
                </span>
            </div>
            <button class="login__button" @click="handleSignUp">Create my account</button>
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useAuthStore } from "../../../stores/authStore";

const authStore = useAuthStore();
const showPassword = ref(false);

let dataRegister = ref({
    name: "",
    email: "",
    password: ""
});

let nameValue = ref(dataRegister.value.name);
let emailValue = ref(dataRegister.value.email);
let passwordValue = ref(dataRegister.value.password);

const nameError = ref(false);
const emailError = ref(false);
const passwordError = ref(false);

const emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

const validateName = () => {
    if (!nameValue.value.trim()) {
        nameError.value = true;
    } else {
        nameError.value = false;
    }
};

const validateEmail = () => {
    if (!emailValue.value.trim()) {
        emailError.value = true;
    } else if (!emailRegex.test(emailValue.value)) {
        emailError.value = true;
    } else {
        emailError.value = false;
    }
};

const validatePassword = () => {
    if (!passwordValue.value.trim()) {
        passwordError.value = true;
    } else {
        passwordError.value = false;
    }
};

const handleSignUp = (e) => {
    e.preventDefault();
    nameError.value = !nameValue.value.trim();
    emailError.value = !emailValue.value.trim() || !emailRegex.test(emailValue.value);
    passwordError.value = !passwordValue.value.trim();

    if (!nameError.value && !emailError.value && !passwordError.value) {
        const name = nameValue.value;
        const email = emailValue.value;
        const password = passwordValue.value;
        const userData = {
            name: name,
            email: email,
            password: password
        };
        authStore.signup(userData);
        nameValue.value = "";
        emailValue.value = "";
        passwordValue.value = "";
    }
};

const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
};
</script>

<style lang="scss" scoped>
.login__header {
    margin: 0 auto;
    max-width: 556px;
    background-color: var(--white-color);
    border-radius: 12px;
    padding: 32px 60px;
    box-shadow: rgba(67, 71, 85, 0.27) 0px 0px 0.25em, rgba(90, 125, 188, 0.05) 0px 0.25em 1em;

}

.login__title {
    margin-bottom: 12px;
    font-size: 20px;
    line-height: 1.75rem;
    font-weight: 600;
    text-align: center;
    color: var(--black-color);
}

.login__account {
    margin-bottom: 20px;
    font-size: 18px;
    text-align: center;
    color: #808191;
}

.login__switch {
    font-weight: 500;
    text-decoration-line: underline;
    color: var(--text-color-1);
}

.login__btn {
    display: flex;
    justify-content: center;
    width: 100%;
    padding: 12px 0;
    column-gap: 0.75rem;
    margin-bottom: 20px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 12px;
    border: 1px solid var(--border-color);
    align-items: center;
    background-color: var(--white-color);
    cursor: pointer;
}

.login__option {
    display: flex;
    justify-content: center;
    margin-bottom: 16px;
    font-size: 15px;
    color: var(--text-color-4);
}

.login__form {
    .login__input {
        // flex flex-col mb-5 gap-y-3"
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
        row-gap: 12px;
        position: relative;
    }

    .login__text {
        width: 100%;
        padding: 16px 24px;
        font-size: 14px;
        font-weight: 500;
        border-radius: 10px;
        font-weight: 500;
        background-color: #E7ECF3;
        color: #373739;
        transition: all 0.2 linear;
        border: 1px solid transparent;
    }

    .login__text:focus {
        background-color: var(--white-color);
        border: 1px solid var(--primary-color);
    }

    .login__text::-webkit-input-placeholder {
        color: #4a4b4d;
    }

    .login__text::-moz-input-placeholder {
        color: #4a4b4d;

    }

    .login__icon {
        position: absolute;
        top: 50px;
        right: 25px;
        cursor: pointer;
    }



    .login__notifi {
        display: inline-block;
        color: #6F49FD;
        text-decoration: underline;
        margin: 10px 0px;
    }

    .login__forgot {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 10px;
        cursor: pointer;
        color: var(--green-color);

    }

    .login__notifi {
        display: inline-block;
        color: #6F49FD;
        text-decoration: underline;
        margin: 10px 0px;
    }

    .login__button {
        display: flex;
        align-items: center;
        padding: 16px;
        width: 100%;
        justify-content: center;
        font-size: 16px;
        font-weight: 600;
        border-radius: 12px;
        min-height: 56px;
        background-color: var(--secondary-color);
        color: var(--white-color);
        cursor: pointer;

        &:hover {
            opacity: .9;
        }
    }
}

.error {
    color: red;
    font-size: 12px;
}
</style>
