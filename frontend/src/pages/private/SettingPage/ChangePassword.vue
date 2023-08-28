<template >
    <div class="password__container">
        <div class="password__content"></div>
    </div>
</template>
<script>
export default {

}
</script>
<style lang="scss" scoped>
.password__container {
    width: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 901;
    bottom: 0;
    background-color: rgba(0, 0, 0, .2);
    // animation: cubic-bezier(0.075, 0.82, 0.165, 1);
    animation-name: slideInRight;
    animation-duration: 0.8s;
    /* Adjust the animation duration as needed */
    animation-fill-mode: forwards;

    .password__content {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 500px;
        height: 400px;
        background-color: var(--white-color);
    }
}
</style>