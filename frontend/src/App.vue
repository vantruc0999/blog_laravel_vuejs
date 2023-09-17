<template>
    <div>
        <router-view />
        <button v-if="showScrollTop" @click="scrollToTop" class="btn-scroll-top">
            <ion-icon name="arrow-up-outline"></ion-icon>
        </button>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const showScrollTop = ref(false);

const handleScroll = () => {
    showScrollTop.value = window.scrollY >= 1000;
};

const scrollToTop = () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<style lang="scss" scoped>
.btn-scroll-top {
    position: fixed;
    bottom: 20px;
    right: 20px;
    font-size: 20px;
    padding: 10px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    background-color: var(--primary-color);
    color: var(--white-color);
    display: flex;
    align-items: center;

    ion-icon {
        font-size: 24px;
    }
}
</style>
