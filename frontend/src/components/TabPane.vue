<template>
    <div v-if="postStore.isLoading">
        <Loading />
    </div>
    <div class="tabs">
        <div class="tab__links">
            <div class="tab__wrapper">
                <div class="tab" v-for="(tab, index) in tabs" :key="index" @click="selectedTab = tab"
                    :class="{ activeTab: selectedTab === tab }">{{ tab }}</div>
            </div>
            <div class="tab__menu" v-if="selectedTab != 'Theo tác giả'">
                <ion-icon name="menu-outline" @click="handleOpenSelectCategory"></ion-icon>
                <div class="tab__option" v-if="isSelectCategory">
                    <span class="tab__category" @click="handleSelectAll">Tất cả</span>
                    <span class="tab__category" v-for="(tag, index) in postStore.tags" :key="index"
                        @click="handleFilterCategory(tag?.id)">{{ tag.name }}</span>
                </div>
            </div>
        </div>
        <div class="tab__content">
            <div class="tab__post" v-if="selectedTab === 'Theo bài viết'">
                <CardNew :isCard="true" :post="post" v-for="(post, index) in postStore.dataSearch?.posts" :key="index"
                    :isSaved="isSaved" />
            </div>
            <div class="tab__author" v-else>
                <router-link :to="`/profile/${author?.id}`" class="tab__author__wrapper"
                    v-for="(author, index) in postStore.dataSearch?.bloggers" :key="index">
                    <img class="tab__author__avatar" :src="'http://127.0.0.1:8000/images/avatar/' + author?.profile_image"
                        alt="" v-if="author?.profile_image">
                    <img class="tab__author__avatar" src="../../../../assets/images/avatar-default.png" alt="" v-else>
                    <div class="tab__author__name">{{ author?.name }}</div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import CardNew from "./CardNew.vue";
import { usePostStore } from "../stores/postStore";
import Loading from "./Loading.vue";
import { useRoute } from "vue-router";
import SignatureAuthor from "../pages/public/Home/RelatedPage/SignatureAuthor.vue";

const postStore = usePostStore();
postStore.getAllTags();
const handleGetDataSave = async () => {
    await postStore.getAllSavePosts()
}

handleGetDataSave()
const route = useRoute()
const searchParam = ref(route.query.search)
const tabs = ref(['Theo bài viết', 'Theo tác giả']);
const selectedTab = ref('Theo bài viết');
const isSelectCategory = ref(false)

const handleOpenSelectCategory = () => {
    isSelectCategory.value = !isSelectCategory.value
}
const handleFilterCategory = async (id) => {
    await postStore.searchPost(searchParam.value, id)
}
const handleSelectAll = async () => {
    await postStore.searchPost(searchParam.value, "")
};
// saved
const getIdOfFavorites = computed(() => {
    return postStore?.favorites.map((favorites) => favorites?.id)
})

const isSaved = (id) => {
    if (getIdOfFavorites.value.length > 0) {
        return getIdOfFavorites.value.includes(id)
    } else {
        return false
    }
};

const fakeVariable = () => {
    return false
}
</script >

<style lang="scss" scoped>
.tabs {
    width: 100%;

    .tab__links {
        display: flex;
        align-items: center;
        cursor: pointer;
        margin-bottom: 20px;
        justify-content: space-between;

        .tab__wrapper {
            display: flex;
            gap: 20px;

            .tab {
                display: flex;
                font-size: 20px;
                font-weight: 700;
                color: var(--black-color);
                padding: 10px 0px;
            }
        }
    }

    .tab__menu {
        font-size: 20px;
        padding: 5px;
        border-radius: 5px;
        background-color: #eee;
        position: relative;

        .tab__option {
            z-index: 3;
            margin: 0;
            position: absolute;
            inset: 0 0 auto auto;
            min-width: 230px;
            margin: 0px;
            transform: translate3d(0px, 46.8px, 0px);
            background: var(--white-color);
            border-radius: 10px;
            box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
            overflow: hidden;
            color: var(--gray-color);
            animation: toggleOptions 0.3s ease;
            transition: all 0.3s ease;
            will-change: opacity, transform;
            display: flex;
            flex-direction: column;

            .tab__category {
                font-size: 16px;
                font-weight: 300;
                padding: 15px;

                &:hover {
                    background-color: var(--border-color);
                }
            }
        }
    }

    .tab__content {
        display: flex;
        justify-content: flex-start;

        .tab__post {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .tab__author {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            width: 100%;
            gap: 20px;

            .tab__author__wrapper {
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 20px;
                box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;
                max-width: 720px;
                width: 100%;
                padding: 15px;
                border-radius: 8px;
                height: 75px;

                .tab__author__avatar {
                    width: 50px;
                    height: 50px;
                    object-fit: cover;
                    border-radius: 50%;
                }

                .tab__author__name {
                    font-weight: 700;
                }

            }
        }
    }
}

.activeTab {
    border-bottom: 3px solid var(--primary-color);
}
</style>