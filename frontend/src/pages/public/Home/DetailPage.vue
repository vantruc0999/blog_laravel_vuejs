<template>
<div class="detail__container">
    <div class="detail__heading">
        <img src="https://images.unsplash.com/photo-1692107329566-0ce6353eedf5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" />
        <div class="detail__infor">
            <div class="detail__category">
                <span>An Ninh Mạng</span>
            </div>
            <p class="detail__title">
                Hướng dẫn setup phòng cực chill dành cho người mới toàn tập
            </p>
            <div class="detail__view">
                <div class="detail__view--public">
                    <div class="detail__user">
                        <img src="../../../assets/images/banner.png" />
                        <div class="detail__user__infor">
                            <span class="detail__user__name">Dong Pham</span>
                        </div>
                    </div>
                    <span class="detail__time">28/10</span>
                </div>
                <span class="detail__viewer">
                    <ion-icon name="eye-outline"></ion-icon> 1208
                </span>
            </div>

        </div>
    </div>
    <div class="detail__content">
        <div class="detail__wrapper">
            <div>wqewqew</div>
            <h1>eqwewqeqwew</h1>
        </div>
    </div>
    <router-link to="/" class="detail__author">
        <img src="https://images.unsplash.com/photo-1687360440102-78d15c3e5045?ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1332&q=80" alt="">
        <div class="detail__infor">
            <h2 class="detail__name">Jake Sullivan</h2>
            <p class="detail__desc">Gastronomy atmosphere set aside. Slice butternut cooking home. Delicious romantic undisturbed raw platter will meld. Thick Skewers skillet natural, smoker soy sauce wait roux. Gastronomy atmosphere set aside. Slice butternut cooking home. </p>
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
        <span class="detail__controller" >
            <ion-icon name="arrow-forward-outline"></ion-icon>
          </span>
    </div>
</div>
</template>

<script setup>
// import {
//     ref,
//     onMounted
// } from "vue";
import CardNew from "../../../components/CardNew.vue";
import {
    Swiper,
    SwiperSlide
} from "swiper/vue";
import "swiper/swiper-bundle.css";
import "swiper/css";
</script>

<style lang="scss" scoped>
.detail__container {
    padding: 20px 130px;
}

.detail__heading {
    display: flex;
    align-items: center;
    position: relative;
    
    img {
        max-width: 650px;
        width: 100%;
        height: 465px;
        border-radius: 12px;
        margin-right: 70px;
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
    font-size: 36px;
    color: var(--btn-color);
    font-weight: 700;
    margin-top: 20px;
    line-height: 1.3;
    margin-bottom: 20px;
}

.detail__view {
    display: flex;
    align-items: center;
    justify-content: space-between;
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

.detail__viewer {
    display: flex;
    align-items: center;
}

.detail__content {
    padding: 20px 250px;
    background-color: red;
    margin: 70px 0px;
}

.detail__wrapper {
    margin: 0 auto;
    background-color: yellow;
}

// card author
.detail__author {
    margin: 0 auto;
    width: 100%;
    border: 1px solid var(--border-color);
    max-width: 780px;
    display: flex;

    img {
        width: 100%;
        max-width: 240px;
        // height: 237px;
        border-radius: 12px;
        object-fit: cover;
    }
}

.detail__infor {
    padding: 20px;
}

.detail__name {
    font-size: 22px;
    color: var(--secondary-color);
    font-weight: 600;
}

.detail__desc {
    margin-top: 10px;
    color: var(--black-color);
    font-size: 18px;

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
    margin:80px 0px 30px 0px;
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
