<template>
    <div class="card" v-if="isCard">
        <router-link :to="`/detail/${post?.id}`">
            <div class="card__image">
                <img :src="'http://127.0.0.1:8000/' + post?.banner" alt="">
            </div>
        </router-link>
        <div class="card__detail">
            <div class="card__header">
                <div class="card__category">{{ post?.category_name }}</div>
                <span class="card__comment--icon blog__favorites">
                    <ion-icon name="bookmark-outline"></ion-icon>
                </span>
            </div>
            <router-link :to="`/detail/${post?.id}`">
                <div class="blog__body">
                    <div class="blog__title">
                        {{ post?.title }}
                    </div>
                    <div class="blog__content">
                        {{ post?.description }}
                    </div>

                    <div class="blog__bottom">
                        <div class="blog__user">
                            <img src="../assets/images/banner.png" />
                            <div class="blog__user__infor">
                                <span class="blog__user__name">{{ post?.blogger_name }}</span>
                                <div class="blog__user__time">9 giờ trước</div>
                            </div>
                        </div>

                        <div class="blog__comment">
                            <span class="blog__comment--icon">
                                <ion-icon name="eye-outline"></ion-icon>
                            </span>
                            <span class="blog__amount">1,2k lượt xem</span>
                            <span class="blog__comment--icon">
                                <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                            </span>
                            <span class="blog__amount">7</span>
                        </div>
                    </div>
                </div>
            </router-link>
        </div>
    </div>

    <!-- Blog -->
    <div class="blog" v-else>
        <div class="blog__header">
            <div class="blog__category">{{ post?.category_name }}</div>
            <span class="blog__comment--icon blog__favorites">
                <ion-icon name="bookmark-outline"></ion-icon>
            </span>
        </div>
        <router-link :to="`/detail/${post?.id}`">
            <div class="blog__image">
                <img :src="'http://127.0.0.1:8000/' + post?.banner" alt="">
            </div>
            <div class="blog__body">
                <div class="blog__title">
                    {{ post?.title }}
                </div>
                <div class="blog__bottom">
                    <div class="blog__user">
                        <img src="../assets/images/banner.png" />
                        <div class="blog__user__infor">
                            <span class="blog__user__name">{{ post?.blogger_name }}</span>
                            <div class="blog__user__time">9 giờ trước</div>
                        </div>
                    </div>

                    <div class="blog__comment">
                        <span class="blog__comment--icon">
                            <ion-icon name="eye-outline"></ion-icon>
                        </span>
                        <span class="blog__amount">{{ post?.view_count }} k lượt xem</span>
                    </div>
                </div>
            </div>
        </router-link>
    </div>
</template>

<script setup>
import {
    ref
} from "vue"

// Định nghĩa prop "message"
const props = defineProps({
    isCard: Boolean,
    post: Object

})

</script>

<style lang="scss" scoped>
.card {
    display: flex;

    .card__image {
        max-width: 200px;
        margin-right: 20px;
        width: 200px;

        img {
            width: 100%;
            height: 200px;
            border: 1px solid var(--border-color);
            // object-fit: cover;
        }
    }

    .card__detail {
        flex: 1;

        .card__header {
            display: flex;
            justify-content: space-between;

            .card__category {
                color: var(--text-color-4);
                padding: 5px 15px;
                border-radius: 10px;
                border: 1px solid var(--border-color);
                font-size: 14px;
                display: flex;
                justify-content: center;
                font-weight: 600;
                display: flex;
                justify-content: center;
                background-color: var(--white-color);
                display: -webkit-box;
                -webkit-line-clamp: 1;
                -webkit-box-orient: vertical;
                overflow: hidden;
                margin-bottom: 5px;
            }

            .card__comment--icon {
                cursor: pointer;
                font-size: 20px;
            }
        }


    }
}


// Blog

.blog {
    border-radius: 12px;
    width: 100%;
    padding: 10px;
    display: flex;
    flex-direction: column;
    position: relative;
    background-color: var(--white-color);
    cursor: pointer;
    box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
}

.blog__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}

.blog__image {
    img {
        border: 1px solid var(--border-color);
        flex-shrink: 0;
        width: 100%;
        border-radius: 10px;
        height: 200px;
    }
}

.blog__category {
    color: var(--text-color-4);
    padding: 5px 15px;
    border-radius: 10px;
    border: 1px solid var(--border-color);
    font-size: 14px;
    display: flex;
    justify-content: center;
    font-weight: 600;
    display: flex;
    justify-content: center;
    background-color: var(--white-color);
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 5px;
}

.blog__body {
    display: flex;
    flex-direction: column;
    color: var(--text-color-4);


    .blog__title {
        flex: 1;
        margin-top: 20px;
        font-size: 18px;
        color: var(--black-color);
        font-weight: 600;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 6;
        -webkit-box-orient: vertical;
        overflow: hidden !important;
    }

    .blog__bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        margin-top: auto;
        flex-shrink: 0;
    }
}


.blog__user {
    display: flex;
    gap: 10px;
    align-items: center;

    img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 1px solid var(--border-color);
        background-color: var(--white-color);
        object-fit: cover;
        flex-shrink: 0;
    }
}

// .blog__bottom {
//     margin-top: auto !important;
//     display: flex;
//     justify-content: space-between;
//     align-items: center;
//     padding: 15px 0;
//     flex-shrink: 0;
// }

.blog__comment {
    display: flex;
    gap: 2px;
    align-items: center;

    .blog__comment--icon {
        cursor: pointer;
        font-size: 20px;
        color: var(--text-color-4);
        margin-left: 5px;
    }

    .blog__amount {
        color: var(--text-color-4);
        font-size: 12px;
        position: relative;
        top: -2px;
    }
}
</style>
