<template >
    <div class="related__wrapper">
        <ul class="related__menu">
            <router-link to="/" >
                Dành cho bạn
            </router-link>
            <router-link to="/" >
                Theo tác giả
            </router-link>
            <router-link to="/" >
                Đánh giá cao
            </router-link>
        </ul>
        <div class="related__post">
             <CardNew :isCard="true"/>
             <CardNew :isCard="true"/>
             <CardNew :isCard="true"/>
        </div>
    </div>
</template>
<script setup>
import CardNew from "../../../../components/CardNew.vue"
</script>
<style lang="scss" scoped>
.related__wrapper {
    margin-right: 20px;
    .related__menu {
        padding: 10px;
        display: flex;
        align-items: center;
        gap: 20px;
        border-bottom: 1px solid var(--border-color);
    }
    .related__post {
        margin-top: 20px;
        gap: 40px;
        display: flex;
        flex-direction: column;
    }
}

</style>