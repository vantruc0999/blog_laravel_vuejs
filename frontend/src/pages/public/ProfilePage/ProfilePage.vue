<template>
    <div v-if="authStore.isLoading">
        <Loading />
    </div>
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
                                <input type="text" class="search__input" placeholder="Search post..."
                                    v-model="searchText" />
                                <span class="search__icon" @click="handleSearch">
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
                                <input type="text" class="header__user__input" placeholder="Search post..."
                                    v-model="searchText" />
                                <span class="header__user__icon" @click="handleSearch">
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
                                <img :src="'http://127.0.0.1:8000/images/avatar/' + authStore.user.blogger_info?.profile_image"
                                    alt="avatar" v-if="authStore.user.blogger_info?.profile_image">
                                <img src="../assets/images/avatar-default.png" alt="" v-else>
                            </div>
                            <OptionUser :isOpen="isOpen" />
                        </div>
                    </div>
                </div>

            </div>
            <div class="user__avatar">
                <img :src="'http://127.0.0.1:8000/images/avatar/' + authorStore?.author?.blogger_infor?.profile_image"
                    class="avatar__img" v-if="authorStore?.author?.blogger_infor?.profile_image" />
                <img src="../../../assets/images/avatar-default.png" class="avatar__img" alt="" v-else />
            </div>
        </div>
    </div>
    <div class="profile__content">
        <div class="profile__desc">
            <div class="profile__detail">
                <div class="user__infor">
                    <span class="user__name">{{ authorStore?.author?.blogger_infor?.name }}</span>
                    <span class="user__nickname">@{{ authorStore?.author?.blogger_infor?.slug }}</span>
                    <span class="user__follow" @click="handleOpenFollowed">{{
                        authorStore?.author?.blogger_infor?.number_of_followers }} <span
                            class="user__follow--text">followers</span></span>
                </div>
                <div class="profile__options" v-if="!checkMyProfile">
                    <button class="profile__btn" @click="handleGetFollow(authorStore?.author?.blogger_infor?.id)"
                        v-if="!isFollowed(userData?.id)"><ion-icon name="person-add-outline"></ion-icon> Theo
                        dõi</button>
                    <button class="profile__btn profile__btn--follow"
                        @click="handleGetFollow(authorStore?.author?.blogger_infor?.id)" v-else>Đang theo dõi
                        <ion-icon name="checkmark-circle-outline"></ion-icon></button>
                    <span class="profile__delete">
                        <ion-icon name="ellipsis-vertical-outline" @click="handleOpenBanned"></ion-icon>
                        <div class="profile__ban" v-if="isBanned" @click="handleOpenModalBan">
                            <ion-icon name="ban-outline"></ion-icon>
                            Chặn người dùng
                        </div>
                        <ModalController title="Bạn có chắc muốn chặn người dùng này?"
                            content="Nếu người dùng này gây ảnh hưởng tới bạn hãy chặn họ để tránh việc giảm trải nghiệm của bạn khi sử dụng MONKEY BLOG"
                            :closeModel="handleCloseModalBan" :isOpenModal="isOpenModal" :handleDelete="handleDeletePost" />
                    </span>
                </div>

                <div class="profile__interaction">
                    <div class="profile__followers" @click="handleOpenFollowing">
                        <div class="profile__interaction--amount">
                            {{ authorStore?.author?.blogger_infor?.number_of_following }}
                        </div>
                        <span class="profile__interaction--text">following</span>
                    </div>

                    <div class="profile__followers">
                        <div class="profile__interaction--amount">
                            {{ authorStore?.author?.blogger_infor?.total_view_count }}
                        </div>
                        <span class="profile__interaction--text">views</span>
                    </div>
                </div>
                <ModalFollowed :isOpenModalFollowed="isOpenModalFollowed" :handleClose="handleClose"
                    :checkMyProfile="checkMyProfile" />
                <ModalFollowing :isOpenModalFollowing="isOpenModalFollowing" :handleCloseFollowing="handleCloseFollowing"
                    :checkMyProfile="checkMyProfile" />
                <p class="profile__about">{{ authorStore?.author?.blogger_infor?.bio }}</p>
            </div>
            <div class="profile__action">
                <div class="profile__action__controller">
                    <ul class="profile__action__list">
                        <div class="profile__action__item" v-for="(tab, index) in tabs" :key="index"
                            @click="selectedTab = tab" :class="{ activeTab: selectedTab === tab }">
                            <span class="profile__action__icon" v-html="tab.icon">
                            </span>
                            <span class="profile__action__text">{{ tab.name }}</span>
                        </div>
                    </ul>
                </div>
                <div class="profile__card" v-if="selectedTab === tabs[0]">
                    <CardNew :isCard="false" :post="post"
                        v-for="( post, index ) in  authorStore?.author?.blogger_infor?.posts " :key="index"
                        :isProfile="true" :isMyProfile="checkMyProfile" :isSaved="isSaved" />
                </div>
                <div class="profile__draft" v-else>
                    <div class="profile__wrap">
                        <div class="profile__draft__content">
                            <p class="profile__draft__title">Tôi là ai ai là tôi</p>
                            <span class="profile__draft__time">Khoảng một phút trước</span>
                        </div>
                        <div class="profile__draft__editor">
                            <div class="profile__draft__action">
                                <ion-icon name="pencil-outline"></ion-icon>
                                <span class="profile__draft__controller">Tiếp tục</span>
                            </div>
                            <div class="profile__draft__action profile__draft__action--delete"
                                @click="handleOpenModalDraft">
                                <ion-icon name="trash-outline"></ion-icon>
                                <span class="profile__draft__controller">Xóa</span>
                            </div>
                        </div>
                    </div>

                    <ModalController title="Bạn có chắc muốn xóa bản nháp này?"
                        content="Bạn có chắc rằng muốn xóa bản nháp này? Hành động này sẽ không thể hoàn thành khi bạn chưa đồng ý"
                        :closeModel="handleCloseModalDraft" :isOpenModal="isOpenModalDraft" />
                </div>
            </div>
        </div>
    </div>
    <Footer />
