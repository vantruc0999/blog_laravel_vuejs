<template>
<router-link to="/detail" class="card" v-if="isCard">
    <div class="card__image">
        <img src="https://images.unsplash.com/photo-1692607038324-6957c392410c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1332&q=80" />
    </div>
    <div class="card__body">
        <div class="card__category">Khoa học Khoa học Khoa học</div>
        <div class="card__title">
            Hướng dẫn setup phòng cực chill dành cho người mới toàn tập
        </div>
        <div class="card__content">
            Đây là bộ phim mà mình đã trông Đây là bộ phim mà mình đã trông ngóng suốt gần một năm qua, với ba điều cuốn hút nhất: Tâm trí con
        </div>

        <div class="card__bottom">
            <div class="card__user">
                <img src="../assets/images/banner.png" />
                <div class="card__user__infor">
                    <span class="card__user__name">Dong Pham</span>
                    <div class="card__user__time">9 giờ trước</div>
                </div>
            </div>

            <div class="card__comment">
                <span class="card__comment--icon">
                    <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                </span>
                <span class="card__amount">7</span>
                <span class="card__comment--icon card__favorites">
                    <ion-icon name="bookmark-outline"></ion-icon>
                </span>
            </div>
        </div>
    </div>

</router-link>

<router-link to="/detail" class="blog" v-else>

    <div class="blog__header">
        <div class="blog__category">Khoa học</div>
        <span class="blog__comment--icon blog__favorites">
            <ion-icon name="bookmark-outline"></ion-icon>
        </span>

    </div>

    <div class="blog__image">
        <img src="https://images.unsplash.com/photo-1692607038324-6957c392410c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1332&q=80" />
    </div>
    <div class="blog__body">
        <div class="blog__title">
            Hướng dẫn setup phòng cực chill dành cho người mới toàn tập
        </div>
        <div class="blog__content">
            Đây là bộ phim mà mình đã trông Đây là bộ phim mà mình đã trông ngóng suốt gần một năm qua, với ba điều cuốn hút nhất: Tâm trí con
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
    cursor: pointer;
    width: 100%;
    display: flex;
    gap: 20px;
    border: 1px solid var(--border-color);
    padding: 10px;
    position: relative;
    margin-bottom: 5px;
    border-radius: 12px;
}

.card__image {
    img {
        width: 100%;
        border-radius: 10px;
        height: 200px;
        object-fit: cover;
    }
}

.card__user {
    margin-top: 10px;
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

.card__category {
    max-height: 25px;
    max-width: 300px;
    width: 100%;
    color: var(--text-color-4);
    padding: 5px 15px;
    border-radius: 10px;
    border: 1px solid var(--border-color);
    font-size: 14px;
    margin-bottom: 10px;
    font-weight: 600;
    background-color: var(--white-color);
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden !important;
}

.card__title {
    font-size: 18px;
    color: var(--black-color);
    font-weight: 600;
    margin-bottom: 10px;
}

.card__bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.card__content {
    font-size: 14px;
    color: var(--text-color-4);
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.3;
}

.card__user {
    display: flex;
    align-items: center;
}

.card__user__infor {
    display: flex;
    flex-direction: column;
}

.card__comment {
    display: flex;
    align-items: center;
    justify-content: center;
}

.card__comment--icon {
    margin-top: 30px;
    cursor: pointer;
    margin-left: 10px;
    font-size: 25px;
}

.card__favorites {
    position: absolute;
    top: -15px;
}

// Blog

.blog {
    border-radius: 12px;
    width: 100%;
    border: 1px solid var(--border-color);
    padding: 10px;
    position: relative;
    cursor: pointer;
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
    font-size: 18px;
    color: var(--black-color);
    font-weight: 600;
    margin-bottom: 10px;
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
