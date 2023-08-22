<template>
<div class="home__container">
    <div class="home__banner">
        <div class="home__content">
            <h1 class="home__heading">Monkey Blogging</h1>
            <p class="home__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi.</p>
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
                <CardFeature />
                <CardFeature />
                <CardFeature />
            </div>
        </div>

        <div class="home__update">
            <h2 class="home__card--title">Tin tức cập nhật</h2>
            <div class="update__container">
                <div class="update__big">
                    <img src="https://images.unsplash.com/photo-1682687982167-d7fb3ed8541d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=871&q=80" />
                    <div class="update__content">
                        <span class="update__category">Kiến thức</span>
                        <span class="update__time">22/08</span>
                        <p class="update__content">Hướng dẫn setup phòng cực chill dành cho Hướng dẫn setup phòng cực chill dành cho nHướng dẫn setup phòng cực chill dành cho n người mới toàn tập</p>
                        <div class="update__author">
                            <div class="update__profile">
                                <img src="../../../assets/images/banner.png" alt="">
                                <span class="update__name">Dong Pham</span>
                            </div>
                            <span class="update__comment">
                                <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                                <span class="update__count">10</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="update__list">
                    <CardNew :isCard="true"/>
                </div>
            </div>
            <div class="home__blog">
                <CardNew :isCard="false"/>
                <CardNew :isCard="false"/>
                <CardNew :isCard="false"/>
                <CardNew :isCard="false"/>

            </div>
        </div>
    </div>
</div>
</template>

<script setup>
import CardFeature from "../../../components/CardFeature.vue"
import CardNew from "../../../components/CardNew.vue"
</script>

<style lang="scss" scoped>
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

.card__render {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 50px;
}
// card update
.home__update {
    
    margin-top: 60px;
    .update__container {
        display: flex;
    }
}
.update__big {
    width: 100%;
    max-width: 600px;
    margin-right: 45px;
    img {
        width: 100%;
        max-height: 435px;
        border-radius: 16px;
        object-fit: cover;
    }
}
.update__category {
    color: var(--text-color-4);
    padding: 5px 15px;
    border-radius: 10px;
    font-size: 14px;
    border: 1px solid var(--border-color);
    font-weight: 600;
    background-color: var(--white-color);
    margin-right: 20px;
    margin-right: 30px;
    
}
.update__content {
    margin-top: 15px;
    font-size: 22px;
    font-weight: 700;
    color: var(--black-color);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.2;
}
.update__author {
    margin-top: 10px;
    display: flex;
    gap: 10px;
    align-items: center;
    justify-content: space-between;
    padding: 0px 10px;
    img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--white-color);
        object-fit: cover;
    }
}
.update__profile {
    display: flex;
    align-items: center;
    gap: 10px;
}
.update__count {
    font-size: 14px;
    border-radius: 50%;
    border: 1px solid var(--border-color);
    padding: 5px;
    position: relative;
    padding: -16px;
}
.update__name {
    font-size: 15px;
}
.update__list {
    background-color: #f0f0f0;
    padding: 10px;
}
.home__blog {
    margin-top: 90px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 40px;
}
</style>
