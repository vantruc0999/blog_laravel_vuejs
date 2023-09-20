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
                    <span class="form__followed" v-if="authorStore.authorsFollowed?.length > 1">Có {{
                        authorStore.authorsFollowed?.length }} người theo dõi bạn</span>
                    <span class="form__followed" v-else>Bạn viết dở quá, chả có ai
                        theo dõi cả</span>
                    <SignatureAuthor :author="author" v-for="(author, index) in authorStore.authorsFollowed" :key="index" />
                </div>
                <div class="form__follow__user" v-else>
                    <span class="form__followed" v-if="authorStore.authorsFollowing?.length > 1">Bạn đang theo dõi {{
                        authorStore.authorsFollowing?.length }} tác giả</span>
                    <span class="form__followed" v-else>Bạn chưa theo dõi ai cả</span>
                    <SignatureAuthor :author="author" v-for="(author, index) in authorStore?.authorsFollowing" :key="index"
                        :isFollowing="true" />
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { onMounted, ref, computed } from "vue"
import SignatureAuthor from '../pages/public/Home/RelatedPage/SignatureAuthor.vue';
import { useAuthorStore } from '../stores/authorStore';
import { useAuthStore } from "../stores/authStore";
import {
    useRoute,
    useRouter
} from 'vue-router';
const route = useRoute();
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
const authStore = useAuthStore()
const refAuthor = ref(route.params.id)
const getIdFollowing = computed(() => {
    return authorStore?.authorsFollowing.map(author => author.id) || [];
});
console.log("first", authorStore.authorsFollowing)
console.log("firsttttt", authorStore.authorsFollowed)
// console.log("firsttttt", authorStore.authorsFollowed?.length)
// const getIdBlogger = computed(() => {
//     if (authorStore.author?.blogger_infor?.follows) {
//         return authorStore.author?.blogger_infor?.follows.map(author => author.follower_id);
//     } else {
//         return [];
//     }
// });

// const isFollowing = (id) => {
//     if (getIdFollowing.value.length > 0) {
//         return getIdFollowing.value.includes(id)
//     } else {
//         return false
//     }
// };

const getProfileAuthor = computed(() => {
    return authorStore.getAuthorById(refAuthor.value)
})
onMounted(async () => {
    await authorStore.getFollowing();
    await getProfileAuthor.value;
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