<template>
    <div class="card" v-if="isCard">
        <router-link to="/detail">
            <div class="card__image">
                <img src="https://images.unsplash.com/photo-1682685797088-283404e24b9d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                    alt="">
            </div>
        </router-link>
        <div class="card__detail">
            <div class="card__header">
                <div class="card__category">Khoa học</div>
                <span class="card__comment--icon blog__favorites">
                    <ion-icon name="bookmark-outline"></ion-icon>
                </span>
            </div>
            <router-link to="/detail">
                <div class="blog__body">
                    <div class="blog__title">
                        Hướng dẫn setup phòng cực chill dành cho người mới toàn tập
                    </div>
                    <div class="blog__content">
                        Đây là bộ phim mà mình đã trông Đây là bộ phim mà mình đã trông ngóng suốt gần một năm qua, với ba
                        điều
                        cuốn
                        hút nhất: Tâm trí con
                    </div>

                    <div class="blog__bottom">
                        <div class="blog__user">
                            <img src="../assets/images/banner.png" />
                            <div class="blog__user__infor">
                                <span class="blog__user__name">Dong Pham</span>
                                <div class="blog__user__time">9 giờ trước</div>
                            </div>
                        </div>

                        <div class="blog__comment">
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
            <div class="blog__category">Khoa học</div>
            <span class="blog__comment--icon blog__favorites">
                <ion-icon name="bookmark-outline"></ion-icon>
            </span>

        </div>
        <router-link to="/detail">

            <div class="blog__image">
                <img
                    src="https://images.unsplash.com/photo-1682685795463-0674c065f315?ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1926&q=80" />
            </div>
            <div class="blog__body">
                <div class="blog__title">
                    Hướng dẫn setup phòng cực chill dành cho người mới toàn tập
                </div>
                <div class="blog__content">
                    Đây là bộ phim mà mình đã trông Đây là bộ phim mà mình đã trông ngóng suốt gần một năm qua, với ba điều
                    cuốn
                    hút nhất: Tâm trí con
                </div>

                <div class="blog__bottom">
                    <div class="blog__user">
                        <img src="../assets/images/banner.png" />
                        <div class="blog__user__infor">
                            <span class="blog__user__name">Dong Pham</span>
                            <div class="blog__user__time">9 giờ trước</div>
                        </div>
                    </div>

                    <div class="blog__comment">
                        <span class="blog__comment--icon">
                            <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                        </span>
                        <span class="blog__amount">7</span>
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
    isCard: Boolean
})
</script>

<style lang="scss" scoped>
.card {
    display: flex;

    .card__image {
        max-width: 200px;
        margin-right: 20px;

        img {
            width: 100%;
            border-radius: 10px;
            height: 200px;
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
    // border: 1px solid var(--border-color);
    padding: 10px;
    position: relative;
    background-color: var(--white-color);
    cursor: pointer;
    box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
}

.blog__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.blog__image {
    img {
        width: 100%;
        border-radius: 10px;
        height: 200px;
        object-fit: cover;
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

.blog__title {
    margin-top: 10px;
    font-size: 18px;
    color: var(--black-color);
    font-weight: 600;
    margin-bottom: 10px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden !important;
}

.blog__content {
    display: -webkit-box;
    color: var(--text-color-4);
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden !important;
}

.blog__user {
    margin-top: 30px;
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
    }
}

.blog__bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.blog__comment {
    margin-top: 30px;
}

.blog__comment--icon {
    cursor: pointer;
    font-size: 20px;
}

.blog__amount {
    color: var(--text-color-4);
    border-radius: 50%;
    // border: 1px solid var(--border-color);
    position: relative;
    top: -16px;
}
</style>
