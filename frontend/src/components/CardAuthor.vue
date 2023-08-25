<template >
    <router-link to="/profile" class="detail__author">
        <img src="../assets/images/bin.jpg" alt="">
        <div class="detail__infor">
            <h2 class="detail__name">Bin zét</h2>
            <p class="detail__desc">Gastronomy atmosphere set aside. Slice butternut cooking home. Delicious romantic
                undisturbed raw platter will meld. Thick Skewers skillet natural, smoker soy sauce wait roux. Gastronomy
                atmosphere set aside. Slice butternut cooking home. </p>
        </div>
    </router-link>
</template>
<script setup>

</script>
<style lang="scss" scoped>
// card author
.detail__author {
    margin: 0 auto;
    width: 100%;
    border: 1px solid var(--border-color);
    max-width: 780px;
    display: flex;

    img {
        width: 100%;
        height: auto;
        max-height: 250px;
        max-width: 240px;
        // height: 237px;
        border-radius: 12px;
        object-fit: cover;
    }
}

.detail__infor {
    padding: 20px;
}

.detail__name {
    font-size: 22px;
    color: var(--secondary-color);
    font-weight: 600;
}

.detail__desc {
    margin-top: 10px;
    color: var(--black-color);
    font-size: 18px;

}
</style>