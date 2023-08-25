<template >
    <div class="related__wrapper">
        <a-tabs v-model:activeKey="activeKey" :style="{ color: 'black' }" contenteditable="false">
            <a-tab-pane key="1" tab="Dành cho bạn">
                <ForYouPage />
            </a-tab-pane>
            <a-tab-pane key="2" tab="Theo tác giả" force-render>
                <ForYouPage />
            </a-tab-pane>
            <a-tab-pane key="3" tab="Đánh giá cao">
                <ForYouPage />
            </a-tab-pane>
        </a-tabs>
    </div>
</template>
<script setup>
import ForYouPage from "./PageContent/foryoupage.vue"
import { ref } from 'vue';
const activeKey = ref('1');
</script>
<style lang="scss" scoped>
.related__wrapper {
    .related__menu {
        display: flex;
        align-items: center;
        gap: 20px;
        border-bottom: 1px solid var(--border-color);

    }

    .related__route {
        padding: 10px;
    }


}

// .ant-tabs-tab-btn {
//     color: black !important;
// }
</style>