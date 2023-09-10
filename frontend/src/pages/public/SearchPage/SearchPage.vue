<template >
    <div class="search__container">
        <h1 class="search__heading">Kết quả tìm kiếm: "Thể thao"</h1>
        <!-- <a-tabs v-model:activeKey="activeKey" :style="{ color: 'black' }" contenteditable="false">
            <a-tab-pane key="1" tab="Dành cho bạn">
                <Foryoupage />
            </a-tab-pane>
            <a-tab-pane key="2" tab="Theo tác giả" force-render>
            </a-tab-pane>

        </a-tabs> -->
        <div class="search__tab">
            <TabPane />
        </div>
    </div>
</template>
<script setup>
import { ref } from "vue"
import Foryoupage from "../Home/RelatedPage/PageContent/foryoupage.vue";
import TabPane from "../../../components/TabPane.vue"

</script>
<style lang="scss" scoped>
.search__container {
    // padding: 100px 400px 0px 400px;
    margin: 100px auto;
    width: 100%;
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;

    .search__heading {
        font-size: 30px;
        text-transform: capitalize;
        font-weight: 700;
    }

    .search__tab {
        background-color: var(--white-color);
        max-width: 750px;
        width: 100%;
        padding: 15px;
        border-radius: 12px;
    }
}
</style>