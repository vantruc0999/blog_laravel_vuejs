<template >
    <div class="related__post">
        <CardNew :isCard="true" />
        <CardNew :isCard="true" />
        <CardNew :isCard="true" />
    </div>
</template>
<script setup>
import CardNew from "../../../../../components/CardNew.vue"
</script>
<style lang="scss" scoped>
.related__post {
    margin-top: 20px;
    gap: 40px;
    display: flex;
    flex-direction: column;
}
</style>