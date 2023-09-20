<template >
    <div v-if="postStore.isLoading">
        <Loading />
    </div>
    <div class="favorites__container">
        <h1 class="favorites__header">Bạn có {{ postStore.favorites?.length }} bài viết đã lưu</h1>
        <div class="favorites__wrapper">
            <CardNew :post="post" v-for="(post, index) in postStore.favorites" :key="post" :isSaved="isSaved" />
        </div>
    </div>
</template>
<script setup>
import { computed, onMounted } from "vue"
import { usePostStore } from '../../../stores/postStore';
import CardNew from "../../../components/cardnew.vue"
import Loading from '../../../components/Loading.vue';
const postStore = usePostStore()
// onMounted(async () => {
//     await postStore.getAllSavePosts()
// })
const handleGetDataSave = async () => {
    await postStore.getAllSavePosts()
}
handleGetDataSave()

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
</script>
<style lang="scss" scoped>
.favorites__container {
    margin-top: 100px;
    padding: 0 100px;

    .favorites__wrapper {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }

    .favorites__header {
        margin: 30px 0;
        font-family: 'Pacifico', cursive;
        color: var(--secondary-color);
    }
}
</style>