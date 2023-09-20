<template >
    <div class="cate__container">
        <div class="cate__banner">
            <img src="../../../assets/images/books.jpg" alt="" class="cate__img">
            <div class="cate__type">
                Thể Thao
            </div>
        </div>
        <div class="cate__body">
            <img src="../../../assets/images/bannercate.jpeg" alt="" class="cate__ads">
            <div class="cate__content">
                <div class="cate__card">
                    <CardNew :isCard="true" :post="post" :isSaved="isSaved" v-for="(post, index) in paginatedItems"
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
                </div>
                <div class="cate__rules">
                    <h2 class="cate__title">
                        Thể Thao Thể ThaoThể Thao
                    </h2>
                    <div class="cate__allow">
                        <strong>Nội dung cho phép</strong>
                        <p class="cate__allow--content">
                            Các nội dung thể hiện góc nhìn, quan điểm đa chiều về các vấn đề kinh tế, văn hoá – xã hội trong
                            và ngoài nước.
                        </p>
                    </div>
                    <div class="cate__allow--rule">
                        <strong>Quy định</strong>
                        <div class="cate__allow--regulation">
                            <div class="circle"></div>
                            <p class="cate__allow--text">
                                Nghiêm cấm spam, quảng cáo
                            </p>
                        </div>
                        <div class="cate__allow--regulation">
                            <div class="circle"></div>
                            <p class="cate__allow--text">
                                Nghiêm cấm post nội dung 18+ hay những quan điểm cực đoan liên quan tới chính trị - tôn giáo
                            </p>
                        </div>
                        <div class="cate__allow--regulation">
                            <div class="circle"></div>
                            <p class="cate__allow--text">
                                Nghiêm cấm bài đăng không ghi rõ nguồn nếu đi cóp nhặt.
                            </p>
                        </div>
                        <div class="cate__allow--regulation">
                            <div class="circle"></div>
                            <p class="cate__allow--text">
                                Nghiêm cấm phát ngôn thiếu văn hoá và đả kích cá nhân.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script setup>
import { computed, ref, onMounted } from 'vue';
import CardNew from '../../../components/CardNew.vue';
import { usePostStore } from '../../../stores/postStore';

const postStore = usePostStore()
onMounted(async () => {
    await postStore.fetchAllPosts()
})
const activeKey = ref('1');
const currentPage = ref(1);
const itemsPerPage = 20;

const totalItems = computed(() => postStore?.dataFilters?.length);
const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage));
const paginatedItems = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    return postStore?.posts.slice(startIndex, endIndex);
});
// const handleGetFilterPage = (data) => {
//     plantStore.plants = data;
//     currentPage.value = 1; // Reset trang khi áp dụng bộ lọc mới
// };
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
.cate__container {
    margin-top: 140px;

    .cate__banner {
        position: relative;
        margin-bottom: 50px;

        .cate__img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
        }

        .cate__type {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 30px;
            text-transform: uppercase;
            color: var(--white-color);
            font-weight: 700;
        }
    }

    .cate__body {
        max-width: 1160px;
        margin: 0 auto;

        .cate__ads {
            object-fit: cover;
            width: 100%;
            max-height: 150px;
        }

        .cate__content {
            display: flex;
            margin-top: 30px;

            .cate__card {
                width: 70%;
                margin-right: 10px;
                background-color: var(--white-color);
                padding: 10px;

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

            .cate__rules {
                flex: 1;
                padding: 20px;
                border-radius: 5px;
                border: 1px solid var(--border-color);
                box-shadow: 0 10px 15px -3px rgba(var(--blue-500), .05), 0 4px 6px -2px rgba(var(--blue-500), .025) !important;
                max-height: 450px;
                background-color: var(--white-color);

                .cate__title {
                    font-weight: 700;
                    text-transform: uppercase;
                    font-family: Raleway, sans-serif;
                    line-height: 1.5;
                }

                .cate__allow--rule {
                    .cate__allow--regulation {
                        // display: flex;
                        // gap: 5px;

                        .circle {
                            width: 10px;
                            height: 10px;
                            border-radius: 50%;
                            border: 1px solid var(--black-color);
                            float: left;
                            margin-top: 5px;
                            margin-right: 5px;
                        }
                    }
                }
            }
        }
    }
}

@media only screen and (max-width: 1020px) {
    .cate__container {
        .cate__body {


            .cate__content {

                .cate__card {
                    width: 100%;
                    margin-right: 10px;
                    background-color: var(--white-color);
                    padding: 10px;
                }

                .cate__rules {
                    display: none;
                }
            }
        }
    }
}
</style>