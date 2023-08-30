<template >
    <div class="blog__container">
        <BlogEditor />
    </div>
</template>
<script setup>
import BlogEditor from "../../private/Blog/BlogEditor.vue"
</script>
<style lang="scss" scoped>
.blog__container {
    padding: 40px 140px;
    margin: 80px 0px 100px 0px;

    .blog__logo {
        width: 150px;
    }
}
</style>