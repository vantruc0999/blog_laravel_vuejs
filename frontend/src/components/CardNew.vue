<template>
    <div class="card" v-if="isCard">
        <img :src="'http://127.0.0.1:8000/storage/' + post?.banner" alt="card img" class="card__image">
        <div class="card__right">
            <div class="card__favorite">
                <div class="card__categori">{{ post?.category_name }}</div>
                <div class="card__icon">
                    <ion-icon name="bookmark-outline" class="card__bookmark" @click="handleAddBookmark"></ion-icon>
                    <ion-icon name="ellipsis-vertical-outline" class="card__menu" @click="handleOpenOption"></ion-icon>
                    <div class="card__options" v-if="isOpen">
                        <div class="card__options--edit">
                            <ion-icon name="create-outline"></ion-icon>Sửa
                        </div>
                        <div class="card__options--delete">
                            <ion-icon name="trash-outline"></ion-icon>Xóa
                        </div>
                    </div>
                </div>
            </div>
            <div class="card__content">
                <div class="card__top">
                    <router-link :to="`/detail/${post?.id}`">
                        <h3 class="card__title">
                            {{ post?.title }}
                        </h3>
                        <p class="card__intro">{{ post?.intro }}</p>
                    </router-link>
                </div>
                <div class="card__bottom">
                    <div class="card__user">
                        <img src="../assets/images/avatar-default.png" alt="" class="card__user__avatar">
                        <router-link :to="`/profile/${post?.blogger_infor?.id}`">
                            <div class="card__user__infor">
                                <div class="card__user__top">
                                    <div class="card__user__name">{{ post?.blogger_infor?.name }}</div>
                                </div>
                                <div class="card__user__time">9 giờ trước</div>
                            </div>
                        </router-link>
                    </div>
                    <router-link :to="`/detail/${post?.id}`">
                        <div class="card__footer">
                            <div class="card__watch">
                                <ion-icon name="eye-outline"></ion-icon>
                                <span>{{ post?.view_count }} lượt xem</span>
                            </div>
                            <div class="card__comment">
                                <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                                <span>12</span>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog -->
    <div class="blog" v-else>
        <div class="blog__favorite">
            <div class="blog__categori">{{ post?.category_name }}</div>
            <div class="blog__icon">
                <ion-icon name="bookmark-outline" class="blog__bookmark"></ion-icon>
                <ion-icon name="ellipsis-vertical-outline" class="blog__menu"
                    v-if="post?.blogger_id == post?.blogger_infor?.id" @click="handleOpenOption"></ion-icon>
                <div class="card__options" v-if="isOpen">
                    <div class="card__options--edit">
                        <ion-icon name="create-outline"></ion-icon>Sửa
                    </div>
                    <div class="card__options--delete">
                        <ion-icon name="trash-outline"></ion-icon>Xóa
                    </div>
                </div>
            </div>
        </div>
        <router-link :to="`/detail/${post?.id}`">
            <img :src="'http://127.0.0.1:8000/storage/' + post?.banner" alt="blog img" class="blog__image">
        </router-link>

        <div class="blog__content">
            <div class="blog__top">
                <router-link :to="`/detail/${post?.id}`">
                    <h3 class="blog__title">
                        {{ post?.title }}
                    </h3>
                </router-link>
                <div class="blog__user">
                    <img src="../assets/images/avatar-default.png" alt="" class="blog__user__avatar">
                    <router-link :to="`/profile/${post?.blogger_infor?.id}`">
                        <div class="blog__user__infor">
                            <div class="blog__user__top">
                                <div class="blog__user__name">{{ post?.blogger_infor?.name }}</div>
                            </div>
                            <div class="blog__user__time">9 giờ trước</div>
                        </div>
                    </router-link>
                </div>
            </div>
            <router-link :to="`/detail/${post?.id}`">
                <div class="blog__bottom">
                    <div class="blog__watch">
                        <ion-icon name="eye-outline"></ion-icon>
                        <span>{{ post?.view_count }} lượt xem</span>
                    </div>
                    <div class="blog__comment">
                        <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                        <span>12</span>
                    </div>
                </div>
            </router-link>
        </div>

    </div>
</template>

<script setup>
import {
    ref
} from "vue"
import { usePostStore } from "../stores/postStore";

