<template >
    <div class="container">
        <img :src="'http://127.0.0.1:8000/images/avatar/' + comment?.blogger_image" alt="avatar"
            v-if="comment?.blogger_image">
        <img src="../../../../assets/images/banner.png" alt="" v-else>
        <div class="comment__people">
            <div class="comment__list--user">
                <span class="comment__list--name">{{ comment.blogger_name }}</span>
                <span class="comment__list--desc" v-if="isOpenEdit">{{ comment.description }}</span>
                <div class="comment__list--input" v-else>
                    <input class="comment__list__text" type="text" v-model="editCommentValue">
                    <div class="comment__list--controller">
                        <div class="comment__list__btn comment__list--calcel" @click="handleOpenEditComment">Hủy</div>
                        <div class="comment__list__btn comment__list--submit" @click="handleEditComment">Lưu</div>
                    </div>
                </div>
            </div>
            <div class="comment__reaction">
                <div class="comment__reply">
                    <span class="comment__reply--reaction">Thích</span>
                    <span class="comment__reply--reaction" @click="handleOpenAnswer">Trả lời</span>
                    <span class="comment__reply--day">{{ calculateTimeAgo(comment.created_at) }}</span>
                </div>
                <div class="comment__reply__user" v-if="isAnswer">
                    <div class="comment__user">
                        <img :src="'http://127.0.0.1:8000/images/avatar/' + authStore.user.blogger_info?.profile_image"
                            alt="avatar" v-if="authStore.user.blogger_info?.profile_image">
                        <img src="../assets/images/avatar-default.png" alt="" v-else>
                        <EmojiPicker v-if="showEmojiPicker" :native="true" @select="onSelectEmoji" class="comment__emoji" />
                        <ion-icon name="happy-outline" @click="toggleEmojiPicker"></ion-icon>
                        <input type="text" placeholder="Viết câu trả lời..." v-model="commentDescription">
                        <ion-icon name="send-outline" class="comment__icon" @click="handlePostComment"></ion-icon>
                    </div>
                </div>
            </div>
        </div>
        <div class="comment__options" v-if="handleCheckMyComment(comment?.blogger_id)">
            <ion-icon name="ellipsis-horizontal-outline" @click="handleOpenOption"></ion-icon>
            <div class="comment__option" v-if="isOpen">
                <div class="comment__option--edit" @click="handleOpenEditComment">
                    <ion-icon name="create-outline"></ion-icon>Sửa
                </div>
                <div class="comment__option--delete" @click="handleOpenModal">
                    <ion-icon name="trash-outline"></ion-icon>Xóa
                </div>
            </div>
        </div>
    </div>
    <div class="comment__more" v-if="comment?.replies?.length > 0">
        <div class="comment__answer" @click="handleOpenCommentSub">
            Xem {{ comment?.replies?.length }} câu trả lời
            <ion-icon name="chevron-down-outline" v-if="!isOpenCommentDetail"></ion-icon>
            <ion-icon name="chevron-up-outline" v-else></ion-icon>
        </div>
        <div class="comment__answers">
            <CommentUser :comment="reply" :isOpen="isOpen" v-for="(reply, index) in comment?.replies" :key="index"
                v-if="isOpenCommentDetail" />
        </div>
    </div>
    <ModalController title="Bạn có muốn xóa comment  của mình?" content="" :closeModel="closeModel"
        :isOpenModal="isOpenModal" :handleDelete="handleDeleteComment" />
</template>
<script setup>
import {
    ref,
    computed,
    onMounted
} from "vue";
import { usePostStore } from "../../../../stores/postStore"
import ModalController from "../../../../components/ModalController.vue"
import { useAuthStore } from "../../../../stores/authStore";
const isOpenCommentDetail = ref(false)