</template>

<script setup>
import { onMounted, computed, ref, watchEffect, watch } from "vue"
import Footer from "../../../components/Footer.vue"
import DropDown from "../../../components/DropDown.vue"
import CardNew from "../../../components/CardNew.vue"
import OptionUser from "../../../components/OptionUser.vue"
import { useAuthStore } from "../../../stores/authStore"
import {
    useRoute,
    useRouter
} from 'vue-router';
import Loading from "../../../components/Loading.vue"
import { useAuthorStore } from "../../../stores/authorStore"
import ModalFollowed from "../../../components/ModalFollowed.vue"
import ModalFollowing from "../../../components/ModalFollowing.vue"
import ModalController from "../../../components/ModalController.vue"
import { usePostStore } from "../../../stores/postStore"

const authorStore = useAuthorStore()
const authStore = useAuthStore()
const postStore = usePostStore()
const isAuth = ref(localStorage.getItem("isLogin"));
const userData = ref(JSON.parse(localStorage.getItem("user")));
const checkMyProfile = ref(false)
const route = useRoute();
const router = useRouter()
const refAuthor = ref(route.params.id)
const isOpen = ref(false);
const isOpenModalFollowed = ref(false)
const isOpenModalFollowing = ref(false)
const isBanned = ref(false)
const isOpenModal = ref(false)
const isOpenModalDraft = ref(false)
const tabs = ref([
    { name: 'Bài viết', icon: '<ion-icon name="create-outline"></ion-icon>' },
    { name: 'Lưu nháp', icon: '<ion-icon name="layers-outline"></ion-icon>' }
]);
const selectedTab = ref(tabs.value[0]);
let searchText = ref("")

// search
const handleSearch = async () => {
    const searchValue = searchText.value.trim();
    if (searchValue) {
        await postStore.searchPost(searchValue, "");
        router.push({ path: '/filter/filter-post', query: { search: searchValue } });
    } else {
        router.push({ path: '/filter/filter-post' });
    }
};

// check follow
const getUserFollow = computed(() => {
    return authorStore.author?.blogger_infor?.follows.map((user) => user?.follower_id)
})

const isFollowed = (id) => {
    console.log("🚀 ~ file: ProfilePage.vue:205 ~ isFollowed ~ id:", id)
    if (getUserFollow.value?.length > 0) {
        return getUserFollow.value.includes(id)
    } else {
        return false
    }
};
// const fakeVariable = () => {
//     return false
// }
// saved
const getIdOfFavorites = computed(() => {
    return postStore?.favorites.map((favorites) => favorites?.id)
})

const isSaved = (id) => {
    if (getIdOfFavorites.value.length > 0) {
        return getIdOfFavorites.value.includes(id)
    } else {
        return false
    }
};
// open options
const handleOpenOptions = () => {
    isOpen.value = !isOpen.value;
};

const handleOpenBanned = () => {
    isBanned.value = !isBanned.value;
}
const handleOpenModalBan = () => {
    isOpenModal.value = !isOpenModal.value;
}
const handleCloseModalBan = () => {
    isOpenModal.value = false
}

