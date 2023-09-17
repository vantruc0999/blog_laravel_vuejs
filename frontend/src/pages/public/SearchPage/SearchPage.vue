<template>
    <div class="search__container">
        <h1 class="search__heading">Kết quả tìm kiếm: "<span class="search__text">{{ $route.query.search }}</span>"</h1>
        <div class="search__tab">
            <TabPane />
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import TabPane from "../../../components/TabPane.vue";
import { useRoute } from 'vue-router';
const route = useRoute();

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

    .search__text {
        color: var(--primary-color);
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