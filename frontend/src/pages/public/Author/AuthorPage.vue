<template >
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
            <SignatureAuthor />
            <SignatureAuthor />
            <SignatureAuthor />
        </div>
    </div>
</template>
<script setup>
import SignatureAuthor from "../../../pages/public/Home/RelatedPage/SignatureAuthor.vue"
import {
    watchEffect
} from "vue";


watchEffect(() => {
    window.scrollTo(0, 0);

})
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

            // position: absolute;
            // top: 0;
            // right: 0;
            // left: 0;
            // bottom: 0;
            // background-color: var(--white-color);
            // opacity: .3;
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