const props = defineProps({
    comment: Object,
    handleOpenOption: Function,
    idPost: String,
});
const userData = ref(JSON.parse(localStorage.getItem("user")));
const tempCommentId = ref(props.comment?.id)
const postStore = usePostStore()
const authStore = useAuthStore()
const isAnswer = ref(false)
const isOpenModal = ref(false)
const isOpen = ref(false)
const isOpenEdit = ref(true)
const editCommentValue = ref(props.comment?.description)
const showEmojiPicker = ref(true);
const commentDescription = ref('');
// check options
const handleCheckMyComment = (idUserCmt) => {
    if (userData.value.id == idUserCmt) {
        return true
    } else {
        return false
    }
}

// open emoji
const toggleEmojiPicker = () => {
    showEmojiPicker.value = !showEmojiPicker.value;
};
const onCloseEmoji = () => {
    showEmojiPicker.value = false
}
const onSelectEmoji = (emoji) => {
    commentDescription.value += emoji.i;
};
const formData = new FormData();

formData.append('commentDescription', commentDescription.value)
const handlePostComment = async () => {
    const payload = {
        description: commentDescription.value
    }
    postStore.replyComment(props.idPost, tempCommentId.value, payload)
    // await getDetailPost.value;
    commentDescription.value = ''
    isAnswer.value = false
    isOpen.value = true
}
// const getDetailPost = computed(() => {
//     return postStore.getPostById(props.idPost)
// })

// onMounted(async () => {
//     await getDetailPost.value;
//     await handlePostComment
// });
// open modal
const handleOpenModal = () => {
    isOpenModal.value = !isOpenModal.value
}


const getBloggerID = computed(() => {
    const comments = postStore.post?.data?.comments;
    return comments.map((comment) => comment?.blogger_id);
})

const closeModel = () => {
    isOpenModal.value = false
}
const handleOpenEditComment = () => {
    isOpenEdit.value = !isOpenEdit.value
    isOpen.value = false
}

const handleEditComment = () => {
    const formData = new FormData();
    formData.append('description', editCommentValue.value)
    postStore.editComment(props.idPost, tempCommentId.value, formData)
    isOpenEdit.value = !isOpenEdit.value

}
const handleCloseOption = () => {
    isOpen.value = false
}
const handleOpenOption = () => {
    isOpen.value = !isOpen.value;
};
const handleDeleteComment = () => {
    postStore.deleteComment(props.idPost, tempCommentId.value)
}
const handleOpenAnswer = () => {
    isAnswer.value = !isAnswer.value
}
// open option
const handleOpenCommentSub = () => {
    isOpenCommentDetail.value = !isOpenCommentDetail.value;
}
// convert date time
const calculateTimeAgo = (created_at) => {
    const currentTime = new Date();
    const commentTime = new Date(created_at);
    const timeDiff = currentTime - commentTime;
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

        .comment__list--input {
            width: 100%;

            .comment__list--controller {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                gap: 10px;
                margin-top: 10px;

                .comment__list__btn {
                    cursor: pointer;
                    padding: 10px;
                    background-color: var(--white-color);
                    border-radius: 12px;

                }

                .comment__list--submit {
                    background-color: var(--btn-color) !important;
                    color: var(--white-color);
                }
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

.comment__more {
    margin-left: 60px;

    .comment__answer {
        display: flex;
        align-items: center;
        gap: 5px;
        color: var(--black-color);
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
    }

    .comment__answers {
        border-left: 1px solid var(--green-color);
        padding-left: 10px;

    }
}

.comment__user {
    display: flex;
    align-items: center;
    gap: 10px;
    // position: relative;
    // .comment__emoji {
    //     position: absolute;
    //     width: 250px;
    //     top: 40px;
    // }

    img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 1px solid var(--border-color);
    }

    input {
        border-bottom: 1px solid var(--border-color);

        &::placeholder {
            font-size: 16px;
            color: #c4c4c4;
        }

    }

    .comment__icon {
        cursor: pointer;
    }
}
</style>