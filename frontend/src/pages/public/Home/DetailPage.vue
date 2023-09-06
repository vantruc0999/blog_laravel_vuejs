<template>
    <div v-if="postStore.isLoading">
        <Loading />
    </div>
    <div class="detail__container">
        <div class="detail__heading">
            <img :src="'http://127.0.0.1:8000/storage/' + postStore.post?.data?.banner" alt="">
            <div class="detail__infor">
                <div class="detail__category">
                    <span>{{ postStore.post?.data?.category_name }}</span>
                </div>
                <p class="detail__title">
                    {{ postStore.post?.data?.title }}
                </p>
                <div class="detail__view">
                    <!-- <div class="detail__view--public">
                        <div class="detail__user">
                            <img :src="'http://127.0.0.1:8000/images/avatar/' + postStore.post?.data?.blogger_infor?.profile_image"
                                alt="" v-if="postStore.post?.data?.blogger_infor?.profile_image">
                            <img src="../../../assets/images/avatar-default.png" alt="" v-else>
                            <div class="detail__user__infor">
                                <span class="detail__user__name">{{ postStore.post?.data?.blogger_infor.name }}</span>
                            </div>
                        </div>
                        <span class="detail__time">28/10</span>
                    </div> -->
                    <div class="detail_view--interact">
                        <span class="detail__viewer">
                            <ion-icon name="eye-outline"></ion-icon> {{ postStore.post?.data?.view_count }} lượt xem
                        </span>
                        <span class="detail__viewer" @click="handleOpenComment">
                            <ion-icon name="chatbubbles-outline"></ion-icon>{{ postStore.post?.data?.comments.length }}
                        </span>
                        <span class="detail__viewer">
                            <ion-icon name="triangle-outline"></ion-icon> 3000 lượt thích
                        </span>
                    </div>
                </div>

            </div>
        </div>
        <div class="detail__content">
            <div class="detail__wrapper">
                <p class="detail__text image-container" v-html="postStore.post?.data?.description" target="_blank"></p>
            </div>
        </div>
        <!-- Author -->
        <router-link :to="`/profile/${postStore.post?.data?.blogger_infor?.id}`" class="detail__author">
            <img :src="'http://127.0.0.1:8000/images/avatar/' + postStore.post?.data?.blogger_infor?.profile_image" alt=""
                v-if="postStore.post?.data?.blogger_infor?.profile_image">
            <img src="../../../assets/images/avatar-default.png" alt="" v-else>
            <div class="detail__infor">
                <h2 class="detail__name">{{ postStore.post?.data?.blogger_infor.name }}</h2>
                <p class="detail__desc" v-if="postStore.post?.data?.blogger_infor.bio">{{
                    postStore.post?.data?.blogger_infor.bio }} </p>
                <p class="detail__desc" v-else>Một tác giả đến từ Monkey Blog với những bài đăng chia sẻ thú vị về kiến thức
                </p>
            </div>
        </router-link>

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

let isOpenComment = ref(false);

const userData = ref(JSON.parse(localStorage.getItem("user")));

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
</script>

<style lang="scss" scoped>
.detail__container {
    padding: 120px 130px;
}

.detail__heading {
    display: flex;
    align-items: center;
    position: relative;

    img {
        max-width: 600px;
        width: 100%;
        height: 465px;
        border-radius: 12px;
        margin-right: 70px;
    }

}

.detail__author {
    margin: 0 auto;
    width: 100%;
    border: 1px solid var(--border-color);
    max-width: 780px;
    display: flex;
    border-radius: 12px;

    img {
        width: 100%;
        height: auto;
        max-height: 180px;
        max-width: 240px;
        border-radius: 12px;
    }

    .detail__infor {
        padding: 20px;
    }

    .detail__name {
        font-size: 22px;
        color: var(--secondary-color);
        font-weight: 600;
        text-transform: uppercase;
    }

    .detail__desc {
        margin-top: 10px;
        color: var(--black-color);
        font-size: 18px;
    }

}

.detail__category {
    width: 150px;
    max-width: 100%;
    padding: 10px;
    border: 1px solid var(--border-color);
    border-radius: 10px;
    display: flex;
    justify-content: center;
}

.detail__title {
    font-size: 32px;
    color: var(--btn-color);
    font-weight: 700;
    margin-top: 20px;
    line-height: 1.3;
    margin-bottom: 20px;
}

.detail__view {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    color: var(--text-color-4);
    font-weight: 700;
}

.detail__view--public {
    display: flex;
    align-items: center;
}

.detail__user {
    display: flex;
    align-items: center;
    margin-right: 20px;

    img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border: 1px solid var(--border-color);
        border-radius: 50%;
        margin-right: 10px;
    }
}

.detail_view--interact {
    display: flex;
    flex-direction: column;
    gap: 20px;
    font-size: 14px;

    .detail__viewer {
        cursor: pointer;
        display: flex;
        align-items: center;
        font-size: 15px;

        ion-icon {
            font-size: 20px;
        }
    }
}

.detail__content {
    padding: 20px 250px;
    background-color: var(--white-color);
    margin: 70px 0px;
}

.detail__wrapper {
    margin: 0 auto;
    background-color: var(--white-color);
    overflow: hidden;

    .detail__text {
        font-family: "Noto Serif", Regular, Times New Roman;
        white-space: pre-wrap;
        word-break: break-word;
        line-height: 1.4;


    }
}

.image-container {
    max-width: 700px;
    margin: 0 auto;
}

.detail__related {
    display: flex;
    margin-top: 30px;
    gap: 10px;
    align-items: center;
}

.detail__controller {
    cursor: pointer;
    padding: 7px;
    border-radius: 50%;
    border: 1px solid var(--border-color);
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
