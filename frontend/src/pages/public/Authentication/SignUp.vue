<template>
    <div className="login__header">
        <h1 className="login__title">
            SignIn
        </h1>
        <p className="login__account">
            Already have an account?
            <router-link to="/auth/signin" class="login__switch">
                Sign in
            </router-link>
            <!-- <route-l to="/sign-in" className="font-medium underline text-primary">
            </route-l> -->
        </p>
        <button className="login__btn">
            <img src="../../../assets/images/google.png" alt="google" />
            <span>Sign up with google</span>
        </button>
        <p className="login__option">
            Or sign up with email
        </p>

        <form class="login__form">
            <div class="login__input">
                <label for="email">Full Name *</label>
                <input type="email" placeholder="Enter email..." class="login__text">
            </div>
            <div class="login__input">
                <label for="email">Email *</label>
                <input type="email" placeholder="Enter email..." class="login__text">
            </div>
            <div class="login__input">
                <label for="password">Password *</label>
                <input :type="showPassword ? 'text' : 'password'" placeholder="Enter password..." class="login__text">
                <span class="login__icon" @click="togglePasswordVisibility">
                    <ion-icon :name="showPassword ? 'eye-outline' : 'eye-off-outline'"></ion-icon>
                </span>
            </div>
            <p class="login__forgot">Forgot Password?</p>
            <button class="login__button">
                Create my account
            </button>
        </form>
    </div>
</template>

<script setup>
import {
    ref
} from "vue"

const showPassword = ref(false)

const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
}
</script>

<style lang="scss" scoped>
.login__header {
    margin: 0 auto;
    max-width: 556px;
    background-color: var(--white-color);
    border-radius: 12px;
    padding: 32px 60px;
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

// mb-4 text-xs font-normal text-center lg:text-sm lg:mb-8 text-text2
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
        color: #B2B3BD;
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
        background-image: linear-gradient(to right bottom, #2ebac1, #a4d96c);
        color: var(--white-color);
        cursor: pointer;

        &:hover {
            opacity: .9;
        }
    }
}
</style>
