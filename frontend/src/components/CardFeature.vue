<template>
    <div class="card__container">
        <div class="card__image">
            <img :src="feature.imgPath" alt="">
        </div>
        <div class="card__infor">
            <div class="card__top">
                <div class="card__category">{{ feature.category }}</div>
                <div class="card__public">
                    <span class="card__public--time">22/08</span>
                </div>
            </div>
            <p class="card__content">{{ feature.content }}</p>
            <div class="card__author">
                <img :src="feature.avatarPath" alt="">
                <span class="card__author--name">{{ feature.author }}</span>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    feature: Object
})
</script>

<style lang="scss" scoped>
.card__container {
    cursor: pointer;
    display: flex;
    width: 100%;
    border-radius: 16px;
    height: 272px;
    position: relative;
    border-radius: 10px;
    max-width: 320px;

    &:hover {
        transform: scale(1.01);
    }
}

.card__image {
    img {
        width: 320px;
        height: 100%;
        border-radius: 16px;
        object-fit: cover;
    }
}

.card__top {
    display: flex;
    align-items: center;
}

.card__infor {
    position: absolute;
    background-color: rgba(0, 0, 0, 0.5);
    padding: 20px;
    max-width: 400px;
    height: 100%;
    border-radius: 16px;
}

.card__category {
    color: var(--text-color-4);
    padding: 5px 15px;
    display: flex;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    justify-content: center;
    align-items: center;
    background-color: var(--white-color);
}

.card__public {
    margin-left: auto;
    color: var(--white-color);
    // display: flex;
    // gap: 10px;
    font-size: 14px;
}

.card__content {
    margin-top: 20px;
    font-size: 22px;
    font-weight: 500;
    color: var(--white-color);
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.2;
}

.card__author {
    margin-top: 30px;
    display: flex;
    gap: 10px;
    align-items: center;

    img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--white-color);
        object-fit: cover;
    }
}

.card__author--name {
    font-size: 16px;
    color: var(--white-color);
}

.card__overlay {
    position: absolute;
    inset: 0;
    border-radius: 16px;
    background-color: rgba(0, 0, 0, 0.75);
    mix-blend-mode: multiply;
    opacity: 0.6;
}
</style>