const postStore = usePostStore()
// Định nghĩa prop "message"
const props = defineProps({
    isCard: Boolean,
    post: Object
})

const isOpen = ref(false)
const handleOpenOption = () => {
    isOpen.value = !isOpen.value
}
const handleAddBookmark = () => { }
</script>

<style lang="scss" scoped>
//  Card 
.card {
    display: flex;

    .card__right {
        width: 100%;
    }

    .card__image {
        width: 100%;
        max-width: 230px;
        height: auto;
        object-fit: cover;
        margin-right: 10px;
        border: 1px solid var(--border-color);
    }

    .card__favorite {
        display: flex;
        justify-content: space-between;
    }

    .card__categori {
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
    }

    .card__icon {
        position: relative;

        .card__bookmark {
            cursor: pointer;
            font-size: 20px;
        }

        .card__menu {
            cursor: pointer;
        }
    }

    .card__content {
        &:hover {
            color: var(--black-color);
        }
    }

    .card__bottom {
        display: flex;
        justify-content: space-between;
    }

    .card__title {
        font-size: 20px;
        font-weight: 700;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card__description {
        font-size: 14px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card__user {
        display: flex;
        align-items: center;
        margin-top: auto;
        flex-shrink: 0;

        .card__user__avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .card__user__infor {
            padding-left: 10px;
            flex: 1;
        }

        .card__user__top {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .card__user__name {
            font-weight: 500;
            font-size: 14px;
            line-height: 1;
        }

        .card__user__time {
            color: #999;
            font-weight: 300;
            font-size: 13px;
        }
    }

    .card__footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: var(--text-color-4);
        font-weight: 700;
        margin-top: auto;
        align-items: center;
        display: flex;
        gap: 15px;
    }
}

// Blog
.blog {
    border-radius: 10px;
    overflow: hidden;
    background-color: var(--white-color);
    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0;
    display: flex;
    flex-direction: column;

    .blog__favorite {
        display: flex;
        justify-content: space-between;
        padding: 10px;
    }

    .blog__categori {
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
    }

    .blog__icon {
        position: relative;

        .blog__bookmark {
            cursor: pointer;
            font-size: 20px;
        }

        .blog__menu {
            cursor: pointer;
        }
    }

    .blog__image {
        height: 200px;
        width: 100%;
        object-fit: cover;
        flex-shrink: 0;
    }

    .blog__content {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .blog__top {
        padding: 15px;
        display: flex;
        flex: 1;
        flex-direction: column;
    }

    .blog__title {
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .blog__user {
        display: flex;
        align-items: center;
        margin-top: auto;
        flex-shrink: 0;

        .blog__user__avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .blog__user__infor {
            padding-left: 10px;
            flex: 1;
        }

        .blog__user__top {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .blog__user__name {
            font-weight: 500;
            font-size: 14px;
            line-height: 1;
        }

        .blog__user__time {
            color: #999;
            font-weight: 300;
            font-size: 13px;
        }

    }

    .blog__bottom {
        padding: 15px;
        border-top: 1px solid #eee;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: var(--text-color-4);
        font-weight: 700;
        margin-top: auto;

        .blog__watch {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
        }

        .blog__comment {
            display: flex;
            align-items: center;
            gap: 2px;

            span {
                font-size: 14px;
            }
        }
    }
}

.card__options {
    position: absolute;
    top: 25px;
    z-index: 1;
    right: 5px;
    width: 120px;
    display: flex;
    align-items: center;
    flex-direction: column;
    font-size: 17px;
    background-color: var(--white-color);
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    cursor: pointer;
    border-radius: 12px;
    transition: cubic-bezier(0.165, 0.84, 0.44, 1);

    &--edit {
        display: flex;
        align-items: center;
        gap: 5px;
        justify-content: center;
        border-bottom: 1px solid var(--border-color);
        width: 100%;
        padding: 5px;
        border-radius: 12px 12px 0px 0px;

        &:hover {
            background-color: var(--secondary-color);
            color: var(--white-color);
        }
    }

    &--delete {
        display: flex;
        align-items: center;
        gap: 5px;
        justify-content: center;
        width: 100%;
        padding: 0px 5px;
        border-radius: 0px 0px 12px 12px;
        padding: 5px;

        &:hover {
            color: red;
            background-color: #eee;
        }
    }
}

.card__bookmark--active {
    color: var(--primary-color);
}
</style>
