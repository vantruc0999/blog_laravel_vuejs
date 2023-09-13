<template>
    <div v-if="postStore.isLoading">
        <Loading />
    </div>
    <div class="home__container">
        <div class="home__banner">
            <div class="home__content">
                <h1 class="home__heading">Monkey Blogging</h1>
                <p class="home__desc">Monkey Blog là một nền tảng thú vị, nơi bạn có thể khám phá những bài viết
                    hấp dẫn về nhiều chủ đề khác nhau. Từ du lịch, ẩm thực, công nghệ đến nghệ thuật và cuộc sống hàng ngày,
                    chúng tôi cung cấp cho bạn một nền tảng để tìm hiểu, chia sẻ và trao đổi thông tin. Với những bài viết
                    độc đáo và nội dung sáng tạo. </p>
                <button class="home__button">Tìm hiểu</button>

            </div>
            <div class="home__image">
                <img src="../../../assets/images/banner.png" />
            </div>

        </div>

        <div class="home__body">
            <div class="home__card">
                <h2 class="home__card--title">Tính năng</h2>
                <div class="card__render">
                    <swiper :modules="modules" :loop="true" :slides-per-view="3" :space-between="50" navigation
                        :pagination="{ clickable: true }" @swiper="onSwiper" @slideChange="onSlideChange">
                        <swiper-slide>
                            <CardFeature />
                        </swiper-slide>
                        <swiper-slide>
                            <CardFeature />
                        </swiper-slide>
                        <swiper-slide>
                            <CardFeature />
                        </swiper-slide>
                        <swiper-slide>
                            <CardFeature />
                        </swiper-slide>
                        <swiper-slide>
                            <CardFeature />
                        </swiper-slide>
                    </swiper>

                </div>
            </div>
            <div class="home__ads">
                <swiper :modules="modules" :slides-per-view="3" :space-between="50" navigation
                    :pagination="{ clickable: true }" :autoplay="{ delay: 1000 }" :scrollbar="{ draggable: true }"
                    @swiper="onSwiper" @slideChange="onSlideChange">
                    <swiper-slide>
                        <img src="../../../assets/images/ads1.png" class="home__ads__image" />
                    </swiper-slide>
                    <swiper-slide>
                        <img src="../../../assets/images/ads2.png" class="home__ads__image" />
                    </swiper-slide>
                </swiper>
            </div>
            <div class="home__update">
                <h2 class="home__card--title">Được xem nhiều nhất</h2>
                <div class="update__list">
                    <!--  -->
                    <CardNew :isCard="false" :isSaved="isSaved" :post="post"
                        v-for="(post, index) in sortedPostByView.slice(0, 4) " :key="index" />
                </div>
                <!-- ---------- -->
                <div class="home__special">
                    <h2 class="home__card--title">Được yêu thích</h2>
                    <div class="home__blog">
                        <CardNew :isCard="false" :post="post" :isSaved="isSaved"
                            v-for="(post, index) in sortedPostByLikes.slice(0, 4) " :key="index" />
                    </div>
                </div>
                <!-- ---------- -->

                <div class="home__special">
                    <h2 class="home__card--title">Được bàn luận nhiều</h2>
                    <div class="home__blog">
                        <CardNew :isCard="false" :post="post" :isSaved="isSaved"
                            v-for="(post, index) in sortedPostByComments.slice(0, 4) " :key="index" />
                    </div>
                </div>
            </div>

            <div class="home__signature">
                <RelatedPage />
            </div>
        </div>
        <button v-if="showButton" class="scroll-top" @click="handleScroll">Cuộn lên</button>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, watchEffect } from "vue"
import CardFeature from "../../../components/CardFeature.vue"
import CardNew from "../../../components/CardNew.vue"
import RelatedPage from "./RelatedPage/RelatedPage.vue";
import Loading from "../../../components/Loading.vue"
import { Navigation, Pagination, Scrollbar, A11y, Autoplay } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import { usePostStore } from "../../../stores/postStore";
import { useAuthStore } from "../../../stores/authStore";

// Store
const postStore = usePostStore()
const authStore = useAuthStore()
const showButton = ref(false);

const handleScroll = (event) => {
    const scrollPosition = event.target.scrollTop;
    showButton.value = scrollPosition >= 300;
};

const scrollToTop = () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth',
    });
};
// Call api
// const handleGetDataSave = async () => {
//     await postStore.getAllSavePosts()
// }
// const handleGetAllData = async () => {
//     await postStore.fetchAllPosts()
// }
// handleGetAllData()
// handleGetDataSave()
// onMounted(async () => {
//     await authStore.fetchAllBlogger()
// })

// Get Id already saved
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

// Slideer
const modules = [Navigation, Pagination, Scrollbar, A11y, Autoplay]

const onSwiper = (swiper) => {
    // console.log(swiper);
};
const onSlideChange = () => {
    console.log('slide change');
};

// Sort Post By Condition
// --- Likes ---
const sortPostsByLikes = (posts) => {
    const sortedPosts = [...posts]; // Create a copy of the original array
    return sortedPosts.sort((a, b) => b.likes_count - a.likes_count);
};

const sortedPostByLikes = computed(() => {
    return sortPostsByLikes(postStore?.posts)
});

// --- View ---
const sortPostsByView = (posts) => {
    const sortedPosts = [...posts]; // Create a copy of the original array
    return sortedPosts.sort((a, b) => b.view_count - a.view_count);
};

const sortedPostByView = computed(() => {
    return sortPostsByView(postStore?.posts)
});

// --- Comment ---
const sortPostsByComment = (posts) => {
    const sortedPosts = [...posts]; // Create a copy of the original array
    return sortedPosts.sort((a, b) => b.comment_count - a.comment_count);
};

const sortedPostByComments = computed(() => {
    return sortPostsByComment(postStore?.posts)
});

</script>

<style lang="scss" scoped>
.home__container {
    margin: 0 auto;

    .scroll-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        background-color: #333;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
}

.home__banner {
    padding: 195px 125px;
    width: 100%;
    max-height: 520px;
    background-image: linear-gradient(to right bottom, #2ebac1, #a4d96c);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.home__image {
    img {
        max-width: 280px;
        object-fit: cover;
    }
}

.home__content {
    max-width: 600px;
    color: var(--white-color);
}

.home__heading {
    font-size: 40px;
    margin-bottom: 20px;
}

.home__desc {
    line-height: 1.75;
    margin-bottom: 40px;
    font-size: 16px;
}

.home__button {
    width: 100%;
    max-width: 200px;
    padding: 15px;
    color: var(--btn-color);
    background-color: var(--white-color);
    border: 1px solid var(--border-color);
    font-size: 18px;
    font-weight: 600;
    border-radius: 10px;
    cursor: pointer;

    &:hover {
        opacity: .9;
    }
}

.home__body {
    margin: 0 auto;
    padding: 60px 120px;
    max-width: 1528px;

    .home__ads {
        margin-top: 40px;

        .home__ads__image {
            height: 130px;
        }
    }
}

.home__card--title {
    // border-top: 3px solid var(--primary-color);
    margin-bottom: 30px;
    padding-top: 10px;
    font-size: 28px;
    color: var(--text-color-2);
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


// card update
.home__update {
    margin-top: 30px;

    .update__list {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }
}

.home__signature {
    padding: 10px;
}




.home__special {
    margin-top: 90px;

    .home__blog {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }
}

.swiper {
    padding-bottom: 35px;
}

.ant-tabs-tab-btn {
    color: var(--black-color) !important;
}


.ant-tabs-tab-active {
    color: var(--black-color) !important;

}
</style>
