<template >
    <div class="related__post">
        <CardNew :isCard="true" :post="post" v-for="(post, index) in postStore.posts " :key="index" />
    </div>
</template>
<script setup>
import CardNew from "../../../../../components/CardNew.vue"
import { usePostStore } from "../../../../../stores/postStore";

const postStore = usePostStore()
</script>
<style lang="scss" scoped>
.related__post {
    margin-top: 20px;
    gap: 40px;
    display: flex;
    flex-direction: column;
}
</style>