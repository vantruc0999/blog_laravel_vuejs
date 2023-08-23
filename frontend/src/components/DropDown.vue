<template>
<div class="sub__menu" @click="handleDropDown">
    <div class="sub__header">
        <div class="sub__title">{{ title }}</div>
        <span class="sub__down">
            <ion-icon name="chevron-down-outline"></ion-icon>
        </span>
        <transition name="fade" appear>
            <div class="sub__items" v-if="isOpen">
                <div class="sub__item" v-for="(item, index) in items" :key="index">
                    <a href="#">{{ item.title }}</a>
                </div>
            </div>
        </transition>
    </div>
</div>
</template>

<script setup>
import {
    ref
} from 'vue';

const props = defineProps({
    title: String,
    items: Object,
});

const isOpen = ref(false);

const handleDropDown = () => {
    isOpen.value = !isOpen.value;
};
</script>

<style lang="scss" scoped>
.sub__menu {
    width: 100%;
}

.sub__header {
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 20px;
    position: relative;
}

.sub__items {
    border: 1px solid var(--border-color);
    z-index: 9;
    padding: 5px;
    position: absolute;
    background-color: var(--white-color);
    top: calc(100% + 5px);
    border-bottom: 1px solid var(--border-color);
    border-radius: 0px 0px 16px 16px;
    box-shadow: rgba(0, 0, 0, 0.15) 0px 3px 3px 0px;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>
