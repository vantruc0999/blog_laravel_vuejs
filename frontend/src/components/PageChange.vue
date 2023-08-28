<template >
    <div class="pagination__wrapper">
        <div class="pagination__page "><ion-icon name="arrow-back-outline"></ion-icon></div>
        <div class="pagination__page pagination__active">1</div>
        <div class="pagination__page">2</div>
        <div class="pagination__page">3</div>
        <div class="pagination__page "><ion-icon name="arrow-forward-outline"></ion-icon></div>
    </div>
</template>
<script>

</script>
<style lang="scss" scoped>
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
</style>