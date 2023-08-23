<template>
<div class="related__container">
    <div class="related__left">
        <RelatedPost />
    </div>
    <div class="related__right">
        <SignatureAuthor />
    </div>

</div>
</template>

<script setup>
import RelatedPost from './RelatedPost.vue';
import SignatureAuthor from './SignatureAuthor.vue';
</script>

<style lang="scss" scoped>
.related__container {
    padding: 20px 0;
    display: flex;
    .related__left {
        width: 68%;
    }
    .related__right {
        flex: 1;
        margin-top: 10px;
    }
}
</style>
