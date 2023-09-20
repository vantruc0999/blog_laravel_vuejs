<template>
    <div class="related__container">
        <div class="related__left">
            <RelatedPost />
        </div>
        <div class="related__right">
            <div class="signature__header">
                <span class="signature__text">Cây bút nổi bật</span>
                <router-link to="/author" class="signature__more">
                    Xem thêm
                </router-link>
            </div>
            <SignatureAuthor :author="author" v-for="(author, index) in authStore.users.slice(0, 3)" :key="index" />
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import { useAuthStore } from '../../../../stores/authStore';
import RelatedPost from './RelatedPost.vue';
import SignatureAuthor from './SignatureAuthor.vue';

const authStore = useAuthStore()

const getAllBlogger = async () => {
    await authStore.fetchAllBlogger()
}
getAllBlogger()

</script>

<style lang="scss" scoped>
.related__container {
    padding: 20px 0;
    display: flex;

    .related__left {
        width: 65%;
        border-radius: 10px;
        padding: 10px;
        background-color: var(--white-color);
        margin-right: 20px;

    }

    .related__right {
        padding: 30px 20px 20px 20px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        background-color: var(--white-color);
        flex: 1;
        height: 100%;
        max-height: 251px;
        width: 100%;

        .signature__header {
            display: flex;
            justify-content: space-between;

            .signature__text {
                font-size: 16px;
                font-weight: 700;
                text-transform: uppercase;
            }

            .signature__more {
                font-size: 12px;

            }
        }
    }
}

@media only screen and (max-width: 1060px) {
    .related__container {
        display: block;

        .related__left {
            width: 100%;
            margin-bottom: 50px;
        }

        .related__right {
            width: 100%;
        }
    }

}
</style>
