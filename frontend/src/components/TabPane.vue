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
            <div class="tab__menu">
                <ion-icon name="menu-outline" @click="handleOpenSelectCategory"></ion-icon>
                <div class="tab__option" v-if="isSelectCategory">
                    <span class="tab__category" v-for="(tag, index) in postStore.tags" :key="index"
                        @click="handleFilterCategory(tag?.id)">{{ tag.name }}</span>
                </div>
            </div>
        </div>
        <div class="tab__content">
            <div class="tab__post" v-if="selectedTab === 'Theo bài viết'">
                <CardNew :isCard="true" :post="post" v-for="(post, index) in postStore.dataSearch?.data" :key="index"
                    :isSaved="fakeVariable" />
            </div>
            <div class="tab__author" v-else>
                Đây là author
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import CardNew from "./CardNew.vue";
import { usePostStore } from "../stores/postStore";
import Loading from "./Loading.vue";
import { useRoute } from "vue-router";

const postStore = usePostStore();
postStore.getAllTags();
const route = useRoute()
console.log("hello", postStore.dataSearch);
const tabs = ref(['Theo bài viết', 'Theo tác giả']);
const selectedTab = ref('Theo bài viết');

const isSelectCategory = ref(false)
const handleOpenSelectCategory = () => {
    isSelectCategory.value = !isSelectCategory.value
}

const handleFilterCategory = (id) => {
    console.log(id);
}
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
    }
}

.activeTab {
    border-bottom: 3px solid var(--primary-color);
}
</style>