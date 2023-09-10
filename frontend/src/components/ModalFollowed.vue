<template >
    <div class="container" v-if="isOpenModalFollowed && checkMyProfile">
        <div class="form">
            <div class="form__header">
                <span class="form__all">Tất cả</span>
                <span class="form__close" @click="handleClose">
                    <ion-icon name="close-outline"></ion-icon>
                </span>
            </div>
            <span class="form__followed" v-if="authorStore.authorsFollowed?.length > 1">Bạn viết dở quá, chả có ai theo dõi
                cả</span>
            <span class="form__followed" v-else>Có {{
                authorStore.authorsFollowed?.length }} người theo dõi bạn</span>

            <div class="follower">
                <SignatureAuthor :author="author" v-for="(author, index) in authorStore.authorsFollowed" :key="index" />
            </div>
        </div>
    </div>
</template>
<script setup>
import { onMounted, ref } from "vue"
import SignatureAuthor from '../pages/public/Home/RelatedPage/SignatureAuthor.vue';
import { useAuthorStore } from '../stores/authorStore';

const props = defineProps({
    isOpenModalFollowed: {
        type: Boolean
    },
    closeModelFollow: {
        type: Function
    },
    handleClose: {
        type: Function
    },
    checkMyProfile: {
        type: Boolean
    }
})

const authorStore = useAuthorStore()

authorStore.getFollowered()
console.log("followed", authorStore?.authorsFollowed)
</script>
<style lang="scss" scoped>
.container {
    position: fixed;
    z-index: 999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
    transition-timing-function: ease-in-out;

    .form {
        margin: 50px auto;
        width: 500px;
        max-height: 600px;
        background-color: var(--white-color);
        padding: 15px;
        border-radius: 10px;

        .form__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 25px;
            color: var(--text-color-4);

            .form__all {
                border-bottom: 3px solid var(--green-color);
                padding: 10px 0px;
                font-size: 18px;
            }

            .form__close {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                padding: 2px;
                cursor: pointer;
                background-color: #D8DADF;
                color: var(--black-color);
            }
        }
    }

    .form__followed {
        display: inline-block;
        margin-top: 10px;
        font-size: 14px;
        color: #848586;
        font-weight: 500;
    }
}
</style>