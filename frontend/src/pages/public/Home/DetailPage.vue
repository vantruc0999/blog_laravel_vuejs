<template>
    <div v-if="postStore.isLoading">
        <Loading />
    </div>
    <div class="detail__container">
        <div class="detail__wrapper">
            <div class="detail__left">
                <!-- :to="`/profile/${postStore.post?.data?.blogger_infor?.id}`" -->
                <router-link :to="`/profile/${postStore.post?.data?.blogger_infor?.id}`">
                    <span class="detail__name">
                        {{ postStore.post?.data?.blogger_infor.name }}
                    </span>
                    <p class="detail__desc" v-if="postStore.post?.data?.blogger_infor.bio">{{
                        postStore.post?.data?.blogger_infor.bio }} </p>
                    <p class="detail__desc" v-else>Một tác giả đến từ Monkey Blog với những bài đăng chia sẻ thú vị về kiến
                        thức
                    </p>
                </router-link>
                <div class="detail__interaction">
                    <span class="detail__viewer">
                        <ion-icon name="eye-outline"></ion-icon> <span class="detail__viewer--count">{{
                            postStore.post?.data?.view_count }} </span>
                    </span>
                    <span class="detail__viewer" @click="handleOpenComment">
                        <ion-icon name="chatbubbles-outline"></ion-icon>
                        <span class="detail__viewer--count">{{ postStore.post?.data?.comments.length }}</span>
                    </span>
                    <span class="detail__viewer detail__viewer--active" @click="handleLikePost(postStore.post?.data?.id)">
                        <ion-icon name="triangle-outline" :style="{ color: isLike ? 'red' : '' }"></ion-icon> <span
                            class="detail__viewer--count">{{
                                postStore.post?.data?.likes_count }} </span>
                    </span>
                </div>
            </div>
            <div class="detail__middle">
                <div class="detail__post">
                    <p class="detail__title">
                        {{ postStore.post?.data?.title }}
                    </p>
                    <div class="detail__user">
                        <router-link :to="`/profile/${postStore.post?.data?.blogger_infor?.id}`" class="detail__user__left">
                            <img :src="'http://127.0.0.1:8000/images/avatar/' + postStore.post?.data?.blogger_infor?.profile_image"
                                alt="" v-if="postStore.post?.data?.blogger_infor?.profile_image" class="detail__user__img">
                            <img src="../../../assets/images/avatar-default.png" alt="" v-else class="detail__user__img">
                            <div class="detail__user__infor">
                                <span class="detail__user__name">{{ postStore.post?.data?.blogger_infor.name }}</span>
                                <span class="detail__user__time">{{
                                    calculateTimeAgo(postStore.post?.data?.created_at) }}</span>
                            </div>
                        </router-link>
                        <div class="detail__user__right">
                            <span class="detail__user__icon">
                                <ion-icon name="bookmark-outline"></ion-icon>
                            </span>
                            <span class="detail__user__icon">
                                <ion-icon name="ellipsis-horizontal-outline"></ion-icon>
                            </span>
                        </div>
                    </div>
                    <p class="detail__text" v-html="postStore.post?.data?.description" target="_blank"></p>
                </div>
            </div>
            <div class="detail__right">
                <img :src="'http://127.0.0.1:8000/storage/' + postStore.post?.data?.banner" alt=""
                    v-if="postStore.post?.data?.banner" class="detail__right__image">
                <img src="../../../assets/images/books.jpg" v-else class="detail__right__image">
            </div>
        </div>
        <h1 class="detail__related__title">Bài viết liên quan</h1>
        <div class="detail__related">
            <span class="detail__controller">
                <ion-icon name="arrow-back-outline"></ion-icon>
            </span>
            <swiper :slides-per-view="4" :space-between="20" ref="swiper" class="detail__swiper">
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
            </swiper>
            <span class="detail__controller">
                <ion-icon name="arrow-forward-outline"></ion-icon>
            </span>
        </div>

        <!-- Special -->
        <h1 class="detail__related__title">Bài viết nổi bật</h1>

        <div class="detail__related">
            <span class="detail__controller">
                <ion-icon name="arrow-back-outline"></ion-icon>
            </span>
            <swiper :slides-per-view="4" :space-between="20" ref="swiper" class="detail__swiper">
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
            </swiper>
            <span class="detail__controller">
                <ion-icon name="arrow-forward-outline"></ion-icon>
            </span>
        </div>
    </div>
    <Comment :isOpenComment="isOpenComment" :handleOpenComment="handleOpenComment" :idPost="postId" />
