<template>
<div class="profile__container">
    <div class="profile__heading">
        <img src="https://images.unsplash.com/photo-1692685934729-ade81906226e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" alt="" class="background">
        <div class="user__avatar">
            <img src="https://plus.unsplash.com/premium_photo-1692243074477-80a0e0496517?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=387&q=80" class="avatar__img" alt="" />
            <div class="user__infor">
                <span class="user__name">Pham Van Dong</span>
                <span class="user__follow">3355 <span class="user__follow--text">followers</span></span>
                <span class="user__social">
                    <ion-icon name="logo-facebook"></ion-icon>
                </span>
            </div>
        </div>
        <div class="profile__authen">
            <button class="profile__authen__sub">Đăng ký</button>
            <button class="profile__authen__btn">Đăng nhập</button>
        </div>
    </div>
</div>
<div class="profile__content">
    <div class="profile__desc">
        <div class="profile__detail">
            <div class="profile__options">
                <button class="profile__btn">Theo dõi</button>
                <span class="profile__delete">
                    <ion-icon name="ellipsis-vertical-outline"></ion-icon>
                </span>
            </div>
            <p class="profile__about">Góc nhỏ chia sẻ cảm nhận về sách. Bạn có thể gặp mình nhiều hơn ở blog: vietcungtieuhy.com. Mong câu chữ của mình sẽ giúp bạn hiểu thêm về sách</p>
        </div>
        <div class="profile__action">
            <div class="profile__action__controller">
                <ul class="profile__action__list">
                    <router-link to="/profile" class="profile__action__item">
                        <span class="profile__action__icon">
                            <ion-icon name="create-outline"></ion-icon>
                        </span>
                        <span class="profile__action__text">Bài viết(47)</span>
                    </router-link>
                    <router-link to="/" class="profile__action__item">
                        <span class="profile__action__icon">
                            <ion-icon name="layers-outline"></ion-icon>
                        </span>
                        <span class="profile__action__text">Series</span>
                    </router-link>
                </ul>
            </div>
            <div class="profile__action__time">
                <DropDown title="Theo thời gian" :items="filterData" />
            </div>
            <!-- Card -->
            <div class="profile__card">
                <CardNew />
                <CardNew />
                <CardNew />
                <CardNew />
                <CardNew />
                <CardNew />
            </div>
        </div>

    </div>
</div>
</template>

<script setup>
import DropDown from "../../../components/DropDown.vue"
import CardNew from "../../../components/CardNew.vue"

const filterData = [{
        title: "Theo ngày gần nhất",
        link: "#"
    },
    {
        title: "Theo ngày xa nhất",
        link: "#"
    },
]
</script>

<style lang="scss" scoped>
.profile__container {
    .profile__heading {
        position: relative;
    }

    .profile__authen {
        position: absolute;
        display: flex;
        gap: 10px;
        top: 30px;
        right: 180px;
        .profile__authen__sub {
            width: 140px;
        }
        .profile__authen__btn {
            padding: 15px;
            width: 150px;
            background-image: linear-gradient(to right bottom, #2ebac1, #a4d96c);
            color: var(--white-color);
            border-radius: 12px;
        }
    }

    background-color: #F5F7FA;
    --size: 168px;
    margin-bottom: 140px;
    position: relative;
    display: flex !important;

    .background {
        width: 100vw;
        height: 120px;
        object-fit: cover;
        background-repeat: no-repeat;
    }

    .user__avatar {
        display: flex;
        align-items: center;
        position: absolute;
        gap: 10px;
        bottom: calc(var(--size) / 2 * -1.5);
        left: 175px;

        .avatar__img {
            object-fit: cover;
            background-repeat: no-repeat;
            border: 4px solid var(--white-color);
            border-radius: 50%;
            width: var(--size);
            height: var(--size);
            margin-right: 20px;
        }
    }

    .user__infor {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 30px;

        .user__name {
            font-size: 36px;
            font-weight: 600;
        }

        .user__follow {
            font-size: 16px;
            color: var(--text-color-4);
            font-weight: 600;
        }

        .user__follow--text {
            font-weight: 400;
        }

        .user__social {
            display: inline-block;
            padding: 5px;
            border-radius: 50%;
            border: 1px solid var(--border-color);
            height: 40px;
            width: 40px;
            font-size: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    }
}

.profile__content {
    border-top: 1px solid var(--border-color);
    padding: 0px 180px;
    background-color: #F5F7FA;

    .profile__desc {
        display: flex;
    }

    .profile__detail {
        width: 25%;
        height: 100vh;
        padding: 20px;
        margin-right: 20px;
    }

    .profile__options {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .profile__btn {
        padding: 10px;
        border-radius: 10px;
        width: 150px;
        cursor: pointer;
        background-image: linear-gradient(to right bottom, #2ebac1, #a4d96c);
        color: var(--white-color);
        font-size: 15px;
    }

    .profile__about {
        line-height: 1.3;
        font-weight: 500;
        font-size: 16px;
        margin-top: 30px;
    }

    .profile__action {
        flex: 1;
        background-color: var(--white-color);
        padding: 0 20px;
    }

    .profile__action__time {
        width: 140px;
    }

    .profile__card {
        margin-top: 30px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
    }

    .profile__action__controller {
        padding: 20px 0;

        .profile__action__list {
            display: flex;
            align-items: center;
            gap: 30px;
            border-bottom: 1px solid var(--border-color);

        }

        .profile__action__item {
            display: flex;
            align-items: center;
            gap: 5px;
            padding-bottom: 12px;

        }

        .profile__action__icon {
            display: inline-block;
            font-weight: 400;
        }

        .profile__action__text {
            font-size: 18px;
            color: var(--black-color);
            font-weight: 700;
        }
    }
}

.router-link-exact-active {
    border-bottom: 2px solid var(--primary-color);
}
</style>
