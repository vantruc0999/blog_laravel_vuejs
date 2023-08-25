<template >
    <div class='wrapper' v-if="isOpen">
        <div class='header'>
            <div class='header-left'>
                <!-- {user.imageUrl ? (
            <img class='avatar-img avatar' src={user.imageUrl} alt={user.imageUrl} />
            ) : (
            <img class='avatar' src={images.avatarDefault} alt="Avatar" />
            )} -->
                <img class='avatar'
                    src="https://prtimes.jp/data/corp/52087/ogp/tmp-76356af6bbe6808780560cbb9a079658-4f2a31ac93df6dfcbea753878b5607c7.jpg"
                    alt="Avatar" />

            </div>
            <div class='header-right'>
                <div class='user-name'>Dong</div>
            </div>
        </div>
        <ul class='option'>
            <hr />
            <ul class='option-list'>
                <router-link class='option-item-link' to="/">
                    <span class="option-icon"><ion-icon name="person-circle-outline"></ion-icon></span>
                    <li class='option-item'>Trang cá nhân</li>
                </router-link>
            </ul>
            <ul class='option-list'>
                <router-link class='option-item-link' to="/">
                    <span class="option-icon"><ion-icon name="create-outline"></ion-icon></span>
                    <li class='option-item'>Bài viết của tôi</li>
                </router-link>
            </ul>
            <ul class='option-list'>
                <router-link class='option-item-link' to="/">
                    <span class="option-icon"><ion-icon name="bookmark-outline"></ion-icon></span>
                    <li class='option-item'>Đã lưu</li>
                </router-link>

            </ul>

            <ul class='option-list'>
                <router-link class='option-item-link' to="/setting/account">
                    <span class="option-icon"><ion-icon name="settings-outline"></ion-icon></span>
                    <li class='option-item'>Tùy chỉnh tài khoản</li>
                </router-link>
                <hr />

                <router-link class='option-item-link' to="/auth/signin">
                    <span class="option-icon"><ion-icon name="log-out-outline"></ion-icon></span>
                    <li class='option-item'>Đăng xuất</li>
                </router-link>
            </ul>
        </ul>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    isOpen: Boolean
});

</script>

<style lang="scss" scoped>
.wrapper {
    z-index: 9999;
    margin: 0;
    position: absolute;
    inset: 0 0 auto auto;
    min-width: 230px;
    margin: 0px;
    transform: translate3d(-121px, 80.8px, 0px);
    background: var(--white-color);
    border-radius: 10px;
    box-shadow: 0 -4px 32px rgb(0 0 0 / 20%);
    overflow: hidden;
    padding: 8px 24px !important;
    color: var(--gray-color);
    animation: toggleOptions 0.3s ease;
    transition: all 0.3s ease;
    will-change: opacity, transform;

    a {
        color: var(--gray-color) !important;
    }
}

.option-item-link {
    display: flex;
    font-size: 18px;
    align-items: center;
    gap: 5px;
    padding: 10px 2px;
    border-radius: 3px;

    &:hover {
        background-color: #f0ebeb !important;
    }

    .option-icon {
        color: var(--text-color-4);
        margin-top: 5px;
        font-size: 22px;
    }

    .option-item {
        padding: 6px 0;
        color: var(--text-color-4);
    }
}

.header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px;

    .header-left {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;

        .avatar {
            --size: 50px;
            border-radius: 50%;
            object-fit: cover;
            background-repeat: no-repeat;
            width: var(--size);
            height: var(--size);
        }
    }

    .header-right {
        flex: 1;

        .user-name {
            color: var(--text-color-1);
            font-size: 1.6rem;
            font-weight: 700;
        }

        .user-email {
            font-size: 1.4rem;
        }
    }
}


.option {
    .option-list {
        .option-item {
            padding: 6px 0;
        }
    }
}



@keyframes toggleOptions {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}
</style>
