<template >
    <div class="container">
        <img src="../../../../assets/images/banner.png" alt="">
        <div class="comment__people">
            <div class="comment__list--user">
                <span class="comment__list--name">{{ comment.blogger_name }}</span>
                <span class="comment__list--desc">{{ comment.description }}</span>
            </div>
            <div class="comment__reaction">
                <div class="comment__reply">
                    <span class="comment__reply--reaction">Thích</span>
                    <span class="comment__reply--reaction" @click="handleOpenAnswer">Trả lời</span>
                    <span class="comment__reply--day">{{ calculateTimeAgo(comment.created_at) }}</span>
                </div>
                <div class="comment__reply__user" v-if="isAnswer">
                    <div class="comment__reply__avatar">
                        <img src="../../../../assets/images/avatar-default.png" alt="">
                    </div>
                    <textarea type="text" placeholder="Nhập câu trả lời của bạn..."
                        class="comment__reply__input"></textarea>
                </div>
            </div>

        </div>
        <div class="comment__options"><ion-icon name="ellipsis-horizontal-outline" @click="handleOpenOption"></ion-icon>
            <div class="comment__option" v-if="isOpen">
                <div class="comment__option--edit">
                    <ion-icon name="create-outline"></ion-icon>Sửa
                </div>
                <div class="comment__option--delete" @click="handleOpenModal">
                    <ion-icon name="trash-outline"></ion-icon>Xóa
                </div>
            </div>
        </div>
    </div>

    <ModalController title="You want to delete this comment?"
        content="Do you really want to deleted this comment This process cannot be undone" :closeModel="closeModel"
        :isOpenModal="isOpenModal" :handleDelete="handleDeleteComment" />
</template>
<script setup>
import {
    ref
} from "vue";
import { usePostStore } from "../../../../stores/postStore"
import ModalController from "../../../../components/ModalController.vue"
const props = defineProps({
    comment: Object,
    handleOpenOption: Function,
    isOpen: Boolean
});
const tempCommentId = ref(props.comment?.id)
const postStore = usePostStore()
const isAnswer = ref(false)
const isOpenModal = ref(false)
const handleOpenModal = () => {
    isOpenModal.value = !isOpenModal.value
}
const closeModel = () => {
    isOpenModal.value = false
}
const handleDeleteComment = () => {
    postStore.deleteComment(tempCommentId.value)
}
const handleOpenAnswer = () => {
    isAnswer.value = !isAnswer.value
}
const calculateTimeAgo = (created_at) => {
    const currentTime = new Date();
    const commentTime = new Date(created_at);
    const timeDiff = currentTime - commentTime;

    // Chuyển đổi khoảng thời gian sang giây, phút, giờ, ngày
    const seconds = Math.floor(timeDiff / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);

    if (days > 0) {
        return `${days} ngày trước`;
    } else if (hours > 0) {
        return `${hours} giờ trước`;
    } else {
        return `${minutes} phút trước`;
    }
}

</script>
<style lang="scss" scoped>
.container {
    display: flex;
    gap: 20px;
    margin: 20px 0px;
}

.comment__list {
    display: flex;
    gap: 20px;
    margin-top: 30px;
    margin-bottom: 20px;


    .comment__people {
        .comment__reaction {}

        .comment__reply__user {
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 555;
            margin: 10px;

            .comment__reply__input {
                border-radius: 12px;
                padding: 10px;
                background-color: #fafafa;
                height: 50px;
            }
        }

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

    .comment__options {
        color: var(--text-color-4);
        cursor: pointer;
        position: relative;

    }

    .comment__option {
        position: absolute;
        top: 20px;
        z-index: 1;
        right: 20px;
        width: 120px;
        display: flex;
        align-items: center;
        flex-direction: column;
        font-size: 17px;
        background-color: var(--white-color);
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        cursor: pointer;
        border-radius: 5px;
        transition: cubic-bezier(0.165, 0.84, 0.44, 1);

        &--edit {
            display: flex;
            align-items: center;
            gap: 5px;
            justify-content: center;
            border-bottom: 1px solid var(--border-color);
            width: 100%;
            padding: 5px;
            border-radius: 5px 5px 0px 0px;

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
            border-radius: 0px 0px 5px 5px;
            padding: 5px;

            &:hover {
                color: red;
                background-color: #eee;
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
</style>