const handleOpenModalDraft = () => {
    isOpenModalDraft.value = !isOpenModalDraft.value;
}
const handleCloseModalDraft = () => {
    isOpenModalDraft.value = false
}
const handleGetFollow = (id) => {
    authorStore.getFollowAuthor(refAuthor.value, id);
    authorStore.getAuthorFollowed(id)
}

const handleCheckMyProfile = (id) => {
    if (id?.toString() === refAuthor?.value?.toString()) {
        checkMyProfile.value = true
    } else {
        checkMyProfile.value = false
    }
}
const handleOpenFollowed = () => {
    isOpenModalFollowed.value = !isOpenModalFollowed.value
}
const handleClose = () => {
    isOpenModalFollowed.value = false
}
const handleOpenFollowing = () => {
    isOpenModalFollowing.value = !isOpenModalFollowing.value
}
const handleCloseFollowing = () => {
    isOpenModalFollowing.value = false
}

const getProfileAuthor = computed(() => {
    return authorStore.getAuthorById(refAuthor.value)
})
watch(() => route.params, (newId) => {
    authorStore.getAuthorById(newId.id)
})
handleCheckMyProfile(userData?.value?.id)
onMounted(async () => {
    await authStore.getMyProfile()
    await getProfileAuthor.value;
    await authorStore.getAuthorFollowed(refAuthor.value)
    await handleCheckMyProfile(userData.value.id)
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
                    padding-right: 25px;
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
                            width: 40px;
                            height: 40px;
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

            .user__nickname {
                font-size: 16px;
                color: var(--text-color-4);
                font-weight: 600;
                margin-bottom: 5px;
            }

            .user__follow {
                font-size: 16px;
                font-weight: 600;
            }

            .user__follow--text {
                font-weight: 400;
                color: var(--text-color-4);
            }
        }
    }

    .profile__options {
        display: flex;
        align-items: center;
        justify-content: space-between;

        .profile__btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            border-radius: 10px;
            gap: 5px;
            width: 150px;
            cursor: pointer;
            background-image: linear-gradient(to right bottom, #2ebac1, #a4d96c);
            color: var(--white-color);
            font-size: 15px;

        }

        .profile__btn--follow {
            border: 1px solid var(--border-color);
            color: var(--green-color);
            font-weight: 700;
            background-image: var(--white-color) !important;
        }

        .profile__delete {
            cursor: pointer;
            position: relative;

            .profile__ban {
                position: absolute;
                right: 5px;
                top: 30px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 5px;
                border-radius: 10px;
                width: 170px;
                height: 50px;
                background-color: var(--white-color);
                box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;

                &:hover {
                    background-color: var(--border-color);
                    color: var(--white-color);
                }
            }
        }
    }

    .profile__interaction {
        margin-top: 30px;
        display: flex;
        gap: 40px;
        font-size: 16px;
        font-family: "Noto Sans", sans-serif;

        .profile__followers {
            color: var(--black-color);
            font-weight: 700;
            display: flex;
            align-items: center;
            flex-direction: column;
            justify-content: center;
            width: 100%;

            .profile__interaction--amount {
                display: flex;
                justify-content: center;
            }

            .profile__interaction--text {
                font-weight: 400;
                color: var(--text-color-4);
                font-size: 18px;
            }
        }
    }



    .profile__about {
        line-height: 1.3;
        font-weight: 400;
        font-size: 16px;
        margin-top: 30px;
        border-top: 2px solid var(--border-color);
        padding-top: 20px;
    }

    .profile__action {
        flex: 1;
        background-color: var(--white-color);
        padding: 0 20px;

        .profile__draft {
            padding: 20px;
            border: 1px solid var(--border-color);
            box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;

            .profile__wrap {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: 1px solid var(--border-color);
                padding-bottom: 20px;
                margin-top: 20px;

                &:last-child {
                    border-bottom: none;
                }

                .profile__draft__content {
                    display: flex;
                    flex-direction: column;
                }

                .profile__draft__title {
                    font-weight: 600;
                    font-size: 16px;
                }

                .profile__draft__time {
                    font-weight: 300;
                    color: var(--text-color-4);
                    font-size: 14px;
                }

                .profile__draft__editor {
                    display: flex;
                    gap: 20px;
                    align-items: center;
                }

                .profile__draft__action {
                    display: flex;
                    gap: 10px;
                    font: size 14px;
                    cursor: pointer;

                    &--delete {
                        color: red;
                    }
                }
            }
        }
    }

    .profile__action__time {
        cursor: pointer;
        margin: 0px 0px 30px 0;
        width: 100%;
        max-width: 200px;
    }

    .profile__card {
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

        .activeTab {
            border-bottom: 2px solid var(--primary-color);
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
