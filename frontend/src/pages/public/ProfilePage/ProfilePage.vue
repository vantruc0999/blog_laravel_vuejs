<template>
    <div class="profile__container">
        <div class="profile__heading">
            <div class="profile_wrapper">
                <img v-if="authStore?.user?.blogger_infor?.banner"
                    :src="'http://127.0.0.1:8000/images/banner/' + authStore?.user?.blogger_infor?.banner"
                    class="background" />
                <img src="../../../assets/images/books.jpg" v-else class="background" />

                <div class="profile__top">
                    <router-link to="/">
                        <img src="../../../assets/images/logo-monkey-white.png">
                    </router-link>
                    <div class="profile__right">
                        <div class="header__right" v-if="!isAuth">
                            <div class="header__search">
                                <input type="text" class="search__input" placeholder="Search post..." />
                                <span class="search__icon">
                                    <ion-icon name="search-outline"></ion-icon>
                                </span>
                            </div>
                            <router-link to="/auth/signup" class="header__btn--signup">
                                Đăng ký
                            </router-link>
                            <router-link to="/auth/signin" class="header__btn">
                                Đăng nhập
                            </router-link>
                        </div>
                        <div class="header__user" v-else>
                            <div class="header__user__search" v-if="$route.path !== '/blog-post'">
                                <input type="text" class="header__user__input" placeholder="Search post..." />
                                <span class="header__user__icon">
                                    <ion-icon name="search-outline"></ion-icon>
                                </span>
                            </div>
                            <span class="header__user__notifi"><ion-icon name="notifications-outline"></ion-icon></span>
                            <router-link to="/blog-post" v-if="$route.path !== '/blog-post'">
                                <button class="header__user__write__btn">
                                    <img src="../../../assets/images/pen.png" class="header__user__write__pen">
                                    Viết bài
                                </button>
                            </router-link>
                            <div class="header__user__avatar" @click="handleOpenOptions">
                                <img :src="'http://127.0.0.1:8000/images/avatar/' + userData.value?.profile_image" alt=""
                                    v-if="userData.value?.profile_image">
                                <img src="../../../assets/images/avatar-default.png" alt="" v-else>
                            </div>
                            <OptionUser :isOpen="isOpen" />
                        </div>
                    </div>
                </div>

            </div>
            <div class="user__avatar">
                <img :src="'http://127.0.0.1:8000/images/avatar/' + authStore?.user?.blogger_infor?.profile_image"
                    class="avatar__img" v-if="authStore?.user?.blogger_infor?.profile_image" />
                <img src="../../../assets/images/avatar-default.png" class="avatar__img" alt="" v-else />
            </div>
        </div>
    </div>
    <div class="profile__content">
        <div class="profile__desc">
            <div class="profile__detail">
                <div class="user__infor">
                    <span class="user__name">{{ authStore?.user?.blogger_infor?.name }}</span>
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
                        1200
                        <span class="profile__interaction--text">views</span>
                    </div>
                </div>
                <p class="profile__about">{{ authStore?.user?.blogger_infor?.bio }}</p>
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
                    <CardNew :post="post" v-for="(  post, index  ) in   authStore?.user?.blogger_infor?.posts  " />
                </div>
            </div>

        </div>
    </div>
    <Footer />
</template>

<script setup>
import { onMounted, computed, ref, watchEffect } from "vue"
import Footer from "../../../components/Footer.vue"
import DropDown from "../../../components/DropDown.vue"
import CardNew from "../../../components/CardNew.vue"
import OptionUser from "../../../components/OptionUser.vue"
import { useAuthStore } from "../../../stores/authStore"
import {
    useRoute,
    useRouter
} from 'vue-router';

const authStore = useAuthStore()
const isAuth = ref(localStorage.getItem("isLogin"));
const userData = ref(JSON.parse(localStorage.getItem("user")));
console.log("🚀 ~ file: ProfilePage.vue:135 ~ userData:", userData.value.profile_image)
console.log('http://127.0.0.1:8000/images/avatar/' + authStore?.user?.blogger_infor?.profile_image);
const route = useRoute();
const refAuthor = ref(route.params.id)
let isOpen = ref(false);

const handleOpenOptions = () => {
    isOpen.value = !isOpen.value;
};
const filterData = [{
    title: "Theo ngày gần nhất",
    link: "#"
},
{
    title: "Theo ngày xa nhất",
    link: "#"
},
]

const getProfileAuthor = computed(() => {
    return authStore.getAuthorById(refAuthor.value)
})
onMounted(async () => {
    await getProfileAuthor.value;
});

watchEffect(() => {
    window.scrollTo(0, 0);

})
</script>

<style lang="scss" scoped>
.profile__container {
    background-color: #F5F7FA;
    --size: 168px;
    position: relative;
    display: flex !important;

    .profile_wrapper {
        position: relative;

        .profile__top {
            position: absolute;
            top: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 140px;
            width: 100%;

            img {
                width: 150px;
            }

            .profile__right {
                .header__right {
                    display: flex;
                    flex: 1;
                }

                .header__search {
                    margin-left: auto;
                    padding: 13px;
                    border: 1px solid var(--border-color);
                    border-radius: 8px;
                    width: 100%;
                    max-width: 320px;
                    position: relative;
                    background-color: var(--white-color);
                }

                .search__input {
                    width: 100%;
                    padding-right: 35px;
                }

                .search__icon {
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    right: 25px;
                    cursor: pointer;
                }

                .header__btn {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 100%;
                    max-width: 160px;
                    height: 45px;
                    color: var(--white-color);
                    font-weight: 700;
                    font-size: 18px;
                    cursor: pointer;
                    background-color: var(--btn-color);
                    border-radius: 10px;
                    margin-left: 10px;
                }

                .header__btn--signup {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 100%;
                    max-width: 160px;
                    height: 45px;
                    color: var(--black-color);
                    font-weight: 700;
                    font-size: 18px;
                    cursor: pointer;
                    background-color: var(--white-color);
                    border-radius: 10px;
                    margin-left: 10px;
                    border: 1px solid var(--border-color);
                }

                .header__user {
                    display: flex;
                    align-items: center;
                    gap: 10px;

                    .header__user__search {
                        margin-left: auto;
                        padding: 13px;
                        border: 1px solid var(--border-color);
                        border-radius: 8px;
                        width: 100%;
                        max-width: 320px;
                        position: relative;
                        background-color: var(--white-color);

                        .header__user__input {
                            width: 100%;
                            padding-right: 35px;
                        }

                        .header__user__icon {
                            position: absolute;
                            top: 50%;
                            transform: translateY(-50%);
                            right: 25px;
                            cursor: pointer;
                        }

                    }


                    .header__user__notifi {
                        display: inline-block;
                        font-size: 23px;
                        margin-top: 10px;
                        cursor: pointer;
                        color: var(--white-color);
                    }

                    .header__user__write__btn {
                        border-radius: 16px;
                        background-color: var(--white-color);
                        border: 1px solid var(--border-color);
                        width: 120px;
                        padding: 10px;
                        display: flex;
                        align-items: center;
                        justify-content: center;

                        img {
                            width: 20px;
                        }
                    }

                    .header__user__avatar {
                        img {
                            width: 50px;
                            border-radius: 50%;
                            cursor: pointer;
                        }
                    }
                }
            }
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
    padding: 0px 140px;
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
        margin: 0px 0px 30px 0;
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
