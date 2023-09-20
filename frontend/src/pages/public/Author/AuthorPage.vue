<template >
    <div v-if="authorStore.isLoading">
        <Loading />
    </div>
    <div class="author__container">
        <div class="author__banner">
            <img src="../../../assets/images/books.jpg" alt="" class="author__image">
            <div class="author__member">
                <strong class="author__signature">THÀNH VIÊN NỔI BẬT</strong>
                <p class="author__list">Danh sách thành viên hoạt động tích cực</p>
            </div>
        </div>

        <div class="author__title">
            <span class="author__time">Mọi thời điểm</span>
        </div>
        <div class="author__list">
            <SignatureAuthor :author="author" v-for="(author, index) in authorStore.users" :key="index" />
        </div>
    </div>
</template>
<script setup>
import SignatureAuthor from "../../../pages/public/Home/RelatedPage/SignatureAuthor.vue"

import {
    onMounted,
    watchEffect
} from "vue";
import { useAuthorStore } from "../../../stores/authorStore";
import Loading from "../../../components/Loading.vue";

const authorStore = useAuthorStore()
const handleFetchUserFollower = async () => {
    await authorStore.fetchAllBlogger()
}
handleFetchUserFollower()

</script>
<style lang="scss" scoped>
.author__container {
    .author__banner {
        position: relative;

        .author__image {
            height: 320px;
            width: 100%;
            object-fit: cover;
        }

        .author__member {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            align-items: center;
            flex-direction: column;
            justify-content: center;
            gap: 30px;
            color: #fff;
            width: 100%;

            .author__signature {
                font-size: 46px;
                font-weight: 700;
            }

            .author__list {
                font-size: 24px;
                display: flex;
                justify-content: center;
            }


        }
    }

    .author__title {
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: center;

        .author__time {
            padding: 15px;
            font-size: 16px;
            font-weight: 700;
            color: var(--green-color);
            border-bottom: 2px solid var(--green-color);
        }
    }

    .author__list {
        width: 700px;
        margin: 0 auto;
        margin-top: 40px;
    }
}
</style>