<template>
    <router-view />
    <button v-scroll-directive="1000" @click="scrollToTop" class="btn-scroll-top">
        <ion-icon name="arrow-up-outline"></ion-icon>
    </button>
</template>

<script setup>
const scrollToTop = () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
};

</script>

<style lang="scss" scoped>
.btn-scroll-top {
    position: fixed;
    bottom: 20px;
    right: 20px;
    font-size: 20px;
    padding: 10px;
    cursor: pointer;
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;

    &:hover {
        color: var(--green-color);
    }
}
</style>
