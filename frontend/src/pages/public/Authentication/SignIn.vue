<template>
    <div className="login__header">
        <h1 className="login__title">
            SignIn
        </h1>
        <p className="login__account">
            Dont have an account?
            <router-link to="/auth/signup" class="login__switch">
                Sign up
            </router-link>
        </p>
        <button className="login__btn">
            <img src="../../../assets/images/google.png" alt="google" />
            <span>Sign up with google</span>
        </button>

        <form class="login__form">
            <div class="login__input">
                <label for="email">Email *</label>
                <input v-model="emailValue" type="email" placeholder="Enter email..." class="login__text"
                    @blur="validateEmail" />
                <p class="error" v-if="emailError && !emailValue">This field must have a value</p>
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
            <p class="login__forgot">Forgot Password?</p>
            <button class="login__button" @click="handleSignIn">Sign in</button>
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useAuthStore } from "../../../stores/authStore";

const authStore = useAuthStore();
const showPassword = ref(false);

let dataRegister = ref({
    email: "",
    password: ""
});

let emailValue = ref(dataRegister.value.email);
let passwordValue = ref(dataRegister.value.password);

const emailError = ref(false);
const passwordError = ref(false);
const emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

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
    passwordError.value = !passwordValue.value.trim();
};

const handleSignIn = (e) => {
    e.preventDefault();
    emailError.value = !emailValue.value.trim();
    passwordError.value = !passwordValue.value.trim();

    if (emailError.value || passwordError.value || !emailRegex.test(emailValue.value)) {
        return;
    }

    const email = emailValue.value;
    const password = passwordValue.value;
    const userData = {
        email: email,
        password: password
    };
    authStore.signin(userData);
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
    box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 1px, rgba(0, 0, 0, 0.07) 0px 2px 2px, rgba(0, 0, 0, 0.07) 0px 4px 4px, rgba(0, 0, 0, 0.07) 0px 8px 8px, rgba(0, 0, 0, 0.07) 0px 16px 16px;

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
        color: var(--black-color);
        transition: all 0.2 linear;
        border: 1px solid transparent;
    }

    .login__text:focus {
        background-color: var(--white-color);
        border: 1px solid var(--primary-color);
    }

    .login__text::-webkit-input-placeholder {
        color: #84878b;
    }

    .login__text::-moz-input-placeholder {
        color: #84878b;
    }

    .login__icon {
        position: absolute;
        top: 50px;
        right: 25px;
        cursor: pointer;
    }

    .login__term {
        display: flex;
        column-gap: 20px;
        align-items: center;

        .login__check {
            background-color: var(--green-color);
        }

        .login__ligacy {
            flex: 1 1 0%;
            color: #4B5264;
            font-size: 14px;
            margin-bottom: 10px;
            line-height: 0;
        }

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
        margin: 20px 0px;
        cursor: pointer;
        color: var(--green-color);

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
        background-image: linear-gradient(to right bottom, #2ebac1, #a4d96c);
        color: var(--white-color);
        cursor: pointer;

        &:hover {
            opacity: .9;
        }
    }

    .login__label {
        .login__checkbox {
            background-color: var(--green-color);

            &:checked {
                &+.login__checkmark {
                    background-color: var(--white-color);
                }
            }
        }

        .login__checkmark {
            background-color: transparent;

            &.checked {
                background-color: var(--white-color);
            }
        }
    }
}

.error {
    color: red;
    font-size: 12px;
}
</style>
