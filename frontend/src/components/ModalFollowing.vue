<template >
    <div class="container" v-if="isOpenModalFollowing && checkMyProfile">
        <div class="form">
            <span class="form__close" @click="handleCloseFollowing">
                <ion-icon name="close-outline"></ion-icon>
            </span>
            <div class="form__follow">
                <div class="form__tab" v-for="(tab, index) in tabs" :key="index" @click="selectedTab = tab"
                    :class="{ activeTab: selectedTab === tab }">{{ tab }}</div>
            </div>
            <div class="form__account">
                <div class="form__follow__user" v-if="selectedTab === 'Người theo dõi'">
                    <span class="form__followed" v-if="authorStore.authorsFollowed?.length > 1">Bạn viết dở quá, chả có ai
                        theo dõi
                        cả</span>
                    <span class="form__followed" v-else>Có {{
                        authorStore.authorsFollowed?.length }} người theo dõi bạn</span>
                    <SignatureAuthor :author="author" v-for="(author, index) in authorStore.authorsFollowed" :key="index" />
                </div>
                <div class="form__follow__user" v-else>
                    <span class="form__followed" v-if="authorStore.authorsFollowing?.length > 1">Bạn viết dở quá, chả có ai
                        theo dõi
                        cả</span>
                    <span class="form__followed" v-else>Bạn đang theo dõi {{
                        authorStore.authorsFollowing?.length }} tác giả</span>
                    <SignatureAuthor :author="author" v-for="(author, index) in authorStore?.authorsFollowing"
                        :key="index" />
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { onMounted, ref } from "vue"
import SignatureAuthor from '../pages/public/Home/RelatedPage/SignatureAuthor.vue';
import { useAuthorStore } from '../stores/authorStore';

const props = defineProps({
    isOpenModalFollowing: {
        type: Boolean
    },
    closeModelFollow: {
        type: Function
    },
    handleCloseFollowing: {
        type: Function
    },
    checkMyProfile: {
        type: Boolean
    }
})

const authorStore = useAuthorStore()

onMounted(async () => {
    await authorStore.getFollowing();
});
const tabs = ref(['Đang theo dõi', 'Người theo dõi']);
const selectedTab = ref('Đang theo dõi');
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
        position: relative;

        .form__close {
            position: absolute;
            right: 20px;
            font-size: 22px;
            cursor: pointer;
            width: 35px;
            padding: 5px;
            height: 35px;
            background-color: var(--border-color);
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
        }

        .form__follow {
            display: flex;
            gap: 10px;

            .form__tab {
                padding: 10px 0px;
                font-size: 18px;
                cursor: pointer;
            }
        }

        .form__account {
            margin-top: 20px;

            .form__follow__user {
                margin-bottom: 20px;

                .form__followed {
                    margin-top: 10px;
                    font-size: 14px;
                    color: #848586;
                    font-weight: 500;
                }
            }
        }

        .activeTab {
            border-bottom: 3px solid var(--green-color);

        }
    }

}
</style>