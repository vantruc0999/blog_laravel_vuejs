<template>
    <div class="comment__container" v-if="isOpenComment" @scroll.passive="handleScroll"
        :style="{ overflow: isScrollEnabled ? 'auto' : 'hidden' }">
        <div class="comment__content">
            <div class="comment__top">
                <span class="comment__top--number">{{ postStore.post?.data?.comments.length }} bình luận</span>
                <span class="comment__top--report">(Nếu thấy bình luận spam, các bạn bấm report giúp admin nhé)</span>
            </div>
            <div class="comment__user">
                <img :src="'http://127.0.0.1:8000/images/avatar/' + userData.value?.profile_image" alt="avatar"
                    v-if="userData.value?.profile_image">
                <img src="../../../../assets/images/banner.png" alt="" v-else>
                <input type="text" placeholder="Viết bình luận của bạn..." v-model="commentDescription">
                <ion-icon name="send-outline" class="comment__icon" @click="handlePostComment"></ion-icon>
            </div>
            <span class="comment__close" @click="handleOpenComment">
                <ion-icon name="close-outline"></ion-icon>
            </span>

            <div class="comment__list" v-for="(comment, index) in postStore.post?.data?.comments">
                <CommentUser :comment="comment" :handleOpenOption="handleOpenOption" :isOpen="isOpen" />
            </div>
        </div>
    </div>
</template>

<script setup>
import {
    ref,
    computed,
    onMounted
} from "vue";
import {
    usePostStore
} from "../../../../stores/postStore";
import CommentUser from "./CommentUser.vue"
const props = defineProps({
    isOpenComment: Boolean,
    handleOpenComment: Function,
    idPost: String
});
const postStore = usePostStore()
const userData = ref(JSON.parse(localStorage.getItem("user")));
const commentDescription = ref('');
const isScrollEnabled = ref(false);

// open option
const isOpen = ref(false)
const handleOpenOption = () => {
    isOpen.value = !isOpen.value;
};
const handleCloseOption = () => {
    isOpen.value = false
}
const formData = new FormData();
formData.append('commentDescription', commentDescription.value)
const handlePostComment = async () => {
    const payload = {
        description: commentDescription.value
    }
    postStore.postComment(props.idPost, payload)
    await getDetailPost.value;
    commentDescription.value = ''
}

const getDetailPost = computed(() => {
    return postStore.getPostById(props.idPost)
})

onMounted(async () => {
    await getDetailPost.value;
});
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
    animation-name: slideInRight;
    animation-duration: 0.8s;
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
        overflow-y: scroll;
        animation-fill-mode: forwards;

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
            overflow-y: scroll;
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
