<template>
    <div className="container">
        <img src="../assets/images/eclip.png" alt="bg" className="container__image" />
        <router-link to="/">
            <img src="../assets/images/logo-large.png" alt="plantshop" class="container__logo" />
        </router-link>
        <router-view></router-view>

    </div>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
.container {
    position: relative;
    width: 100%;
    height: 100vh;
    padding: 20px;
    --tw-bg-opacity: 1;
    isolation: isolate;
    background-color: rgb(252 252 253 / var(--tw-bg-opacity));

    &__image {
        width: 100%;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        pointer-events: none;
        z-index: -1;
    }

    &__logo {
        display: inline-block;
        margin-bottom: 20px;
        width: 50px;
        height: 50px;
    }

    .wrapper {
        // margin: 0 auto;
    }


}
</style>
