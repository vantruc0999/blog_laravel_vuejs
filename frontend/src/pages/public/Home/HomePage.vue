<template>
    <div class="home__container">
        <div class="home__banner">
            <div class="home__content">
                <h1 class="home__heading">Monkey Blogging</h1>
                <p class="home__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                    laboris nisi.</p>
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
                    <swiper :modules="modules" :slides-per-view="3" :space-between="50" navigation
                        :pagination="{ clickable: true }" :scrollbar="{ draggable: true }" @swiper="onSwiper"
                        @slideChange="onSlideChange">
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
                    :pagination="{ clickable: true }" :scrollbar="{ draggable: true }" @swiper="onSwiper"
                    @slideChange="onSlideChange">
                    <swiper-slide>
                        <img src="../../../assets/images/ads1.png" class="home__ads__image" />
                    </swiper-slide>
                    <swiper-slide>
                        <img src="../../../assets/images/ads2.png" class="home__ads__image" />
                    </swiper-slide>
                </swiper>
            </div>
            <div class="home__update">
                <h2 class="home__card--title">Tin tức cập nhật</h2>

                <div class="update__list">
                    <CardNew :isCard="false" />
                    <CardNew :isCard="false" />
                    <CardNew :isCard="false" />
                    <CardNew :isCard="false" />
                </div>

                <div class="home__special">
                    <h2 class="home__card--title">Nổi bật trong tháng</h2>
                    <div class="home__blog">
                        <CardNew :isCard="false" />
                        <CardNew :isCard="false" />
                        <CardNew :isCard="false" />
                        <CardNew :isCard="false" />
                    </div>
                </div>
            </div>

            <div class="home__signature">
                <RelatedPage />
            </div>
        </div>
    </div>
</template>

<script setup>
import CardFeature from "../../../components/CardFeature.vue"
import CardNew from "../../../components/CardNew.vue"
import RelatedPage from "./RelatedPage/RelatedPage.vue";
import { Navigation, Pagination, Scrollbar, A11y } from 'swiper/modules';

// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from 'swiper/vue';

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';

const onSwiper = (swiper) => {
    // console.log(swiper);
};
const onSlideChange = () => {
    console.log('slide change');
};

const modules = [Navigation, Pagination, Scrollbar, A11y]
</script>

<style lang="scss" scoped>
.home__container {
    max-width: 1528px;
    margin: 0 auto;
}

.home__banner {
    padding: 40px 125px;
    min-height: 520px;
    background-image: linear-gradient(to right bottom, #2ebac1, #a4d96c);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.home__content {
    max-width: 600px;
    color: var(--white-color);
}

.home__heading {
    font-size: 46px;
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
    padding: 60px 120px;

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

.swiper-scrollbar {
    display: none;
}
</style>
