<template >
    <div class="related__wrapper">
        <a-tabs v-model:activeKey="activeKey" :style="{ color: 'black' }" contenteditable="false">
            <a-tab-pane key="1" tab="Dành cho bạn">
                <!-- <ForYouPage /> -->
                <!-- :isSaved="isSaved" -->
                <CardNew :isCard="true" :isSaved="isSaved" :post="post" v-for="(post, index) in paginatedItems "
                    :key="index" />
                <div class="pagination__wrapper">
                    <div class="pagination__page " @click="handleGoPrevPage()"><ion-icon
                            name="arrow-back-outline"></ion-icon>
                    </div>
                    <span v-for="page in totalPages" :key="page" class="pagination__page "
                        :class="{ ' pagination__active': page === currentPage }" @click="handleGoNewPage(page)">
                        {{ page }}
                    </span>
                    <div class="pagination__page " @click="handleGoNextPage()"><ion-icon
                            name="arrow-forward-outline"></ion-icon>
                    </div>
                </div>
            </a-tab-pane>
            <a-tab-pane key="2" tab="Theo tác giả" force-render>
                <CardNew :isCard="true" :isSaved="isSaved" :post="post" v-for="(post, index) in paginatedItemsFollow "
                    :key="index" />
                <div class="pagination__wrapper">
                    <div class="pagination__page " @click="handleGoPrevPageFollow()"><ion-icon
                            name="arrow-back-outline"></ion-icon>
                    </div>
                    <span v-for="pageFollow in totalPagesFollow" :key="pageFollow" class="pagination__page "
                        :class="{ ' pagination__active': pageFollow === currentPageFollow }"
                        @click="handleGoNewPageFollow(pageFollow)">
                        {{ pageFollow }}
                    </span>
                    <div class="pagination__page " @click="handleGoNextPageFollow()"><ion-icon
                            name="arrow-forward-outline"></ion-icon>
                    </div>
                </div>
            </a-tab-pane>
        </a-tabs>

    </div>
</template>
<script setup>
import CardNew from "../../../../components/CardNew.vue";
import { usePostStore } from "../../../../stores/postStore";
import ForYouPage from "./PageContent/foryoupage.vue"
// import PageChange from "../../../../components/PageChange.vue"
import { ref, computed, onMounted } from 'vue';


const postStore = usePostStore()
// author post
const activeKey = ref('1');
const currentPage = ref(1);
const itemsPerPage = 20;

const totalItems = computed(() => postStore?.posts?.length);
const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage));
const paginatedItems = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    return postStore?.posts.slice(startIndex, endIndex);
});
const handleGoNewPage = (page) => {
    currentPage.value = page
}
const handleGoNextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};
const handleGoPrevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};
// follow author post
const currentPageFollow = ref(1);
const itemsPerPageFollow = 20;

const totalItemsFollow = computed(() => postStore.postsAuthor?.length);
const totalPagesFollow = computed(() => Math.ceil(totalItemsFollow.value / itemsPerPageFollow));
const paginatedItemsFollow = computed(() => {
    const startIndexFollow = (currentPageFollow.value - 1) * itemsPerPageFollow;
    const endIndexFolow = startIndexFollow + itemsPerPageFollow;
    return postStore?.posts.slice(startIndexFollow, endIndexFolow);
});
const handleGoNewPageFollow = (page) => {
    currentPageFollow.value = page
}
const handleGoNextPageFollow = () => {
    if (currentPageFollow.value < totalPagesFollow.value) {
        currentPageFollow.value++;
    }
};
const handleGoPrevPageFollow = () => {
    if (currentPageFollow.value > 1) {
        currentPageFollow.value--;
    }
};

// is Favorites (saved)
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
onMounted(async () => {
    await postStore.fetchAllPosts()
    await postStore.getAllSavePosts()
    await postStore.fetchPostsByFollowAuhor()
})
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

    .pagination__wrapper {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;

        .pagination__page {
            cursor: pointer;
            padding: 8px;
            border-radius: 10px;
            box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
        }

        .pagination__active {
            background-color: var(--green-color);
            color: var(--white-color);
        }
    }

}
</style>