</template>

<script setup>
import {
    ref,
    watchEffect,
    computed,
    onMounted
} from "vue";
import CardNew from "../../../components/CardNew.vue";
import Comment from "../../public/Home/Comment/Comment.vue"
import {
    useRoute
} from 'vue-router';
import {
    Swiper,
    SwiperSlide
} from "swiper/vue";
import "swiper/swiper-bundle.css";
import "swiper/css";
import Loading from "../../../components/Loading.vue"
import { usePostStore } from "../../../stores/postStore";

const postStore = usePostStore()
const route = useRoute();
const refDetail = ref(route.params.id)
const postId = ref(refDetail)
const isLike = ref(false)
let isOpenComment = ref(false);

const userData = ref(JSON.parse(localStorage.getItem("user")));

const handleLikePost = (id) => {
    postStore.likePost(id)
    isLike.value = !isLike.value
}
const handleOpenComment = () => {
    isOpenComment.value = !isOpenComment.value
}

const getDetailPost = computed(() => {
    return postStore.getPostById(refDetail.value)
})

onMounted(async () => {
    await getDetailPost.value;
});

watchEffect(() => {
    window.scrollTo(0, 0);
})
const calculateTimeAgo = (created_at) => {
    const currentTime = new Date();
    const commentTime = new Date(created_at);
    const timeDiff = currentTime - commentTime;

    // Chuyển đổi khoảng thời gian sang giây, phút, giờ, ngày
    const seconds = Math.floor(timeDiff / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);

    if (days > 0) {
        return `${days} ngày trước`;
    } else if (hours > 0) {
        return `${hours} giờ trước`;
    } else {
        return `${minutes} phút trước`;
    }
}
</script>

<style lang="scss" scoped>
.detail__container {

    padding: 120px 100px;
}

.detail__wrapper {
    display: flex;
    gap: 20px;

    .detail__left {
        width: 20%;
        padding-right: 10px;
        // position: fixed;

        .detail__name {
            font-size: 16px;
            font-weight: 500;
            color: var(--black-color);
        }

        .detail__desc {
            color: var(--smoke-color);
            font-size: 1.4rem;
            margin-top: 10px;
            line-height: 1.4;
        }

        .detail__interaction {
            display: flex;
            flex-direction: column;
            gap: 20px;
            border-top: 1px solid var(--border-color);
            padding-top: 20px;

            .detail__viewer {
                display: flex;
                align-items: center;
                color: var(--smoke-color);
                cursor: pointer;
                gap: 5px;

                .detail__viewer--count {
                    position: relative;
                    top: 3px;
                }

                ion-icon {
                    display: flex;
                    font-size: 1.6rem;
                }
            }
        }
    }

    .detail__middle {
        flex: 1;
        margin: 0px 20px;
        max-width: 60%;

        .detail__post {
            .detail__title {
                color: #222;
                font-size: 40px;
                font-weight: 700;
                line-height: 1.5;
            }

            .detail__user {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 40px;

                .detail__user__left {
                    display: flex;
                    align-items: center;
                    gap: 10px;

                    .detail__user__name {
                        color: #292929;
                        font-size: 1.6rem;
                        font-weight: 600;
                        margin: 0;
                    }

                    .detail__user__time {
                        color: var(--smoke-color);
                        font-size: 14px;
                    }

                    .detail__user__img {
                        width: 50px;
                        height: 50px;
                        border-radius: 50%;
                    }

                    .detail__user__infor {
                        display: flex;
                        flex-direction: column;
                        gap: 10px;
                    }
                }

                .detail__user__right {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    cursor: pointer;
                    font-size: 18px;
                    color: var(--smoke-color);

                }
            }
        }

        .detail__text {
            overflow: hidden;
            width: 100%;
            padding-bottom: 100px;
            border-bottom: 3px solid var(--primary-color);
        }
    }

    .detail__right {
        width: 30%;

        .detail__right__image {
            width: 100%;
            height: 200px;
            border-radius: 12px;
        }
    }
}

.detail__swiper {
    padding: 5px;
}

.detail__related__title {
    margin: 80px 0px 30px 0px;
    padding-top: 10px;
    font-size: 28px;
    color: var(--btn-color);
    font-weight: 600;
    position: relative;

    &::after {
        position: absolute;
        content: "";
        top: 0;
        background-color: var(--primary-color);
        left: 0;
        width: 35px;
        height: 3px;
    }
}
</style>
