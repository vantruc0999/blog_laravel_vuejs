<template >
    <div class="search__container">
        <h1 class="search__heading">Kết quả tìm kiếm: "Thể thao"</h1>
        <a-tabs v-model:activeKey="activeKey" :style="{ color: 'black' }" contenteditable="false">
            <a-tab-pane key="1" tab="Dành cho bạn">
                <Foryoupage />
            </a-tab-pane>
            <a-tab-pane key="2" tab="Theo tác giả" force-render>
            </a-tab-pane>

        </a-tabs>
    </div>
</template>
<script setup>
import { ref } from "vue"
import Foryoupage from "../Home/RelatedPage/PageContent/foryoupage.vue";
</script>
<style lang="scss" scoped>
.search__container {
    padding: 100px 400px 0px 400px;
    margin: 0 auto;
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;

    .ant-tabs-nav {
        justify-content: center;
        font-size: 22px;
    }
}
</style>