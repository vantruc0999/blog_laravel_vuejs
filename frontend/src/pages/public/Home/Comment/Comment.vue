<template >
    <div class="comment__container" v-if="isOpenComment" @click="handleOpenComment">
        <!-- <div class="overlay"></div> -->
        <div class="comment__content">
            <div class="comment__top">
                <span class="comment__top--number">3 bình luận</span>
                <span class="comment__top--report">(Nếu thấy bình luận spam, các bạn bấm report giúp admin nhé)</span>
            </div>
            <div class="comment__user">
                <img src="../../../../assets/images/banner.png" alt="">
                <input type="text" placeholder="Viết bình luận của bạn...">
                <ion-icon name="send-outline" class="comment__icon"></ion-icon>
            </div>
            <div class="comment__list">
                <span class="comment__close" @click="isOpenComment == false"><ion-icon
                        name="close-outline"></ion-icon></span>
                <img src="../../../../assets/images/banner.png" alt="">
                <div class="comment__people">
                    <div class="comment__list--user">
                        <span class="comment__list--name">Nguyễn Thị Bin</span>
                        <span class="comment__list--desc">Mỗi lần đọc bài viết này làm tôi đều nhớ lại những ngày còn thiếu
                            nữ của mình.</span>
                    </div>
                    <div class="comment__reply">
                        <span class="comment__reply--reaction">Thích</span>
                        <span class="comment__reply--reaction">Trả lời</span>
                        <span class="comment__reply--day">15 ngày trước</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
<script setup>
import { ref } from "vue"

const props = defineProps({
    isOpenComment: Boolean,
    handleOpenComment: Function
});

// const handleOpenComment = () => {
//     isOpenComment.value = !isOpenComment.value
// }

</script>
<style lang="scss" scoped>
.comment__container {
    width: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 901;
    bottom: 0;
    background-color: rgba(0, 0, 0, .2);
    // animation: cubic-bezier(0.075, 0.82, 0.165, 1);
    animation-name: slideInRight;
    animation-duration: 0.8s;
    /* Adjust the animation duration as needed */
    animation-fill-mode: forwards;

    .comment__content {
        width: 50%;
        height: 100%;
        background-color: var(--white-color);
        z-index: 902;
        float: right;
        padding: 30px;
        position: relative;
        animation-name: slideInRight;
        animation-duration: 0.8s;
        /* Adjust the animation duration as needed */
        animation-fill-mode: forwards;
        // animation: cubic-bezier(0.175, 0.885, 0.32, 1.275);


        .comment__close {
            position: absolute;
            top: 0;
            right: 0;
            cursor: pointer;
            font-size: 25px;
            right: 10px;
        }

        .comment__top {
            display: flex;
            flex-direction: column;
            gap: 10px;

            &--number {
                font-size: 16px;
                font-weight: 500;
            }

            &--report {
                color: var(--text-color-4);
                font-size: 14px;
                font-style: italic;
            }
        }

        .comment__user {
            display: flex;
            align-items: center;
            margin-top: 80px;
            gap: 20px;

            img {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                border: 1px solid var(--border-color);
            }

            input {
                border-bottom: 1px solid var(--border-color);
                flex: 1;

                &::placeholder {
                    font-size: 16px;
                    color: #c4c4c4;
                }

            }

            .comment__icon {
                cursor: pointer;
            }
        }

        .comment__list {
            display: flex;
            gap: 20px;
            margin-top: 30px;
            margin-bottom: 20px;


            .comment__people {
                .comment__reply {
                    cursor: pointer;
                    display: flex;
                    gap: 10px;
                    font-size: 14px;
                    margin-top: 5px;
                    color: rgb(211, 65, 65);

                    &--day {
                        font-size: 13px;
                        color: var(--text-color-4);
                    }
                }
            }

            img {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                border: 1px solid var(--border-color);
            }

            &--user {
                background-color: #f2f3f5;
                padding: 15px;
                border-radius: 15px;
            }

            &--name {
                display: flex;
                font-weight: 700;
                font-size: 16px;

            }

            &--desc {
                display: inline-block;
                margin-top: 20px;
                font-size: 14px;
                font-weight: 400;
            }
        }
    }
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        /* Start from the right side */
    }

    to {
        transform: translateX(0);
        /* Slide to the left side */
    }
}
</style>