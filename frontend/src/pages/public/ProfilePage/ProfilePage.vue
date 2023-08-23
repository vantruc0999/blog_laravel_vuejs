<template>
<div class="profile__container">
    <div class="profile__heading">
        <img src="https://images.unsplash.com/photo-1692685934729-ade81906226e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" alt="" class="background">
        <div class="user__avatar">
            <img src="https://plus.unsplash.com/premium_photo-1692243074477-80a0e0496517?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=387&q=80" class="avatar__img" alt="" />
        </div>
        <router-link to="/" class="profile__logo">
            <img src="../../../assets/images/logo-small.png" class="profile__logo__img" />
            <span class="profile__logo__title">Money Blog</span>
        </router-link>
        <div class="profile__authen">
            <button class="profile__authen__sub">Đăng ký</button>
            <button class="profile__authen__btn">Đăng nhập</button>
        </div>
    </div>
</div>
<div class="profile__content">
    <div class="profile__desc">
        <div class="profile__detail">
            <div class="user__infor">
                <span class="user__name">Pham Van Dong</span>
                <span class="user__follow">3355 <span class="user__follow--text">followers</span></span>
                <span class="user__social">
                    <ion-icon name="logo-facebook"></ion-icon>
                </span>
            </div>
            <div class="profile__options">
                <button class="profile__btn">Theo dõi</button>
                <span class="profile__delete">
                    <ion-icon name="ellipsis-vertical-outline"></ion-icon>
                </span>
            </div>
            <div class="profile__interaction">
                <div class="profile__followers">
                    16
                    <span class="profile__interaction--text">followers</span>
                </div>
                <div class="profile__followers">
                    32
                    <span class="profile__interaction--text">following</span>
                </div>
                <div class="profile__followers">
                    1200
                    <span class="profile__interaction--text">views</span>
                </div>
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
                        <span class="profile__action__text">Bài viết (47)</span>
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
<Footer/>
</template>

<script setup>
import Footer from "../../../components/Footer.vue"
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
    background-color: #F5F7FA;
    --size: 168px;
    position: relative;
    display: flex !important;
    .profile__heading {
        position: relative;
    }
    .profile__logo {
        cursor: pointer;
        position: absolute;
        display: flex;
        gap: 10px;
        align-items: center;
        top: 10px;
        left: 200px;
        .profile__logo__title {
            color: var(--secondary-color);
           font-family: 'Quicksand', sans-serif;
            font-size: 18px;
        }
    }
    .profile__authen {
        position: absolute;
        display: flex;
        gap: 10px;
        top: 30px;
        right: 180px;
        .profile__authen__sub {
            width: 150px;
            font-size: 16px;
            cursor: pointer;
            font-weight: 600;
            // color: var(--white-color);
            border-color: 1px solid var(--border-color);
            background-color: rgb(241, 234, 234);
            border-radius: 12px;
            opacity: .7;
        }
        .profile__authen__btn {
            padding: 15px;
            font-size: 16px;
            width: 150px;
            background-image: linear-gradient(to right bottom, #2ebac1, #a4d96c);
            color: var(--white-color);
            border-radius: 12px;
        }
    }

   

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

   
}

.profile__content {
    padding: 0px 180px;
    background-color: #F5F7FA;
    .profile__desc {
        display: flex;
    }

    .profile__detail {
        margin-top: 140px;
        width: 25%;
        height: 100vh;
        padding: 20px;
        margin-right: 20px;
         .user__infor {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;

        .user__name {
            font-size: 32px;
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

    .profile__options {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .profile__interaction {
        margin-top: 30px;
        display: flex;
        gap: 40px;
        .profile__followers {
            color: var(--black-color);
            font-weight: 700;
            .profile__interaction--text {
                font-weight: 400;
                font-size: 13px;
            }
        }
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
        font-weight: 400;
        font-size: 16px;
        margin-top: 30px;
        
    }

    .profile__action {
        flex: 1;
        background-color: var(--white-color);
        padding: 0 20px;
    }

    .profile__action__time {
        cursor: pointer;
        margin:0px 0px 30px 0;
        width: 100%;
        max-width: 200px;
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
