<template>
    <div class="tabs">
        <div class="tab__links">
            <div class="tab" v-for="(tab, index) in tabs" :key="index" @click="selectedTab = tab"
                :class="{ activeTab: selectedTab === tab }">{{ tab }}</div>
        </div>
        <div class="tab__content">
            <div class="tab__post" v-if="selectedTab === 'Theo bài viết'">
                Đây là post
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

const tabs = ref(['Theo bài viết', 'Theo tác giả']);
const selectedTab = ref('Theo bài viết');
</script>

<style lang="scss" scoped>
.tabs {
    width: 100%;

    .tab__links {
        display: flex;
        gap: 20px;
        cursor: pointer;
        margin-bottom: 20px;
        align-items: center;
        justify-content: center;
        flex-direction: row;

        .tab {
            display: flex;
            font-size: 20px;
            font-weight: 700;
            color: var(--black-color);
            padding: 10px 0px;
        }
    }

    .tab__content {
        display: flex;
        justify-content: flex-start;
    }
}

.activeTab {
    border-bottom: 3px solid var(--primary-color);
}
</style>